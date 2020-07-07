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
  checkConnection($post['login'], $post['password']);
  $hashed_password = password_hash($post['password'], PASSWORD_DEFAULT);
  connectUser(htmlspecialchars($post['login']), $hashed_password, $post['auto']);
  header("Location: index.php");
}

/**
 * Check if user's cookies are correct
 */
function checkCookie(){
  try {
    checkConnection($_COOKIE['pseudo'], $_COOKIE['password']);
    $hashed_password = password_hash($_COOKIE['password'], PASSWORD_DEFAULT);
    connectUser(htmlspecialchars($_COOKIE['pseudo']), $hashed_password, true);
    header("Location: index.php");
  } catch (Exception $e) {
    header("Location: index.php?action=home");
  }

}

/**
 * Get tasks stats and show them
 * @param int $project_id Current project id
 */
function showMainPage($project_id = 0){
  $tasks = Task::getAllTasks($project_id);
  $to_do = Task::getStat('is_done', 0, $project_id);
  $done = Task::getStat('is_done', 1, $project_id);
  $percentage = $done / ($to_do + $done) * 100;
  require('view/main.php');
}

/**
 * Get all of project commits and show them
 */
function showProjectCommit(){
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
