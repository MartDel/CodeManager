<?php // Show errors
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
?>

<?php
session_start();
require("controler/controler.php");
require('class/Passwords.php');
require('class/InformationMessage.php');
require('class/CustomException.php');
require("class/simple_html_dom.php");
require("class/DatabaseManager.php");
require("class/User.php");
require("class/Task.php");
require("class/Role.php");
require('class/Project.php');
require('class/Category.php');
require('class/Team.php');
$hostname = 'localhost/CodeManager';
$_SESSION['last_page'] = isset($_SESSION['last_page']) ? $_SESSION['last_page'] : '';

try{
	date_default_timezone_set('UTC');
	if(isset($_SESSION['user_id'])){ // Connected
		if(!isset($_GET['action'])) $action = 'tasks';
		else $action = htmlspecialchars($_GET['action']);
		executeFunction($action, true);
	} else { // Disconnected
		if(isset($_GET['action'])) executeFunction(htmlspecialchars($_GET['action']));
		else {
			if (isset($_COOKIE['auth'])) checkCookie(); // Check if user's cookies are correct
			else require('view/home.php'); // Home page
		}
	}
} catch(CustomException $e){
	header('Location: ' . $e->getRedirection() . $e->getUrlEncoded());
} catch(Exception $e){
	echo 'Erreur : ' . $e->getMessage();
}
