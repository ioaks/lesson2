<?php

function get_connect_db($dbname, $dblogin, $dbpass) {
    $pdo = new PDO("mysql:host=localhost; dbname=$dbname", $dblogin, $dbpass);
    return $pdo;
}

function add_user($pdo, $email, $password) {
    $sql = "INSERT INTO users (user_email, user_password) VALUES (:email, :password)";
    $statement = $pdo->prepare($sql);
    $statement->execute(['email' => $email, 'password' => $password]);
}

function get_user_by_email($pdo, $email) {
    $sql = "SELECT * FROM users WHERE user_email=:email";
    $statement = $pdo->prepare($sql);
    $statement->execute(['email' => $email]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    return $user;
}

function set_flash_message($name, $message) {
    $_SESSION[$name] = $message;
}

function redirect_to($path) {
    header("Location: /" . $path);
}

function get_display_message() {
    $html = '';
    $sessions = $_SESSION;

    if (!empty($sessions)) {
        foreach ($sessions as $k => $v) {
            $html = '<div class="alert alert-' . $k . ' ' . $k . ' text-dark" role="alert">' . $v . '</div>';
        }

        if ($_SESSION['danger']) {
            unset($_SESSION['danger']);
        }

        if ($_SESSION['success']) {
            unset($_SESSION['success']);
        }
    }

    return $html;
}
