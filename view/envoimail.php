<?php


	 if (get_magic_quotes_gpc())
	{
	 $nom = stripslashes(trim($_POST['text2']));
	 $prenom = stripslashes(trim($_POST['text3']));
	 $mail = stripslashes(trim($_POST['text4']));
	 $telephone = stripslashes(trim($_POST['text6']));
	 $sujet = stripslashes(trim($_POST['text5']));
	 $message = stripslashes(trim($_POST['text1']));

	}
	else
	{
	 $nom = trim($_POST['text2']);
	 $prenom = trim($_POST['text3']);
	 $mail = trim($_POST['text4']);
	 $telephone = trim($_POST['text6']);
	 $sujet = trim($_POST['text5']);
	 $message = trim($_POST['text1']);

	}


	// DESTINATAIRE
	$to="tom.mullier@outlook.fr";

	//SUJET MAIL
	$sujet="Message depuis le site";
	$msg='';

	//MESSAGE EN LUI MÊME
	$msg .= 'Nom : '.$nom."rnrn";
	$msg .= 'Prénom : '.$prenom."rnrn";
	$msg .= 'Mail : '.$mail."rnrn";
	$msg .= 'Numéro de téléphone : '.$telephone."rnrn";
	$msg .= 'Sujet : '.$sujet."rnrn";
	$msg .= 'Message : '.$message."rnrn";

	//EN-TÊTE DU MAIL
	$headers = 'From: MESSAGE DU SITE ZAYDIONE<demo@zaydione>'."rn";
	$headers .="rn"

	//ENVOI DU MAIL ET REDIRECTION
	mail($to, $sujet, $msg, $headers);

	header(Loaction:formulaire-merci.html)


?>
