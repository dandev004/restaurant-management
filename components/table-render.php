<?php
function renderTable($table) {
    $componentMap = [
        'roundTable2' => '../components/roundTable2.php',
        'roundTable4' => '../components/roundTable4.php',
        'roundTable12' => '../components/roundTable12.php',
        'squareTable2' => '../components/squareTable2.php',
        'squareTable4' => '../components/squareTable4.php',
        'rectangularTable6' => '../components/rectangularTable6.php',
        'rectangularTable12' => '../components/rectangularTable12.php',
    ];
    
    if (isset($componentMap[$table['table_type']])) {
        include $componentMap[$table['table_type']];
    }
}
?>