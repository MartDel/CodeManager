<?php
session_start();
require("controler/controler.php");

try{
	if(isset($_GET['action'])){
		$action = htmlspecialchars($_GET["action"]);
		if($action == "signup") require('view/signup.php'); // SignUp page
		elseif ($action == "checkSignUp") checkSignUp($_POST); // Check SignUp
	} else{
		if(isset($_SESSION['pseudo'])) echo $_SESSION['pseudo']; // Connected
		else require('view/home.php'); // Home page
	}
} catch(Exception $e){
	echo 'Erreur : ' . $e->getMessage();
}
