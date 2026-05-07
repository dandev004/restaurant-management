<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/TableModel.php';
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../components/card.php';

session_start();

$user = User::getUserById($_SESSION['user_id'], $pdo);
if (!$user) {
    header('Location: ../views/Login.php');
    exit;
}

$page_title = 'Dashboard';

$totalTables = Table::countTables($pdo);
$todayStats = Order::getTodayStats($pdo);
$weekStats = Order::getWeekStats($pdo);
$monthStats = Order::getMonthStats($pdo);

$selectedDate = $_GET['date'] ?? date('Y-m-d');

$dailyReportByTable = Order::getDailyReportByTable($selectedDate, $pdo);
$dailyTotal = Order::getDailyTotal($selectedDate, $pdo);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Dashboard</title>
</head>

<body class="bg-gray-100">
    <?php include '../components/header.php'; ?>

    <div class="container mx-auto p-6">
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Tables</p>
                        <p class="text-3xl font-bold"><?= $totalTables ?></p>
                    </div>
                    <img src="../assets/images/table.png" alt="tables" class="w-12 h-12">
                </div>
            </div>

            <div class="bg-blue-500 text-white p-6 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm">Today's Orders</p>
                        <p class="text-3xl font-bold"><?= $todayStats['total_orders'] ?? 0 ?></p>
                        <p class="text-sm text-blue-100"><?= number_format($todayStats['total_revenue'] ?? 0, 2) ?> EUR</p>
                    </div>
                    <img src="../assets/images/graph.png" alt="graph" class="w-12 h-12">
                </div>
            </div>

            <div class="bg-green-500 text-white p-6 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm">This Week</p>
                        <p class="text-3xl font-bold"><?= $weekStats['total_orders'] ?? 0 ?></p>
                        <p class="text-sm text-green-100"><?= number_format($weekStats['total_revenue'] ?? 0, 2) ?> EUR</p>
                    </div>
                    <img src="../assets/images/graph.png" alt="graph" class="w-12 h-12">
                </div>
            </div>

            <div class="bg-purple-500 text-white p-6 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm">This Month</p>
                        <p class="text-3xl font-bold"><?= $monthStats['total_orders'] ?? 0 ?></p>
                        <p class="text-sm text-purple-100"><?= number_format($monthStats['total_revenue'] ?? 0, 2) ?> EUR</p>
                    </div>
                    <img src="../assets/images/graph.png" alt="graph" class="w-12 h-12">
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-2xl font-bold mb-4">Daily Report</h2>
            
            <form method="GET" class="flex gap-4 items-end">
                <div class="flex-1">
                    <label for="date" class="block text-sm font-semibold mb-2">Select Date:</label>
                    <input 
                        type="date" 
                        name="date" 
                        id="date" 
                        value="<?= $selectedDate ?>"
                        max="<?= date('Y-m-d') ?>"
                        class="w-full border px-4 py-2 rounded">
                </div>
                <button type="submit" class="bg-[#9D00FF] text-white px-6 py-2 rounded hover:bg-[#9D00FF]/80">
                    Generate Report
                </button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h3 class="text-xl font-bold mb-4">
                Report for <?= date('d/m/Y', strtotime($selectedDate)) ?>
            </h3>
            <?php if (empty($dailyReportByTable)): ?>
                <p class="text-gray-500">No orders for this date.</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left">Table Number</th>
                                <th class="px-4 py-3 text-left">Total Orders</th>
                                <th class="px-4 py-3 text-left">Total Amount</th>
                                <th class="px-4 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dailyReportByTable as $tableReport): ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3 font-semibold">Table <?= $tableReport['table_number'] ?></td>
                                    <td class="px-4 py-3"><?= $tableReport['total_orders'] ?></td>
                                    <td class="px-4 py-3 font-semibold text-green-600">
                                        <?= number_format($tableReport['table_total'], 2) ?> EUR
                                    </td>
                                    <td class="px-4 py-3">
                                        <button 
                                            onclick="viewTableDetails(<?= $tableReport['table_number'] ?>, '<?= $selectedDate ?>')"
                                            class="bg-[#9D00FF] text-white px-3 py-1 rounded hover:bg-[#9D00FF]/80 text-sm">
                                            View Details
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="bg-gray-100 font-bold">
                            <tr>
                                <td class="px-4 py-3">TOTAL</td>
                                <td class="px-4 py-3"><?= $dailyTotal['total_orders'] ?? 0 ?></td>
                                <td class="px-4 py-3 text-green-600 text-lg">
                                    <?= number_format($dailyTotal['daily_total'] ?? 0, 2) ?> EUR
                                </td>
                                <td class="px-4 py-3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div id="tableDetailsModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg w-full max-w-2xl relative max-h-[90vh] overflow-y-auto">
            <button onclick="closeTableDetails()" class="absolute top-2 right-2 text-gray-500 hover:text-black text-2xl">
                ✕
            </button>

            <h2 class="text-xl font-bold mb-4" id="modalTitle">Table Details</h2>
            
            <div id="modalContent">
                
            </div>
        </div>
    </div>

    <script src="../assets/js/viewTableDetails.js"></script>
</body>

</html>
<?php include '../components/footer.php' ?>