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
    require('view/main.php');
}

/**
 * Add a new task in the database
 */
function addTask(){
    $data = secure($_POST);
    if($_SESSION['permissions'] == 0){
        header('Location: index.php?action=team');
        return;
    }
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
    if($_SESSION['permissions'] == 0){
        header('Location: index.php?action=team');
        return;
    }
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

/**
 * Add a category to the database
 */
function addCategory(){
    $data = secure($_POST);
    if(!isset($data['name']) && $data['name'] != ''){
        throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php');
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
        throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", 'index.php');
    }
    $category = Category::getCategoryById(htmlspecialchars($_GET['id']));
    if($category->getProjectId() != $_SESSION['project_id']){
        throw new CustomException('Action refusée', "Vous n'avez pas le droit de modifier cette catégorie.", 'index.php');
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
    if(!isset($data['id'])){
        header('Location: index.php');
        return;
    }
    $category = Category::getCategoryById($id);
    if($category->getProjectId() != $_SESSION['project_id']){
        throw new CustomException('Action refusée', "Vous n'avez pas le droit de modifier cette catégorie.", 'index.php');
    }
    $category->delete(isset($data['deleteTasks']));
    header('Location: index.php');
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
    if($_SESSION['permissions'] != 2) {
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
    $project = Project::getProjectById($_SESSION['project_id']);
    $project->delete();

    if(count(Project::getAllProjects($_SESSION['user_id'])) == 0){
        logout();
        throw new CustomException('Pas de projet', "Vous n'avez pas de projet... Il faut modifier la base de données manuellement.", 'index.php?action=home', 'openPhpMyAdmin');
    }
    $_SESSION['project_id'] = Project::getFirstProject($_SESSION['user_id'])->getId();

    header('Location: index.php');
}

/**
 * Change current project
 */
function switchProject(){
    $data = secure($_POST);
    if(isset($data['project'])){
        $project_id = $data['project'];
        if(Project::projectExist($project_id, $_SESSION['user_id'])) $_SESSION['project_id'] = $project_id;
    }
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
