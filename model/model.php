<?php

/**
 * Check if there are errors in new user's data
 * @param Object $data User's data
 */
function checkNewUserData($data){
	if(!isset($data['pseudo']) || !isset($data['mail']) || !isset($data['password']) || !isset($data['confirm']) || !isset($data['firstname']) || !isset($data['lastname'])) {
		throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=' . $_SESSION['last_page'], 'focusEmptyInput');
	}
	$pseudo = htmlspecialchars($data['pseudo']);
	$mail = htmlspecialchars($data['mail']);
	$firstname = htmlspecialchars($data['firstname']);
	$lastname = htmlspecialchars($data['lastname']);
	$password = $data['password'];
	$confirm = $data['confirm'];
	if($pseudo == "" || $mail == "" || $password == "" || $firstname == "" || $lastname == "") {
		throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=' . $_SESSION['last_page'], 'focusEmptyInput');
	}
	if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
		throw new CustomException('Addresse mail non valide', "L'addresse e-mail n'est pas valide.", 'index.php?action=' . $_SESSION['last_page'], 'focusEmail');
	}
	if($password != $confirm) {
		throw new CustomException('Mot de passe incorrect', "Le mot de passe n'est pas correct.", 'index.php?action=' . $_SESSION['last_page'], 'focusPassword');
	}
	if((new User($pseudo, $mail, $firstname, $lastname))->accountExist()) {
		throw new CustomException('Compte déjà existant', "Un compte déja existant a été trouvé avec ces identifiants.", 'index.php?action=' . $_SESSION['last_page']);
	}
}

/**
 * Add a new user to the database
 * @param Object $data User's data
 */
function addUser($data){
	$pseudo = htmlspecialchars($data['pseudo']);
	$mail = htmlspecialchars($data['mail']);
	$firstname = htmlspecialchars($data['firstname']);
	$lastname = htmlspecialchars($data['lastname']);
	$user = new User($pseudo, $mail, $firstname, $lastname);
	$user->pushToDB($data['password']);
	connectUser($data['pseudo'], true);
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
	$user = new User($login, $login, '', '');
	if(!$user->accountExist()){
		throw new CustomException('Mauvais identifiants', "L'identifiant ou le mot de passe renseigné n'est pas correct.", 'index.php?action=' . $_SESSION['last_page'], 'focusEmptyInput');
	}

	$correct_password = User::getPassword($login);
	if($correct_password == null) {
		throw new CustomException('Erreur!', "Une erreur s'est produite.", 'index.php?action=' . $_SESSION['last_page']);
	}

	if($is_hashed && $password != $correct_password){
		throw new CustomException('Mot de passe incorrect', "Le mot de passe n'est pas correct.", 'index.php?action=' . $_SESSION['last_page'], 'focusPassword');
	} else {
		if($login == "" || $password == "") {
			throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=' . $_SESSION['last_page'], 'focusEmptyInput');
		}
		if(!password_verify($password, $correct_password)) {
			throw new CustomException('Mot de passe incorrect', "Le mot de passe n'est pas correct.", 'index.php?action=' . $_SESSION['last_page'], 'focusPassword');
		}
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
	$user_id = $user->getId();
	$_SESSION['user_id'] = $user_id;
	$_SESSION['pseudo'] = $user->getPseudo();
	$_SESSION['mail'] = $user->getMail();
	$_SESSION['firstname'] = $user->getFirstname();
	$_SESSION['lastname'] = $user->getLastname();
    $project_id = isset($_GET['project']) ? htmlspecialchars($_GET['project']) : false;
    if(!Project::projectExist($project_id, $user_id) || !isset($_GET['project'])){
		$project = Project::getFirstProject($user_id);
		if($project) $project_id = $project->getId();
	}
    $_SESSION['project_id'] = $project_id;
    if(!$project_id) {
		session_destroy();
		throw new CustomException('Pas de projet', "Vous n'avez pas de projet... Il faut modifier la base de données manuellement.", 'index.php?action=' . $_SESSION['last_page'], 'openPhpMyAdmin');
	}
	if($auto){
		setcookie('pseudo', $user->getPseudo(), time() + 365*24*3600, '/', null, false, true);
		setcookie('password', User::getPassword($login), time() + 365*24*3600, '/', null, false, true);
	}
}

// Tasks page

/**
 * Count how many tasks are not finished
 * @param Array $tasks All of database tasks for the current project
 * @return int The count of not done tasks
 */
function countNotDoneTasks($tasks){
	$counter = 0;
	foreach ($tasks as $task) {
		if (!$task->getIsDone()) $counter++;
	}
	return $counter;
}

/**
 * Count how many tasks are finished
 * @param Array $tasks All of database tasks for the current project
 * @return int The count of done tasks
 */
function countDoneTasks($tasks){
	$counter = 0;
	foreach ($tasks as $task) {
		if ($task->getIsDone()) $counter++;
	}
	return $counter;
}

// GitHub page

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
