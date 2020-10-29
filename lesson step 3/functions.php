<?php

function get_connect_db($dbname, $dblogin, $dbpass) {
    $pdo = new PDO("mysql:host=localhost; dbname=$dbname", $dblogin, $dbpass);
    return $pdo;
}

function get_user_by_email($pdo, $email) {
    global $password;

    $sql = "SELECT * FROM users WHERE user_email=:email";
    $statement = $pdo->prepare($sql);
    $statement->execute(['email' => $email]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if (!empty($user)) {
        set_flash_message('danger', '<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.');
        redirect_to('lesson2/page_register.php');
    } else {
        add_user($pdo, $email, $password);
        set_flash_message('success', 'Регистрация прошла успешно. Войдите в систему.');
        redirect_to('lesson2/page_login.php');
    }

    return $user;
}

function add_user($pdo, $email, $password) {
    $sql = "INSERT INTO users (user_email, user_password) VALUES (:email, :password)";
    $statement = $pdo->prepare($sql);
    $statement->execute(['email' => $email, 'password' => $password]);
}

function user_login($pdo, $email, $password) {
    $sql = "SELECT * FROM users WHERE user_email=:email AND user_password=:password";
    $statement = $pdo->prepare($sql);
    $statement->execute(['email' => $email, 'password' => $password]);

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        set_flash_message('seccess', 'Вы успешно авторизовались');
        redirect_to('lesson2/page_profile.php');
    } else {
        set_flash_message('danger', 'Вы ввели не правильно логин или пароль');
        redirect_to('lesson2/page_login.php');
    }

    return $user;
}

function set_flash_message($name, $message) {
    $_SESSION[$name] = $message;
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

function redirect_to($path) {
    header("Location: /" . $path);
}