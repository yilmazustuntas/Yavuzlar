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
    <title>Register</title>
</head>

<body>
    <div class="container">
        <div class="login t0" style="margin-top:5rem; background-color: var(--user);">
            <h2 style="font-weight: 300;" >Kayıt Ol</h2>
            <img src="./public/images/logo.png" alt="Kayıt Logosu" class="login_logo">
            <form action="./scripts/register-query.php" method="post" enctype="multipart/form-data">
                <div style="margin-bottom:2.5rem;">
                    <div class="container_obj">
                        <input style="border-radius: 15px; width: 300px; padding: 8px" type="text" name="name" placeholder="İsim" required />
                    </div>
                    <div class="container_obj">
                        <input style="border-radius: 15px; width: 300px; padding: 8px" type="text" name="surname" placeholder="Soyisim" required />
                    </div>
                    <div class="container_obj">
                        <input style="border-radius: 15px; width: 300px; padding: 8px" type="text" name="username" placeholder="Kullanıcı Adı" required />
                    </div>
                    <div class="container_obj">
                        <label for="image">Profil Fotoğrafı:</label><br>
                        <input style="border-radius: 15px; width: 200px; padding: 5px; margin-top: 10px;" type="file" name="image" accept="image/*" required>
                    </div>
                    <div class="container_obj">
                        <input style="border-radius: 15px; width: 300px; padding: 8px" type="password" name="password" placeholder="Şifre" required />
                    </div>
                    <button style="border-radius: 15px; margin-bottom: -30px;" type="submit">Kayıt Ol</button>
                </div>
            </form>
            <a href="login.php"><button style="border-radius: 15px; margin-top: -20px;">Giriş Yap</button></a>
        </div>
    </div>
</body>

</html>