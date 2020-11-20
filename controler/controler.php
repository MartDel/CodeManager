<?php
require('model/model.php');

/**
 * Check if all of signup data is correct and upload to the database
 * @param  Object $post All of data
 */
function checkSignUp($post){
    checkNewUserData($post);
    addUser($post);
    header("Location: index.php");
}

/**
 * Check if all of signin data is correct by checking the database
 * @param  Object $post All of data
 */
function checkSignIn($post){
    if(!isset($post['login']) || !isset($post['password'])) {
        throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=' . getLastPage(), 'focusEmptyInput');
    }
    checkConnection($post['login'], $post['password'], false);
    connectUser(htmlspecialchars($post['login']), $post['auto']);
    header("Location: index.php");
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

/**
 * Get tasks stats and show them
 * @param int $project_id Current project id
 */
function showMainPage(){
    // Get project and projects list
    setCurrentProject();
    $project = Project::getProjectById($_SESSION['project_id'], $_SESSION['user_id']);
    $project_list = Project::getAllProjects($_SESSION['user_id']);

    $tasks = Task::getAllTasks($_SESSION['project_id']);
    $nb_tasks = isset($tasks) ? countNotDoneTasks($tasks) : 0;
    $nb_done_tasks = isset($tasks) ? countDoneTasks($tasks) : 0;
    require('view/main.php');
}

function showTeamPage(){
    // Get projects infos
    setCurrentProject();
    $project = Project::getProjectById($_SESSION['project_id'], $_SESSION['user_id']);
    $project_list = Project::getAllProjects($_SESSION['user_id']);

    require('view/team.php');
}

/**
 * Get all of project commits and show them
 */
function showProjectCommits(){
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
 * Add a new task in the database
 * @param Object $data All of task data
 */
function addTask($data){
    if(!isset($data['title']) || htmlspecialchars($data['title']) == '') {
        throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=' . getLastPage(), 'focusTitleAddTask');
    }
    $task = new Task(htmlspecialchars($data['title']), $_SESSION['project_id'], false, null, $_SESSION['user_id'], htmlspecialchars($data['description']));
    $task->pushToDB();
    header('Location: index.php');
}

/**
 * Edit a task in the database
 * @param Object $data All of task data
 */
function editTask($data){
    if(!isset($data['title']) || htmlspecialchars($data['title']) == '') {
        throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=' . getLastPage());
    }
    $task = Task::getTaskById(htmlspecialchars($_GET['id']), $_SESSION['project_id']);
    if(!$task) throw new CustomException('Erreur...', "Une erreur est survenue lors de la récupération de la tâche que vous tentez de modifier.", 'index.php?action=' . getLastPage());
    $task->setName(htmlspecialchars($data['title']));
    $task->setDescription(htmlspecialchars($data['description']));
    $task->update();
    header('Location: index.php');
}

/**
 * End a task
 * @param Object $data GET object
 */
function endTask($data){
    if(!isset($data['id'])) header('Location: index.php');
    $id = htmlspecialchars($data['id']);
    $task = Task::getTaskById($id, $_SESSION['project_id']);
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
 * @param Object $data $_GET object
 */
function deleteTasks($data){
    if(!isset($data['tasks'])) header('Location: index.php');
    $tasks = htmlspecialchars($data['tasks']);
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
 * Add a new project to the database
 * @param Object $data All of project data
 */
function createProject($data){
    if(!isset($data['name']) || htmlspecialchars($data['name']) == '') {
        throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=' . getLastPage(), 'focusNameCreateProject');
    }

    // Create remote link with remote informations
    $remote = createRemote($data);

    $project = new Project(htmlspecialchars($data['name']), $_SESSION['user_id'], htmlspecialchars($data['description']), $remote);
    $project->pushToDB();
    header('Location: index.php?project=' . $project->getDatabaseId());
}

/**
 * Edit the current project
 * @param Object $data All of project data
 */
function editProject($data){
    if(!isset($data['name']) || htmlspecialchars($data['name']) == '') {
        throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=' . getLastPage(), 'focusNameEditProject');
    }

    // Create remote link with remote informations
    $remote = createRemote($data);

    $project = new Project(htmlspecialchars($data['name']), $_SESSION['user_id'], htmlspecialchars($data['description']), $remote);
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
 * Logout the current user
 */
function logout(){
    session_destroy();
	setcookie('auth', '', time() + 365*24*3600, '/', null, false, true);
    header('Location: index.php');
}

/**
 * Send a mail to admins to report a bug
 * @param Object $data All of bug data
 */
function reportBug($data){
    $mess = isset($data['mess']) ? htmlspecialchars($data['mess']) : false;
    if(!$mess) header('Location: index.php?action=' . getLastPage());
    if(sendMail($mess)){
        showMessage('Mail envoyé', 'Les administrateurs du site ont été notifié de votre message. Merci de votre contribution!');
    } else {
        throw new CustomException('Erreur', "Une erreur est survenue lors de l'envoi du mail. Veuillez réessayer plus tard.", 'index.php?action=' . getLastPage());
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
