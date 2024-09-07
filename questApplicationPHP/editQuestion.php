<?php
include "functions/functions.php";
$id = $_GET['id'];
$quest = getQuestById($id);


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
            <h1>Soru Düzenleme</h1>
            <form action="editQuestionQuery.php" method="POST">
                <input type="hidden" name="id" value="<?= $id ?>" />
                <input type="text" id="question-text" name="quest" placeholder="Soru metnini girin" value="<?= $quest['quest'] ?>" required style="width:96%; text-align: center;">
                <input type="text" class="option-text" name="select_1" placeholder="Şık 1" value="<?= $quest['select_1'] ?>" required style="width: 20%;">
                <input type="text" class="option-text" name="select_2" placeholder="Şık 2" value="<?= $quest['select_2'] ?>" required style="width: 20%;">
                <input type="text" class="option-text" name="select_3" placeholder="Şık 3" value="<?= $quest['select_3'] ?>" required style="width: 20%;">
                <input type="text" class="option-text" name="select_4" placeholder="Şık 4" value="<?= $quest['select_4'] ?>" required style="width: 20%;">
            <select name="answer" id="answer" required>
                <option value="" disabled>Doğru Cevap</option>
                <option value="Şık 1" <?= $quest['answer'] == 'Şık 1' ? 'selected' : '' ?>>Şık 1</option>
                <option value="Şık 2" <?= $quest['answer'] == 'Şık 2' ? 'selected' : '' ?>>Şık 2</option>
                <option value="Şık 3" <?= $quest['answer'] == 'Şık 3' ? 'selected' : '' ?>>Şık 3</option>
                <option value="Şık 4" <?= $quest['answer'] == 'Şık 4' ? 'selected' : '' ?>>Şık 4</option>
            </select>
            <select name="level" id="difficulty" required style="width: 10%;">
                <option value="" disabled>Zorluk Seçiniz</option>
                <option value="easy" <?= $quest['level'] == 'easy' ? 'selected' : '' ?>>Kolay</option>
                <option value="medium" <?= $quest['level'] == 'medium' ? 'selected' : '' ?>>Orta</option>
                <option value="hard" <?= $quest['level'] == 'hard' ? 'selected' : '' ?>>Zor</option>
            </select>
                <button type="submit" style="width: 10%;">Kaydet</button>
                <button style="width: 10%;" onclick="goToHomePage()">Geri Dön</button>
                <a href="questionsList.php" class="questionsListButton">Soruları Listele</a>
    </form>
    </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
