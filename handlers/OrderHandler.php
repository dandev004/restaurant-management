<?php
session_start();
require_once __DIR__ . '/../Database/db.php';
require_once __DIR__ . '/../controllers/OrderController.php';
require_once __DIR__ . '/../controllers/MenuController.php';
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/ReservationModel.php';
require_once __DIR__ . '/../models/TableModel.php';
require_once __DIR__ . '/../models/ClientsModel.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/Orders.php');
    exit;
}

$tableNumber = OrderController::sanitizeInput($_POST['select_table']);
$clientName = OrderController::sanitizeInput($_POST['client_name']);
$reservationId = !empty($_POST['reservation_id']) ? OrderController::sanitizeInput($_POST['reservation_id']) : null;
$totalAmount = OrderController::sanitizeInput($_POST['total_amount']);

$productsJson = $_POST['products'] ?? '';

$errors = OrderController::validate([
    'select_table' => $tableNumber,
    'client_name' => $clientName,
    'reservation_id' => $reservationId,
    'total_amount' => $totalAmount
]);

if (empty($productsJson)) {
    $errors['products'] = 'Please add at least one product';
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: ../views/Orders.php');
    exit;
}
$products = json_decode($productsJson, true);

if (empty($products) || !is_array($products)) {
    $_SESSION['errors'] = ['Invalid products data'];
    header('Location: ../views/Orders.php');
    exit;
}

try {
    $pdo->beginTransaction();
    
    $orderId = Order::createOrder([
        'client_name' => $clientName,
        'table_number' => $tableNumber,
        'reservation_id' => $reservationId,
        'total_amount' => $totalAmount
    ], $pdo);
    
    foreach ($products as $product) {
        Order::createOrderItem([
            'order_id' => $orderId,
            'product_id' => $product['id'],
            'product_name' => $product['name'],
            'quantity' => $product['quantity'],
            'price' => $product['price']
        ], $pdo);
    }
    
    Client::createTableClient([
        'table_number' => $tableNumber,
        'client_name' => $clientName,
        'reservation_id' => $reservationId,
        'session_date' => date('Y-m-d'),
        'arrived_at' => date('Y-m-d H:i:s'),
        'left_at' => null
    ], $pdo);
    
    $pdo->commit();
    
    $_SESSION['success'] = "Order created successfully!";
    header('Location: ../views/Orders.php');
    exit;
    
} catch (Exception $e) {
    $pdo->rollBack();
    
    $_SESSION['errors'] = ["Error creating order: " . $e->getMessage()];
    header('Location: ../views/Orders.php');
    exit;
}