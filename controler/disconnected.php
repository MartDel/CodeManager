<?php

/*
====================
=== DISCONNECTED ===
====================
 */

function home(){ require('view/home.php'); }
function signup(){ require('view/signup.php'); }
function signin(){ require('view/signin.php'); }

 /**
  * Check if all of signup data is correct and upload to the database
  */
 function checkSignUp(){
     $data = secure($_POST);
     checkNewUserData($data);
     addUser($data);
     header("Location: /");
 }

 /**
  * Check if all of signin data is correct by checking the database
  */
 function checkSignIn(){
     sleep(1);
     $data = secure($_POST);
     if(!isset($data['login']) || !isset($data['password'])) {
         throw new CustomException('Formulaire incorrect', "Veuillez remplir tous les champs.", '/' . getLastPage(), 'focusEmptyInput');
     }
     checkConnection($data['login'], $data['password'], false);
     connectUser($data['login'], $data['auto']);
     header("Location: /");
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
