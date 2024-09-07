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
    <title>Öğrenci Sistemi</title>
    <link rel="stylesheet" href="style.css">
  </head>

  <body>

    <div class="navbarContainer">
    <form action="logout.php" method="post">
        <button class="logout" id="logoutButton">Çıkış Yap</button>
      </form>
      <div class="header">
        <h1>Yavuzlar Takımı</h1>
      </div>
      <div class="navbar">
        <a href="scoreboard.php">
          <div class="navbarButton">
          Scoreboard
          </div>
        </a>
        <a href="quiz.php">
          <div class="navbarButton">
            Soru Çöz
          </div>
        </a>
      </div>
    </div>
    </div>
    </div>

  </body>

  </html>