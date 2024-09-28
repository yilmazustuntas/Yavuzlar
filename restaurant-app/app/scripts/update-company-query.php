<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 0 && $_SESSION['role'] != 1) {
    header("Location: ../index.php?message=403 Yetkisiz Giriş");
} else {
    if (isset($_POST['company_id']) && isset($_POST['name']) && isset($_POST['description'])) {
        include "../controllers/admin-controller.php";
        $name = $_POST['name'];
        $description = $_POST['description'];
        $company_id = $_POST['company_id'];

        $company = GetCompanyById($company_id);
        $old_logo_path = $company['logo_path'];
        
        $logo_path = $old_logo_path;

        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
            $max_size = 2 * 1024 * 1024;
            $target_dir = "./uploads/company/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $new_file_name = time() . "." . $image_file_type;
            $logo_path = $target_dir . $new_file_name;

            if (filesize($_FILES["image"]["tmp_name"]) > $max_size) {
                header("Location: ../add-company.php?message=Resim boyutu 2MB altında olmalıdır.");
                exit();
            }
            if (move_uploaded_file($_FILES["image"]["tmp_name"], "../uploads/company/" . $new_file_name)) {
                if (file_exists($old_logo_path) && $old_logo_path) {
                    unlink($old_logo_path);
                }
            } else {
                header("Location: ../add-company.php?message=Resim yüklenirken bir hata oluştu!");
                exit();
            }
        }

        UpdateCompany($company_id, $name, $description, $logo_path);

        if ($_SESSION['role'] == 0) {
            header("Location: ../company-list.php?message=Başarıyla güncellendi!");
            exit();
        } else if ($_SESSION['role'] == 1) {
            header("Location: ../index.php?message=Başarıyla güncellendi!");
            exit();
        }
    } else {
        header("Location: ../add-company.php?message=Eksik veya hatalı bilgi girdiniz.");
        exit();
    }
}
