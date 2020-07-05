<?php
require('model/model.php');

/**
 * Check if all of signup data is correct and upload to the db
 * @param  Object $post All of data
 * @return void
 */
function checkSignUp($post){
  $success = checkNewUserData($post);
  if($success){
    $_SESSION['pseudo'] = htmlspecialchars($post['pseudo']);
	   header("Location: index.php");
  } else {
    throw new Exception("Informations incorrectes ou compte déjà existant");
  }
}

/*
EX :

function connection(){
    $verif = CheckConnection();
    require('view/frontend/connection.php');
}
*/
