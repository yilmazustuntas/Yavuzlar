<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../index.php");
    exit();
}
if (isset($_POST['balance']) && $_POST['balance']>=0 ) {
    include "../controllers/customer-controller.php";
    $balance = $_POST['balance'];
    AddBalance($balance);
    header("Location: ../profile.php");
    exit();
} else {
    header("Location: ../profile.php?message=Eksik veya hatalı bilgi girdiniz.");
    exit();
}
