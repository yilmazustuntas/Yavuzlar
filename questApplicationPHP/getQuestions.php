<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php?message=You are not logged in!");
    exit;
}

header('Content-Type: application/json');

try {
    $pdo = new PDO('sqlite:db/questapp.db');
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $userId = $_SESSION['id'];
    $excludedQuery = "SELECT DISTINCT question_id FROM submissions WHERE user_id = :user_id";
    $excludedStatement = $pdo->prepare($excludedQuery);
    $excludedStatement->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $excludedStatement->execute();
    $excludedQuestions = $excludedStatement->fetchAll(PDO::FETCH_COLUMN, 0);
    $excludedIds = $excludedQuestions ? implode(',', array_map('intval', $excludedQuestions)) : '0';
    $query = "SELECT * FROM quests WHERE id NOT IN ($excludedIds)";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $questions = $statement->fetchAll();
    echo json_encode($questions);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
