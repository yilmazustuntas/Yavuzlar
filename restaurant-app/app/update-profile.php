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
    <title>Update Profile</title>
</head>

<body>
    <div class="container">
        <div class="login t<?php echo $_SESSION['role']; ?>">
            <h1 class="searchbox">Profilini Güncelle</h1>
            <img style="margin-top: 10px; margin-bottom: 10px;" src="<?php echo $_SESSION['image_path']; ?>" alt="Profil Resmi" class="medPhoto">
            <form action="./scripts/update-profile-query.php" method="post" enctype="multipart/form-data">
                <div>
                    <div class="container_obj">
                        <label for="name">İsim:</label><br>
                        <input style="border-radius: 15px; width: 200px; padding: 5px; margin-top: 10px;" type="text" name="name" placeholder="İsim" value="<?php echo $_SESSION['name']; ?>" required />
                    </div>
                    <div class="container_obj">
                        <label for="surname">Soyisim:</label><br>
                        <input style="border-radius: 15px; width: 200px; padding: 5px; margin-top: 10px;" type="text" name="surname" placeholder="Soyisim" value="<?php echo $_SESSION['surname']; ?>" required />
                    </div>
                    <div class="container_obj">
                        <label for="username">Kullanıcı Adı:</label><br>
                        <input style="border-radius: 15px; width: 200px; padding: 5px; margin-top: 10px;" type="text" name="username" placeholder="Kullanıcı Adı" value="<?php echo $_SESSION['username']; ?>" required />
                    </div>
                    <div class="container_obj">
                    <label for="image">Profil Resmi:<br></label><br>
                    <input style="border-radius: 15px; width: 200px; padding: 5px; margin-top: 10px;" type="file" name="image" accept="image/*">
                </div>
                    <button  style="border-radius: 15px;" type="submit">Profili Güncelle</button>
                </div>
            </form>
        </div>
    </div>
    <?php require_once "footer.php"; ?>
</body>

</html>