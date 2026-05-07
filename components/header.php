<?php
require_once __DIR__ . '../../models/UserModel.php';
require_once __DIR__ . '../../database/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="flex min-h-screen">
        <?php include 'sidebar.php'; ?>
        <main class="flex-1 ml-8 overflow-auto">
            <header>
                <div class="flex items-center justify-between h-16 px-8">
                    <div>
                        <h1 class="text-xl font-semibold tracking-tight"><?= $page_title ?? 'Dashboard' ?></h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-zinc-500"><?= date('l, M j, Y') ?></span>
                        <div class="w-px h-6 bg-white/10"></div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-accent to-purple-600 flex items-center justify-center text-sm font-semibold">
                                <?= strtoupper(substr($user['last_name'], 0, 1)) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="p-2 ml-[20px] ">