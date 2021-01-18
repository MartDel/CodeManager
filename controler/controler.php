<?php
require('model/model.php');

/**
 * Execute a function with its string name
 * @param string $name The function name
 * @param bool $connected If the user is connected
 */
function executeFunction($name, $connected = false){
    if($connected) {
        require('controler/connected.php');
        checkUserData($name == 'noProject');
    } else require('controler/disconnected.php');

    if(function_exists($name) && $name != 'executeFunction') $name();
    else header('Location: index.php');
}

/**
 * Logout the current user
 */
function logout(){
    session_destroy();
	setcookie('auth', '', time() + 365*24*3600, '/', null, false, true);
    header('Location: index.php');
}
