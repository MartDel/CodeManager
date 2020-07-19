<?php
session_start();
require("controler/controler.php");
require("class/simple_html_dom.php");
require("class/DatabaseManager.php");
require("class/User.php");
require("class/Task.php");
require("class/Role.php");
$hostname = 'localhost/CodeManager';

try{
	date_default_timezone_set('UTC');
	if(isset($_SESSION['pseudo'])){ // Connected
		if(isset($_GET['action'])){
			$action = htmlspecialchars($_GET["action"]);
			if ($action == "logout") logout(); // Logout the current user
			elseif ($action == "commits") showProjectCommit(); // GitHub page
			else header('Location: index.php');
		} else {
			showMainPage(); // Tasks list page
		}
	} else { // Disconnected
		if(isset($_GET['action'])){
			$action = htmlspecialchars($_GET["action"]);
			if ($action == "signup") require('view/signup.php'); // SignUp page
			elseif ($action == 'test') {
				// https://www.ecosia.org
				// https://www.google.com
				// https://github.com/MartDel/CodeManager
				$url = 'https://www.google.com';
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
			elseif ($action == "checkSignUp") checkSignUp($_POST); // Check SignUp
			elseif ($action == "signin") require('view/signin.php'); // SignIn page
			elseif ($action == "checkSignIn") checkSignIn($_POST); // Check SignIn
			else header('Location: index.php');
		} else {
			if (isset($_COOKIE['pseudo']) && isset($_COOKIE['password'])) {
				checkCookie(); // Check if user's cookies are correct
			} else require('view/home.php'); // Home page
		}
	}
} catch(Exception $e){
	echo 'Erreur : ' . $e->getMessage();
}
