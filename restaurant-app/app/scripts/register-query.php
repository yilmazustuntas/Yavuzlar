<?php
session_start();
include "../controllers/auth-controller.php";
if (IsUserLoggedIn()) {
    header("Location: ../index.php");
    exit();
}
if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['username']) && isset($_FILES["image"]) && isset($_POST['password'])) {
    include "../controllers/company-controller.php";
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $max_size = 2 * 1024 * 1024;
    $target_dir = "./uploads/users/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $new_file_name = time() . "." . $image_file_type;
    $image_path = $target_dir . $new_file_name;
    if (filesize($_FILES["image"]["tmp_name"]) > $max_size) {
        header("Location: ../register.php?message=Resim boyutu 2MB altında olmalıdır.");
        exit();
    }
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "../uploads/users/" . $new_file_name)) {
        Register($name, $surname, $username, $image_path, $password);
        header("Location: ../login.php?message=Başarıyla kaydedildi!");
        exit();
    } else {
        header("Location: ../register.php?message=Resim yüklenirken bir hata oluştu!");
        exit();
    }
} else {
    header("Location: ../login.php?message=Eksik bilgi girdiniz.");
    exit();
}
