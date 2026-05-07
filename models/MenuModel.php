<?php
class Menu
{
    public static function getAllByCategory($category, $pdo)
    {
        $sql = "SELECT * FROM products WHERE category=:category ORDER BY id ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':category', $category);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllCategory($pdo)
    {
        $sql = "SELECT DISTINCT category FROM products";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getProductById($id, $pdo)
    {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateProduct($id, $data, $pdo) {
        $sql = "UPDATE products 
                SET name = :name, 
                    category = :category, 
                    price = :price, 
                    image = :image 
                WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':category' => $data['category'],
            ':price' => $data['price'],
            ':image' => $data['image']
        ]);
    }
    
    public static function deleteProduct($id, $pdo) {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
