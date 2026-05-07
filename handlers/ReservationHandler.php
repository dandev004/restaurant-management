<?php
session_start();
require_once __DIR__ . '/../Database/db.php';
require_once __DIR__ . '/../controllers/ReservationController.php';
require_once __DIR__ . '/../models/ReservationModel.php';
require_once __DIR__ . '/../models/TableModel.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/CreateReservation.php');
    exit;
}

$clientName = ReservationController::sanitizeInput($_POST['client_name']);
$numberPeople = ReservationController::sanitizeInput($_POST['number_people']);
$tableNumber = ReservationController::sanitizeInput($_POST['table_number']);
$reservationDate = ReservationController::sanitizeInput($_POST['reservation_date']);
$startTime = ReservationController::sanitizeInput($_POST['start_time']);
$endTime = ReservationController::sanitizeInput($_POST['end_time']);
$clientPhone = !empty($_POST['client_phone']) ? ReservationController::sanitizeInput($_POST['client_phone']) : '';

$errors = [];
$errors = ReservationController::validate([
    'client_name' => $clientName,
    'client_phone' => $clientPhone ?? '',
    'number_people' => $numberPeople,
    'table_number' => $tableNumber,
    'reservation_date' => $reservationDate,
    'start_time' => $startTime,
    'end_time' => $endTime
]);

if (empty($errors)) {
    $reservations = Reservation::getReservationsByTableAndDate($tableNumber, $reservationDate, $pdo);
    foreach ($reservations as $reservation) {
        $start = $reservation['start_time'];
        $end = $reservation['end_time'];

        $hasConflict = false;

        if ($startTime >= $start && $startTime < $end) {
            $hasConflict = true;
        }
        if ($endTime > $start && $endTime <= $end) {
            $hasConflict = true;
        }
        if ($startTime <= $start && $endTime >= $end) {
            $hasConflict = true;
        }
        if ($hasConflict) {
            $errors['time_conflict'] = 'Table is already reserved for this time period';
            break;
        }
    }
}
if (empty($errors)) {
    Reservation::create($clientName, $clientPhone, $numberPeople, $tableNumber, $reservationDate, $startTime, $endTime, $pdo);
    $status = 'occupied';
    Table::updateStatus($pdo, $status, $tableNumber);
    $_SESSION['success'] = 'Reservation created successfully';
    header('Location: ../views/Reservations.php');
    exit;
} else {
    $_SESSION['errors'] = $errors;
    $_SESSION['last'] = [
        'client_name' => $clientName,
        'client_phone' => $clientPhone ?? '',
        'number_people' => $numberPeople,
        'table_number' => $tableNumber,
        'reservation_date' => $reservationDate,
        'start_time' => $startTime,
        'end_time' => $endTime
    ];
    header('Location: ../views/CreateReservation.php');
    exit;
}
