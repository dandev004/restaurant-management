<?php
function card($src, $name, $data)
{ ?>
    <div class="flex flex-col w-[20%] h-[200px] rounded-xl bg-white">
        <div class="w-10 h-10 p-2 rounded-md m-[10px] bg-[#9D00FF]/50">
            <img src="<?= $src ?>" alt="table" class="">
        </div>
        <div class="m-[10px] flex justify-between">
            <p class="text-black/60 text-[16px]"><?= $name; ?></p>
            <p class="text-black text-[16px] font-semibold"><?= $data; ?></p>
        </div>
    </div>
<?php } ?>