<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

// User infos
$lastname = 'BlaBla';
$firstname = 'Timothé';

$to = "martin-delebecque@outlook.fr";
$sujet = "Remarque utilisateur";

$headers = "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "Reply-To: The Sender <sender@sender.com>\r\n";
$headers .= "Return-Path: The Sender <sender@sender.com>\r\n";
$headers .= "From: sender@sender.com" ."\r\n" .
$headers .= "Organization: Sender Organization\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;

$msg='';
$msg .= 'Nom : ' . $lastname . '<br>';
$msg .= 'Prénom : ' . $firstname . '<br><br>';
$msg .= 'Bonjouuuuur';

mail($to, $sujet, $msg, $headers);

echo 'Mail envoyé!';
