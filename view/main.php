<?php
$title = "Tâches | NameProject";
$page = 'tasks';
$cssfile = "tasks";
$jsfile = "tasksjs";
$_SESSION['last_page'] = 'tasks';
ob_start();
?>
    <!--Select type of display -->
    <div id="select_display_global" class="select_display_global">
        <div class="selected_display div_img_select" >
            <img id="category_1" src="public/img/category_1.png" alt="">
        </div>
        <a onclick="change_display()" href="#">
            <div class="notselected_display div_img_select">
                <img id="category_2" src="public/img/category_2.png" alt="">
            </div>
        </a>
    </div>

    <!--List display (first) -->
    <section id="firstdisplay" class="ligne_et_taches" style="display:block">
        <div id="ligne_haut_tache_id" class="ligne_haut_tache">
            <span title="Tout sélectionner">
                <input name="sample" id="select_all" type="checkbox" />
            </span>
            <span title="Nouvelle tâche">
                <img class="new_task_img" src="public/img/plus.png" alt="">
            </span>
            <span title="Rafraîchir">
                <img id="refresh" src="public/img/refresh.png" alt="" onclick="location.reload()" />
            </span>
            <span title="Tâches effectuées">
                <img class="tasks_done" src="public/img/task_done0.png" alt="" />
            </span>
            <span title="Supprimer">
                <img class="trash" src="public/img/trash.png" alt="" />
            </span>
            <div class="flex_title_task">
                <table>
                    <tr>
                        <td class="user-table-cell">
                            <p>Utilisateur</p>
                        </td>
                        <td class="title-table-cell">
                            <p>Titre</p>
                        </td>
                        <td class="desc-table-cell">
                            <p>Description</p>
                        </td>
                        <td class="category-table-cell">
                            <p>Catégorie</p>
                        </td>
                        <td class="date-table-cell">
                            <p>Date de création</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <section class="list_task" unselectable="off" onselectstart="return true;">
            <ul id="liste_taches" class="liste_taches" style="opacity:0;">
            <?php if (isset($tasks)): ?>
                <!--Error messages -->
                <?php if ($nb_tasks == 0): ?>
                    <p name="task">Toutes les tâches sont terminées !</p>
                <?php elseif ($nb_done_tasks == 0): ?>
                    <p name="done_task">Il n'y a aucune tâche terminée.</p>
                <?php endif; ?>

                <!-- Tasks btn -->
                <?php foreach ($tasks as $task) { if ($task->getAuthor()): ?>
                    <button
                    name="<?= $task->getIsDone() ? 'done_' : '' ?>task"
                    class="myBtn<?= $task->getIsDone() ? ' done-task' : '' ?>"
                    id="<?= $task->getIsDone() ? 'done_' : '' ?>task<?= $task->getId() ?>"><li>
                        <span class="span_input_img" title="Sélectionner">
                            <input class="input_img check_js to_check" type="checkbox" />
                        </span>
                        <span class="span_input_img" title="Marquer comme <?= $task->getIsDone() ? 'non ' : '' ?>effectuée">
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
                        <span class="category_tache"><?= "Catégorie de la tâche (Front, back etc...)" ?></span>
                        <span class="date"><?= $task->getCreateDate() ?></span>
                    </li></button>
                <?php endif; } ?>
            <?php else: ?>
                <p>Pas de tâche pour le moment...</p>
            <?php endif; ?>
            </ul>
        </section>
    </section>

    <!-- Array display (2nd) -->
    <section id="seconddisplay" class="ligne_et_taches" style="display:none">
        <div id="ligne_haut_tache_id" class="ligne_haut_tache">
            <span title="Tout sélectionner">
                <input name="sample" id="select_all2" type="checkbox" />
            </span>
            <span title="Nouvelle tâche">
                <img class="new_task_img" src="public/img/plus.png" alt="">
            </span>
            <span title="Rafraîchir">
                <img id="refresh" src="public/img/refresh.png" alt="" onclick="location.reload()" />
            </span>
            <span title="Tâches effectuées">
                <img class="tasks_done" src="public/img/task_done0.png" alt="" />
            </span>
            <span title="Supprimer">
                <img class="trash" src="public/img/trash.png" alt="" style="display:none;" />
            </span>
        </div>
        <div class="wrapper-table-task">
            <div class="table-wrapper mozaic_all_table">
                <?php if (isset($tasks)): ?>
                <table class="table_contain">
                    <tbody>
                        <?php if ($nb_tasks == 0): ?>
                            <p name="task">Toutes les tâches sont terminées !</p>
                        <?php elseif ($nb_done_tasks == 0): ?>
                            <p name="done_task">Il n'y a aucune tâche terminée.</p>
                        <?php endif; ?>

                        <tr class="table_row_main categories">
                            <td class="table_col_main category-name">
                                <input type="checkbox" class="to-check2 category-check" id="category1" />
                                <p>
                                    <label for="category1">Catégorie n°1</label>
                                </p>
                            </td>
                        </tr>

                        <!-- Tasks in the category -->
                        <?php foreach ($tasks as $task) { if ($task->getAuthor()): ?>
                            <tr
                            class="table_row_main<?= $task->getIsDone() ? ' done-task' : '' ?>"
                            name="<?= $task->getIsDone() ? 'done_' : '' ?>task"
                            id="<?= $task->getIsDone() ? 'done_' : '' ?>task<?= $task->getId() ?>">
                                <td class="table_col_main">
                                    <div class="border_all">
                                        <div class="left-side-task-mosaic">
                                            <input type="checkbox" class="check_js to-check2 in-category1" />
                                            <a href=""><img src="public/img/edit_task_bar.png" class="tick2" alt="" /></a>
                                            <a href=""><img src="public/img/trash.png" class="trash-btn" alt="" /></a>
                                        </div>
                                        <div class="task_name_mozaic">
                                            <p><?= $task->getName() ?></p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; } ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <p>Pas de tâche pour le moment...</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</section>

<!-- All of modals -->
<div id="modals" style="display:none;">
    <?php if (isset($tasks)): ?>
        <?php foreach ($tasks as $task){ if ($task->getAuthor()): ?>
            <!-- Tasks modals -->
            <modal
            id="<?= $task->getIsDone() ? 'done_' : '' ?>task<?= $task->getId() ?>_modal"
            name="popup_modal_task">
                <span class="close close-modal">&times;</span>
                <section class="header_popup">
                    <p><strong>Tâche<?= $task->getIsDone() ? ' effectuée' : '' ?></strong></p>
                    <br><br>
                </section>
                <section class="titre_popup<?= $task->getIsDone() ? ' done-task' : '' ?>">
                    <strong><?= $task->getName() ?></strong>
                </section>
                <div class="line_popup"></div>
                <section class="descriptif_popup<?= $task->getIsDone() ? ' done-task' : '' ?>">
                    <?= $task->getDescription() ? $task->getDescription() : '<i>Pas de description</i>' ?>
                    <br><br>
                    <p><strong>Catégorie :</strong> Front etc...</p>
                    <br><br>
                    <br><br>
                    <i class="no-decoration">Par <?= $task->getAuthor() ?> le <?= $task->getCreateDate() ?></i>
                </section>
            </modal>

            <!--Tasks edit modals -->
            <modal id="<?= $task->getIsDone() ? 'done_' : '' ?>task<?= $task->getId() ?>_edit">
                <section id="section_ligne_haut_edit">
                    <br><br><br>
                    <p><strong>Modifier la tâche</strong></p>
                    <span id="close_edit" class="close_add close-modal">&times;</span>
                </section>
                <section id="section_ligne_bas_edit">
                    <form method="POST" action="index.php?action=edittask&id=<?= $task->getId() ?>">
                      <h1>Titre de la tâche (80 caractères maximum)</h1>
                      <input class="textarea_title" name="title" type="text" value="<?= $task->getName()?>" maxlength="80" required></input>
                      <h1>Catégorie de la tâche (20 caractères maximum)</h1>
                      <input class="textarea_title" name="category" type="text" value="Catégorie" maxlength="20" required></input>
                      <h1>Description de la tâche (Optionnel)</h1>
                      <input class="textarea_desc_edit" name="description" type="text" <?= $task->getDescription() ? 'value="' . $task->getDescription() . '"' : 'placeholder="Description"' ?>></input>
                      <h2></h2>
                      <section id="button_line_edit">
                          <button name="cancel_button_edit_task" class="close-modal" type="button">Annuler</button>
                          <button name="submit_button_edit_task" type="submit">Valider</button>
                      </section>
                    </form>
                </section>
            </modal>
        <?php endif; } ?>
    <?php endif; ?>

    <!--Add task modal-->
    <modal id="add_task">
        <section id="section_ligne_haut">
          <br><br><br>
            <p><strong>Ajouter une tâche</strong></p>
            <span id="close_add" class="close_add close-modal">&times;</span>
        </section>
        <section id="section_ligne_bas">
            <form method="POST" action="index.php?action=addtask">
                <h1>Titre de la tâche (80 caractères maximum)</h1>
                <input id="addtask_title" class="textarea_title" name="title" type="text" placeholder="Titre" maxlength="80" required></input>
                <h1>Catégorie de la tâche (20 caractères maximum)</h1>
                <input id="addtask_cate" class="textarea_title" name="category" type="text" placeholder="Catégorie" maxlength="20" required></input>
                <h1>Description de la tâche (Optionnel)</h1>
                <textarea id="textarea_desc" name="description" type="text" placeholder="Description"></textarea>
                <h2></h2>
                <section id="button_line">
                    <button name="cancel_button_create_task" id="addtask_cancel" class="close-modal" type="button">Annuler</button>
                    <button name="submit_button_create_task" type="submit">Valider</button>
                </section>
            </form>
        </section>
    </modal>

    <!--MODAL CONFIRM DELETE TASK-->

    <modal id="delete_task">
      <span id="close_settings" class="close-modal close_add">&times;</span>
      <h1>CONFIRMATION de suppression de tâche(s)</h1>
      <br>
      <h2>Êtes vous sûr(e) de vouloir supprimer *getnumber* tâches ?</h2>
      <br>
      <div id="flex_confirm" class="flex_confirm">
        <p id="no_delete_task" class="close-modal no_delete_task">Non je veux la/les conserver</p>

        <p id="yes_delete_task" class="yes_delete_task">Oui je veux la/les supprimer définitivement</p>
      </div>
    </modal>

    <?php require('template/modals.php'); ?>

</div>

<?php
$content = ob_get_clean();
require('template/template.php');
