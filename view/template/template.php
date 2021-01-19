<!DOCTYPE html>
<html lang="fr">
	<head>
    <title><?= $project->getName() ?> | CodeManager</title>
		<meta charset="utf-8" />
		<meta name="color-scheme" content="dark light">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="HandheldFriendly" content="true" />

		<!-- CSS -->
    <link rel="stylesheet" type="text/css" href="public/CSS/<?= $cssfile ?>.css" id="stl"/>
    <link rel="stylesheet" type="text/css" href="public/CSS/transitions.css" />

		<!-- Template CSS -->
		<link rel="stylesheet" type="text/css" href="public/CSS/template/modals.css" />
		<link rel="stylesheet" type="text/css" href="public/CSS/template/message.css" />
		<link rel="stylesheet" type="text/css" href="public/CSS/template/template.css" />

    <link rel="shortcut icon" href="public/img/shortcuticon.png" />
  	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet" />

		<!-- Ionicons -->
		<script type="module" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.esm.js"></script>
		<script nomodule="" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.js"></script>
	</head>
	<body>
		<!--MENU DU HAUT-->
		<div id="menu_haut">
		    <!--<img id="burger" src="public/img/burgermenugauche.png">-->
	    <div id="webapp_cover">
      	<div id="menu_button">
	        <input type="checkbox" id="menu_checkbox">
	        <label for="menu_checkbox" id="menu_label">
            <span id="menu_text_bar"></span>
	        </label>
        </div>
    	</div>
	    <a id="logo_a" href="index.php">
        <img alt="" id="logo" src="public/img/essai_logo.png" />
	    </a>
	    <input type="search" autocomplete="off" id="findField" placeholder="Rechercher" />
	    <img class="onhover_top_animation" id="help_logo_img" src="public/img/question.png" alt="" />
			<img id="account_logo_img" src="public/img/<?= isset($_SESSION['pp']) ? 'users/' . $_SESSION['pp'] : 'defaultuser.png' ?>" alt="Photo de profil">
	    <img alt="" class="onhover_top_animation" id="gear_logo_img" src="public/img/gear.png" />
	    <img class="onhover_top_animation" id="switch_logo_img" src="public/img/file_swap.png" alt="" />
	    <button id="project_actual"><?= $project->getName() ?></button>
		</div>

		<!--MENU DE GAUCHE-->
		<section class="section_en_dessous_menu">
	    <div id="menu_gauche">
      	<ul>
					<li class="<?= $page == 'tasks' ? '' : 'not' ?>selectedmenu">
	          <a href="index.php?action=tasks">
              <div>
                <span title="Tâches">
                  <img class="img_menu_gauche_js" src="public/img/listindex.png" alt="" />
                </span>
                <p class="colorred textgauche" id="text_menu_left_1">Tâches</p>
          		</div>
	          </a>
					</li>
					<li class="<?= $page == 'objectives' ? '' : 'not' ?>selectedmenu">
						<a href="index.php?action=objectives">
							<div>
                <span title="Objectifs">
                  <img class="img_menu_gauche_js" src="public/img/objectiveindex.png" alt="" />
                </span>
                <p class="textgauche" id="text_menu_left_2">Objectifs</p>
							</div>
						</a>
					</li>
					<li id="menu3" class="<?= $page == 'team' ? '' : 'not' ?>selectedmenu">
						<a href="index.php?action=team">
							<div>
	              <span title="Team">
	                <img class="img_menu_gauche_js" src="public/img/group.png" alt="" />
	              </span>
                <p class="textgauche" id="text_menu_left_3">Team</p>
							</div>
						</a>
					</li>
					<li class="<?= $page == 'other' ? '' : 'not' ?>selectedmenu">
						<a href="index.php?action=chat">
							<div>
	              <span title="Discussion">
	                <img class="img_menu_gauche_js" src="public/img/people.png" alt="" />
	              </span>
                <p class="textgauche" id="text_menu_left_4">Discussion</p>
							</div>
						</a>
					</li>
					<li class="<?= $page == 'github' ? '' : 'not' ?>selectedmenu">
      			<a href="index.php?action=github">
							<div>
	              <span title="GitHub">
	                <img class="img_menu_gauche_js" src="public/img/network.png" alt="" />
	              </span>
                <p class="textgauche" id="text_menu_left_5">GitHub</p>
							</div>
						</a>
					</li>
        </ul>
	    </div>
	    <section id="copyright">
        <p>Copyright ® 2020 CodeManager. All Rights Reserved</p>
	    </section>

		<?= $content ?>

		<?php require('message.php'); ?>

		<script >
			const permissions = <?= $_SESSION['permissions'] ?>
		</script>

		<!-- Implementations -->
		<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.0.js"></script>

		<!-- JS code -->
		<script src="public/JS/template/Message.js"></script>
		<script src="public/JS/template/manage_messages.js"></script>
		<script src="public/JS/template/modal.js"></script>
		<script src="public/JS/template/template.js"></script>
		<script src="public/JS/<?= $jsfile ?>.js"></script>
	</body>
</html>
