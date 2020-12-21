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
    $project = Project::getProjectById($_SESSION['project_id']);
    $project_list = Project::getAllProjects($_SESSION['user_id']);

    $tasks = Task::getAllTasks($_SESSION['project_id']);
    $tasksByCategory = orderByCategory($tasks);
    $nb_tasks = isset($tasks) ? countNotDoneTasks($tasks) : 0;
    $nb_done_tasks = isset($tasks) ? countDoneTasks($tasks) : 0;

    $categories = Category::getAllCategories($_SESSION['project_id']);
    require('view/tasks.php');
}

/**
 * Add a new task in the database
 */
function addTask(){
    $data = secure($_POST);
    if($_SESSION['permissions'] == 0){
        header('Location: index.php');
        return;
    }
    if(!isset($data['title']) || $data['title'] == '') {
        throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=tasks', 'focusTitleAddTask');
    }
    $category = isset($data['category']) && $data['category'] != '-1' ? $data['category'] : null;
    $category = isset($data['add_category']) && $data['add_category'] != '' ? addCategory($data['add_category']) : $category;
    $task = new Task($data['title'], $_SESSION['project_id'], false, null, $_SESSION['user_id'], $data['description'], $category);
    $task->pushToDB();
    header('Location: index.php');
}

/**
 * Edit a task in the database
 */
function editTask(){
    $data = secure($_POST);
    if($_SESSION['permissions'] == 0){
        header('Location: index.php');
        return;
    }
    if(!isset($data['title']) || $data['title'] == '') {
        throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php');
    }
    $task = Task::getTaskById(htmlspecialchars($_GET['id']), $_SESSION['project_id']);
    if(!$task) throw new CustomException('Erreur...', "Une erreur est survenue lors de la récupération de la tâche que vous tentez de modifier.", 'index.php');
    $task->setName($data['title']);
    $task->setDescription($data['description']);

    $category = isset($data['category']) && $data['category'] != '-1' ? $data['category'] : null;
    $category = isset($data['add_category']) && $data['add_category'] != '' ? addCategory($data['add_category']) : $category;
    $task->setCategoryId($category);

    $task->update();
    header('Location: index.php');
}

/**
 * End a task
 */
function endTask(){
    $data = secure($_GET);
    if($_SESSION['permissions'] == 0){
        throw new CustomException('Action refusée...', "Vous n'avez pas l'autorisation de marquer une tâche comme terminée.", 'index.php');
    }
    if(!isset($data['id'])){
        header('Location: index.php');
        return;
    }
    $task = Task::getTaskById($data['id'], $_SESSION['project_id']);
    if($task){
        $done_task = $task->getIsDone();
        $task->setIsDone(!$done_task);
        $task->update();
        $params = $done_task ? '?endTask' : '';
        header('Location: index.php' . $params);
        return;
    }
    header('Location: index.php');
}

/**
 * Delete selected tasks
 */
function deleteTasks(){
    $data = secure($_GET);
    if($_SESSION['permissions'] == 0){
        header('Location: index.php');
        return;
    }
    if(!isset($data['tasks'])){
        header('Location: index.php');
        return;
    }
    $tasks = $data['tasks'];
    $tasks_array = explode(' ', $tasks);
    if(count($tasks_array) == 0){
        header('Location: index.php');
        return;
    }
    foreach ($tasks_array as $task_id) {
        $current_task = Task::getTaskById($task_id, $_SESSION['project_id']);
        if($current_task) $current_task->delete();
    }
    header('Location: index.php');
}

function objectives(){
    // Get projects infos
    $project = Project::getProjectById($_SESSION['project_id']);
    $project_list = Project::getAllProjects($_SESSION['user_id']);

    require('view/objectives.php');
}

/**
 * Show the team page
 */
function team(){
    // Get projects infos
    $project = Project::getProjectById($_SESSION['project_id']);
    $project_list = Project::getAllProjects($_SESSION['user_id']);

    $users = Team::getAllUsers($_SESSION['project_id']);
    require('view/team.php');
}

/**
 * Search an user in the database
 */
function searchUser(){
    $data = secure($_POST);
    $user = User::getUserByLogin($data['mail']);
    if($_SESSION['permissions'] != 2){
        header('Location: index.php?action=team');
        return;
    }
    if(!$user){
        $not_found = new CustomException('Mauvaise nouvelle...', "Aucun utilisateur n'a été trouvé. Veulliez réessayer avec une autre addresse e-mail.", 'index.php?action=team', 'openAddUserModal');
        $not_found->setBtn('reload');
        throw $not_found;
    }
    $team_row = new Team($_SESSION['project_id'], $user->getId());
    if($team_row->exists()){
        $not_found = new CustomException('Mauvaise nouvelle...', "L'utilisateur trouvé est déjà dans votre équipe. Veulliez réessayer avec une autre addresse e-mail.", 'index.php?action=team', 'openAddUserModal');
        $not_found->setBtn('reload');
        throw $not_found;
    }
    $found = new InformationMessage('Utilisateur trouvé !', "L'utilisateur '" . $user->getPseudo() . "' a été trouvé. Voulez-vous l'ajouter à votre équipe?", 'index.php?action=team', 'addUser');
    $found->setBtn('add');
    $found->setArg($user->getMail());
    $found->redirect();
}

/**
 * Add a contributor to the current team
 */
function addUserToTeam(){
    $data = secure($_GET);
    $user = User::getUserByLogin($data['mail']);
    if($_SESSION['permissions'] != 2){
        header('Location: index.php?action=team');
        return;
    }
    if(!$user){
        header('Location: index.php?action=team');
        return;
    }
    $team = new Team($_SESSION['project_id'], $user->getId());
    if($team->exists()){
        header('Location: index.php?action=team');
        return;
    }
    $team->pushToDB();
    $added = new InformationMessage('Utilisateur ajouté !', "Tout s'est passé comme prévu ! L'utilisateur '" . $user->getPseudo() . "' a été ajouté à votre équipe.", 'index.php?action=team');
    $added->redirect();
}

/**
 *  Remove a contributor from the current team
 */
function removeUserFromTeam(){
    $data = secure($_GET);
    if($_SESSION['permissions'] != 2) {
        header('Location: index.php?action=team');
        return;
    }
    $user = User::getUserById($data['id']);
    if(!$user){
        header('Location: index.php?action=team');
        return;
    }
    $team = new Team($_SESSION['project_id'], $user->getId());
    if(!$team->exists()){
        header('Location: index.php?action=team');
        return;
    }
    if($team->getPermissions() == 2) {
        throw new CustomException('Action refusée...', "Vous ne pouvez pas vous retirer du projet.", 'index.php?action=team');
    }
    $team->delete();
    $added = new InformationMessage('Utilisateur écarté du projet !', "Tout s'est passé comme prévu ! L'utilisateur '" . $user->getPseudo() . "' a été supprimé de votre équipe.", 'index.php?action=team');
    $added->redirect();
}

/**
 * Edit user role and permissions from the current the team
 */
function editUserFromTeam(){
    $post = secure($_POST);
    $get = secure($_GET);
    if($_SESSION['permissions'] != 2) {
        header('Location: index.php?action=team');
        return;
    }
    $user = User::getUserById($get['id']);
    if(!$user){
        header('Location: index.php?action=team');
        return;
    }
    $team = new Team($_SESSION['project_id'], $user->getId());
    if(!$team->exists()){
        header('Location: index.php?action=team');
        return;
    }
    if(!isset($post['perm'])){
        throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs du formulaire.", 'index.php?action=team');
    }

    if(isset($post['role']) && $post['role'] != '') $role = $post['role'];
    else $role = null;
    $perm = $post['perm'] == 'on' ? 1 : 0;
    $perm = $team->getPermissions() == 2 ? 2 : $perm;

    $team->setRole($role);
    $team->setPermissions($perm);
    $team->update();
    header('Location: index.php?action=team');
}

/**
 * Get all of project commits and show them (test)
 */
function chat(){
    // Get projects infos
    $project = Project::getProjectById($_SESSION['project_id']);
    $project_list = Project::getAllProjects($_SESSION['user_id']);

    require('view/talk.php');
}

/**
 * Get all of project commits and show them (test)
 */
function github(){
    // Get projects infos
    $project = Project::getProjectById($_SESSION['project_id']);
    $project_list = Project::getAllProjects($_SESSION['user_id']);

    // Check if the repository exists
    // $commits_available = false;
    // if($project->getRemotePseudo() && $project->getRemoteName()){
    //     $url = "https://github.com/" . $project->getRemotePseudo() . "/" . $project->getRemoteName();
    //     $array = get_headers($url);
    //     $string = $array[0];
    //     if(strpos($string,"200")) $commits_available = true;
    // }
    //
    // if($commits_available) $branches = Commit::getAllBranches($project->getRemotePseudo(), $project->getRemoteName());
    require('view/gitpage.php');
}

/**
 * New project form
 */
function noProject(){
    // Check current project
    if(isset($_SESSION['project_id'])) {
        header('Location: index.php');
        return;
    }

    require('view/project_creation.php');
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
    $team_row = new Team($project->getId(), $_SESSION['user_id']);
    $team_row->setPermissions(2);
    $team_row->pushToDB();
    $_SESSION['project_id'] = $project->getId();
    header('Location: index.php');
}

/**
 * Edit the current project
 */
function editProject(){
    $data = secure($_POST);
    if($_SESSION['permissions'] != 2) {
        header('Location: index.php?action=' . getLastPage());
        return;
    }
    if(!isset($data['name']) || $data['name'] == '') {
        throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=' . getLastPage(), 'focusNameEditProject');
    }

    // Create remote link with remote informations
    $remote = createRemote($data);

    $project = new Project($data['name'], $_SESSION['user_id'], $data['description'], $remote);
    $project->update($_SESSION['project_id']);

    $success = new InformationMessage('Projet modifié', "Votre projet a été modifié avec succés !", 'index.php?action=' . getLastPage());
    $success->redirect();
}

/**
 * Delete the current project from the database
 */
function deleteProject(){
    if($_SESSION['permissions'] != 2) {
        header('Location: index.php?action=' . getLastPage());
        return;
    }
    $project = Project::getProjectById($_SESSION['project_id']);
    $project->delete();

    $project = Project::getFirstProject($_SESSION['user_id']);
    if(!$project){
        header('Location: index.php?action=noProject');
        return;
    }
    $_SESSION['project_id'] = $project->getId();

    $success = new InformationMessage('Projet supprimé', "Votre projet a été supprimé avec succés !", 'index.php');
    $success->redirect();
}

/**
 * Change current project
 */
function switchProject(){
    $data = secure($_POST);
    if(isset($data['project'])){
        $project_id = $data['project'];
        $team_row = new Team($project_id, $_SESSION['user_id']);
        if($team_row->exists()) $_SESSION['project_id'] = $project_id;
    }
    header('Location: index.php');
}

/**
 * Change the user's profile picture
 */
function editPP(){
    checkFileInfo();

    // Delete existing pp
    if(isset($_SESSION['pp'])){
        unlink('public/img/users/' . $_SESSION['pp']);
    }

    $user = getCurrentUser();
	$extension = pathinfo($_FILES['pp']['name'])['extension'];
    $user->setPictureName($_SESSION['user_id'] . '.' . $extension);
    $_SESSION['pp'] = $user->getPictureName();

    cropImage($_FILES['pp']['tmp_name'], 'public/img/users/' . $user->getPictureName());

    $success = new InformationMessage('Photo de profil modifiée', "Votre photo de profil a été modifiée avec succés !", 'index.php?action=' . getLastPage());
    $success->redirect();
}

function editAccount(){
    $data = secure($_POST);
    if(!isset($data['pseudo']) || $data['pseudo'] == '') {
        throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php?action=' . getLastPage(), 'focusNameEditProject');
    }
    if(User::getUserByLogin($data['pseudo'])) {
        throw new CustomException('Pseudo non disponible', "Ce nom d'utilisateur est déjà utilisé. Veuillez réessayer avec un autre nom d'utilisateur.", 'index.php?action=' . getLastPage(), 'openEditAccount');
    }
    $user = User::getUserById($_SESSION['user_id']);
    $user->setPseudo($data['pseudo']);
    $_SESSION['pseudo'] = $data['pseudo'];

    $success = new InformationMessage('Profil modifié', "Votre profil a été modifié avec succés !", 'index.php?action=' . getLastPage());
    $success->redirect();
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
 * Send a mail to admins to report a bug
 */
function reportBug(){
    $data = secure($_POST);
    $mess = isset($data['mess']) ? $data['mess'] : false;
    if(!$mess){
        header('Location: index.php?action=' . getLastPage());
        return;
    }
    if(sendMail($mess)){
        $success = new InformationMessage('Mail envoyé', "Les administrateurs du site ont été notifié de votre message. Merci de votre contribution!", 'index.php?action=' . getLastPage());
        $success->redirect();
    } else {
        throw new CustomException('Erreur', "Une erreur est survenue lors de l'envoi du mail. Veuillez réessayer plus tard.", 'index.php?action=' . getLastPage());
    }
}
