<?php 
  session_start();
  include "functions/functions.php";

  if (!isset($_SESSION['id']) && !isset($_SESSION['username']) ) {
    header("Location: login.php?message=You are not logged in!");
  }
  if (isset($_POST['searchTerm'])) {
    $searchTerm = htmlclean($_POST['searchTerm']);
    $fenerbahce = searchQuestions($searchTerm);
  } else {
    $fenerbahce = getQuestions();
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Soru Listeleme/Düzenleme</title>

  <link rel="stylesheet" href="style.css">

</head>

<style>


</style>

<body>

  <div class="userList">
  <div class="action-buttons">
  <form id="search-form" method="POST" action="">
    <input type="text" id="search-input" class="search-input" name="searchTerm" placeholder="Soru ara...">
    <button style="width: 200px;" type="submit" class="search-button">Ara</button>
  </form>
    <button style="width: 200px;" id="homePageButton" onclick="goToHomePage()">Anasayfa</button>
    <button style="width: 200px;" id="adminpanel" onclick="adminpanel()">Admin Paneli</button>
    
  
  </div>
    <table>
      <thead>
        <tr>
          <?php
          if($_SESSION['isAdmin']):?>
          <th>ID</th>
            <th>Soru</th>
          <?php endif?>
            <th>Şık 1</th>
            <th>Şık 2</th>
            <th>Şık 3</th>
            <th>Şık 4</th>
            <th>Doğru Cevap</th>
          <?php if( $_SESSION['isAdmin']):?>
            <th>Zorluk Seviyesi</th>
            <th colspan="2">İşlemler</th>
          <?php endif?>
        </tr>
      </thead>
      <tbody>
        <?php foreach($fenerbahce as $quests):?>
          <tr>
            <?php if($_SESSION['isAdmin']):?>
              <td><?php echo $quests['id'];?></td>
              <td><?php echo $quests['quest'];?></td>
            <?php endif?>
              <td><?php echo $quests['select_1'];?></td>
              <td><?php echo $quests['select_2'];?></td>
              <td><?php echo $quests['select_3'];?></td>
              <td><?php echo $quests['select_4'];?></td>
              <td><?php echo $quests['answer'];?></td>
              <td><?php echo $quests['level'];?></td>
            <?php if( $_SESSION['isAdmin']):?>
              <td><a href='deleteQuestion.php?id=<?php echo $quests["id"]?>'>Sil</a></td>
              <td><a href='editQuestion.php?id=<?php echo $quests["id"]?>'>Düzenle</a></td>
            <?php endif?>
          </tr>
        <?php endforeach?>
      </tbody>
    </table>
  </div>
  <script src="script.js"></script>
</body>

</html>
