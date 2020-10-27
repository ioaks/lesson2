<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$pdo = new PDO('mysql:host=localhost; dbname=lesson-project', 'mysql', 'mysql');

function add_user($pdo, $email, $password) {
    $sql = "INSERT INTO users (user_email, user_password) VALUES (:email, :password)";
    $statement = $pdo->prepare($sql);
    $statement->execute(['email' => $email, 'password' => $password]);
}

function get_user_by_email ($pdo, $email) {

    $sql = "SELECT * FROM users WHERE user_email=:email";
    $statement = $pdo->prepare($sql);
    $statement->execute(['email' => $email]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result;

}

function set_flash_message($key, $message) {
    $_SESSION[$key] = $message;
}

function redirect_to($path) {
    header("Location: /" . $path);
}

if (get_user_by_email($pdo, $email)) {
    set_flash_message('danger', '<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.');
    redirect_to('lesson2/page_register.php');
} else {
    set_flash_message('success', 'Регистрация прошла успешно. Войдите в систему.');
    add_user($pdo, $email, $password);
    redirect_to('lesson2/page_login.php');
}