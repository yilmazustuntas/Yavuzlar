<?php
session_start();
include "../controllers/auth-controller.php";
if(isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    if(Login($username,$password)){
        if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2) {
            header("Location: ../index.php");
            exit();
        } elseif ($_SESSION['role'] == 0) {
            header("Location: ../login.php?message=admin.php'den giriniz.");
            exit();
        }
        header("Location: ../index.php");
        exit();
    }else{
        header("Location: ../login.php?message=Hatalı kullanıcı adı, şifre veya banlı kullanıcı");
        exit();
    }
}else{
    header("Location: ../index.php?message=Kullanıcı adı veya şifre boş bırakılamaz");
    exit();
}