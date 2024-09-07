<?php 
  session_start();
  include "functions/functions.php";
  
  if (!isset($_SESSION['id']) && !isset($_SESSION['username']) ) {
    header("Location: studentLogin.php?message=You are not logged in!");
  }

  $scores = getScore();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Scoreboard</title>

  <link rel="stylesheet" href="style.css">

</head>
<body>
  
<div class="userList">
<button id="studentButton" style="width: auto;" onclick="student()">Öğrenci Sayfası</button>

    <table>
      <thead>
        <tr>
            <th>Kullanıcı Adı</th>
            <th>Adı Soyadı</th>
            <th>Puan</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($scores as $user):?>
          <tr>
              <td><?php echo $user['nickname'];?></td>
              <td><?php echo $user['name'] . " " . $user['surname'];?></td>
              <td><?php echo $user['score'];?></td>
          </tr>
        <?php endforeach?>
      </tbody>
    </table>
  </div>

  <script src="script.js"></script>
</body>

</html>
