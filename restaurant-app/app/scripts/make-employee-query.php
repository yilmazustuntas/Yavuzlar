<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../admin.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 0) {
    header("Location: ../index.php?message=403 Yetkisiz Giriş");
} else {
    if (isset($_POST['user_id']) && isset($_POST['company_id'])) {
        include "../controllers/admin-controller.php";
        $user_id = $_POST['user_id'];
        $company_id = $_POST['company_id'];
        MakeEmployee($user_id, $company_id);
        header("Location: ../customer-list.php?message=Kullanıcı başarıyla firma yetkilisi oldu.");
        exit();
    }
    header("Location: ../customer-list.php?message=Kullanıcı yetkilendirilirken hatayla karşılaşıldı.");
    exit();
}
