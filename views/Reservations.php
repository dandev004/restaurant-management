<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/ReservationModel.php';
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ .  '/../components/card.php';
session_start();
$user = User::getUserById($_SESSION['user_id'], $pdo);
if (!$user) {
    header('Location: ../views/Login.php');
    exit;
}
$reservations = Reservation::getAll($pdo);
$page_title = 'All Reservations';
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
    <div class="mr-10 flex justify-end">
        <a
            href="../views/CreateReservation.php"
            class="border border-gray-500 items-center py-2 px-3 bg-[#9D00FF] text-white font-semibold rounded-md hover:opacity-80">New Rezervation</a>
    </div>
    <div class="mt-5 border ">
        <table class="w-full">
            <thead class="bg-gray-200 ">
                <tr>
                    <th class="p-2">ID</th>
                    <th class="p-2">Client Name</th>
                    <th class="p-2">Client Phone</th>
                    <th class="p-2">Number People</th>
                    <th class="p-2">Number Table</th>
                    <th class="p-2">Date Rezervetion</th>
                    <th class="p-2">Start Time</th>
                    <th class="p-2">End Time </th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($reservations)): ?>
                    <tr>
                        <td colspan="8" class="text-center p-4 text-black/50">Reservations empty</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td class="p-2 border"><?= htmlspecialchars($reservation['id']) ?></td>
                            <td class="p-2 border"><?= htmlspecialchars($reservation['client_name']) ?></td>
                            <td class="p-2 border"><?= htmlspecialchars($reservation['client_phone']) ?></td>
                            <td class="p-2 border"><?= htmlspecialchars($reservation['number_people']) ?></td>
                            <td class="p-2 border"><?= htmlspecialchars($reservation['table_number']) ?></td>
                            <td class="p-2 border"><?= htmlspecialchars($reservation['reservation_date']) ?></td>
                            <td class="p-2 border"><?= htmlspecialchars($reservation['start_time']) ?></td>
                            <td class="p-2 border"><?= htmlspecialchars($reservation['end_time']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>

        </table>

    </div>
</body>

</html>
<?php include '../components/footer.php' ?>