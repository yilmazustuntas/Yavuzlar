<?php
session_start();
include "functions/functions.php";


if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
  $name = htmlclean($_POST['name']);
  $surname = htmlclean($_POST['surname']);
  $username = htmlclean($_POST['username']);
  $email = htmlclean($_POST['email']);
  $password = htmlclean($_POST['password']);
  

    SAddUser($name, $surname, $username, $email, $password);
    header("Location: studentLogin.php?message=Kayıt Başarılı!");

} else {
  header("Location: register.php?message=You must fill all the fields!");
}
