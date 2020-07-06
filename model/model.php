<?php

/**
 * Check if there are errors in new user's data
 * @param Object $data User's data
 */
function checkNewUserData($data){
	if(!isset($data['pseudo']) || !isset($data['mail']) || !isset($data['password']) || !isset($data['confirm'])) {
		throw new Exception("Veuillez remplir tous les champs");
	}
	$pseudo = htmlspecialchars($data['pseudo']);
	$mail = htmlspecialchars($data['mail']);
	$password = $data['password'];
	$confirm = $data['confirm'];
	if($pseudo == "" || $mail == "" || $password == "") throw new Exception("Veuillez remplir tous les champs.");
	if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) throw new Exception("Addresse mail non valide.");
	if($password != $confirm) throw new Exception("Mot de passe non valide.");
	if(User::accountExist($pseudo, $mail)) throw new Exception("Ce compte existe déjà.");
}

/**
 * Add a new user to the database
 * @param Object $data User's data
 */
function addUser($data){
	$pseudo = htmlspecialchars($data['pseudo']);
	$mail = htmlspecialchars($data['mail']);
	$user = new User($pseudo, $mail);
	$user->pushToDB($data['password']);
	$_SESSION['pseudo'] = $user->getPseudo();
	$_SESSION['mail'] = $user->getMail();
}

/**
 * Check if there are errors in user's data
 * @param String $l User's pseudo or email
 * @param String $p User's password
 */
function checkConnection($l, $p) {
	$login = htmlspecialchars($l);
	$password = $p;
	if($login == "" || $password == "") throw new Exception("Veuillez remplir tous les champs.");
	if(!User::accountExist($login, $login)) throw new Exception("Aucun compte n'existe avec ces identifiants.");

	$correct_password = User::getPassword($login);
	if($correct_password == null) throw new Exception("Un problème est survenu");
	if(!password_verify($password, $correct_password)) throw new Exception("Le mot de passe n'est pas correct");
}

/**
 * Connect an user with his login
 * @param String $login User's pseudo or email
 * @param String $login User's password
 * @param boolean $auto Autoconnection checkbox value
 */
function connectUser($login, $password, $auto){
	$user = User::getUserByLogin($login);
	$_SESSION['pseudo'] = $user->getPseudo();
	$_SESSION['mail'] = $user->getMail();
	if($auto){
		setcookie('pseudo', $user->getPseudo(), time() + 365*24*3600, null, null, false, true);
		setcookie('password', $password, time() + 365*24*3600, null, null, false, true);
	}
}
