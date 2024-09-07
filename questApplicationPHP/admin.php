<?php
  session_start();
  if (!$_SESSION['isAdmin']) {
    header("Location: index.php?message=You are not authorized to view this page!");
    die();
  }
  if (!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header("Location: login.php?message=You are not logged in!");
  }
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yavuzlar Yönetici Paneli</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="addUserForm">
    <h1>Soru Ekleme</h1>
    <form action="addQuestQuery.php" method="POST">
    <input type="text" id="question-text" name="quest" placeholder="Soru metnini girin" required style="width:96%; text-align: center;" >
    <input type="text" class="option-text" name="select_1" placeholder="Şık 1" required style="width: 20%;">
    <input type="text" class="option-text" name="select_2" placeholder="Şık 2" required style="width: 20%;">
    <input type="text" class="option-text" name="select_3" placeholder="Şık 3" required style="width: 20%;">
    <input type="text" class="option-text" name="select_4" placeholder="Şık 4" required style="width: 20%;">
    <select name="answer" id="answer" required>
        <option value="" selected disabled>Doğru Cevap</option>
        <option value="Şık 1">Şık 1</option>
        <option value="Şık 2">Şık 2</option>
        <option value="Şık 3">Şık 3</option>
        <option value="Şık 4">Şık 4</option>
    </select>
    <select name="level" id="difficulty" required style="width: 10%;">
        <option value="" selected disabled>Zorluk Seçiniz</option>
        <option value="easy">Kolay</option>
        <option value="medium">Orta</option>
        <option value="hard">Zor</option>
    </select>
    
    <button type="submit" style="width: 10%;">Kaydet</button>
    <button style="width: 10%;" onclick="goToHomePage()">Anasayfa</button>
    <a href="questionsList.php" class="questionsListButton">Soruları Listele</a>

</form>

    </div>
</div>

    <script src="script.js"></script>
</body>
</html>
