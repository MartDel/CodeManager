<!DOCTYPE html>
<html>
	<head>
	    <title><?= $title ?></title>
			<meta charset="utf-8" />
	    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

			<!-- CSS -->
	    <link rel="stylesheet" type="text/css" href="public/CSS/<?= $cssfile ?>.css" />
	    <link rel="stylesheet" type="text/css" href="public/CSS/transitions.css" />
			<link rel="stylesheet" type="text/css" href="public/CSS/template/modals.css" />
			<link rel="stylesheet" type="text/css" href="public/CSS/template/message.css" />
			<link rel="stylesheet" type="text/css" href="public/CSS/template/template.css" />
	    <link rel="icon" type="image/png" href="" />
	    <link rel="shortcut icon" href="public/img/programmer2.png">
	    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
      <script type="module" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.esm.js"></script>
      <script nomodule="" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.js"></script>
			<script type="module">
				window.onload = () => {
						// Menu/nav onload function and check if there is a message to print
						setTimeout(() => {
							document.getElementsByTagName("BODY")[0].style.opacity="1";
						},50)
						if (getCookie('menu') === 'open') {
							for (let i = 0; i < menu.text.length; i++) {
									menu.text[i].style.transition = "all 0s";
									//hide(menu.text[i]);
							}
							for (let i = 0; i < menu.img.length; i++) menu.img[i].style.transition = "all 0s";
							for (let i = 0; i < menu.not_selected.length; i++) menu.not_selected[i].style.transition = "all 0s";
							menu.main_div.style.transition = "all 0s";
							menu.selected.style.transition = "all 0s";
							openMenu();

							setTimeout(() => {
								for (let i = 0; i < menu.text.length; i++) {
									menu.text[i].style.transition = "all 0.2s";
									//hide(menu.text[i]);
								}
								for (let i = 0; i < menu.img.length; i++) menu.img[i].style.transition = "all 0.2s";
								for (let i = 0; i < menu.not_selected.length; i++) menu.not_selected[i].style.transition = "all 0.2s";
								menu.main_div.style.transition = "all 0.2s";
								menu.selected.style.transition = "all 0.2s";
							},1000)
							setTimeout(() => {
								closeMenu()
							},1000)
						}
						wOnload()
						checkMessage()

						// Hide or show done tasks
						const search = window.location.search
						const params = new URLSearchParams(search)
						tasks_done.show = params.has('endTask')
						showTasks(!tasks_done.show)
						showDoneTasks(tasks_done.show)
						if (tasks_done.show) {
								tasks_done.btn.style.filter = "grayscale(0%)";
								tasks_done.btn.style.animation = "0.5s Rotate";
						} else {
								tasks_done.btn.style.filter = "grayscale(100%)";
								tasks_done.btn.style.animation = "0.5s RotateInv";
						}
						tasks.container.style.opacity = 1
				};
			</script>
	</head>
	<body>
		<!--MENU DU HAUT-->
		<div id="menu_haut">
		    <!--<img id="burger" src="public/img/burgermenugauche.png">-->
		    <div id="webapp_cover">
		        <div id="menu_button">
		            <input type="checkbox" id="menu_checkbox">
		            <label for="menu_checkbox" id="menu_label">
		                <div id="menu_text_bar"></div>
		            </label>
		        </div>
		    </div>
		    <a id="logo_a" href="index.php">
		        <img id="logo" src="public/img/essai_logo.png" />
		    </a>
		    <input type="search" autocomplete="off" id="findField" placeholder="Rechercher" />
		    <img id="help_logo_img" src="public/img/question.png" alt="" />
		    <img id="account_logo_img" src="public/img/switzerland.png" />
		    <img id="gear_logo_img" src="public/img/gear.png" />
		    <img id="switch_logo_img" src="public/img/file_swap.png" alt="" />
		    <button id="project_actual"><?= /*$project->getName()*/ "TestTeam"?></button>
		</div>

		<!--MENU DE GAUCHE-->
		<section class="section_en_dessous_menu">
		    <div id="menu_gauche">

		        <ul>
		            <a>
		                <li onclick="redirect_index()" class="<?= $page == 'tasks' ? '' : 'not' ?>selectedmenu">
		                  <span title="Tâches">
		                    <img class="img_menu_gauche_js" src="public/img/listindex.png" alt="" />
		                  </span>
		                    <p id="text_menu_left_1">Tâches</p>
		                </li>
		            </a>
		            <li class="<?= $page == 'other' ? '' : 'not' ?>selectedmenu">
		                <span title="Objectifs">
		                  <img class="img_menu_gauche_js" src="public/img/objectiveindex.png" alt="" />
		                </span>
		                <p id="text_menu_left_2">Objectifs</p>
		            </li>
					<a onclick="redirect_team()">
						<li id="menu3" class="<?= $page == 'team' ? '' : 'not' ?>selectedmenu">
			              <span title="Team">
			                <img class="img_menu_gauche_js" src="public/img/group.png" alt="" />
			              </span>
			                <p id="text_menu_left_3">Team</p>
			            </li>
					</a>
		            <li class="<?= $page == 'other' ? '' : 'not' ?>selectedmenu">
		              <span title="Discussion">
		                <img class="img_menu_gauche_js" src="public/img/people.png" alt="" />
		              </span>
		                <p id="text_menu_left_4">Discussion</p>
		            </li>
		            <li class="<?= $page == 'other' ? '' : 'not' ?>selectedmenu">
		              <span title="GitHub">
		                <img class="img_menu_gauche_js" src="public/img/network.png" alt="" />
		              </span>
		                <p id="text_menu_left_5">GitHub</p>
		            </li>
		        </ul>
		    </div>
		    <section id="copyright">
		        <p>Copyright ® 2020 CodeManager. All Rights Reserved</p>
		    </section>

		<?= $content ?>

		<?php require('message.php'); ?>

		<!-- Implementations -->
		<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.0.js"></script>

		<!-- JS code -->
		<script type="text/javascript" src="public/JS/template/message.js"></script>
		<script type="text/javascript" src="public/JS/template/manage_messages.js"></script>
		<script type="text/javascript" src="public/JS/template/modal.js"></script>
		<script type="text/javascript" src="public/JS/template/menu_nav.js"></script>
		<script type="text/javascript" src="public/JS/<?= $jsfile ?>.js"></script>

	</body>
</html>
