<?php

$title = "Tâches | CodeManager";
$cssfile = "task";
$jsfile = "tasksjs";
ob_start();

?>

<body id="body">

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
        <input type="text" placeholder="Rechercher dans les tâches" />
        <img id="help_logo_img" src="public/img/question.png" alt="">
        <img id="account_logo_img" src="public/img/switzerland.png" />
        <img id="gear_logo_img" src="public/img/gear.png" />
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
                <span title="Tout sélectionner"><input name="sample" onclick="all()" id="selectall"
                        type="checkbox"></span>
                <span title="Rafraîchir"><img id="refresh" src="public/img/refresh.png" alt="" onclick="refresh()">
                    <span title="Tâches effectuées"><img class="tasks_done" src="public/img/tick.png" alt=""></span>

            </div>



            <!--PARTI TACHES NON REALISEES-->
            <section class="list_task">
                <ul id="liste_taches" class="liste_taches">

                    <button name="myBtn" class="myBtn" id="myBtn">
                        <li>
                            <span class="span_input_img" title="Sélectionner"><input id="check_js" class="input_img"
                                    type="checkbox"></span>
                            <span class="span_input_img" title="Marquer comme effectuée"><img class="input_img"
                                    id="tick" src="public/img/tick.png" alt=""></span>
                            <span class="span_input_img" title="Éditer"><img class="input_img" id="tick2"
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
                    <button name="myBtn" class="myBtn" id="myBtn">
                        <li>
                            <span class="span_input_img" title="Sélectionner"><input id="check_js" class="input_img"
                                    type="checkbox"></span>
                            <span class="span_input_img" title="Marquer comme effectuée"><img class="input_img"
                                    id="tick" src="public/img/tick.png" alt=""></span>
                            <span class="span_input_img" title="Éditer"><img class="input_img" id="tick2"
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


                </ul>
            </section>
        </section>
    </section>


    <!--MODAL CONTENT-->
    <div id="myModal" class="modal">
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
                Pour faire une bonne descrition il faut choisir les bons mots, et savoir etre precis dans ce qu'on dit
                pour que les autres developpeurs et designer et autres puissent savoir concretement de quoi on veut
                parler. il faut que ca soit detaillé sans etre forcement trop long pour pas avoir la flemme de lire tout
                ce bazar.
                <br><br>
                <i>Par Martin est un gentil vacanciers un peu flemmard mais uand meme sympa (c'est toujours un test de
                    bug eheh) le 11/08/2020</i>
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
                <form>
                    <h1>Titre de la tâche (80 caractères maximum)</h1>
                    <textarea id="textarea_title" name="textarea_title" type="text" placeholder="Titre"
                        maxlength="80"></textarea>
                    <h1>Description de la tâche</h1>
                    <textarea id="textarea_desc" name="textarea_desc" type="text" placeholder="Description"></textarea>
                    <h2>Par Utilisateur le 18/08/2020</h2>
                    <section id="button_line">
                        <button name="cancel_button" onclick="clear_content_add();" type="button">Annuler</button>
                        <button name="submit_button" type="submit">Valider</button>
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
            <span id="close_settings" onclick="clear_content_bug();" class="close_settings">&times;</span>
            <div class="row_settings">
                <p>Mode Sombre : </p>
                <input class="apple-switch" id="dark_mode" type="checkbox">
            </div>
            <div class="row_settings">
                <p>Night Shift : </p>
                <input class="apple-switch" id="night_shift" type="checkbox">
            </div>
            <div class="row_settings" id="col_settings">
                <p>Vous avez trouvé un Bug ? Faîtes le nous savoir ci dessous : </p>
                <textarea id="textarea_bug" placeholder="Message" name="" id=""></textarea>
                <button type="submit" id="bug_submission">Envoyer</button>
                <br>
            </div>
        </div>
    </div>


    <!--HELP MODAL-->
    <div id="help_modal">
        <h1>AIDE</h1>
        <span id="close_help" class="close_help">&times;</span>
        <span class="span_help"><img src="public/img/plusadd.png" alt="">
            <p> Ajouter une tâche</p>
        </span>
        <span class="span_help"><img src="public/img/checkbox.png" alt="">
            <p> Tout sélectionner</p>
        </span>
        <span class="span_help"><img src="public/img/refresh.png" alt="">
            <p> Rafraîchir</p>
        </span>
        <span class="span_help"><img src="public/img/tick.png" alt="">
            <p> Voir les tâches effectuées / Marquer comme effectuée</p>
        </span>
        <span class="span_help"><img src="public/img/edit_task_bar.png" alt="">
            <p> Éditer la tâche</p>
        </span>
        <span class="span_help"><img src="public/img/gear.png" alt="">
            <p> Réglages</p>
        </span>

    </div>


    <!--ACCOUNT MODAL-->

    <div id="account_modal">
        <p id="account_title">Mon Compte</p>
        <section id="account_section">
            <img id="user_img" src="public/img/switzerland.png" alt="">
            <p id="user">Utilisateur</p>
        </section>
        <section id="body_account">
            <p id="name_user">Tom Mullier</p>
            <p id="mail_user">tom.mullier@outlook.fr</>
                <section id="section_button">
                    <button id="account_button">Mon compte</button>
                    <button id="deconnect_button">Déconnexion</button>
                </section>
        </section>
    </div>

</body>

<?php

$content = ob_get_clean();
require('template/template.php');

?>
