<!DOCTYPE html>
<html>
	<head>
	    <title><?= $title ?></title>
		<meta charset="utf-8" />
	    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	    <link rel="stylesheet" href="public/CSS/<?= $cssfile ?>.css" />

		<!-- CSS for JS transitions -->
	    <link rel="stylesheet" href="public/CSS/transitions.css" />

	    <link rel="icon" type="image/png" href="" />
	    <link rel="shortcut icon" href="public/img/programmer2.png">
	    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

	    <!--Start of Tawk.to Script
	    <script type="text/javascript">
	        var Tawk_API = Tawk_API || {},
	            Tawk_LoadStart = new Date();
	        (function () {
	            var s1 = document.createElement("script"),
	                s0 = document.getElementsByTagName("script")[0];
	            s1.async = true;
	            s1.src = 'https://embed.tawk.to/5f3cf6161e7ade5df442289f/1egl19u2n';
	            s1.charset = 'UTF-8';
	            s1.setAttribute('crossorigin', '*');
	            s0.parentNode.insertBefore(s1, s0);
	        })();
	    </script>
	    End of Tawk.to Script-->
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
		    <input type="search" autocomplete="off" id="findField" placeholder="Rechercher dans les tâches" />
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
		            <a href="index.php">
		                <li id="menu1" class="selectedmenu">
		                  <span title="Tâches">
		                    <img class="img_menu_gauche_js" src="public/img/listindex.png" alt="" />
		                  </span>
		                    <p id="text_menu_left_1">Tâches</p>
		                </li>
		            </a>
		            <li class="notselectedmenu">
		                <span title="Objectifs">
		                  <img class="img_menu_gauche_js" src="public/img/objectiveindex.png" alt="" />
		                </span>
		                <p id="text_menu_left_2">Objectifs</p>
		            </li>
								<a href="index.php?action=team">
									<li class="notselectedmenu">
			              <span title="Team">
			                <img class="img_menu_gauche_js" src="public/img/group.png" alt="" />
			              </span>
			                <p id="text_menu_left_3">Team</p>
			            </li>
								</a>
		            <li class="notselectedmenu">
		              <span title="Discussion">
		                <img class="img_menu_gauche_js" src="public/img/people.png" alt="" />
		              </span>
		                <p id="text_menu_left_4">Discussion</p>
		            </li>
		            <li class="notselectedmenu">
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
		<script type="text/javascript" src="public/JS/<?= $jsfile ?>.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
	</body>
</html>
