<?php
$statusColors = [
        'free' => 'border-green-500 bg-green-100 hover:bg-green-200',
        'occupied' => 'border-orange-500 bg-orange-100 hover:bg-orange-200',
        'reserved' => 'border-yellow-500 bg-yellow-100 hover:bg-yellow-200'
];
$colorClasses = $statusColors[$table['status']] ?? 'border-gray-500 bg-gray-100';
?>
<section class="relative flex items-center justify-center w-[310px] h-[160px] group cursor-pointer" data-table-id="<?= $table['id'] ?>">

        <div class="absolute right-0  w-[25px] h-[25px] border-2 rounded-md <?= $colorClasses ?>"></div>

        <div class="absolute   left-0 top-0 translate-x-11 w-[25px] h-[25px] border-2 rounded-md <?= $colorClasses ?>"></div>
        <div class="absolute   left-0 top-0 translate-x-20 w-[25px] h-[25px] border-2 rounded-md <?= $colorClasses ?>"></div>
        <div class="absolute    top-0 w-[25px] h-[25px] border-2 rounded-md <?= $colorClasses ?>"></div>

        <div class="absolute   right-0 top-0 -translate-x-11 w-[25px] h-[25px] border-2 rounded-md <?= $colorClasses ?>"></div>
        <div class="absolute   right-0 top-0 -translate-x-20 w-[25px] h-[25px] border-2 rounded-md <?= $colorClasses ?>"></div>

        <div class="w-[250px] h-[100px] border-2 rounded-md <?= $colorClasses ?>"></div>

        <div class="absolute   left-0 bottom-0 translate-x-11 w-[25px] h-[25px] border-2 rounded-md <?= $colorClasses ?>"></div>
        <div class="absolute   left-0 bottom-0 translate-x-20 w-[25px] h-[25px] border-2 rounded-md <?= $colorClasses ?>"></div>
        <div class="absolute    bottom-0 w-[25px] h-[25px] border-2 rounded-md <?= $colorClasses ?>"></div>

        <div class="absolute   right-0 bottom-0 -translate-x-11 w-[25px] h-[25px] border-2 rounded-md <?= $colorClasses ?>"></div>
        <div class="absolute   right-0 bottom-0 -translate-x-20 w-[25px] h-[25px] border-2 rounded-md <?= $colorClasses ?>"></div>

        <div class="absolute left-0  w-[25px] h-[25px] border-2 rounded-md <?= $colorClasses ?>"></div>

        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm font-bold">
                <?= $table['number'] ?></div>

        <div class="absolute -top-2 -right-2 px-2 py-1 rounded-full text-xs font-semibold 
        <?= $table['status'] === 'free' ? 'bg-green-500 text-white' : ($table['status'] === 'occupied' ? 'bg-orange-500 text-white' : 'bg-yellow-500 text-gray-800') ?>">
                <?= ucfirst($table['status']) ?>
        </div>
</section>