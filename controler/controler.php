<?php
require('model/model.php');

/**
 * Execute a function with its string name
 * @param string $name The function name
 * @param bool $name If the user must be connected or not
 */
function executeFunction($name, $connected = false){
    if($connected) {
        require('controler/connected.php');
        checkUserData();
    } else require('controler/disconnected.php');
    
    if(function_exists($name)) $name();
    else header('Location: index.php');
}

/**
 * Update new informations
 */
function updateSession(){
    $user = User::getUserById($_SESSION['user_id']);
    $_SESSION['role'] = $user->getFinalRole();
    $_SESSION['permissions'] = $user->getPermissions();
}
