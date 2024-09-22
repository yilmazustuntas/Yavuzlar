<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../index.php");
    exit();
}else if ($_SESSION['role'] != 2) {
    header("Location: ../index.php?message=403 Yetkisiz Giriş");
}
if (isset($_POST['basket_id'])) {
    include "../controllers/customer-controller.php";
    $basket_id = $_POST['basket_id'];
    DeleteFromBasket($basket_id);
    header("Location: ../basket.php");
    exit();
} else {
    header("Location: ../basket.php?message=Eksik veya hatali bilgi girdiniz.");
    exit();
}
