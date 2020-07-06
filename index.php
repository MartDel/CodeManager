<?php
session_start();
require("controler/controler.php");
require("class/user.php");

try{
	if(isset($_GET['action'])){
		$action = htmlspecialchars($_GET["action"]);
		if($action == "signup") require('view/signup.php'); // SignUp page
		elseif ($action == "checkSignUp") checkSignUp($_POST); // Check SignUp
		elseif ($action == "signin") require('view/signin.php'); // SignIn page
		elseif ($action == "checkSignIn") checkSignIn($_POST); // Check SignIn
		elseif ($action == "logout") logout(); // Logout the current user
	} else{
		if(isset($_SESSION['pseudo']) && isset($_SESSION['mail'])) {
			require('view/main.php'); // Connected
		} else require('view/home.php'); // Home page
	}
} catch(Exception $e){
	echo 'Erreur : ' . $e->getMessage();
}
