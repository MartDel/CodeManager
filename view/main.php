<?php

$title = "Tâches | ProjectName";
$cssfile = "tasks";
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
        <img id="switch_logo_img" src="public/img/file_swap.png" alt="">
        <p id="project_actual">
            <?= $project->getName() ?>
        </p>
        <!-- <p id="project_actual">Projet en cours</p> -->
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
                <span title="Tâches effectuées"><img class="tasks_done" src="public/img/task_done.png" alt=""></span>
                <span title="Supprimer"><img class="trash" src="public/img/trash.png" alt=""></span>

            </div>



            <!--PARTI TACHES NON REALISEES-->
            <section class="list_task">
                <ul id="liste_taches" class="liste_taches">

                <?php
                if($tasks){
                    $i = 0;
                    foreach ($tasks as $task) {
                        if (!$task->getIsDone()) {
                    ?>
                    <button name="task" class="myBtn" id="task<?= $i ?>">
                        <li>
                            <span class="span_input_img" title="Sélectionner"><input class="input_img check_js to_check"
                                    type="checkbox"></span>
                            <span class="span_input_img" title="Marquer comme effectuée"><img class="input_img tick"
                                    src="public/img/tick.png" alt=""></span>
                            <span class="span_input_img" title="Éditer"><img class="input_img tick2"
                                    src="public/img/edit_task_bar.png" alt=""></span>
                            <span class="utilisateur"><?= $task->getAuthor() ?></span>
                            <span class="titre_tache"><?= $task->getName() ?></span>
                            <span class="desc_tache"><?= $task->getDescription() ? $task->getDescription() : '<i>Aucune description</i>' ?></span>
                            <span class="date"><?= $task->getCreateDate() ?></span>
                        </li>
                    </button>
                    <?php
                            $i++;
                        }
                    }
                }
                ?>

                </ul>
            </section>
        </section>
    </section>


    <!--MODAL CONTENT-->
<?php
if($tasks){
    $i = 0;
    foreach ($tasks as $task) {
    ?>
    <div id="task<?= $i ?>_modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>

            <!--A MODIFIER EN FONCTION DE LA TÂCHE-->
            <section class="header_popup">
                <img id="logo_popup" src="public/img/essai_logo.png">
                <p><strong>Tâche</strong></p>
            </section>

            <section class="titre_popup">
                <strong><?= $task->getName() ?></strong>
            </section>
            <div class="line_popup"></div>
            <section class="descriptif_popup">
                <?= $task->getDescription() ? $task->getDescription() : '<i>Aucune description</i>' ?>
                <br><br>
                <i><?= $task->getAuthor() ?> le <?= $task->getCreateDate() ?></i>
            </section>
        </div>
    </div>
    <?php
        $i++;
    }
}
?>

    <!--ADD TASK MODAL-->
    <div id="add_task_modal_general">
        <div id="add_task_modal">
            <section id="section_ligne_haut">
                <img id="logo_add_task" src="public/img/essai_logo.png" alt="">
                <p><strong>Ajouter une tâche</strong></p>
                <span id="close_add" class="close_add">&times;</span>
            </section>
            <section id="section_ligne_bas">
                <form action="index.php?action=addtask" method="post">
                    <h1>Titre de la tâche (80 caractères maximum)</h1>
                    <textarea id="textarea_title" name="title" type="text" placeholder="Titre" maxlength="80" required></textarea>
                    <h1>Description de la tâche</h1>
                    <textarea id="textarea_desc" name="description" type="text" placeholder="Description"></textarea>
                    <h2></h2>
                    <section id="button_line">
                        <button name="cancel_button" id="addtask_cancel" type="button">Annuler</button>
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
            <span id="close_settings" class="close_settings">&times;</span>
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

    <div id="account_modal">
        <p id="account_title">Mon Compte</p>
        <section id="account_section">
            <img id="user_img" src="public/img/switzerland.png" alt="">
            <p id="user"><?= $_SESSION['pseudo'] ?></p>
        </section>
        <section id="body_account">
            <p id="name_user"><?= $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] ?></p>
            <p id="mail_user"><?= $_SESSION['mail'] ?></p>
                <section id="section_button">
                    <button id="account_button">Mon compte</button>
                    <a href="index.php?action=logout" id="deconnect_button">Déconnexion</a>
                </section>
        </section>
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
                    <?php foreach ($project_list as $p) { ?>
                    <li class="li_swap" <?php if($p['description']) echo 'title="' . $p['description'] . '"'; ?>>
                        <!-- <?= $p['name'] ?> -->
                        <a href="index.php?project=<?= $p['id'] ?>"><?= $p['name'] ?></a>
                    </li>
                    <!-- ID = $p['id'] -->
                    <?php } ?>
                </ul>
                <br><br>
                <div id="div_form_new_project"></div>
                <br><br>
                <h1>Nom du Projet (20 caractères max.)</h1>
                <textarea name="" id="new_project_name" maxlength="20" placeholder="Nom du projet"></textarea>
                <h1>Description du projet (optionnel)</h1>
                <textarea name="" id="new_project_desc" placeholder="Description du projet"></textarea>
                <h2>Lien GitHub (optionnel)</h2>
                <textarea name="" id="new_project_git" placeholder="Lien GitHub"></textarea>
                <button id="create_project">Créer un nouveau projet</button>

            </section>
        </div>
    </div>
</body>

<?php

$content = ob_get_clean();
require('template/template.php');
