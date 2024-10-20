<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 0) {
    header("Location: ../index.php?message=403 Yetkisiz Giriş");
} else {
    include "../controllers/admin-controller.php";

    if (isset($_POST['user_id']) && !empty($_POST['user_id']) ) {
        $user_id = $_POST['user_id']; 
        BanUser($user_id);
        header("Location: ../customer-list.php");
        exit();
    } else {
        header("Location: ../customer-list.php?message=Eksik bilgi girdiniz.");
        exit();
    }
}