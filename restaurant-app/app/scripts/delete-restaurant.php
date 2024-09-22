<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 1) {
    header("Location: ../index.php?message=403 Yetkisiz Giriş");
} else {
    include "../controllers/company-controller.php";

    if (isset($_POST['restaurant_id']) && !empty($_POST['restaurant_id'])) {
        $restaurant_id = $_POST['restaurant_id'];
        DeleteRestaurant($restaurant_id);
        header("Location: ../restaurant-list.php");
        exit();
    } else {
        header("Location: ../restaurant-list.php?message=Eksik bilgi girdiniz.");
        exit();
    }
}
