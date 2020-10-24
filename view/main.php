<?php
$title = "Tâches | NameProject";
$cssfile = "tasks";
$jsfile = "tasksjs";
ob_start();
?>

    <!--LIGNE SELECTION TACHES-->
    <section class="ligne_et_taches">
        <div id="ligne_haut_tache_id" class="ligne_haut_tache">
            <span title="Tout sélectionner">
                <input name="sample" id="select_all" type="checkbox" />
            </span>
            <span title="Nouvelle tâche">
                <img id="new_task_img" src="public/img/plus.png" alt="">
            </span>
            <span title="Rafraîchir">
                <img id="refresh" src="public/img/refresh.png" alt="" onclick="location.reload()" />
            </span>
            <span title="Tâches effectuées">
                <img class="tasks_done" id="tasks_done" src="public/img/task_done0.png" alt="" />
            </span>
            <span title="Supprimer">
                <img class="trash" src="public/img/trash.png" alt="" />
            </span>
        </div>

        <section class="list_task">
            <ul id="liste_taches" class="liste_taches">
            <?php if (isset($tasks)) { ?>
                <!--TACHES NON REALISEES-->
                <?php foreach ($tasks as $task) { if (!$task->getIsDone()) { ?>
                    <button name="task" class="myBtn" id="task<?= $task->getId() ?>">
                        <li>
                            <span class="span_input_img" title="Sélectionner">
                                <input class="input_img check_js to_check" type="checkbox" />
                            </span>
                            <span class="span_input_img" title="Marquer comme effectuée">
                                <a href="index.php?action=endtask&id=<?= $task->getId() ?>">
                                    <img class="input_img tick" src="public/img/tick.png" alt="" />
                                </a>
                            </span>
                            <span class="span_input_img" title="Éditer">
                                <img class="input_img tick2" src="public/img/edit_task_bar.png" alt="" />
                            </span>
                            <span class="utilisateur"><?= $task->getAuthor() ?></span>
                            <span class="titre_tache"><?= $task->getName() ?></span>
                            <span class="desc_tache"><?= $task->getDescription() ? $task->getDescription() : '<i>Pas de description</i>' ?></span>
                            <span class="date"><?= $task->getCreateDate() ?></span>
                        </li>
                    </button>
                <?php }} ?>

                <!-- TACHES REALISEES -->
                <?php foreach ($tasks as $task) { if ($task->getIsDone()) { ?>
                    <button name="done_task" class="myBtn done-task" id="done_task<?= $task->getId() ?>">
                        <li>
                            <span class="span_input_img" title="Sélectionner">
                                <input class="input_img check_js to_check" type="checkbox" />
                            </span>
                            <span class="span_input_img" title="Marquer comme effectuée">
                                <a href="index.php?action=endtask&id=<?= $task->getId() ?>">
                                    <img class="input_img tick" src="public/img/tick.png" alt="" />
                                </a>
                            </span>
                            <span class="span_input_img" title="Éditer">
                                <img class="input_img tick2" src="public/img/edit_task_bar.png" alt="" />
                            </span>
                            <span class="utilisateur"><?= $task->getAuthor() ?></span>
                            <span class="titre_tache"><?= $task->getName() ?></span>
                            <span class="desc_tache"><?= $task->getDescription() ? $task->getDescription() : '<i>Pas de description</i>' ?></span>
                            <span class="date"><?= $task->getCreateDate() ?></span>
                        </li>
                    </button>
                <?php }} ?>
            <?php } else { ?>
                <p>
                    <i>Pas de tâche pour le moment...</i>
                </p>
            <?php } ?>
            </ul>
        </section>
    </section>
</section>

<!--HELP MODAL-->
<div id="help_modal">
    <span class="span_help">
        <img src="public/img/plusadd.png" alt="" />
        <p> Ajouter une tâche</p>
    </span>
    <span class="span_help">
        <img src="public/img/checkbox.png" alt="" />
        <p> Sélectionner / Tout sélectionner</p>
    </span>
    <span class="span_help">
        <img src="public/img/refresh.png" alt="" />
        <p> Rafraîchir</p>
    </span>
    <span class="span_help">
        <img src="public/img/tick.png" alt="" />
        <p>Marquer comme effectuée</p>
    </span>
    <span class="span_help">
        <img src="public/img/task_done.png" alt="" />
        <p>Voir les tâches effectuées</p>
    </span>
    <span class="span_help">
        <img src="public/img/edit_task_bar.png" alt="" />
        <p> Éditer la tâche</p>
    </span>
    <span class="span_help">
        <img src="public/img/trash.png" alt="" />
        <p> Supprimer la/les tâche(s)</p>
    </span>
    <span class="span_help">
        <img src="public/img/gear.png" alt="" />
        <p> Réglages</p>
    </span>
</div>

<!-- All of modals -->
<div id="modals" style="display:none;">
    <!--MODAL CONTENT-->
    <?php if (isset($tasks)) { ?>
        <!-- TASKS NOT FINISHED -->
        <?php foreach ($tasks as $task) { if (!$task->getIsDone()) { ?>
        <modal id="task<?= $task->getId() ?>_modal">
            <span class="close">&times;</span>
            <section class="header_popup">
                <img id="logo_popup" src="public/img/essai_logo.png" />
                <p><strong>Tâche</strong></p>
            </section>
            <section class="titre_popup">
                <strong><?= $task->getName() ?></strong>
            </section>
            <div class="line_popup"></div>
            <section class="descriptif_popup">
                <?= $task->getDescription() ? $task->getDescription() : '<i>Pas de description</i>' ?>
                <br><br>
                <i><?= $task->getAuthor() ?> le <?= $task->getCreateDate() ?></i>
            </section>
        </modal>
        <?php }} ?>

        <!-- TASKS DONE -->
        <?php foreach ($tasks as $task) { if ($task->getIsDone()) { ?>
        <modal id="done_task<?= $task->getId() ?>_modal">
            <span class="close">&times;</span>
            <section class="header_popup">
                <img id="logo_popup" src="public/img/essai_logo.png" />
                <p><strong>Tâche</strong></p>
            </section>
            <section class="titre_popup">
                <strong><?= $task->getName() ?></strong>
            </section>
            <div class="line_popup"></div>
            <section class="descriptif_popup">
                <?= $task->getDescription() ? $task->getDescription() : '<i>Pas de description</i>' ?>
                <br><br>
                <i><?= $task->getAuthor() ?> le <?= $task->getCreateDate() ?></i>
            </section>
        </modal>
        <?php }} ?>
    <?php } ?>

    <!--ADD TASK MODAL-->
    <modal id="add_task">
        <section id="section_ligne_haut">
            <img id="logo_add_task" src="public/img/essai_logo.png" alt="" />
            <p><strong>Ajouter une tâche</strong></p>
            <span id="close_add" class="close_add close-modal">&times;</span>
        </section>
        <section id="section_ligne_bas">
            <form method="POST" action="index.php?action=addtask">
                <h1>Titre de la tâche (80 caractères maximum)</h1>
                <textarea class="textarea_title" name="title" type="text" placeholder="Titre" maxlength="80" required></textarea>
                <h1>Description de la tâche</h1>
                <textarea id="textarea_desc" name="description" type="text" placeholder="Description"></textarea>
                <h2></h2>
                <section id="button_line">
                    <button name="cancel_button_create_task" id="addtask_cancel" class="close-modal" type="button">Annuler</button>
                    <button name="submit_button_create_task" type="submit">Valider</button>
                </section>
            </form>
        </section>
    </modal>

    <!--SETTINGS MODAL-->
    <modal id="settings">
        <div id="settings_title">Réglages</div>
        <span id="close_settings" class="close-modal close_settings">&times;</span>
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
    </modal>

    <!--ACCOUNT MODAL-->
    <modal id="account">
        <div id="bc_img_logo_account"></div>
        <span id="close_account_modal" class="close-modal close_account_modal">&times;</span>
        <p class="name_user_title"><?= $_SESSION['pseudo'] ?></p>
        <p class="mail_user_title"><?= $_SESSION['mail'] ?></p>
        <a class="button_my_account">Mon compte</a>
        <div class="flex_button_account">
            <a id="button_option" class="close-modal button_option">Options</a>
            <a href="index.php?action=logout" name="deconnexion_button" class="button_deconnect">Déconnexion</a>
        </div>
    </modal>

    <!--SWAP PROJECT MODAL-->
    <modal id="project">
        <section id="header_project_modal">
            <img src="public/img/essai_logo.png" alt="" />
            <p>Changer de projet</p>
            <span id="close_swap" class="close_swap">&times;</span>
        </section>
        <br><br><br><br>
        <section id="body_project_modal">
            <section id="flex_arrow">
                <p id="change_title">Changer de projet :</p>
                <section>
                    <div id="projet_princ"><?= $project->getName() ?></div>
                    <p id="arrow">&#x25BC;</p>
                </section>
            </section>
            <ul id="ul_swap">
            <?php foreach ($project_list as $current_project) { ?>
                <a href="index.php?project=<?= $current_project['id'] ?>">
                  <li class="li_swap">
                    <div class="link_swap_project_div">
                      <?= $current_project['name'] ?>
                    </div>
                  </li>
                </a>
            <?php } ?>
            </ul>
            <br><br>
            <div id="div_form_new_project"></div>
            <div class="info_current_project">
              <br>
              <h1>Nom du Projet : <?= $project->getName() ?></h1>
              <br>
              <h1>Description du Projet : <?= $project->getDescription() ?></h1>
              <br>
            </div>
            <div id="div_form_new_project"></div>
            <br><br>
            <form name="create_project_form" action="index.php?action=createproject" method="POST">
                <h1>Nom du Projet (20 caractères max.)</h1>
                <textarea name="name" id="new_project_name" maxlength="20" placeholder="Nom du projet" required></textarea>
                <h1>Description du projet (optionnel)</h1>
                <textarea name="description" id="new_project_desc" placeholder="Description du projet"></textarea>
                <h2>GitHub (optionnel)</h2>
                <div class="flex_git_links">
                  <textarea name="github_pseudo" id="new_project_git_name" placeholder="Pseudo GitHub"></textarea>
                  <textarea name="remote" id="new_project_git_repo" placeholder="Nom du projet GitHub"></textarea>
                </div>
                <button name="create_project_button" id="create_project" type="submit">Créer un nouveau projet</button>
            </form>
        </section>
    </modal>
</div>

<!--ADD TASK MODAL-->
<!-- <div id="add_task_modal_general">
    <div id="add_task_modal">

    </div>
</div> -->

<!--SETTINGS MODAL-->
<!-- <div id="bcc_settings">
    <div id="settings_modal">

    </div>
</div> -->

<!--ACCOUNT MODAL-->
<!-- <div id="account_background" class="account_background modal_to_animate">
    <div class="whitecolor" id="account_white_bc">

    </div>
</div> -->

<!--SWAP PROJECT MODAL-->
<!-- <div id="project_modal_container">
    <div id="project_modal">

    </div>
</div> -->

<?php
$content = ob_get_clean();
require('template/template.php');
