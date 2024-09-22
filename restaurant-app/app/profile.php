<?php
session_start();
include "./controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
}
require_once "header.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/style.css">
    <title>Profile</title>
</head>

<body>
<div class="container">
    <div class="login t<?php echo $_SESSION['role']; ?>">
        <h2>Profil</h2>
        <div>
            <h4>Ad: <?php echo $_SESSION['name']; ?></h4>
            <h4>Soyad: <?php echo $_SESSION['surname']; ?></h4>
            <h4>Kullanıcı Adı: <?php echo $_SESSION['username']; ?></h4>
            <h4>Bakiye: <?php echo $_SESSION['balance']; ?></h4>
            <h4>Kayıt Tarihi: <?php echo  $_SESSION['created_at']; ?></h4>
        </div>
        <div>
            <a href="update-password.php"><button style="border-radius: 15px;" class="container_obj">Şifreyi Güncelle</button></a>
            <?php if ($_SESSION['role'] != 0): ?>
                <a href="update-profile.php"><button style="border-radius: 15px;" class="container_obj">Profili Güncelle</button></a>
            <?php endif; ?>
            <?php if ($_SESSION['role'] != 1 && $_SESSION['role'] != 0): ?>
                <a href="add-balance.php"><button style="border-radius: 15px;" class="container_obj">Bakiye Ekle</button></a>
            <?php endif; ?>
            <a href="index.php"><button style="border-radius: 15px;">Ana Sayfa</button></a>
        </div>
    </div>
</div>
    <?php require_once "footer.php"; ?>
</body>

</html>