<?php
$statusColors = [
    'free' => 'border-green-500 bg-green-100 hover:bg-green-200',
    'occupied' => 'border-orange-500 bg-orange-100 hover:bg-orange-200',
    'reserved' => 'border-yellow-500 bg-yellow-100 hover:bg-yellow-200'
];
$colorClasses = $statusColors[$table['status']] ?? 'border-gray-500 bg-gray-100';
?>
<section class="relative flex items-center justify-center w-[190px] h-[190px] group cursor-pointer" data-table-id="<?= $table['id'] ?>">

    <div class="absolute top-0 w-[30px] h-[30px] border-2 rounded-full <?= $colorClasses ?>"></div>

    <div class="absolute right-2 top-10 w-[30px] h-[30px] border-2 rounded-full <?= $colorClasses ?>"></div>
    <div class="absolute right-10 top-2 w-[30px] h-[30px] border-2 rounded-full <?= $colorClasses ?>"></div>

    <div class="absolute right-0 w-[30px] h-[30px] border-2 rounded-full <?= $colorClasses ?>"></div>

    <div class="absolute left-2 top-10 w-[30px] h-[30px] border-2 rounded-full <?= $colorClasses ?>"></div>
    <div class="absolute left-10 top-2 w-[30px] h-[30px] border-2 rounded-full <?= $colorClasses ?>"></div>


    <div class="absolute left-0 w-[30px] h-[30px] border-2 rounded-full <?= $colorClasses ?>"></div>

    <div class="absolute left-2 bottom-10 w-[30px] h-[30px] border-2 rounded-full <?= $colorClasses ?>"></div>
    <div class="absolute left-10 bottom-2 w-[30px] h-[30px] border-2 rounded-full <?= $colorClasses ?>"></div>


    <div class="absolute bottom-0 w-[30px] h-[30px] border-2 rounded-full <?= $colorClasses ?>"></div>

    <div class="absolute right-2 bottom-10  w-[30px] h-[30px] border-2 rounded-full <?= $colorClasses ?>"></div>
    <div class="absolute right-10 bottom-2  w-[30px] h-[30px] border-2 rounded-full <?= $colorClasses ?>"></div>


    <div class="w-[120px] h-[120px] border-2 rounded-full <?= $colorClasses ?>"></div>

    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm font-bold">
        <?= $table['number'] ?>
    </div>

    <div class="absolute -top-2 -right-2 px-2 py-1 rounded-full text-xs font-semibold 
        <?= $table['status'] === 'free' ? 'bg-green-500 text-white' : ($table['status'] === 'occupied' ? 'bg-orange-500 text-white' : 'bg-yellow-500 text-gray-800') ?>">
        <?= ucfirst($table['status']) ?>
    </div>

</section>