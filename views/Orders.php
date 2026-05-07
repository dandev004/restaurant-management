<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/TableModel.php';
require_once __DIR__ . '/../models/MenuModel.php';
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ .  '/../components/card.php';

session_start();

$user = User::getUserById($_SESSION['user_id'], $pdo);
if (!$user) {
    header('Location: ../views/Login.php');
    exit;
}

$page_title = 'Orders';
$categoriesProduct = Menu::getAllCategory($pdo);
$tables = Table::getAllTables($pdo);

$orders = Order::getAllOrders($pdo);

if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $products = Menu::getAllByCategory($category, $pdo);

    header('Content-Type: application/json');
    echo json_encode($products);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100">
    <?php include '../components/header.php'; ?>

    <div class="container mx-auto p-4">
        <button id="openModal" class="p-2 border border-gray-300 bg-[#9D00FF] rounded mb-4 text-white font-semibold">
            Create Order
        </button>

        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-2xl font-bold mb-4">All Orders</h2>

            <?php if (empty($orders)): ?>
                <p class="text-gray-500">No orders yet.</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left">ID</th>
                                <th class="px-4 py-2 text-left">Client Name</th>
                                <th class="px-4 py-2 text-left">Table</th>
                                <th class="px-4 py-2 text-left">Reservation ID</th>
                                <th class="px-4 py-2 text-left">Total Amount</th>
                                <th class="px-4 py-2 text-left">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2"><?= $order['id'] ?></td>
                                    <td class="px-4 py-2"><?= htmlspecialchars($order['client_name']) ?></td>
                                    <td class="px-4 py-2"><?= $order['table_number'] ?></td>
                                    <td class="px-4 py-2"><?= $order['reservation_id'] ?? '-' ?></td>
                                    <td class="px-4 py-2 font-semibold"><?= number_format($order['total_amount'], 2) ?> EUR</td>
                                    <td class="px-4 py-2"><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?= $_SESSION['success'] ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['errors'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <section
        id="orderModal"
        class="fixed inset-0 bg-black/50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg w-full max-w-md relative max-h-[90vh] overflow-y-auto">

            <button
                id="closeModal"
                class="absolute top-2 right-2 text-gray-500 hover:text-black">
                ✕
            </button>

            <h2 class="text-xl text-[#9D00FF] font-bold mb-4">Create Order</h2>

            <form action="../handlers/OrderHandler.php" method="POST" class="space-y-4">
                <div>
                    <h3 class="text-[18px] text-[#9D00FF] font-semibold">Order Information:</h3>
                    <div class="flex flex-col gap-2">
                        <div class="flex gap-2 w-full">
                            <p class="w-1/2">Table Number</p>
                            <select name="select_table" id="select_table" class="w-1/2 border px-2 py-1">
                                <?php foreach ($tables as $table): ?>
                                    <option value="<?= $table['number'] ?>">
                                        <?= $table['number'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="flex gap-2 w-full">
                            <label for="client_name" class="w-1/2">Client Name:</label>
                            <input type="text" name="client_name" id="client_name" class="border px-2 py-1 w-1/2">
                        </div>
                        <div class="flex gap-2 w-full">
                            <label for="reservation_id" class="w-1/2">Reservation ID:</label>
                            <input type="number" name="reservation_id" id="reservation_id" class="border px-2 py-1 w-1/2">
                        </div>
                    </div>
                    <h3 class="text-[18px] text-[#9D00FF] font-semibold mt-4">Order Items</h3>
                    <div class="flex flex-col gap-2 w-full">

                        <div id="productsList" class="flex flex-col gap-2 mt-4"></div>

                        <div id="modalCategory" class="hidden flex w-full">
                            <p class="w-1/2">Select Category:</p>
                            <select name="select_category" id="select_category" class="w-1/2 border px-2 py-1">
                                <option value="">Choose category</option>
                                <?php foreach ($categoriesProduct as $categories): ?>
                                    <option value="<?= $categories['category'] ?>">
                                        <?= $categories['category'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div id="modalProduct" class="hidden flex w-full">
                            <p class="w-1/2">Select Product:</p>
                            <select name="select_Product" id="select_Product" class="w-1/2 border px-2 py-1">
                                <option value="">Choose product</option>
                            </select>
                        </div>

                        <button
                            type="button"
                            id="openModalCategory"
                            class="text-black opacity-50 hover:opacity-100">
                            +Add Product
                        </button>

                        <div class="flex justify-between gap-2 w-full mt-4 font-semibold">
                            <p>Total Amount:</p>
                            <p id="totalAmount">0.00 EUR</p>
                        </div>

                        <input type="hidden" name="total_amount" id="total_amount_input" value="0">
                        <input type="hidden" name="products" id="products_input" value="">

                    </div>
                </div>
                <button
                    type="submit"
                    class="w-full bg-[#9D00FF] text-white p-2 rounded ">
                    Save Order
                </button>
            </form>
        </div>
    </section>

</body>
<script src="../assets/js/create.order.js"></script>

</html>
<?php include '../components/footer.php' ?>