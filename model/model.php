<?php

/**
 * Check if there are errors in new user's data
 * @param Object $data User's data
 */
function checkNewUserData($data){
	if(!isset($data['pseudo']) || !isset($data['mail']) || !isset($data['password']) || !isset($data['confirm']) || !isset($data['firstname']) || !isset($data['lastname'])) {
		throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=' . getLastPage(), 'focusEmptyInput');
	}
	$pseudo = htmlspecialchars($data['pseudo']);
	$mail = htmlspecialchars($data['mail']);
	$firstname = htmlspecialchars($data['firstname']);
	$lastname = htmlspecialchars($data['lastname']);
	$password = $data['password'];
	$confirm = $data['confirm'];
	if($pseudo == "" || $mail == "" || $password == "" || $firstname == "" || $lastname == "") {
		throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=' . getLastPage(), 'focusEmptyInput');
	}
	if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
		throw new CustomException('Addresse mail non valide', "L'addresse e-mail n'est pas valide.", 'index.php?action=' . getLastPage(), 'focusEmail');
	}
	if($password != $confirm) {
		throw new CustomException('Mot de passe incorrect', "Le mot de passe n'est pas correct.", 'index.php?action=' . getLastPage(), 'focusPassword');
	}
	if((new User($pseudo, $mail, $firstname, $lastname))->accountExist()) {
		throw new CustomException('Compte déjà existant', "Un compte déja existant a été trouvé avec ces identifiants.", 'index.php?action=' . getLastPage());
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
	$user->pushToDB($data['password'], genUniqueId());
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
		throw new CustomException('Mauvais identifiants', "L'identifiant ou le mot de passe renseigné n'est pas correct.", 'index.php?action=' . getLastPage(), 'focusEmptyInput');
	}

	$correct_password = User::getPassword($login);
	if($correct_password == null) {
		throw new CustomException('Erreur!', "Une erreur s'est produite.", 'index.php?action=' . getLastPage());
	}

	if($is_hashed){
		if($password != $correct_password){
			throw new CustomException('Mot de passe incorrect', "Le mot de passe n'est pas correct.", 'index.php?action=' . getLastPage(), 'focusPassword');
		}
	} else {
		if($login == "" || $password == "") {
			throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=' . getLastPage(), 'focusEmptyInput');
		}
		if(!password_verify($password, $correct_password)) {
			throw new CustomException('Mot de passe incorrect', "Le mot de passe n'est pas correct.", 'index.php?action=' . getLastPage(), 'focusPassword');
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
	if($user->getPictureName()) $_SESSION['pp'] = $user->getPictureName();

	$project = Project::getFirstProject($user_id);
	if($project) $_SESSION['project_id'] = $project->getId();
    else {
		session_destroy();
		throw new CustomException('Pas de projet', "Vous n'avez pas de projet... Il faut modifier la base de données manuellement.", 'index.php?action=' . getLastPage(), 'openPhpMyAdmin');
	}

	if($auto){
		$auth = password_hash(User::getUniqueId($user->getPseudo()), PASSWORD_DEFAULT);
		setcookie('auth', $auth, time() + 365*24*3600, '/', null, false, true);
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

// Account

/**
 * Check if the sended file is ok
 */
function checkFileInfo(){
	// Check if there is no error
    if (!isset($_FILES['pp']) || $_FILES['pp']['error'] != 0){
        throw new CustomException('Erreur', 'Un problème est survenu.', 'index.php?action=' . getLastPage());
    }

	// Check the file size
	if ($_FILES['pp']['size'] > 1000000){
		throw new CustomException('Fichier trop volumineux', 'Le fichier que vous avez fourni est trop volumineux. Veuillez recommencer avec un fichier moins lourd.', 'index.php?action=' . getLastPage());
	}

	// Check file extension
	$infosfichier = pathinfo($_FILES['pp']['name']);
	$extension_upload = $infosfichier['extension'];
	$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
	list($w, $h) = getimagesize($_FILES['pp']['tmp_name']);
	if (!in_array($extension_upload, $extensions_autorisees) || $w == null || $h == null) {
		throw new CustomException('Extension incorrecte', "L'extension de votre fichier ne correspond pas à nos critères. Veuillez recommencer avec les extensions suivantes: .jpg, .jpeg, .gif, .png", 'index.php?action=' . getLastPage());
	}
}

/**
 * Crop the image if it's necessary and upload it
 * @param String $tmpName Uploaded file temporary name
 * @param String $fileName Uploaded file name
 */
function cropImage($tmpName, $fileName){
	list($w, $h) = getimagesize($tmpFile);
	if($w == $h){ // Square image
	    move_uploaded_file($tmpFile, $fileName);
	} else{
	    $image = new Imagick($tmpFile);
	    if($w < $h) { // Portrait
	        $image->cropImage($w, $w, 0, ($h - $w) / 2);
	    } else { // Landscape
	        $image->cropImage($h, $h, ($w - $h) / 2, 0);
	    }
	    $image->writeImage($fileName);
	}
}

// Functions

/**
 * Get the last page name with $_SESSION
 * @param String $error_redirect What returned if $_SESSION['last_page'] doesn't exist
 * @return String The last page name
 */
function getLastPage($error_redirect = 'home'){
	return isset($_SESSION['last_page']) ? $_SESSION['last_page'] : $error_redirect;
}

/**
 * Get the connected user as an User object
 * @return User The connected user
 */
function getCurrentUser(){
	return new User($_SESSION['pseudo'], $_SESSION['mail'], $_SESSION['firstname'], $_SESSION['lastname']);
}

/**
 * Generate an unique id
 * @param integer $length Id length (default = 13)
 * @return String The unique id
 */
function genUniqueId($length = 13){
	$bytes = random_bytes(ceil($length / 2));
	// If 'random_bytes' doesn't exists
	// $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    return substr(bin2hex($bytes), 0, $length);
}
