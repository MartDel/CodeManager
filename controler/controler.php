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
  checkConnection($post);
  connectUser(htmlspecialchars($post['login']));
  header("Location: index.php");
}

function logout(){
  session_destroy();
  header('Location: index.php');
}
