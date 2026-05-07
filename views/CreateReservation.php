<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/TableModel.php';
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ .  '/../components/card.php';

session_start();

$user = User::getUserById($_SESSION['user_id'], $pdo);
if (!$user) {
    header('Location: ../views/Login.php');
    exit;
}

$page_title = 'Create Reservation';

$errors = $_SESSION['errors'] ?? [];
$last = $_SESSION['last'] ?? [];
unset($_SESSION['errors'], $_SESSION['last']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Dashboard</title>
</head>

<body class="bg-gray-100 ">
    <?php include '../components/header.php'; ?>
    <section class="flex justify-center items-center ">
        <div class="w-1/2 bg-white rounded-md p-6 flex flex-col justify-center items-center">
            <h1 class="text-xl font-bold text-[#9D00FF]">Create Rezervation</h1>
            <form action="../handlers/ReservationHandler.php" method="post" class="mt-2 w-full">
                <label for="client_name" class="text-[16px]">Client Name</label>
                <input
                    type="text"
                    name="client_name"
                    id="client_name"
                    placeholder="John"
                    value="<?= htmlspecialchars($last['client_name'] ?? '') ?>"
                    class="w-full border border-gray-200 rounded-md p-2 placeholder:text-black/30">
                <?php if (isset($errors['client_name'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['client_name'] ?></p>
                <?php endif; ?>

                <label for="client_phone" class="text-[16px] ">Client Phone</label>
                <input
                    type="tel"
                    name="client_phone"
                    id="client_phone"
                    placeholder="+373 789 22 89"
                    value="<?= htmlspecialchars($last['client_phone'] ?? '') ?>"
                    class="w-full border border-gray-200 rounded-md p-2 placeholder:text-black/30">
                <?php if (isset($errors['client_phone'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['client_phone'] ?></p>
                <?php endif; ?>

                <label for="number_people" class="text-[16px]">Number People</label>
                <input
                    type="number"
                    name="number_people"
                    id="number_people"
                    placeholder="0"
                    value="<?= htmlspecialchars($last['number_people'] ?? '') ?>"
                    class="w-full border border-gray-200 rounded-md p-2 placeholder:text-black/30">
                <?php if (isset($errors['number_people'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['number_people'] ?></p>
                <?php endif; ?>

                <label for="table_number" class="text-[16px]">Table Number</label>
                <input
                    type="number"
                    name="table_number"
                    id="table_number"
                    placeholder="0"
                    value="<?= htmlspecialchars($last['table_number'] ?? '') ?>"
                    class="w-full border border-gray-200 rounded-md p-2 placeholder:text-black/30">
                <?php if (isset($errors['table_number'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['table_number'] ?></p>
                <?php endif; ?>

                <label for="reservation_date" class="text-[16px]">Rezervation Date</label>
                <input
                    type="date"
                    name="reservation_date"
                    id="reservation_date"
                    placeholder="0"
                    value="<?= htmlspecialchars($last['reservation_date'] ?? '') ?>"
                    class="w-full border border-gray-200 rounded-md p-2 placeholder:text-black/30">
                <?php if (isset($errors['reservation_date'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['reservation_date'] ?></p>
                <?php endif; ?>

                <label for="start_time" class="text-[16px]">Start Time</label>
                <input
                    type="time"
                    name="start_time"
                    id="start_time"
                    placeholder="0"
                    value="<?= htmlspecialchars($last['start_time'] ?? '') ?>"
                    class="w-full border border-gray-200 rounded-md p-2 placeholder:text-black/30">
                <?php if (isset($errors['start_time'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['start_time'] ?></p>
                <?php endif; ?>

                <label for="end_time" class="text-[16px]">End Time</label>
                <input
                    type="time"
                    name="end_time"
                    id="end_time"
                    placeholder="0"
                    value="<?= htmlspecialchars($last['end_time'] ?? '') ?>"
                    class="w-full border border-gray-200 rounded-md p-2 placeholder:text-black/30">
                <?php if (isset($errors['end_time'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['end_time'] ?></p>
                <?php endif; ?>
                <?php if (isset($errors['time_conflict'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['time_conflict'] ?></p>
                <?php endif; ?>

                <button type="submit" class="w-full mt-5 text-white font-semibold p-2 rounded-md bg-[#9D00FF] hover:bg-[#9D00FF]/80">Continue</button>

            </form>
        </div>
    </section>
</body>

</html>
<?php include '../components/footer.php' ?>