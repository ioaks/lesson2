<?php
session_start();
include 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];
$pdo = get_connect_db('lesson-project', 'mysql', 'mysql');
$user = get_user_by_email($pdo, $email);


if (!empty($user)) {
    set_flash_message('danger', '<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.');
    redirect_to('lesson2/page_register.php');
} else {
    add_user($pdo, $email, $password);
    set_flash_message('success', 'Регистрация прошла успешно. Войдите в систему.');
    redirect_to('lesson2/page_login.php');
}