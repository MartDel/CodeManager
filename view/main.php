<?php
$title = "Tâches | NameProject";
$page = 'tasks';
$cssfile = "tasks";
$jsfile = "tasksjs";
$_SESSION['last_page'] = 'tasks';
ob_start();
?>


    <!--SELECT TYPE OF DISPLAY-->

    <div id="select_display_global" class="select_display_global">
      <div class="selected_display div_img_select">
        <img id="category_1" src="public/img/category_1.png" alt="">
      </div>
      <a onclick="change_display()" href="#">
        <div class="notselected_display div_img_select">
          <img id="category_2" src="public/img/category_2.png" alt="">
        </div>
      </a>
    </div>


    <!--LIGNE SELECTION TACHES-->
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
                <img class="tasks_done" id="tasks_done" src="public/img/task_done0.png" alt="" />
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
                <!--TACHES NON REALISEES-->
                <?php if ($nb_tasks == 0): ?>
                    <p name="task">Toutes les tâches sont terminées !</p>
                <?php endif; ?>
                <?php foreach ($tasks as $task) { if (!$task->getIsDone() && $task->getAuthor()): ?>
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
                            <span class="category_tache"><?= "Catégorie de la tâche (Front, back etc...)" ?></span>
                            <span class="date"><?= $task->getCreateDate() ?></span>
                        </li>
                    </button>
                <?php endif; } ?>

                <!-- TASKS DONE -->
                <?php if ($nb_done_tasks == 0): ?>
                    <p name="done_task">Il n'y a aucune tâche terminée.</p>
                <?php endif; ?>
                <?php foreach ($tasks as $task) { if ($task->getIsDone() && $task->getAuthor()): ?>
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
                            <span class="span_input_img">
                                <img class="input_img tick2" src="public/img/edit_task_bar.png" alt="" />
                            </span>
                            <span class="utilisateur"><?= $task->getAuthor() ?></span>
                            <span class="titre_tache"><?= $task->getName() ?></span>
                            <span class="desc_tache"><?= $task->getDescription() ? $task->getDescription() : '<i>Pas de description</i>' ?></span>
                            <span class="date"><?= $task->getCreateDate() ?></span>
                        </li>
                    </button>
                <?php endif; } ?>
            <?php else: ?>
                <p>Pas de tâche pour le moment...</p>
            <?php endif; ?>
            </ul>
        </section>
    </section>
    <section id="seconddisplay" class="ligne_et_taches" style="display:none">
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
              <img class="tasks_done" id="tasks_done" src="public/img/task_done0.png" alt="" />
          </span>
          <span title="Supprimer">
              <img class="trash" src="public/img/trash.png" alt="" />
          </span>
      </div>
      <div class="wrapper-table-task">
        <div class="table-wrapper">
          <table class="table_contain">
            <tbody>
              <tr class="table_row_main">
                <td class="table_col_main" id="category_name">
                  <input type="checkbox" name="" value="">
                  <p>Catégorie n°1</p>
                </td>
              </tr>
              <tr class="table_row_main">
                <td class="table_col_main">
                  <div class="border_all">
                    <div class="left-side-task-mosaic">
                      <input type="checkbox" name="" value="">
                      <img src="public/img/edit_task_bar.png" alt="">
                      <img src="public/img/trash.png" alt="">
                    </div>
                    <div class="">
                      <p>Tache n°1scsdcsdc sdcsdcsd  sdcsdddddddd ddddddddd dddddddd</p>
                    </div>
                  </div>
                </td>
              </tr>
              <tr class="table_row_main">
                <td class="table_col_main">
                  <div class="border_all">
                    <div class="left-side-task-mosaic">
                      <input type="checkbox" name="" value="">
                      <img src="public/img/edit_task_bar.png" alt="">
                      <img src="public/img/trash.png" alt="">
                    </div>
                    <div class="">
                      <p>Tache n°1scsdcsdc sdcsdcsd  sdcsdddddddd ddddddddd dddddddd</p>
                    </div>
                  </div>
                </td>
              </tr>
              <tr class="table_row_main">
                <td class="table_col_main">
                  <div class="border_all">
                    <div class="left-side-task-mosaic">
                      <input type="checkbox" name="" value="">
                      <img src="public/img/edit_task_bar.png" alt="">
                      <img src="public/img/trash.png" alt="">
                    </div>
                    <div class="">
                      <p>Tache n°1scsdcsdc sdcsdcsd  sdcsdddddddd ddddddddd dddddddd</p>
                    </div>
                  </div>
                </td>
              </tr>

              <tr class="table_row_main">
                <td class="table_col_main">
                  <div class="border_all task_done_mosaic">
                    <div class="">
                      <input type="checkbox" name="" value="">
                    </div>
                    <div class="">
                      <p>Tache n°1scsdcsdc sdcsdcsd sdcsdddddddd ddddddddd dddddddd</p>
                    </div>
                  </div>
                </td>
              </tr>

            </tbody>
          </table>
          <table class="table_contain">
            <tbody>
              <tr class="table_row_main">
                <td class="table_col_main" id="category_name">
                  <input type="checkbox" name="" value="">
                  <p>Catégorie n°1</p>
                </td>
              </tr>
              <tr class="table_row_main">
                <td class="table_col_main">
                  <div class="border_all">
                    <div class="left-side-task-mosaic">
                      <input type="checkbox" name="" value="">
                      <img src="public/img/edit_task_bar.png" alt="">
                      <img src="public/img/trash.png" alt="">
                    </div>
                    <div class="">
                      <p>Tache n°1scsdcsdc sdcsdcsd  sdcsdddddddd ddddddddd dddddddd</p>
                    </div>
                  </div>
                </td>
              </tr>
              <tr class="table_row_main">
                <td class="table_col_main">
                  <div class="border_all">
                    <div class="left-side-task-mosaic">
                      <input type="checkbox" name="" value="">
                      <img src="public/img/edit_task_bar.png" alt="">
                      <img src="public/img/trash.png" alt="">
                    </div>
                    <div class="">
                      <p>Tache n°1scsdcsdc sdcsdcsd  sdcsdddddddd ddddddddd dddddddd</p>
                    </div>
                  </div>
                </td>
              </tr>
              <tr class="table_row_main">
                <td class="table_col_main">
                  <div class="border_all">
                    <div class="left-side-task-mosaic">
                      <input type="checkbox" name="" value="">
                      <img src="public/img/edit_task_bar.png" alt="">
                      <img src="public/img/trash.png" alt="">
                    </div>
                    <div class="">
                      <p>Tache n°1scsdcsdc sdcsdcsd  sdcsdddddddd ddddddddd dddddddd</p>
                    </div>
                  </div>
                </td>
              </tr>

            </tbody>
          </table>
        </div>

      </div>
    </section>

  </section>


<!-- All of modals -->
<div id="modals" style="display:none;">
    <!--MODAL CONTENT-->
    <?php if (isset($tasks)): ?>
        <!-- TASKS NOT FINISHED -->
        <?php foreach ($tasks as $task){ if (!$task->getIsDone() && $task->getAuthor()): ?>
        <modal id="task<?= $task->getId() ?>_modal" name="popup_modal_task">
            <span class="close close-modal">&times;</span>
            <section class="header_popup">
                <p><strong>Tâche</strong></p>
                <br><br>
            </section>
            <section class="titre_popup">
                <strong><?= $task->getName() ?></strong>
            </section>
            <div class="line_popup"></div>
            <section class="descriptif_popup">
                <?= $task->getDescription() ? $task->getDescription() : '<i>Pas de description</i>' ?>
                <br><br>
                <p><strong>Catégorie :</strong> Front etc...</p>
                <br><br>
                <br><br>
                <i>Par <?= $task->getAuthor() ?> le <?= $task->getCreateDate() ?></i>
            </section>
        </modal>
        <!--MODAL EDIT TASK-->
        <modal id="task<?= $task->getId() ?>_edit">
          <section id="section_ligne_haut_edit">
            <br><br><br>
              <p><strong>Modifier la tâche</strong></p>
              <span id="close_edit" class="close_add close-modal">&times;</span>
          </section>
          <section id="section_ligne_bas_edit">
              <form method="POST" action="index.php?action=addtask">
                  <h1>Titre de la tâche (80 caractères maximum)</h1>
                  <input class="textarea_title" name="title" type="text" placeholder="<?= $task->getName()?>" maxlength="80" required></input>
                  <h1>Catégorie de la tâche (20 caractères maximum)</h1>
                  <input class="textarea_title" name="category" type="text" placeholder="Catégorie" maxlength="20" required></input>
                  <h1>Description de la tâche (Optionnel)</h1>
                  <input class="textarea_desc_edit" name="description" type="text" placeholder="<?= $task->getDescription() ?>"></input>
                  <h2></h2>
                  <section id="button_line_edit">
                      <button name="cancel_button_edit_task" class="close-modal" type="button">Annuler</button>
                      <button name="submit_button_edit_task" type="submit">Valider</button>
                  </section>
              </form>
          </section>
        </modal>
        <?php endif; } ?>

        <!-- TASKS DONE -->
        <?php foreach ($tasks as $task) { if ($task->getIsDone() && $task->getAuthor()): ?>
        <modal id="done_task<?= $task->getId() ?>_modal" name="popup_modal_task">
            <span class="close close-modal">&times;</span>
            <section class="header_popup">
                <p><strong>Tâche Effectuée</strong></p>
                <br><br>
            </section>
            <section class="titre_popup">
                <strong><?= $task->getName() ?></strong>
            </section>
            <div class="line_popup"></div>
            <section class="descriptif_popup">
                <?= $task->getDescription() ? $task->getDescription() : '<i>Pas de description</i>' ?>
                <br><br>
                <p><strong>Catégorie :</strong> Front etc...</p>
                <br><br>
                <br><br>
                <i><?= $task->getAuthor() ?> le <?= $task->getCreateDate() ?></i>
            </section>
        </modal>
        <!--MODAL EDIT TASK-->
        <modal id="task<?= $task->getId() ?>_edit">
          <section id="section_ligne_haut_edit">
            <br><br><br>
              <p><strong>Modifier la tâche</strong></p>
              <span id="close_edit" class="close_add close-modal">&times;</span>
          </section>
          <section id="section_ligne_bas_edit">
              <form method="POST" action="index.php?action=addtask">
                  <h1>Titre de la tâche (80 caractères maximum)</h1>
                  <input class="textarea_title" name="title" type="text" placeholder="<?= $task->getName()?>" maxlength="80" required></input>
                  <h1>Catégorie de la tâche (20 caractères maximum)</h1>
                  <input class="textarea_title" name="category" type="text" placeholder="Catégorie" maxlength="20" required></input>
                  <h1>Description de la tâche (Optionnel)</h1>
                  <input class="textarea_desc_edit" name="description" type="text" placeholder="<?= $task->getDescription()?>"></input>
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

    <!--ADD TASK MODAL-->
    <modal id="add_task">
        <section id="section_ligne_haut">
          <br><br><br>
            <p><strong>Ajouter une tâche</strong></p>
            <span id="close_add" class="close_add close-modal">&times;</span>
        </section>
        <section id="section_ligne_bas">
            <form method="POST" action="index.php?action=addtask">
                <h1>Titre de la tâche (80 caractères maximum)</h1>
                <input class="textarea_title" name="title" type="text" placeholder="Titre" maxlength="80" required></input>
                <h1>Catégorie de la tâche (20 caractères maximum)</h1>
                <input class="textarea_title" name="category" type="text" placeholder="Catégorie" maxlength="20" required></input>
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

    <?php require('template/modals.php'); ?>

</div>

<?php
$content = ob_get_clean();
require('template/template.php');
