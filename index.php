<?php // Show errors
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
?>

<?php
session_start();
require("controler/controler.php");
require('class/Passwords.php');
require('class/CustomException.php');
require("class/simple_html_dom.php");
require("class/DatabaseManager.php");
require("class/User.php");
require("class/Task.php");
require("class/Role.php");
require('class/Project.php');
$hostname = 'localhost/CodeManager';
$_SESSION['last_page'] = isset($_SESSION['last_page']) ? $_SESSION['last_page'] : '';

try{
	date_default_timezone_set('UTC');
	if(isset($_SESSION['pseudo'])){ // Connected
		if(isset($_GET['action'])){
			$action = htmlspecialchars($_GET["action"]);
			// Tasks page
			if ($action == 'tasks') showMainPage();
			elseif ($action == "addtask") addTask($_POST); // Add a new task
			elseif ($action == "endtask") endTask($_GET); // End a task
			elseif ($action == 'deletetasks') deleteTasks($_GET); // Delete selected tasks
			// Team page
			elseif ($action == 'team') showTeamPage();
			// GitHub page
			elseif ($action == "commits") showProjectCommits();
			// Projects
			elseif ($action == 'createproject') createProject($_POST); // Add a new project
			elseif ($action == 'editproject') editProject($_POST); // Add a new project
			elseif ($action == 'deleteproject') deleteProject(); // Delete the project
			// Account
			elseif ($action == 'editPP') editPP(); // Change profile picture
			elseif ($action == 'deleteAccount') deleteAccount();
			elseif ($action == "logout") logout(); // Logout the current user
			else header('Location: index.php');
		} else {
			showMainPage(); // Tasks list page
		}
	} else { // Disconnected
		if(isset($_GET['action'])){
			$action = htmlspecialchars($_GET["action"]);
			if ($action == "signup") require('view/signup.php'); // SignUp page
			elseif ($action == 'test') /* test(); */ require('view/test.php');
			elseif ($action == "checkSignUp") checkSignUp($_POST); // Check SignUp
			elseif ($action == "signin") require('view/signin.php'); // SignIn page
			elseif ($action == "checkSignIn") checkSignIn($_POST); // Check SignIn
			elseif ($action == "home") require('view/home.php'); // Home page
			else header('Location: index.php');
		} else {
			if (isset($_COOKIE['auth'])) {
				checkCookie(); // Check if user's cookies are correct
			} else require('view/home.php'); // Home page
		}
	}
} catch(CustomException $e){
	header('Location: ' . $e->getRedirection() . '&error=' . $e->getUrlEncoded());
} catch(Exception $e){
	echo 'Erreur : ' . $e->getMessage();
}
