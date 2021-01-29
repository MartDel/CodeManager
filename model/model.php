<?php

/**
 * Update new informations
 */
function updateSession(){
    if(!isset($_SESSION['project_id'])) return;
    $user = User::getUserById($_SESSION['user_id']);
    $_SESSION['role'] = $user->getFinalRole();
    $_SESSION['permissions'] = $user->getPermissions();
}

/**
 * Check if user's cookies are correct
 */
function checkCookie(){
    $user = User::getUserByLoginId(htmlspecialchars($_COOKIE['auth']));
    if($user){
        connectUser($user->getPseudo(), false);
        header("Location: index.php");
    } else logout();
}

/**
 * Check if all user's data are correct
 */
function checkUserData($redirectToNoProject){
    $redirect = false;
    if(isset($_SESSION['project_id'])){
        $team = new Team($_SESSION['project_id'], $_SESSION['user_id']);
    	if(!$team->exists()){
    		$project = Project::getFirstProject($_SESSION['user_id']);
    		if($project) $_SESSION['project_id'] = $project->getId();
    	    else $redirect = true;
    	}
    } else $redirect = true;
    if(!$redirectToNoProject && $redirect) header('Location: index.php?action=noProject');
}

/**
 * Check if there are errors in new user's data
 * @param Object $data User's data
 */
function checkNewUserData($data){
	if(!isset($data['pseudo']) || !isset($data['mail']) || !isset($data['password']) || !isset($data['confirm']) || !isset($data['firstname']) || !isset($data['lastname'])) {
		throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", getLastPage(), 'focusEmptyInput');
	}
	$pseudo = $data['pseudo'];
	$mail = $data['mail'];
	$firstname = $data['firstname'];
	$lastname = $data['lastname'];
	$password = $data['password'];
	$confirm = $data['confirm'];
	if($pseudo == "" || $mail == "" || $password == "" || $firstname == "" || $lastname == "") {
		throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", getLastPage(), 'focusEmptyInput');
	}
	if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
		throw new CustomException('Addresse mail non valide', "L'addresse e-mail n'est pas valide.", getLastPage(), 'focusEmail');
	}
	if($password != $confirm) {
		throw new CustomException('Mot de passe incorrect', "Le mot de passe n'est pas correct.", getLastPage(), 'focusPassword');
	}
	if((new User($pseudo, $mail, $firstname, $lastname))->accountExist()) {
		throw new CustomException('Compte déjà existant', "Un compte déja existant a été trouvé avec ces identifiants.", getLastPage());
	}
}

/**
 * Add a new user to the database
 * @param Object $data User's data
 */
function addUser($data){
	$pseudo = $data['pseudo'];
	$mail = $data['mail'];
	$firstname = $data['firstname'];
	$lastname = $data['lastname'];
	$user = new User($pseudo, $mail, $firstname, $lastname);
	$user->pushToDB($data['password'], genUniqueId());
	connectUser($data['pseudo'], true);
}

/**
 * Check if there are errors in user's data
 * @param String $login User's pseudo or email
 * @param String $password User's password
 * @param boolean $is_hashed True if the password is hashed
 */
function checkConnection($login, $password, $is_hashed) {
	$user = new User($login, $login, '', '');
	if(!$user->accountExist()){
		throw new CustomException('Mauvais identifiants', "L'identifiant ou le mot de passe renseigné n'est pas correct.", getLastPage(), 'focusEmptyInput');
	}

	$correct_password = User::getPassword($login);
	if($correct_password == null) {
		throw new CustomException('Erreur!', "Une erreur s'est produite.", getLastPage());
	}

	if($is_hashed){
		if($password != $correct_password){
			throw new CustomException('Mot de passe incorrect', "Le mot de passe n'est pas correct.", getLastPage(), 'focusPassword');
		}
	} else {
		if($login == "" || $password == "") {
			throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", getLastPage(), 'focusEmptyInput');
		}
		if(!password_verify($password, $correct_password)) {
			throw new CustomException('Mot de passe incorrect', "Le mot de passe n'est pas correct.", getLastPage(), 'focusPassword');
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

	$project = Project::getFirstProject($user_id);
	if($project) $_SESSION['project_id'] = $project->getId();

	$_SESSION['user_id'] = $user_id;
	$_SESSION['pseudo'] = $user->getPseudo();
	$_SESSION['mail'] = $user->getMail();
	$_SESSION['firstname'] = $user->getFirstname();
	$_SESSION['lastname'] = $user->getLastname();
	$_SESSION['role'] = $user->getFinalRole();
	$_SESSION['permissions'] = $user->getPermissions();
	if($user->getPictureName()) $_SESSION['pp'] = $user->getPictureName();

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

/**
 * Create an array to order tasks by category
 * @param array $tasks The array not ordered
 * @return array An array of tasks
 */
function orderByCategory($tasks){
	if(!$tasks) return null;
	$r = [
		'-1' => []
	];
	foreach ($tasks as $task) {
		$category = $task->getCategoryId();
		if(!$category) $category = '-1';
		if(!isset($r[$category])) $r[$category] = [];
		array_push($r[$category], $task);
	}
	return $r;
}

/**
 * Get a category name with its id
 * @param int $id The category id
 * @return string The category name
 */
function getCategoryNameById($id){
	$category = Category::getCategoryById($id);
	if($category) return $category->getName();
	return null;
}

/**
 * Add a category to the database
 * @param string $name The category name
 * @return int The category id
 */
function addCategory($name){
    $category = new Category($name, $_SESSION['project_id']);
    if($category->getId()){
        throw new CustomException('Categorie déjà existante', "La categorie que vous tentez de créer existe déjà...", 'tasks');
    }
    $category->pushToDB();
    return $category->getDatabaseId();
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
        throw new CustomException('Erreur', 'Un problème est survenu.', getLastPage());
    }

	// Check the file size
	if ($_FILES['pp']['size'] > 1000000){
		throw new CustomException('Fichier trop volumineux', 'Le fichier que vous avez fourni est trop volumineux. Veuillez recommencer avec un fichier moins lourd.', getLastPage());
	}

	// Check file extension
	$infosfichier = pathinfo($_FILES['pp']['name']);
	$extension_upload = $infosfichier['extension'];
	$extensions_autorisees = array('jpg', 'jpeg', 'png');
	list($w, $h) = getimagesize($_FILES['pp']['tmp_name']);
	if (!in_array($extension_upload, $extensions_autorisees) || $w == null || $h == null) {
        throw new CustomException('Extension incorrecte', "L'extension de votre fichier ne correspond pas à nos critères. Veuillez recommencer avec les extensions suivantes: .jpg, .jpeg, .png", getLastPage());
	}
}

/**
 * Crop the image if it's necessary and upload it
 * @param String $tmpName Uploaded file temporary name
 * @param String $fileName Uploaded file name
 */
function cropImage($tmpName, $fileName){
	list($w, $h) = getimagesize($tmpName);
	if($w == $h || !class_exists('Imagick')){ // Square image
	    move_uploaded_file($tmpName, $fileName);
	} else{
	    $image = new Imagick($tmpName);
	    if($w < $h) { // Portrait
	        $image->cropImage($w, $w, 0, ($h - $w) / 2);
	    } else { // Landscape
	        $image->cropImage($h, $h, ($w - $h) / 2, 0);
	    }
	    $image->writeImage($fileName);
	}
}

/**
 * Create remote link with POST data
 * @param Object $data POST data
 * @return String The remote link, null if there isn't enough information
 */
function createRemote($data){
    if(isset($data['github_pseudo']) && $data['github_pseudo'] != '' && isset($data['remote']) && $data['remote'] != '') {
        return 'https://github.com/' . $data['github_pseudo'] . '/' . $data['remote'];
    }
    return null;
}

// Other functions

/**
 * Send an e-mail with a message
 * @param String $message The message to sens
 * @return bool status
 */
function sendMail($message){
	// Headers
	$to = "admin@codemanager.fr";
	$subject = "Remarque de " . $_SESSION['pseudo'];
	$headers = "From: CodeManager <server@codemanager.com>\r\n";
	$headers .= "Reply-To: CodeManager <server@codemanager.com>\r\n";
	$headers .= "Return-Path: CodeManager <server@codemanager.com>\r\n";
	$headers .= "Organization: CodeManager\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\n";
	$headers .= "X-Priority: 3\r\n";
	$headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;

	// Message
	ob_start();
	?>
	<h1 style="text-align:center;">Remarque de <?= $_SESSION['pseudo'] ?> <i>(<?= $_SESSION['user_id'] ?>)</i></h1>
	<section>
		<h2>Informations sur l'utilisateur :</h2>
		<ul>
			<li><strong>Pseudo : </strong><?= $_SESSION['pseudo'] ?></li>
			<li><strong>Addresse mail : </strong><?= $_SESSION['mail'] ?></li>
			<li><strong>Prénom : </strong><?= $_SESSION['firstname'] ?></li>
			<li><strong>Nom : </strong><?= $_SESSION['lastname'] ?></li>
		</ul>
	</section>
	<section>
		<h2>Message de l'utilisateur :</h2>
		<p style="font-size: 1.2em;"><?= $message ?></p>
	</section>
	<?php
	$msg = ob_get_clean();

	return mail($to, $subject, $msg, $headers);
}

function httpRequest($url){
    $opts = [
        'http' => [
            'method' => "GET",
            'header' => "User-Agent: martdel\r\n"
        ]
    ];
    $context = stream_context_create($opts);
    $raw = file_get_contents($url, false, $context);
    return json_decode($raw);
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

/**
 * Add a security to user entries
 * @param Object $object The user's data
 * @return Object The securised user's data
 */
function secure($object){
	foreach ($object as $key => $value) {
		$final = trim(htmlspecialchars($value));
		if(strlen($final) > 255 && $key != 'description' && $key != 'message' && $key != 'mess'){
			throw new CustomException('Données non valide', "Une des données envoyées n'est pas correcte. Veillez à ce qu'elle ne dépasse pas une longuer de 255 et qu'elle ne contienne pas de \".", getLastPage());
		}
		$object[$key] = $final;
	}
	return $object;
}
