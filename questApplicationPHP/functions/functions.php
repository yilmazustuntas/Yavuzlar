<?php

    function Login($nickname,$passwd){

        include "db.php";

        $query = "SELECT *,COUNT(*) as count FROM users WHERE nickname = :nickname AND passwd = :passwd";
    
        $statement = $pdo->prepare($query);

        $statement->execute(['nickname' => $nickname, 'passwd' => $passwd]);

        $result = $statement->fetch();

        return $result;
    }

    function htmlclean($text){
        $text = preg_replace("'<script[^>]*>.*?</script>'si", '', $text );
        $text = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $text );
        $text = preg_replace('/<!--.+?-->/', '', $text ); 
        $text = preg_replace('/{.+?}/', '', $text ); 
        $text = preg_replace('/&nbsp;/', ' ', $text );
        $text = preg_replace('/&amp;/', ' ', $text ); 
        $text = preg_replace('/&quot;/', ' ', $text );
        $text = strip_tags($text);
        $text = htmlspecialchars($text); 

        return $text;
    }

    function addquest($quest,$select_1,$select_2,$select_3,$select_4,$answer,$level){

        include "db.php";

        $query = "INSERT INTO quests(quest,select_1,select_2,select_3,select_4,answer,level) VALUES('$quest','$select_1','$select_2','$select_3','$select_4','$answer','$level')";

        $statement = $pdo->prepare($query);

        $statement->execute();
    }

    function getQuestions(){
        include "db.php";

        $query = "SELECT * FROM quests";

        $statement = $pdo->prepare($query);

        $statement->execute();

        $result = $statement->fetchAll();

        return $result;
    }

    function updateQuest($id, $quest, $select_1, $select_2, $select_3, $select_4, $answer, $level) {

        include "db.php";
    
        $query = "UPDATE quests 
                  SET quest = '$quest', select_1 = '$select_1', select_2 = '$select_2', select_3 = '$select_3', select_4 = '$select_4', answer = '$answer', level = '$level'
                  WHERE id = '$id'";
    
        $statement = $pdo->prepare($query);
    
        $statement->execute();

        return $statement->rowCount() > 0;
    }
    
    function deleteQuest($id) {

        include "db.php";
    
        $query = "DELETE FROM quests WHERE id = '$id'";
    
        $statement = $pdo->prepare($query);
    
        $statement->execute();
    }
    
    function getQuestById($id) {
        include "db.php";
        $query = "SELECT * FROM quests WHERE id = :id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    
    function searchQuestions($searchTerm) {
        include "db.php";
        $query = "SELECT * FROM quests WHERE quest LIKE :searchTerm";
        $statement = $pdo->prepare($query);
        $searchTerm = "%" . $searchTerm . "%";
        $statement->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
        $statement->execute();
    
        return $statement->fetchAll();
    }
    
    function SAddUser($name,$surname,$username,$email,$password){

        include "db.php";

        $groupName = 'student';
        $isAdmin = 'no';

        $query = "INSERT INTO users(name,surname,nickname,email,passwd,groupName,isAdmin) VALUES('$name','$surname','$username','$email','$password','$groupName','$isAdmin')";

        $statement = $pdo->prepare($query);

        $statement->execute();
    }

    function getScore(){
        include "db.php";

        $query = "SELECT score, nickname, name, surname FROM users WHERE groupName=:groupName ORDER BY score DESC";

        $statement = $pdo->prepare($query);

        $statement->execute(['groupName' => 'student']);

        $result = $statement->fetchAll();

        return $result;
    }

?>