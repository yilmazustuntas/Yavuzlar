<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../index.php");
    exit();
} else if ($_SESSION['role'] != 2) {
    header("Location: ../index.php?message=403 Yetkisiz Giriş");
}
include "../controllers/customer-controller.php";
$user_id = $_SESSION['user_id'];
$cupon = isset($_SESSION['cupon']) ? $_SESSION['cupon'] : null;
if ($cupon === null) {
}
ConfirmBasket($user_id,$cupon);
header("Location: ../orders.php");
exit();