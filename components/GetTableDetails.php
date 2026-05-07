<?php
require_once __DIR__ . '/../Database/db.php';
require_once __DIR__ . '/../models/OrderModel.php';

$tableNumber = $_GET['table'] ?? null;
$date = $_GET['date'] ?? null;

if (!$tableNumber || !$date) {
    echo '<p class="text-red-500">Invalid parameters</p>';
    exit;
}

$orders = Order::getOrdersByTableAndDate($tableNumber, $date, $pdo);

if (empty($orders)):
?>
    <p class="text-gray-500">No orders found for this table on this date.</p>
<?php else: ?>
    <table class="w-full table-auto">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 text-left">Order ID</th>
                <th class="px-4 py-2 text-left">Client</th>
                <th class="px-4 py-2 text-left">Time</th>
                <th class="px-4 py-2 text-left">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total = 0;
            foreach ($orders as $order): 
                $total += $order['total_amount'];
            ?>
                <tr class="border-b">
                    <td class="px-4 py-2">#<?= $order['id'] ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($order['client_name']) ?></td>
                    <td class="px-4 py-2"><?= date('H:i', strtotime($order['created_at'])) ?></td>
                    <td class="px-4 py-2 font-semibold"><?= number_format($order['total_amount'], 2) ?> EUR</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot class="bg-gray-100 font-bold">
            <tr>
                <td colspan="3" class="px-4 py-2">TOTAL</td>
                <td class="px-4 py-2 text-green-600"><?= number_format($total, 2) ?> EUR</td>
            </tr>
        </tfoot>
    </table>
<?php endif; ?>