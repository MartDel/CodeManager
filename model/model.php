<?php
require("class/user.php");

/**
 * Check if there are errors in new user's data
 * @param  Object $data User's data
 * @return bool Contain error or not
 */
function checkNewUserData($data){
	if(!isset($data['pseudo']) || !isset($data['mail']) || !isset($data['password']) || !isset($data['confirm'])) return false;

	$pseudo = htmlspecialchars($data['pseudo']);
	$mail = htmlspecialchars($data['mail']);
	$password = htmlspecialchars($data['password']);
	$confirm = htmlspecialchars($data['confirm']);

	if($pseudo == "" || $password == "") return false;
	if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) return false;
	if($password != $confirm) return false;
	return User::accountExist($pseudo, $mail);
}

/*
EX :

function ValidateConnection(){
	$db = dbConnect();
	$mdp = $db->prepare('SELECT mdp FROM compte WHERE pseudo=?');
	$mdp->execute(array(htmlspecialchars($_POST["pseudo"])));
	$pass = $mdp->fetch();
	if(!$pass || !password_verify($_POST['password'], $pass['mdp'])){
		throw new Exception('Aucune données de compte inscrit dans la base de données ne correspondent aux identifiants inscrits.');
	}
	$mdp->closeCursor();
	$info = $db->prepare("SELECT pseudo, prenom, nom, mdp, id FROM compte WHERE pseudo=?");
	$info->execute(array(htmlspecialchars($_POST["pseudo"])));
	$info = $info->fetch();
	return $info;
}
*/
