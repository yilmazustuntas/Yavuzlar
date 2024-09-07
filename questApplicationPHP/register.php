<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Öğrenci Kayıt Formu</title>

  <link rel="stylesheet" href="style.css">

  <style>

  </style>

</head>
</head>

<body>
  <div class="containerregister">
    <div class="addUserForm">
      <h2 style="margin-bottom: 20px;">Yeni Üye Formu</h2>
      <form action="registerQuery.php" method="POST">
        <input type="text" id="name" name="name" placeholder="İsim" required><br><br>

        <input type="text" id="surname" name="surname" placeholder="Soyisim" required><br><br>

        <input type="text" id="username" name="username" placeholder="Kullanıcı Adı" required><br><br>

        <input type="email" id="email" name="email" placeholder="Email" required><br><br>

        <input type="password" id="password" name="password" placeholder="Şifre" required><br><br>
       
        <button type="submit">Kayıt Ol</button>
        <button style="margin-top: 5px;" id="homePageButton" type="button" onclick="studentlogin()">Öğrenci Sistemi</button>
      </form>

    </div>

  </div>
  <script src="script.js"></script>
</body>

</html>
