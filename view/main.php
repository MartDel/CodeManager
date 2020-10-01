<?php

$title = "Tâches | ProjectName";
$cssfile = "tasks";
$jsfile = "tasksjs";
ob_start();

?>

<script type="text/javascript">
    let show_done_tasks = false
</script>

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
    <a id="logo_a" href="./index.html"><img id="logo" src="public/img/essai_logo.png"></a>
    <input type="search" autocomplete="off" id="findField" placeholder="Rechercher dans les tâches" />
    <img id="help_logo_img" src="public/img/question.png" alt="">
    <img id="account_logo_img" src="public/img/switzerland.png" />
    <img id="gear_logo_img" src="public/img/gear.png" />
    <img id="switch_logo_img" src="public/img/file_swap.png" alt="">
    <button id="project_actual">Projet en cours</button>
</div>

<!--MENU DE GAUCHE-->
<section class="section_en_dessous_menu">
    <div id="menu_gauche">
        <div id="new_task_div" class="new_task">
            <img id="new_task_img" src="public/img/plusadd.png" alt="">
            <p id="new_task_text">Nouvelle tâche</p>
        </div>
        <ul>
            <a href="./task2.html">
                <li class="selectedmenu"><img class="img_menu_gauche_js" src="public/img/listindex.png" alt="">
                    <p id="text_menu_left_1">Tâches</p>
                </li>
            </a>
            <li class="notselectedmenu"><img class="img_menu_gauche_js" src="public/img/objectiveindex.png" alt="">
                <p id="text_menu_left_2">Objectifs</p>
            </li>
            <li class="notselectedmenu"><img class="img_menu_gauche_js" src="public/img/group.png" alt="">
                <p id="text_menu_left_3">Team</p>
            </li>
            <li class="notselectedmenu"><img class="img_menu_gauche_js" src="public/img/people.png" alt="">
                <p id="text_menu_left_4">Discussion</p>
            </li>
            <li class="notselectedmenu"><img class="img_menu_gauche_js" src="public/img/network.png" alt="">
                <p id="text_menu_left_5">GitHub</p>
            </li>
        </ul>
    </div>
    <section id="copyright">
        <p>Copyright ® 2020 CodeManager. All Rights Reserved</p>
    </section>


    <!--LIGNE SELECTION TACHES-->
    <section class="ligne_et_taches">

        <div id="ligne_haut_tache_id" class="ligne_haut_tache">
            <span title="Tout sélectionner"><input name="sample" id="select_all" type="checkbox"></span>
            <span title="Rafraîchir"><img id="refresh" src="public/img/refresh.png" alt=""
                    onclick="location.reload()"></span>
            <span title="Tâches effectuées"><img class="tasks_done" id="tasks_done" src="public/img/task_done.png" alt=""></span>
            <span title="Supprimer"><img class="trash" src="public/img/trash.png" alt=""></span>

        </div>



        <section class="list_task">
            <ul id="liste_taches" class="liste_taches">

                <!--PARTI TACHES NON REALISEES-->
                <button name="task" class="myBtn" id="task1">
                    <li>
                        <span class="span_input_img" title="Sélectionner"><input class="input_img check_js to_check"
                                type="checkbox"></span>
                        <span class="span_input_img" title="Marquer comme effectuée"><img class="input_img tick"
                                src="public/img/tick.png" alt=""></span>
                        <span class="span_input_img" title="Éditer"><img class="input_img tick2"
                                src="public/img/edit_task_bar.png" alt=""></span>
                        <span class="utilisateur">Martin est un gentil vacanciers un peu flemmard mais uand meme
                            sympa
                            (c'est toujours un test de bug eheh)</span>
                        <span class="titre_tache">Ceci est un titre bien trop long pour l'écrire sur toute la
                            longueur
                            dans la liste et va surement etre coupé quand on cliqurea sur la tache en question mais
                            c'est fait expres pour faire les tests de bug comme Martin me l'avait conséillé</span>
                        <span class="desc_tache">Pour faire une bonne descrition il faut choisir les bons mots, et
                            savoir etre precis dans ce qu'on dit pour que les autres developpeurs et designer et
                            autres
                            puissent savoir concretement de quoi on veut parler. il faut que ca soit detaillé sans
                            etre
                            forcement trop long pour pas avoir la flemme de lire tout ce bazar.</span>
                        <span class="date">11/08/2020</span>
                    </li>
                </button>

                <button name="task" class="myBtn" id="task2">
                    <li>
                        <span class="span_input_img" title="Sélectionner"><input class="input_img check_js to_check"
                                type="checkbox"></span>
                        <span class="span_input_img" title="Marquer comme effectuée"><img class="input_img tick"
                                src="public/img/tick.png" alt=""></span>
                        <span class="span_input_img" title="Éditer"><img class="input_img tick2"
                                src="public/img/edit_task_bar.png" alt=""></span>
                        <span class="utilisateur">Martin est un gentil vacanciers un peu flemmard mais uand meme
                            sympa
                            (c'est toujours un test de bug eheh)</span>
                        <span class="titre_tache">Coucou, ceci est un titre bien trop long pour l'écrire sur toute
                            la
                            longueur
                            dans la liste et va surement etre coupé quand on cliqurea sur la tache en question mais
                            c'est fait expres pour faire les tests de bug comme Martin me l'avait conséillé</span>
                        <span class="desc_tache">Pour faire une bonne descrition il faut choisir les bons mots, et
                            savoir etre precis dans ce qu'on dit pour que les autres developpeurs et designer et
                            autres
                            puissent savoir concretement de quoi on veut parler. il faut que ca soit detaillé sans
                            etre
                            forcement trop long pour pas avoir la flemme de lire tout ce bazar.</span>
                        <span class="date">11/08/2020</span>
                    </li>
                </button>

                <!-- PARTIE TACHES REALISEES -->
                <button name="done_task" class="myBtn done-task" id="done_task1">
                    <li>
                        <span class="span_input_img" title="Sélectionner"><input class="input_img check_js to_check"
                                type="checkbox"></span>
                        <span class="span_input_img" title="Marquer comme effectuée"><img class="input_img tick"
                                src="public/img/tick.png" alt=""></span>
                        <span class="span_input_img" title="Éditer"><img class="input_img tick2"
                                src="public/img/edit_task_bar.png" alt=""></span>
                        <span class="utilisateur">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span>
                        <span class="titre_tache">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span>
                        <span class="desc_tache">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span>
                        <span class="date">11/08/2020</span>
                    </li>
                </button>

                <button name="done_task" class="myBtn done-task" id="done_task2">
                    <li>
                        <span class="span_input_img" title="Sélectionner"><input class="input_img check_js to_check"
                                type="checkbox"></span>
                        <span class="span_input_img" title="Marquer comme effectuée"><img class="input_img tick"
                                src="public/img/tick.png" alt=""></span>
                        <span class="span_input_img" title="Éditer"><img class="input_img tick2"
                                src="public/img/edit_task_bar.png" alt=""></span>
                        <span class="utilisateur">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span>
                        <span class="titre_tache">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span>
                        <span class="desc_tache">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span>
                        <span class="date">11/08/2020</span>
                    </li>
                </button>
            </ul>
        </section>
    </section>
</section>


<!--MODAL CONTENT-->
<!-- TACHES NON EFFECTUEES -->
<div id="task1_modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>

        <!--A MODIFIER EN FONCTION DE LA TÂCHE-->
        <section class="header_popup">
            <img id="logo_popup" src="public/img/essai_logo.png">
            <p><strong>Tâche</strong></p>
        </section>

        <section class="titre_popup">

            <strong>Ceci est un titre bien trop long pour l'écrire sur toute la longueur dans la liste et va
                surement etre coupé quand on cliqurea sur la tache en question mais c'est fait expres pour faire les
                tests de bug comme Martin me l'avait conséillé</strong>
        </section>
        <div class="line_popup"></div>
        <section class="descriptif_popup">
            Pour faire une bonne descrition il faut choisir les bons mots, et savoir etre precis dans ce qu'on dit pour que les autres developpeurs et designer et autres puissent savoir concretement de quoi on veut parler. il faut que ca soit detaillé sans etre forcement
            trop long pour pas avoir la flemme de lire tout ce bazar.
            <br><br>
            <i>Par Martin est un gentil vacanciers un peu flemmard mais uand meme sympa (c'est toujours un test de
                bug eheh) le 11/08/2020</i>
        </section>
    </div>
</div>
<div id="task2_modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>

        <!--A MODIFIER EN FONCTION DE LA TÂCHE-->
        <section class="header_popup">
            <img id="logo_popup" src="public/img/essai_logo.png">
            <p><strong>Tâche</strong></p>
        </section>

        <section class="titre_popup">

            <strong>Coucou, ceci est un titre bien trop long pour l'écrire sur toute la longueur dans la liste et va
                surement etre coupé quand on cliqurea sur la tache en question mais c'est fait expres pour faire les
                tests de bug comme Martin me l'avait conséillé</strong>
        </section>
        <div class="line_popup"></div>
        <section class="descriptif_popup">
            Pour faire une bonne descrition il faut choisir les bons mots, et savoir etre precis dans ce qu'on dit pour que les autres developpeurs et designer et autres puissent savoir concretement de quoi on veut parler. il faut que ca soit detaillé sans etre forcement
            trop long pour pas avoir la flemme de lire tout ce bazar.
            <br><br>
            <i>Par Martin est un gentil vacanciers un peu flemmard mais uand meme sympa (c'est toujours un test de
                bug eheh) le 11/08/2020</i>
        </section>
    </div>
</div>

<!-- TACHES EFFECTUEES -->
<div id="done_task1_modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>

        <!--A MODIFIER EN FONCTION DE LA TÂCHE-->
        <section class="header_popup">
            <img id="logo_popup" src="public/img/essai_logo.png">
            <p><strong>Tâche</strong></p>
        </section>

        <section class="titre_popup">

            <strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</strong>
        </section>
        <div class="line_popup"></div>
        <section class="descriptif_popup">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
            in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            <br><br>
            <i>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. le 11/08/2020</i>
        </section>
    </div>
</div>
<div id="done_task2_modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>

        <!--A MODIFIER EN FONCTION DE LA TÂCHE-->
        <section class="header_popup">
            <img id="logo_popup" src="public/img/essai_logo.png">
            <p><strong>Tâche</strong></p>
        </section>

        <section class="titre_popup">

            <strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</strong>
        </section>
        <div class="line_popup"></div>
        <section class="descriptif_popup">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
            in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            <br><br>
            <i>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. le 11/08/2020</i>
        </section>
    </div>
</div>



<!--ADD TASK MODAL-->
<div id="add_task_modal_general">
    <div id="add_task_modal">
        <section id="section_ligne_haut">
            <img id="logo_add_task" src="public/img/essai_logo.png" alt="">
            <p><strong>Ajouter une tâche</strong></p>
            <span id="close_add" class="close_add">&times;</span>
        </section>
        <section id="section_ligne_bas">
            <form method="POST" action="">
                <h1>Titre de la tâche (80 caractères maximum)</h1>
                <textarea id="textarea_title" name="task_create_title" type="text" placeholder="Titre" maxlength="80"></textarea>
                <h1>Description de la tâche</h1>
                <textarea id="textarea_desc" name="task_create_desc" type="text" placeholder="Description"></textarea>
                <h2></h2>
                <section id="button_line">
                    <button name="cancel_button_create_task" id="addtask_cancel" type="button">Annuler</button>
                    <button name="submit_button_create_task" type="submit">Valider</button>
                </section>
            </form>
        </section>
    </div>
</div>


<!--SETTINGS MODAL-->


<div id="bcc_settings">
    <div id="settings_modal">
        <div id="settings_title">
            Réglages
        </div>
        <span id="close_settings" class="close_settings">&times;</span>
        <div class="row_settings">
            <p>Mode Sombre : </p>
            <input class="apple-switch" id="dark_mode" type="checkbox">
        </div>
        <div class="row_settings">
            <p>Night Shift : </p>
            <input class="apple-switch" id="night_shift" type="checkbox">
        </div>
        <div class="row_settings_title" id="col_settings">
            <form class="form_bug_report" method="POST" action="">
                <p>Vous avez trouvé un Bug ? Faîtes le nous savoir ci dessous : </p>
                <textarea id="textarea_bug" placeholder="Message" name="bug_report_textarea" id=""></textarea>
                <button type="submit" id="bug_submission" name="bug_report_submit_button">Envoyer</button>
            </form>
            <br>
        </div>
    </div>
</div>


<!--HELP MODAL-->
<div id="help_modal">
    <span class="span_help"><img src="public/img/plusadd.png" alt="">
        <p> Ajouter une tâche</p>
    </span>
    <span class="span_help"><img src="public/img/checkbox.png" alt="">
        <p> Sélectionner / Tout sélectionner</p>
    </span>
    <span class="span_help"><img src="public/img/refresh.png" alt="">
        <p> Rafraîchir</p>
    </span>
    <span class="span_help"><img src="public/img/tick.png" alt="">
        <p>Marquer comme effectuée</p>
    </span>
    <span class="span_help"><img src="public/img/task_done.png" alt="">
        <p>Voir les tâches effectuées</p>
    </span>
    <span class="span_help"><img src="public/img/edit_task_bar.png" alt="">
        <p> Éditer la tâche</p>
    </span>
    <span class="span_help"><img src="public/img/trash.png" alt="">
        <p> Supprimer la/les tâche(s)</p>
    </span>
    <span class="span_help"><img src="public/img/gear.png" alt="">
        <p> Réglages</p>
    </span>

</div>
<!--ACCOUNT MODAL-->

<div id="account_background" class="account_background modal_to_animate">
    <div class="whitecolor" id="account_white_bc">
        <div id="bc_img_logo_account">
        </div>
        <span id="close_account_modal" class="close_account_modal">&times;</span>
        <p class="name_user_title">Loremeruirfbiufhboacfuhbccuhebofihczblaihefblcaiehfboczeifuboazeiuboiuoiuoiuoiuoaieuazeoriuazeroiauzeroizeurypozeirupoziaeurpazoieurpazoeiru</p>
        <p class="mail_user_title">tom.mullier@outlook.fr</p>
        <button class="button_my_account">Mon compte</button>
        <div class="flex_button_account">
            <button id="button_option" class="button_option">Options</button>
            <button href="#" name="deconnexion_button" class="button_deconnect">Déconnexion</button>
        </div>
    </div>
</div>



<!--SWAP PROJECT MODAL-->
<div id="project_modal_container">
    <div id="project_modal">
        <section id="header_project_modal">
            <img src="public/img/essai_logo.png" alt="">
            <p>Changer de projet</p>
            <span id="close_swap" class="close_swap">&times;</span>
        </section>
        <br><br><br><br>
        <section id="body_project_modal">
            <section id="flex_arrow">
                <p id="change_title">Changer de projet :</p>
                <section>
                    <div id="projet_princ">Changer de projet</div>
                    <p id="arrow">&#x25BC;</p>
                </section>
            </section>

            <ul id="ul_swap">
                <li class="li_swap">Projet 1</li>
                <li class="li_swap">Projet 2</li>
                <li class="li_swap">Projet 3</li>
                <li class="li_swap">Projet 4</li>
                <li class="li_swap">Projet 5</li>
                <li class="li_swap">Projet 6</li>
                <li class="li_swap">Projet 7</li>
                <li class="li_swap">Projet 8</li>
                <li class="li_swap">Projet 1</li>
                <li class="li_swap">Projet 2</li>
                <li class="li_swap">Projet 3</li>
                <li class="li_swap">Projet 4</li>
                <li class="li_swap">Projet 5</li>
                <li class="li_swap">Projet 6</li>
                <li class="li_swap">Projet 7</li>
                <li class="li_swap">Projet 8</li>
            </ul>
            <br><br>
            <div id="div_form_new_project"></div>
            <br><br>
            <form name="create_project_form" action="" method="POST">
                <h1>Nom du Projet (20 caractères max.)</h1>
                <textarea name="new_project_name" id="new_project_name" maxlength="20" placeholder="Nom du projet"></textarea>
                <h1>Description du projet (optionnel)</h1>
                <textarea name="new_project_desc" id="new_project_desc" placeholder="Description du projet"></textarea>
                <h2>Lien GitHub (optionnel)</h2>
                <textarea name="new_project_git" id="new_project_git" placeholder="Lien GitHub"></textarea>
                <button name="create_project_button" id="create_project">Créer un nouveau projet</button>
            </form>
        </section>
    </div>
</div>

<?php

$content = ob_get_clean();
require('template/template.php');
