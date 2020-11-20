<?php
session_start();
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
require('class/DatabaseManager.php');
require('class/Passwords.php');
require('class/Task.php');

for ($i=0; $i < 25; $i++) {
    $task = new Task($i, $_SESSION['project_id'], false, null, $_SESSION['user_id'], 'Description');
    $task->pushToDB();
}

header('Location: index.php');
