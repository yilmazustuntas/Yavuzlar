<?php
include "./controllers/auth-controller.php";
if (IsUserLoggedIn()) {
    header("Location: index.php");
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/style.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="login t0" style="margin-top:5rem; background-color: var(--user);">
            <h2 style="font-weight:300;">Yavuzlar Restoran Uygulaması Admin Paneli</h2>
            <div style="margin-bottom: 2.5rem;">
                <img src="./public/images/logo.png" alt="Login Logo" class="login_logo">
                <form action="./scripts/admin-query.php" method="post">
                    <div class="container_obj">
                        <input style="border-radius: 15px; width: 300px; padding: 8px" type="text" name="username" placeholder="Kullanıcı Adı" required />
                    </div>
                    <div class="container_obj">
                        <input style="border-radius: 15px; width: 300px; padding: 8px" type="password" name="password" placeholder="Şifre" required />
                    </div>
                    <button style="border-radius: 15px; margin-bottom: -30px;" type="submit">Giriş Yap</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>