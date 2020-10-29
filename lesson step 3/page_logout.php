<?php
session_start();
include 'functions.php';
session_unset();
redirect_to('lesson2/page_login.php');
