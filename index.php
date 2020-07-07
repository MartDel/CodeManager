<?php
session_start();
require("controler/controler.php");
require("class/simple_html_dom.php");
require("class/DatabaseManager.php");
require("class/User.php");
require("class/Task.php");

try{
	date_default_timezone_set('UTC');
	if(isset($_SESSION['pseudo'])){ // Connected
		if(isset($_GET['action'])){
			$action = htmlspecialchars($_GET["action"]);
			if ($action == "logout") logout(); // Logout the current user
			elseif ($action == "commits") showProjectCommit(); // GitHub page
			else header('Location: index.php');
		} else {
			showMainPage(); // Tasks list page
		}
	} else { // Disconnected
		if(isset($_GET['action'])){
			$action = htmlspecialchars($_GET["action"]);
			if ($action == "signup") require('view/signup.php'); // SignUp page
			elseif ($action == 'test') {
				$url = 'http://localhost/CodeManager/design/index.html';
				$split_url = preg_split('[/]', $url);
				$path = "";
				for ($i=0; $i < count($split_url) - 1; $i++) {
					$path .= $split_url[$i] . "/";
				}
				echo $path;
				echo "<br>";
				$html = file_get_html($url);
				foreach($html->find('img') as $element) {
					echo '<img src="' . $path . $element->src . '" alt="" /><br>';
				}
			}
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
