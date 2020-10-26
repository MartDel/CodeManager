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
        <modal id="task<?= $task->getId() ?>_modal" name="popup_modal_task">
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
        <modal id="done_task<?= $task->getId() ?>_modal" name="popup_modal_task">
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

    <?php require('template/modals.php'); ?>

</div>

<?php
$content = ob_get_clean();
require('template/template.php');
