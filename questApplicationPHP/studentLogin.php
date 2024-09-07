<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Öğrenci Giriş Sayfası</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="container">
    <div class="login">
      <div class="logo">
        <img src="logo.png" alt="image" style="background-color: black; width: 400px; height: auto;">
      </div>
      <div class="loginForm">
      <form action="studentLoginQuery.php" method="post">
          <input class="loginInput" type="text" id="username" name="username" placeholder="Kullanıcı Adı" required>
          <input class="loginInput" type="password" id="password" name="password" placeholder="Şifre" required>
          <button type="submit">Giriş Yap</button>
        </form>
        <button onclick="goToHomePage()">Anasayfa</button>
        <button onclick="register()">Kayıt Ol</button>
      </div>
    </div>
  </div>
  <script src="script.js"></script>
</body>

</html>
