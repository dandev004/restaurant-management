<?php
session_start();
require_once __DIR__ . '/../Database/db.php';
require_once __DIR__ . '/../models/MenuModel.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/Menu.php');
    exit;
}

$action = $_POST['action'] ?? '';

if ($action === 'update') {
    $productId = $_POST['product_id'];
    $name = trim($_POST['name']);
    $category = $_POST['category'];
    $price = $_POST['price'];
    $currentImage = $_POST['current_image'];
    
    $imageName = $currentImage;
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/menu/';
        $imageExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid() . '.' . $imageExtension;
        $uploadPath = $uploadDir . $imageName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            
            if ($currentImage && $currentImage !== $imageName && file_exists($uploadDir . $currentImage)) {
                unlink($uploadDir . $currentImage);
            }
        } else {
            $_SESSION['errors'] = ['Failed to upload image'];
            header('Location: ../views/Menu.php');
            exit;
        }
    }
    
    try {
        Menu::updateProduct($productId, [
            'name' => $name,
            'category' => $category,
            'price' => $price,
            'image' => $imageName
        ], $pdo);
        
        $_SESSION['success'] = 'Product updated successfully!';
    } catch (Exception $e) {
        $_SESSION['errors'] = ['Error updating product: ' . $e->getMessage()];
    }
    
    header('Location: ../views/Menu.php');
    exit;
}

if ($action === 'delete') {
    $productId = $_POST['product_id'];
    
    try {
       
        $product = Menu::getProductById($productId, $pdo);
        
        if ($product) {
           
            $imagePath = __DIR__ . '/../uploads/menu/' . $product['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            
            
            Menu::deleteProduct($productId, $pdo);
            
            $_SESSION['success'] = 'Product deleted successfully!';
        } else {
            $_SESSION['errors'] = ['Product not found'];
        }
    } catch (Exception $e) {
        $_SESSION['errors'] = ['Error deleting product: ' . $e->getMessage()];
    }
    
    header('Location: ../views/Menu.php');
    exit;
}

$_SESSION['errors'] = ['Invalid action'];
header('Location: ../views/Menu.php');
exit;