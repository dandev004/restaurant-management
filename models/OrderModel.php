<?php
class Order {
    
    public static function createOrder($data, $pdo) {
        $sql = "INSERT INTO orders (client_name, table_number, reservation_id, total_amount) 
                VALUES (:client_name, :table_number, :reservation_id, :total_amount)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':client_name' => $data['client_name'],
            ':table_number' => $data['table_number'],
            ':reservation_id' => $data['reservation_id'],
            ':total_amount' => $data['total_amount']
        ]);
        
        return $pdo->lastInsertId();
    }
    
    public static function createOrderItem($data, $pdo) {
        $sql = "INSERT INTO order_items (order_id, product_id, product_name, quantity, price) 
                VALUES (:order_id, :product_id, :product_name, :quantity, :price)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':order_id' => $data['order_id'],
            ':product_id' => $data['product_id'],
            ':product_name' => $data['product_name'],
            ':quantity' => $data['quantity'],
            ':price' => $data['price']
        ]);
        
        return $stmt->rowCount();
    }
    
    
    public static function getAllOrders($pdo) {
        $sql = "SELECT * FROM orders ORDER BY created_at DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function getOrderWithItems($orderId, $pdo) {
        $sql = "SELECT o.*, oi.* 
                FROM orders o
                LEFT JOIN orders_items oi ON o.id = oi.order_id
                WHERE o.id = :order_id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     public static function getDailyReportByTable($date, $pdo) {
        $sql = "SELECT 
                    table_number,
                    COUNT(id) as total_orders,
                    SUM(total_amount) as table_total
                FROM orders 
                WHERE DATE(created_at) = :date
                GROUP BY table_number
                ORDER BY table_number ASC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':date' => $date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function getDailyTotal($date, $pdo) {
        $sql = "SELECT 
                    COUNT(id) as total_orders,
                    SUM(total_amount) as daily_total
                FROM orders 
                WHERE DATE(created_at) = :date";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':date' => $date]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function getOrdersByTableAndDate($tableNumber, $date, $pdo) {
        $sql = "SELECT * FROM orders 
                WHERE table_number = :table_number 
                AND DATE(created_at) = :date
                ORDER BY created_at DESC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':table_number' => $tableNumber,
            ':date' => $date
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function getTodayStats($pdo) {
        $today = date('Y-m-d');
        
        $sql = "SELECT 
                    COUNT(id) as total_orders,
                    SUM(total_amount) as total_revenue,
                    COUNT(DISTINCT table_number) as tables_used
                FROM orders 
                WHERE DATE(created_at) = :today";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':today' => $today]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function getWeekStats($pdo) {
        $sql = "SELECT 
                    COUNT(id) as total_orders,
                    SUM(total_amount) as total_revenue
                FROM orders 
                WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function getMonthStats($pdo) {
        $sql = "SELECT 
                    COUNT(id) as total_orders,
                    SUM(total_amount) as total_revenue
                FROM orders 
                WHERE MONTH(created_at) = MONTH(CURDATE()) 
                AND YEAR(created_at) = YEAR(CURDATE())";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}