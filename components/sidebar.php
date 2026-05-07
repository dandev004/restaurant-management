<?php
$current_page = basename($_SERVER['PHP_SELF']); 
?>
<aside class="sticky top-0 h-screen w-[15%] bg-gray-100 flex">
    <nav class="flex-1 p-4 space-y-4">
        <a href="../views/Dashboard.php" class="px-3 mb-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Restaurant</a>

        <a href="../views/Reservations.php"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 <?= $current_page === 'Reservations.php' ? 'bg-[#9D00FF] text-white shadow-lg shadow-[#9D00FF]' : 'text-zinc-400 hover:text-black hover:bg-[#9D00FF]/10' ?>">
            <img src="../assets/images/reservation.png" alt="reservation" class="w-5 h-5">
            Reservations
        </a>

        <a href="../views/Tables.php"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 <?= $current_page === 'Tables.php' ? 'bg-[#9D00FF] text-white shadow-lg shadow-[#9D00FF]' : 'text-zinc-400 hover:text-black hover:bg-[#9D00FF]/10' ?>">
            <img src="../assets/images/table.png" alt="reservation" class="w-5 h-5">
            Tables
        </a>

        <a href="../views/Orders.php"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 <?= $current_page === 'Orders.php' ? 'bg-[#9D00FF] text-white shadow-lg shadow-[#9D00FF]' : 'text-zinc-400 hover:text-black hover:bg-[#9D00FF]/10' ?>">
            <img src="../assets/images/orders.png" alt="reservation" class="w-5 h-5">
            Orders
        </a>

        <a href="../views/Menu.php"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 <?= $current_page === 'Menu.php' ? 'bg-[#9D00FF] text-white shadow-lg shadow-[#9D00FF]' : 'text-zinc-400 hover:text-black hover:bg-[#9D00FF]/10' ?>">
            <img src="../assets/images/menu.png" alt="reservation" class="w-5 h-5">
            Menu
        </a>
    </nav>
    <div class="w-[2px] h-full bg-black/40"></div>
</aside>
