<?php
session_start();
include "functions/functions.php";

if (!$_SESSION['isAdmin']) {
  header("Location: admin.php?message=You are not authorized to view this page!");
  die();
}
if (!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
  header("Location: login.php?message=You are not logged in!");
  die();
}

if (isset($_POST['quest']) && isset($_POST['select_1']) && isset($_POST['select_2']) && isset($_POST['select_3']) && isset($_POST['select_4']) && isset($_POST['answer']) && isset($_POST['level'])) {
  $quest = htmlclean($_POST['quest']);
  $select_1 = htmlclean($_POST['select_1']);
  $select_2 = htmlclean($_POST['select_2']);
  $select_3 = htmlclean($_POST['select_3']);
  $select_4 = htmlclean($_POST['select_4']);
  $answer = htmlclean($_POST['answer']);
  $level = htmlclean($_POST['level']);

  $result = addquest($quest, $select_1, $select_2, $select_3, $select_4, $answer, $level);

  if ($result) {
    header("Location: admin.php?message=Soru Ekleme İşlemi Başarılı!");
    die();
  } else {
    header("Location: admin.php?message=Soru Ekleme İşlemi Başarısız!");
    die();
  }

} else {
    header("Location: admin.php?message=Hiç Bir Yer Boş Kalmasın!");
  }
  