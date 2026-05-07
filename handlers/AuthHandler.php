<?php
session_start();
require_once __DIR__ . '/../Database/db.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../models/UserModel.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: ../views/Login.php');
    exit;
}
$email = AuthController::sanitizeInput($_POST['email']);
$password = AuthController::sanitizeInput($_POST['password']);

$errors = [];
$errors = AuthController::validate(['email' => $email, 'password' => $password]);

if(empty($errors)) {
    $errors = array_merge($errors, AuthController::validateLogin(['email' => $email, 'password' => $password]));
} else {
    $_SESSION['errors'] = $errors;
    header('Location: ../views/Login.php');
    exit;
}

$user = User::getUserByEmail($email, $pdo);

if(!$user || !password_verify($password, $user['password'])){
    $_SESSION['errors'] = ['general' => "Invalid email or password"];
    $_SESSION['last'] = ['email' => $email];
    header('Location: ../views/Login.php');
    exit;
}
$_SESSION['user_id'] = $user['id'];
header('Location: ../views/Dashboard.php');

?>
