<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../index.php");
    exit();
} else if ($_SESSION['role'] != 2) {
    header("Location: ../index.php?message=403 Yetkisiz Giriş");
}

if (isset($_POST['c_id']) && isset($_POST['r_id'])) {
    include "../controllers/customer-controller.php";
    $comment_id = $_POST['c_id'];
    $restaurant_id = $_POST['r_id'];
    DeleteComment($comment_id);
    header("Location: ../restaurant.php?r_id=" . $restaurant_id);
    exit();
} else {
    header("Location: ../foods.php?message=Eksik veya hatali bilgi girdiniz.");
    exit();
}
?>
