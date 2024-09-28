<?php
include __DIR__ . '/../scripts/functions.php';
include __DIR__ . '/../config/db.php';

function FindUser($username)
{
    global $pdo;
    $query = "SELECT * FROM users WHERE username=:username";
    $statement = $pdo->prepare($query);
    $statement->execute(['username' => htmlclean($username)]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function Login($username, $password)
{
    global $pdo;
    $user = FindUser($username);
    if ($user && password_verify($password, $user['password']) && empty($user['deleted_at'])) {
        session_regenerate_id();
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['surname'] = $user['surname'];
        $_SESSION['balance'] = $user['balance'];
        $_SESSION['created_at'] = $user['created_at'];
        if (!empty($user['image_path'])) {
            $_SESSION['image_path'] = $user['image_path'];
        }
        if (!empty($user['company_id'])) {
            $_SESSION['company_id'] = $user['company_id'];
        }
        return true;
    }
    return false;
}

function Register($name, $surname, $username, $image_path, $password)
{
    global $pdo;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = htmlclean($name);
        $surname = htmlclean($surname);
        $username = htmlclean($username);
        $image_path = htmlclean($image_path);
        $password = htmlclean($password);
        $encrypted_password = password_hash($password, PASSWORD_ARGON2ID);
        $created_at = (new DateTime())->format('Y-m-d H:i:s');
        $query = "INSERT INTO users(name, surname, username, image_path, password, created_at) VALUES(:name, :surname, :username, :image_path, :password, :created_at)";
        $statement = $pdo->prepare($query);
        $statement->execute(['name' => $name, 'surname' => $surname, 'username' => $username, "image_path"=>$image_path, 'password' => $encrypted_password, 'created_at' => $created_at]);
    }
}

function IsUserLoggedIn()
{
    return isset($_SESSION['username']);
}
