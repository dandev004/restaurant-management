<?php

class Table
{
    public static function getAllTables($pdo)
    {
        $sql = "SELECT * FROM restaurant_tables";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTablesByType($type, $pdo)
    {
        $sql = "SELECT * FROM restaurant_tables WHERE table_type = :type ORDER BY number";
        $stmt = $pdo->prepare($sql);
        $stmt->bindparam(":type", $type);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function countTables($pdo)
    {
        $sql = "SELECT COUNT(*) as total FROM restaurant_tables";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public static function countTablesDisponibility($pdo)
    {
        $sql = "SELECT COUNT(*) as total FROM restaurant_tables WHERE status = 'free'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateStatus($pdo, $status, $tableNumber)
    {
        $sql = "UPDATE restaurant_tables SET status = :status WHERE number = :number";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":number", $tableNumber);
        $stmt->execute();
    }

}
