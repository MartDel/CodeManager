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

function showMainPage(){
  $tasks = Task::getAllTasks(0);
  $to_do = Task::getStat('is_done', 0, 0);
  $done = Task::getStat('is_done', 1, 0);
  $percentage = $done / ($to_do + $done) * 100;
  require('view/main.php');
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
