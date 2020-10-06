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
        throw new Exception("Veuillez remplir tous les champs");
    }
    checkConnection($post['login'], $post['password'], false);
    connectUser(htmlspecialchars($post['login']), $post['auto']);
    header("Location: index.php");
}

/**
 * Check if user's cookies are correct
 */
function checkCookie(){
    try {
        checkConnection($_COOKIE['pseudo'], $_COOKIE['password'], true);
        connectUser(htmlspecialchars($_COOKIE['pseudo']), true);
        header("Location: index.php");
    } catch (Exception $e) {
        logout();
        header("Location: index.php");
    }
}

/**
 * Get tasks stats and show them
 * @param int $project_id Current project id
 */
function showMainPage(){
    $user_id = $_SESSION['user_id'];
    $project_id = isset($_GET['project']) ? htmlspecialchars($_GET['project']) : false;
    if(!Project::projectExist($project_id, $user_id) || !isset($_GET['project'])) $project_id = $_SESSION['project_id'];
    $_SESSION['project_id'] = $project_id;
    if(!$project_id) throw new Exception("Vous n'avez pas de projet... Il faut modifier la base de données manuellement!");
    $project = Project::getProjectById($project_id, $user_id);
    $project_list = Project::getAllProjects($user_id);
    $tasks = Task::getAllTasks($project_id);
    require('view/main.php');
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
 * Add a new task in database
 * @param Object $data All of task data
 */
function addTask($data){
    if(!isset($data['title']) || htmlspecialchars($data['title']) == '') throw new Exception("Veuillez remplir tous les champs.");
    $task = new Task(htmlspecialchars($data['title']), $_SESSION['project_id'], false, null, $_SESSION['user_id'], htmlspecialchars($data['description']));
    $task->pushToDB();
    header('Location: index.php');
}

/**
 * End a task
 * @param Object $data
 */
function endTask($data){
    if(!isset($data['id'])) header('Location: index.php');
    $id = htmlspecialchars($data['id']);
    $task = Task::getTaskById($id);
    $done_task = $task->getIsDone();
    $task->setIsDone(!$task->getIsDone());
    $params = $done_task ? '?endTask' : '';
    header('Location: index.php' . $params);
}

/**
 * Add a new project to the database
 * @param Object $data All of project data
 */
function createProject($data){
    if(!isset($data['name']) || htmlspecialchars($data['name']) == '') throw new Exception("Veuillez remplir tous les champs.");
    $project = new Project(htmlspecialchars($data['name']), $_SESSION['user_id'], htmlspecialchars($data['description']), htmlspecialchars($data['remote']));
    $project->pushToDB();
    header('Location: index.php');
}

/**
 * Logout the current user
 */
function logout(){
    session_destroy();
	setcookie('pseudo', '', time() + 365*24*3600, '/', null, false, true);
	setcookie('password', '', time() + 365*24*3600, '/', null, false, true);
    header('Location: index.php');
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
