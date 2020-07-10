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
 * @param boolean $is_hashed True if the password is hashed
 */
function checkConnection($l, $p, $is_hashed) {
	$login = htmlspecialchars($l);
	$password = $p;
	if(!User::accountExist($login, $login)) throw new Exception("Aucun compte n'existe avec ces identifiants.");

	$correct_password = User::getPassword($login);
	if($correct_password == null) throw new Exception("Un problème est survenu.");

	if($is_hashed){
		if($password != $correct_password) throw new Exception("Le mot de passe n'est pas correct.");
	} else {
		if($login == "" || $password == "") throw new Exception("Veuillez remplir tous les champs.");
		if(!password_verify($password, $correct_password)) throw new Exception("Le mot de passe n'est pas correct.");
	}
}

/**
 * Connect an user with his login
 * @param String $login User's pseudo or email
 * @param String $login User's password
 * @param boolean $auto Autoconnection checkbox value
 */
function connectUser($login, $auto){
	$user = User::getUserByLogin($login);
	$_SESSION['pseudo'] = $user->getPseudo();
	$_SESSION['mail'] = $user->getMail();
	if($auto){
		setcookie('pseudo', $user->getPseudo(), time() + 365*24*3600, null, null, false, true);
		setcookie('password', User::getPassword($login), time() + 365*24*3600, null, null, false, true);
	}
}

/**
 * Get all of project commits
 * @param String $github_user Current project owner (GitHub username)
 * @param String $project_name Current project name
 * @return JsonObject[] All of GitHub commits
 */
function getCommits($github_user, $project_name){
	$opts = array(
	  'http'=>array(
	    'method'=>"GET",
	    'header'=>"User-Agent: martdel\r\n"
	  )
	);
	$context = stream_context_create($opts);
	$url = "https://api.github.com/repos/" . $github_user . "/" . $project_name . "/commits";
  $raw = file_get_contents($url, false, $context);
  $json = json_decode($raw);
	return $json;
}
