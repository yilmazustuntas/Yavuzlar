<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['username'])) {
    include "../controllers/customer-controller.php";
    include "../controllers/company-controller.php";
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];

    $old_image_path = $_SESSION["image_path"];

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $max_size = 2 * 1024 * 1024;
        $target_dir = "./uploads/users/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $new_file_name = time() . "." . $image_file_type;
        $image_path = $target_dir . $new_file_name;

        if (filesize($_FILES["image"]["tmp_name"]) > $max_size) {
            header("Location: ../update-profile.php?message=Resim boyutu 2MB altında olmalıdır.");
            exit();
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], "../uploads/users/" . $new_file_name)) {
            if (file_exists($old_image_path) && $old_image_path) {
                unlink($old_image_path);
            }
        } else {
            header("Location: ../update-profile.php?message=Resim yüklenirken bir hata oluştu!");
            exit();
        }
    }
    UpdateProfile($name, $surname, $username, isset($image_path) ? $image_path : null);
    header("Location: ../profile.php?message=Başarıyla kaydedildi!");
    exit();
} else {
    header("Location: ../profile.php?message=Eksik bilgi girdiniz.");
    exit();
}
