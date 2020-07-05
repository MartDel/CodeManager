<?php

function dbConnect(){
	$db = new PDO('mysql:host=localhost;dbname=NAME;charset=utf8', 'USER', 'PWD');
	return $db;
}

//FUNCTIONS

/*
EX :

function ValidateConnection(){
	$db = dbConnect();
	$mdp = $db->prepare('SELECT mdp FROM compte WHERE pseudo=?');
	$mdp->execute(array(htmlspecialchars($_POST["pseudo"])));
	$pass = $mdp->fetch();
	if(!$pass || !password_verify($_POST['password'], $pass['mdp'])){
		throw new Exception('Aucune données de compte inscrit dans la base de données ne correspondent aux identifiants inscrits.');
	}
	$mdp->closeCursor();
	$info = $db->prepare("SELECT pseudo, prenom, nom, mdp, id FROM compte WHERE pseudo=?");
	$info->execute(array(htmlspecialchars($_POST["pseudo"])));
	$info = $info->fetch();
	return $info;
}
*/
