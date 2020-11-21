<?php
require('model/model.php');

/**
 * Execute a function with its string name
 * @param String $name The function name
 */
function executeFunction($name){
    if(function_exists($name)) $name();
    else header('Location: index.php');
}

/*
====================
=== DISCONNECTED ===
====================
 */

function home(){ require('view/home.php'); }
function signup(){ require('view/signup.php'); }
function signin(){ require('view/signin.php'); }

 /**
  * Check if all of signup data is correct and upload to the database
  */
 function checkSignUp(){
     $data = secure($_POST);
     checkNewUserData($data);
     addUser($data);
     header("Location: index.php");
 }

 /**
  * Check if all of signin data is correct by checking the database
  */
 function checkSignIn(){
     $data = secure($_POST);
     if(!isset($data['login']) || !isset($data['password'])) {
         throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=' . getLastPage(), 'focusEmptyInput');
     }
     checkConnection($data['login'], $data['password'], false);
     connectUser($data['login'], $data['auto']);
     header("Location: index.php");
 }

 /**
  * Check if user's cookies are correct
  */
 function checkCookie(){
     $user = User::getUserByLoginId(htmlspecialchars($_COOKIE['auth']));
     if($user){
         connectUser($user->getPseudo(), false);
         header("Location: index.php");
     } else {
         logout();
     }
 }

 function test(){
     // $url = 'https://www.ecosia.org';
     // $url = 'https://www.google.com';
     $url = 'https://github.com/MartDel/CodeManager';

     // Get url infos
     $scheme = parse_url($url)['scheme'] . '://';
     $host = $scheme . parse_url($url)['host'];
     if(isset(parse_url($url)['path'])){
         $path = $host . pathinfo(parse_url($url)['path'])['dirname'];
     } else {
         $path = $host . '/';
     }

     $html = file_get_html($url);
     $title = $html->find('title')[0]->plaintext;
     // Get website icon
     if($html->find('link') != null){
         foreach ($html->find('link') as $element) {
             if(strpos($element->rel, 'icon')){
                 $href = $element->href;
                 if(strpos($href, '://')){
                     $icon = $href;
                 } else {
                     $icon = $path . $href;
                 }
             }
         }
     } else $icon = $host . '/favicon.ico';

     // Change icon if it isn't correct
     set_error_handler(function() {
         global $hostname, $icon;
         $icon = 'http://' . $hostname . '/public/img/unknown_icon.svg';
     });
     file_get_contents($icon);
     restore_error_handler();

     echo 'url: ' . $url . '<br>';
     echo 'host: ' . $host . '<br>';
     echo 'path: ' . $path . '<br>';
     echo 'title: ' . $title . '<br>';
     echo 'icon: ' . $icon . '<br>';
     echo '<img src="' . $icon . '" />';
 }

 /*
 =====================
 ===== CONNECTED =====
 =====================
  */

/**
 * Get tasks stats and show them
 */
function tasks(){
    // Get project and projects list
    setCurrentProject();
    $project = Project::getProjectById($_SESSION['project_id'], $_SESSION['user_id']);
    $project_list = Project::getAllProjects($_SESSION['user_id']);

    $tasks = Task::getAllTasks($_SESSION['project_id']);
    $nb_tasks = isset($tasks) ? countNotDoneTasks($tasks) : 0;
    $nb_done_tasks = isset($tasks) ? countDoneTasks($tasks) : 0;
    require('view/main.php');
}

/**
 * Add a new task in the database
 */
function addTask(){
    $data = secure($_POST);
    if(!isset($data['title']) || $data['title'] == '') {
        throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=' . getLastPage(), 'focusTitleAddTask');
    }
    $task = new Task($data['title'], $_SESSION['project_id'], false, null, $_SESSION['user_id'], $data['description']);
    $task->pushToDB();
    header('Location: index.php');
}

/**
 * Edit a task in the database
 */
function editTask(){
    $data = secure($_POST);
    if(!isset($data['title']) || $data['title'] == '') {
        throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=' . getLastPage());
    }
    $task = Task::getTaskById(htmlspecialchars($_GET['id']), $_SESSION['project_id']);
    if(!$task) throw new CustomException('Erreur...', "Une erreur est survenue lors de la récupération de la tâche que vous tentez de modifier.", 'index.php?action=' . getLastPage());
    $task->setName($data['title']);
    $task->setDescription($data['description']);
    $task->update();
    header('Location: index.php');
}

/**
 * End a task
 */
function endTask(){
    $data = secure($_GET);
    if(!isset($data['id'])) header('Location: index.php');
    $task = Task::getTaskById($data['id'], $_SESSION['project_id']);
    if($task){
        $done_task = $task->getIsDone();
        $task->setIsDone(!$done_task);
        $params = $done_task ? '?endTask' : '';
        header('Location: index.php' . $params);
    } else {
        header('Location: index.php');
    }
}

/**
 * Delete selected tasks
 */
function deleteTasks(){
    $data = secure($_GET);
    if(!isset($data['tasks'])) header('Location: index.php');
    $tasks = $data['tasks'];
    $tasks_array = explode(' ', $tasks);
    if(count($tasks_array) == 0) header('Location: index.php');
    foreach ($tasks_array as $task_id) {
        $current_task = Task::getTaskById($task_id, $_SESSION['project_id']);
        if($current_task) $current_task->delete();
        // echo $current_task->getId() . '<br>';
    }
    header('Location: index.php');
}

/**
 * Show the team page
 * @return [type] [description]
 */
function team(){
    // Get projects infos
    setCurrentProject();
    $project = Project::getProjectById($_SESSION['project_id'], $_SESSION['user_id']);
    $project_list = Project::getAllProjects($_SESSION['user_id']);

    require('view/team.php');
}

/**
 * Get all of project commits and show them (test)
 */
function commits(){
    $github_user = 'MartDel';
    $project_name = 'CodeManager';
    $commits = getCommits($github_user, $project_name);
    foreach ($commits as $key => $commit) {
        $current = $commit->commit;
        $author = $current->author;
        echo $author->name . ' : ' . $current->message . ' | Date : ' . date("H:i:s d/m/Y", strtotime($author->date)) . '<br>';
    }
}

/**
 * Add a new project to the database
 */
function createProject(){
    $data = secure($_POST);
    if(!isset($data['name']) || $data['name'] == '') {
        throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=' . getLastPage(), 'focusNameCreateProject');
    }

    // Create remote link with remote informations
    $remote = createRemote($data);

    $project = new Project($data['name'], $_SESSION['user_id'], $data['description'], $remote);
    $project->pushToDB();
    header('Location: index.php?project=' . $project->getDatabaseId());
}

/**
 * Edit the current project
 */
function editProject(){
    $data = secure($_POST);
    if(!isset($data['name']) || $data['name'] == '') {
        throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=' . getLastPage(), 'focusNameEditProject');
    }

    // Create remote link with remote informations
    $remote = createRemote($data);

    $project = new Project($data['name'], $_SESSION['user_id'], $data['description'], $remote);
    $project->update($_SESSION['project_id']);
    header('Location: index.php');
}

/**
 * Delete the current project from the database
 */
function deleteProject(){
    $project = Project::getProjectById($_SESSION['project_id'], $_SESSION['user_id']);
    $project->delete();

    if(count(Project::getAllProjects($_SESSION['user_id'])) == 0){
        logout();
        throw new CustomException('Pas de projet', "Vous n'avez pas de projet... Il faut modifier la base de données manuellement.", 'index.php?action=home', 'openPhpMyAdmin');
    }
    $_SESSION['project_id'] = Project::getFirstProject($_SESSION['user_id'])->getId();

    header('Location: index.php');
}

/**
 * Change the user's profile picture
 */
function editPP(){
    checkFileInfo();

    $user = getCurrentUser();
	$extension = pathinfo($_FILES['pp']['name'])['extension'];
    $user->setPictureName($_SESSION['user_id'] . '.' . $extension);
    $_SESSION['pp'] = $user->getPictureName();

    cropImage($_FILES['pp']['tmp_name'], 'public/img/users/' . $user->getPictureName());

    header('Location: index.php?action=' . getLastPage('tasks'));
}

/**
 * Delete the connected user
 */
function deleteAccount(){
    $user = getCurrentUser();
    $user->delete();
    // Delete profile picture
    unlink('public/img/users/' . $user->getPictureName());
    logout();
}

/**
 * Logout the current user
 */
function logout(){
    session_destroy();
	setcookie('auth', '', time() + 365*24*3600, '/', null, false, true);
    header('Location: index.php');
}

/**
 * Send a mail to admins to report a bug
 */
function reportBug(){
    $data = secure($_POST);
    $mess = isset($data['mess']) ? $data['mess'] : false;
    if(!$mess) header('Location: index.php?action=' . getLastPage());
    if(sendMail($mess)){
        showMessage('Mail envoyé', 'Les administrateurs du site ont été notifié de votre message. Merci de votre contribution!');
    } else {
        throw new CustomException('Erreur', "Une erreur est survenue lors de l'envoi du mail. Veuillez réessayer plus tard.", 'index.php?action=' . getLastPage());
    }
}
