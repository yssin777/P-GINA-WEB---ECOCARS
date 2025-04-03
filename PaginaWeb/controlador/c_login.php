<?php

include_once __DIR__ . '/../model/m_login.php';
session_start();

if (isset($_SESSION['id'])) {
    header("Location: /index.php?llistar-categories");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = $_POST['mail'];
    $password = $_POST['password'];

    $userModel = new UserModel();
    $user = $userModel->getUserByEmail($mail);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];  
        $_SESSION['user_name'] = $user['nom'];
        $_SESSION['profile_picture'] = $user['fotoperfil'];
        header('Location: /index.php?llistar-categories'); 
        exit();
    } else {
        header('Location: /index.php?action=login&error=invalid_credentials');
        exit();
    }
} else {
    include_once __DIR__ . '/../vista/v_login.php';
}
?>
