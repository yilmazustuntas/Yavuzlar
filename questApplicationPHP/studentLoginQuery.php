<?php

    session_start();
    include "functions/functions.php";
    if(!isset($_POST['username']) || !isset($_POST['password'])) {
        header("Location: studentLogin.php?message=Kullanıcı adı ve şifre boş bırakılamaz!");
        die();
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        include "functions/db.php";

        $result = Login($username,$password);
        $rowCount = $result['count'];
    
        if($rowCount == 1){
            $userInfo = $result;
            
            $_SESSION["id"] = $result["id"];
            $_SESSION["isAdmin"] = $result["isAdmin"];
            $_SESSION["username"] = $result["nickname"];
            
            header("Location: student.php");
            exit();
        } else {
            echo '<script>alert("Kullanıcı adı veya şifre hatalı!");
            window.location.href = "studentLogin.php";</script>';
            
            exit();
        }

        echo "<pre>";
        print_r($result);
        echo "</pre>";

        die();
    }
?>