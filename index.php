<?php // Show errors
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
?>

<?php
session_start();
require("controler/controler.php");
require('class/Passwords.php');
require("class/simple_html_dom.php");
require("class/DatabaseManager.php");
require("class/User.php");
require("class/Task.php");
require("class/Role.php");
require('class/Project.php');
$hostname = 'localhost/CodeManager';

try{
	date_default_timezone_set('UTC');
	if(isset($_SESSION['pseudo'])){ // Connected
		if(isset($_GET['action'])){
			$action = htmlspecialchars($_GET["action"]);
			if ($action == "logout") logout(); // Logout the current user
			elseif ($action == "commits") showProjectCommits(); // GitHub page
			elseif ($action == "addtask") addTask($_POST); // Add a new task
			elseif ($action == "endtask") endTask($_GET); // End a task
			else header('Location: index.php');
		} else {
			showMainPage(); // Tasks list page
		}
	} else { // Disconnected
		if(isset($_GET['action'])){
			$action = htmlspecialchars($_GET["action"]);
			if ($action == "signup") require('view/signup.php'); // SignUp page
			elseif ($action == 'test') test();
			elseif ($action == "checkSignUp") checkSignUp($_POST); // Check SignUp
			elseif ($action == "signin") require('view/signin.php'); // SignIn page
			elseif ($action == "checkSignIn") checkSignIn($_POST); // Check SignIn
			else header('Location: index.php');
		} else {
			if (isset($_COOKIE['pseudo']) && isset($_COOKIE['password'])) {
				checkCookie(); // Check if user's cookies are correct
			} else require('view/home.php'); // Home page
		}
	}
} catch(Exception $e){
	echo 'Erreur : ' . $e->getMessage();
}
