<?php
  session_start();
  if (!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header("Location: login.php?message=You are not logged in!");
  }
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link rel="stylesheet" href="style.css">
    <script>
        const userId = <?php echo json_encode($_SESSION['id']); ?>;
    </script>
</head>
<body>
    <div class="container">
        <div class="addUserForm">
    <div id="quiz-container">
        <h2 style="margin: 15px;" id="quiz-question"></h2>
        <div style="margin: 10px;" id="quiz-options"></div>
        <button style="width: auto;" id="next-question">Sonraki Soru</button>
    </div>
    <div id="quiz-result" style="display:none;">
        <h2>Sonuç</h2>
        <p id="score"></p>
        <button style="width: auto;" onclick="student()">Öğrenci Sayfası</button>
    </div>
</div>
</div>
    <script src="quiz.js"></script>
</body>
</html>
