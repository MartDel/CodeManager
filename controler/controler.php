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
        header("Location: index.php?action=home");
    }
}

/**
 * Get tasks stats and show them
 * @param int $project_id Current project id
 */
function showMainPage($project_id = 0){
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
 * Logout the current user
 */
function logout(){
    session_destroy();
	setcookie('pseudo', '', time() + 365*24*3600, null, null, false, true);
	setcookie('password', '', time() + 365*24*3600, null, null, false, true);
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
