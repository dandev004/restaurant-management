<?php

class OrderController
{
    public static function sanitizeInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public static function validate($data)
    {
        $errors = [];
        
        if (empty($data['client_name'])) {
            $errors['client_name'] = 'Name is required';
        } elseif (!preg_match("/^[a-zA-Z\s]{3,50}$/", $data['client_name'])) {
            $errors['client_name'] = 'Name must contain only letters and spaces (min 3)';
        }
        
        if (empty($data['select_table'])) {
            $errors['select_table'] = 'Table number is required';
        } elseif (!preg_match("/^(?:[1-9]|1[0-3])$/", $data['select_table'])) {
            $errors['select_table'] = 'Table must be between 1 and 13';
        }
        
        if (!empty($data['reservation_id']) && !is_numeric($data['reservation_id'])) {
            $errors['reservation_id'] = 'Reservation ID must be a number';
        }
        
        if (empty($data['total_amount'])) {
            $errors['total_amount'] = 'Total amount is required';
        } elseif (!is_numeric($data['total_amount']) || $data['total_amount'] <= 0) {
            $errors['total_amount'] = 'Total amount must be greater than 0';
        }
        
        return $errors;
    }
}