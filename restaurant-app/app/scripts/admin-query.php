<?php
session_start();
include "../controllers/auth-controller.php";

if (isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (Login($username, $password)) {
        if ($_SESSION['role'] == 0) {
            header("Location: ../index.php");
            exit();
        } else {
            header("Location: ../admin.php?message=403 Yetkisiz erişim.");
            exit();
        }
    } else {
        header("Location: ../admin.php?message=Hatalı kullanıcı adı, şifre veya banlı kullanıcı");
        exit();
    }
} else {
    header("Location: ../admin.php?message=Kullanıcı adı veya şifre boş bırakılamaz");
    exit();
}
