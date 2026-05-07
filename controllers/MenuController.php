<?php

class MenuController
{
    public static function sanitizeInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    public static function sanitizeProducts($productIds, $productNames, $productPrices, $productQuantities)
    {
        $sanitizedProducts = [];
        
        for ($i = 0; $i < count($productIds); $i++) {
            $sanitizedProducts[] = [
                'id' => self::sanitizeInput($productIds[$i]),
                'name' => self::sanitizeInput($productNames[$i]),
                'price' => self::sanitizeInput($productPrices[$i]),
                'quantity' => self::sanitizeInput($productQuantities[$i])
            ];
        }
        
        return $sanitizedProducts;
    }
    
    public static function validateProducts($productIds)
    {
        $errors = [];
        
        if (empty($productIds) || !is_array($productIds) || count($productIds) === 0) {
            $errors['products'] = 'Please add at least one product';
        }
        
        return $errors;
    }
}