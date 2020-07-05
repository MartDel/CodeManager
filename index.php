<?php
require("controler/controler.php");

try{
	if(isset($_GET['action'])){
		//ACTION
	} else{
		//HOME
	}
} catch(Exception $e){
	echo 'Erreur : ' . $e->getMessage();
}
