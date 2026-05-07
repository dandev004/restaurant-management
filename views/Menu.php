<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/TableModel.php';
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ .  '/../components/card.php';
require_once __DIR__ . '/../models/MenuModel.php';

session_start();

$user = User::getUserById($_SESSION['user_id'], $pdo);
if (!$user) {
    header('Location: ../views/Login.php');
    exit;
}

$page_title = 'Menu';
$aperitive = Menu::getAllByCategory('Aperitive', $pdo);
$salats = Menu::getAllByCategory('Salate', $pdo);
$pizzas = Menu::getAllByCategory('Pizza', $pdo);
$mainCourses = Menu::getAllByCategory('Fel Principal', $pdo);
$pastas = Menu::getAllByCategory('Paste', $pdo);
$garnishes = Menu::getAllByCategory('Garnituri', $pdo);
$deserts = Menu::getAllByCategory('Desert', $pdo);

$editProduct = null;
if (isset($_GET['edit_id'])) {
    $editProduct = Menu::getProductById($_GET['edit_id'], $pdo);
}
?>

<?php
function renderCategoryTable(string $title, array $products): void
{
    if (empty($products)) return;
?>
    <div class="mb-6">
        <h2 class="text-[18px] font-bold mb-2"><?= htmlspecialchars($title) ?></h2>
        <table class="w-full table-fixed border-collapse">
            <thead class="bg-gray-200">
                <tr>
                    <th class="w-[5%] p-2 border">ID</th>
                    <th class="w-[15%] p-2 border">Image</th>
                    <th class="w-[40%] p-2 border">Name</th>
                    <th class="w-[15%] p-2 border">Price</th>
                    <th class="w-[15%] p-2 border">Modify</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr class="text-center">
                        <td class="p-2 border"><?= htmlspecialchars($product['id']) ?></td>
                        <td class="p-2 border">
                            <img
                                src="../uploads/menu/<?= htmlspecialchars($product['image']) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>"
                                class="w-24 h-24 object-cover mx-auto rounded">
                        </td>
                        <td class="p-2 border"><?= htmlspecialchars($product['name']) ?></td>
                        <td class="p-2 border"><?= number_format($product['price'], 2) ?> €</td>
                        <td class="p-2 border">
                            <div class="flex gap-3 items-center justify-center">
                                <button onclick="openEditModal(<?= htmlspecialchars(json_encode($product)) ?>)" class="hover:opacity-70">
                                    <img src="../assets/images/edit.png" alt="edit" class="w-5 h-5">
                                </button>
                                <button onclick="openDeleteModal(<?= $product['id'] ?>, '<?= htmlspecialchars($product['name']) ?>')" class="hover:opacity-70">
                                    <img src="../assets/images/trash.png" alt="delete" class="w-5 h-5">
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php
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

        <!-- Mesaje de succes/eroare -->
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

        <?php
        renderCategoryTable('Aperitive', $aperitive);
        renderCategoryTable('Salate', $salats);
        renderCategoryTable('Pizza', $pizzas);
        renderCategoryTable('Paste', $pastas);
        renderCategoryTable('Fel Principal', $mainCourses);
        renderCategoryTable('Garnituri', $garnishes);
        renderCategoryTable('Desert', $deserts);
        ?>
    </div>

    <div id="editModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg w-full max-w-md relative">
            <button onclick="closeEditModal()" class="absolute top-2 right-2 text-gray-500 hover:text-black text-2xl">
                ✕
            </button>

            <h2 class="text-xl font-bold mb-4">Edit Product</h2>

            <form id="editForm" action="../handlers/MenuHandler.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="product_id" id="edit_product_id">

                <div>
                    <label for="edit_name" class="block mb-1 font-semibold">Product Name:</label>
                    <input type="text" name="name" id="edit_name" class="w-full border px-3 py-2 rounded" required>
                </div>

                <div>
                    <label for="edit_category" class="block mb-1 font-semibold">Category:</label>
                    <select name="category" id="edit_category" class="w-full border px-3 py-2 rounded" required>
                        <option value="Aperitive">Aperitive</option>
                        <option value="Salate">Salate</option>
                        <option value="Pizza">Pizza</option>
                        <option value="Paste">Paste</option>
                        <option value="Fel Principal">Fel Principal</option>
                        <option value="Garnituri">Garnituri</option>
                        <option value="Desert">Desert</option>
                    </select>
                </div>

                <div>
                    <label for="edit_price" class="block mb-1 font-semibold">Price (€):</label>
                    <input type="number" step="0.01" name="price" id="edit_price" class="w-full border px-3 py-2 rounded" required>
                </div>

                <div>
                    <label class="block mb-1 font-semibold">Current Image:</label>
                    <img id="edit_current_image" src="" alt="Current" class="w-32 h-32 object-cover rounded mb-2">
                    <input type="hidden" name="current_image" id="edit_current_image_name">
                </div>

                <div>
                    <label for="edit_image" class="block mb-1 font-semibold">Change Image (optional):</label>
                    <input type="file" name="image" id="edit_image" accept="image/*" class="w-full border px-3 py-2 rounded">
                </div>

                <button type="submit" class="w-full bg-[#9D00FF] text-white py-2 rounded hover:bg-[#9D00FF]/80">
                    Update Product
                </button>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg w-full max-w-md relative">
            <button onclick="closeDeleteModal()" class="absolute top-2 right-2 text-gray-500 hover:text-black text-2xl">
                ✕
            </button>

            <h2 class="text-xl font-bold mb-4">Delete Product</h2>

            <p class="mb-4">Are you sure you want to delete <strong id="delete_product_name"></strong>?</p>
            <p class="text-sm text-gray-600 mb-6">This action cannot be undone.</p>

            <form action="../handlers/MenuHandler.php" method="POST" class="space-y-4">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="product_id" id="delete_product_id">

                <div class="flex gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="flex-1 bg-gray-300 text-black py-2 rounded hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 bg-red-500 text-white py-2 rounded hover:bg-red-600">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="../assets/js/menu.js"></script>
</body>

</html>