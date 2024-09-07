<?php

    include "functions/functions.php";

    $questId = $_GET["id"];

    deleteQuest($questId);
    header("Location:questionsList.php");
    exit();

?>