<?php
session_start();
include "../controllers/auth-controller.php";

if (!IsUserLoggedIn()) {
    header("Location: ../login.php?message=Lütfen giriş yapınız.");
    exit();
} elseif ($_SESSION['role'] != 1) {
    header("Location: ../index.php?message=403 Yetkisiz Giriş");
    exit();
}

include "../controllers/company-controller.php";

if (isset($_POST['o_id']) && isset($_POST['value'])) {
    $order_id = $_POST['o_id'];
    $value = $_POST['value'];
    $result = UpdateOrderStatus($order_id, $value);

    if ($result) {
        header("Location: ../customer-orders.php?message=Durum başarıyla güncellendi.");
    } else {
        header("Location: ../customer-orders.php?message=Güncelleme başarısız.");
    }
} else {
    header("Location: ../customer-orders.php?message=Eksik veya hatalı bilgi girdiniz.");
    exit();
}
