<?php
header('Content-Type: application/json');

try {

    $pdo = new PDO('sqlite:db/questapp.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

    $input = json_decode(file_get_contents('php://input'), true);

    $user_id = $input['user_id'];
    $question_id = $input['question_id'];
    $is_correct = $input['is_correct'];

    $query = "INSERT INTO submissions (user_id, question_id, is_correct) VALUES ($user_id, $question_id, $is_correct)";
    $statement = $pdo->prepare($query);
    $statement->execute();

    if ($is_correct) {
        $updateQuery = "UPDATE users SET score = score + 10 WHERE id = $user_id";
        $updateStatement = $pdo->prepare($updateQuery);
        $updateStatement->execute();
    }

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
