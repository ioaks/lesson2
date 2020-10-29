<?php
session_start();
include 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];
$pdo = get_connect_db('lesson-project', 'mysql', 'mysql');

user_login($pdo, $email, $password);
