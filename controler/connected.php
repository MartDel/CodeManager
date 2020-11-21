<?php

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
    $tasksByCategory = orderByCategory($tasks);
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
        $task->update();
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
    }
    header('Location: index.php');
}

/**
 * Add a category to the database
 */
function addCategory(){
    $data = secure($_POST);
    if(!isset($data['name']) && $data['name'] != ''){
        throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=' . getLastPage());
    }
    $category = new Category($data['name'], $_SESSION['project_id']);
    $category->pushToDB();
    header('Location: index.php');
}

/**
 * Edit a category from the database
 */
function editCategory(){
    $data = secure($_POST);
    if(!isset($data['name']) && $data['name'] != ''){
        throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=' . getLastPage());
    }
    $category = Category::getCategoryById(htmlspecialchars($_GET['id']));
    if($category->getProjectId() != $_SESSION['project_id']){
        throw new CustomException('Action refusée', "Vous n'avez pas le droit de modifier cette catégorie.", 'index.php?action=' . getLastPage());
    }
    $category->setName($data['name']);
    $category->update();
    header('Location: index.php');
}

/**
 * Delete a category
 */
function deleteCategory(){
    $data = secure($_GET);
    if(!isset($data['id'])) header('Location: index.php');
    $category = Category::getCategoryById($id);
    if($category->getProjectId() != $_SESSION['project_id']){
        throw new CustomException('Action refusée', "Vous n'avez pas le droit de modifier cette catégorie.", 'index.php?action=' . getLastPage());
    }
    $category->delete(isset($data['deleteTasks']));
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

function editAccount(){
    $data = secure($_POST);
    if(!isset($data['pseudo']) || $data['pseudo'] == '') {
        throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=' . getLastPage(), 'focusNameEditProject');
    }
    $project = User::getUserById($_SESSION['user_id']);
    if(User::getUserByLogin($data['pseudo'])) {
        throw new CustomException('Pseudo non disponible', "Ce nom d'utilisateur est déjà utilisé. Veuillez réessayer avec un autre nom d'utilisateur.", 'index.php?action=' . getLastPage(), 'openEditAccount');
    }
    $project->setPseudo($data['pseudo']);
    header('Location: index.php');
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
