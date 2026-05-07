<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/TableModel.php';
require_once __DIR__ . '/../database/db.php';
session_start();
$user = User::getUserById($_SESSION['user_id'], $pdo);
if (!$user) {
    header('Location: ../views/Login.php');
    exit;
}

$page_title = 'Tables';
$roundTables2 = Table::getTablesByType("roundTable2", $pdo);
$roundTables4 = Table::getTablesByType("roundTable4", $pdo);
$roundTables12 = Table::getTablesByType("roundTable12", $pdo);
$squareTables2 = Table::getTablesByType("squareTable2", $pdo);
$squareTables4 = Table::getTablesByType("squareTable4", $pdo);
$rectangularTables6 = Table::getTablesByType("rectangularTable6", $pdo);
$rectangularTables12 = Table::getTablesByType("rectangularTable12", $pdo);
?>

<?php include '../components/header.php'; ?>

<section class="bg-white rounded-md h-[calc(100vh-8rem)] overflow-hidden">
    <div class="relative m-4">
        <div class="flex flex-wrap lg:space-x-10 lg:flex-nowrap">
            <?php foreach ($roundTables2 as $table): ?>
                <?php include '../components/roundTable2.php'; ?>
            <?php endforeach; ?>
        </div>

        <div class="lg:absolute lg:top-0 lg:left-1/2 lg:-translate-x-40">
            <?php foreach ($squareTables2 as $table): ?>
                <?php include '../components/squareTable2.php'; ?>
            <?php endforeach; ?>
        </div>
        
        <div class="flex flex-col lg:absolute lg:top-0 lg:left-1/2 lg:translate-x-16 lg:space-y-10">
            <?php foreach ($roundTables4 as $table): ?>
                <?php include '../components/roundTable4.php'; ?>
            <?php endforeach; ?>
        </div>
        
    
        <div class="mt-6 flex flex-col lg:absolute lg:top-0 lg:left-1/2 lg:translate-x-20 lg:translate-y-40 lg:space-y-10">
            <?php foreach ($squareTables4 as $table): ?>
                <?php include '../components/squareTable4.php'; ?>
            <?php endforeach; ?>
        </div>
        
        <div class="flex flex-wrap lg:absolute lg:translate-x-24 lg:space-x-20 lg:mt-10">
            <?php foreach ($roundTables12 as $table): ?>
                <?php include '../components/roundTable12.php'; ?>
            <?php endforeach; ?>
        </div>

        <div class="flex flex-col lg:absolute lg:right-10 lg:top-0 lg:space-y-16">
            <?php foreach ($rectangularTables6 as $table): ?>
                <?php include '../components/rectangularTable6.php'; ?>
            <?php endforeach; ?>
        </div>
        
        <div class="mt-4 flex flex-wrap lg:absolute lg:left-0 lg:top-0 lg:translate-y-[480px] lg:space-x-10">
            <?php foreach ($rectangularTables12 as $table): ?>
                <?php include '../components/rectangularTable12.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php include '../components/footer.php' ?>