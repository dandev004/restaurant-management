<?php
    require_once  __DIR__ . '/../models/UserModel.php';

    class AuthController{

        public static function sanitizeInput($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        public static function validate($data){
            $errors = [];
            if(empty($data['email']))
                $errors['errors_email'] = "Email is required";
            if(empty($data['password']))
                $errors['errors_password'] = "Password is required";

            return $errors;
        }
        public static function validateLogin($data){
            $errors = [];
            if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
                $errors['errors_email'] = "Invalid format email";

            if(strlen($data['password']) < 7)
                $errors['errors_password'] = "Password must contain 8 or more charachters";

             return $errors;
        }

    }
?>