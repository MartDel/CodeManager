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
        <a onclick="setDisplay()" href="#">
            <div class="notselected_display div_img_select">
                <img id="category_2" src="public/img/category_2.png" alt="">
            </div>
        </a>
    </div>

    <!--List display (first) -->
    <div id="firstdisplay" class="ligne_et_taches" style="display:block">
      <div class="ligne_haut_tache ligne_haut_tache_id">
        <span title="Tout sélectionner">
          <input name="sample" id="select_all" type="checkbox" />
        </span>
        <span title="Nouvelle tâche">
          <img class="brightnessmax new_task_img" src="public/img/plus.png" alt="">
        </span>
        <span title="Rafraîchir">
          <img class="brightnessmax refresh" src="public/img/refresh.png" alt="" onclick="location.reload()" />
        </span>
        <span title="Tâches effectuées">
          <img class="tasks_done" src="public/img/task_done0.png" alt="" @click="switchDoneTask" />
        </span>
        <span title="Supprimer">
          <img class="brightnessmax trash" src="public/img/trash.png" alt="" />
        </span>
        <div class="flex_title_task">
          <table>
            <tr>
              <td class="user_title user-table-cell">
                <p class="menu_haut_table_cels_p">Utilisateur</p>
              </td>
              <td class="title-table-cell">
                <p class="menu_haut_table_cels_p">Titre</p>
              </td>
              <td class="desc_title desc-table-cell">
                <p class="menu_haut_table_cels_p">Description</p>
              </td>
              <td class="cate_title category-table-cell">
                <p class="menu_haut_table_cels_p">Catégorie</p>
              </td>
              <td class="date-table-cell">
                <p class="date_title menu_haut_table_cels_p">Date de création</p>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class="list_task">
        <?php if (isset($tasks)): ?>
        <!--Error messages -->
        <?php if ($nb_tasks == 0): ?>
            <p id="message-task-none" v-show="!done_task">Toutes les tâches sont terminées !</p>
        <?php elseif ($nb_done_tasks == 0): ?>
            <p id="message-task-none" v-show="done_task">Il n'y a aucune tâche terminée.</p>
        <?php endif; ?>
        <ul id="liste_taches" class="liste_taches" style="opacity:0;">
            <!-- Tasks btn -->
            <?php foreach ($tasks as $task) : ?>
                <?php if ($task->getAuthor()): ?>
                <li>
                  <div
                  class="trytochangethat myBtn<?= $task->getIsDone() ? ' done-task' : '' ?> <?= $task->getIsDone() ? 'done_' : '' ?>task<?= $task->getId() ?>"
                  v-show="<?= $task->getIsDone() ? '' : '!' ?>done_task">
                    <span class="span_input_img" title="Sélectionner">
                      <input class="input_img check_js to_check" type="checkbox" />
                    </span>
                    <span class="span_input_img" title="Marquer comme <?= $task->getIsDone() ? 'non ' : '' ?>effectuée">
                      <a href="index.php?action=endTask&id=<?= $task->getId() ?>">
                        <img class=" invertcent input_img tick" src="public/img/tick.png" alt="" />
                      </a>
                    </span>
                    <span class="span_input_img" title="Éditer">
                      <img class="invertcent input_img tick2" src="public/img/edit_task_bar.png" alt="" />
                    </span>
                    <div class="container-list">
                      <div class=utilisateur>
                        <span><?= $task->getAuthor() ?></span>
                      </div>
                      <div class="titre_tache">
                        <span><?= $task->getName() ?></span>
                      </div>
                      <div class="desc_tache">
                        <span><?= $task->getDescription() ? $task->getDescription() : '<i>Pas de description</i>' ?></span>
                      </div>
                      <div class="category_tache">
                        <span><?= $task->getCategoryId() ? $task->getCategory() : '<i>Divers</i>' ?></span>
                      </div>
                      <div class="date">
                        <span><?= $task->getCreateDate() ?></span>
                      </div>
                    </div>
                  </div>
                </li>
            <?php endif; endforeach; ?>
        </ul>
        <?php else: ?>
          <p id="message-task-none">Pas de tâche pour le moment...</p>
        <?php endif; ?>
        </div>
    </div>

    <!-- Array display (2nd) -->
    <div id="seconddisplay" class="ligne_et_taches" style="display:none">
        <div class="ligne_haut_tache ligne_haut_tache_id">
            <span title="Tout sélectionner">
                <input name="sample" id="select_all2" type="checkbox" />
            </span>
            <span title="Nouvelle tâche">
                <img class="brightnessmax new_task_img" src="public/img/plus.png" alt="">
            </span>
            <span title="Rafraîchir">
                <img class="brightnessmax refresh" src="public/img/refresh.png" alt="" onclick="location.reload()" />
            </span>
            <span title="Tâches effectuées">
                <img class="tasks_done" src="public/img/task_done0.png" alt="" @click="switchDoneTask" />
            </span>
            <span title="Supprimer">
                <img class="brightnessmax trash trashsecond" src="public/img/trash.png" alt="" style="display:none;" />
            </span>
        </div>
        <div class="wrapper-table-task">
            <div class="table-wrapper mozaic_all_table">
                <?php if (isset($tasksByCategory)): ?>
                    <?php if ($nb_tasks == 0): ?>
                        <p id="message-task-none" v-show="!done_task">Toutes les tâches sont terminées !</p>
                    <?php elseif ($nb_done_tasks == 0): ?>
                        <p id="message-task-none" v-show="done_task">Il n'y a aucune tâche terminée.</p>
                    <?php endif; ?>
                    <?php foreach ($tasksByCategory as $category_id => $cat_tasks): ?>
                        <?php if (count($cat_tasks)): ?>
                        <table class="table_contain" v-show="showCategory(<?= $category_id ?>)">
                            <tbody>
                                <tr class="table_row_main categories">
                                    <td class="table_col_main category-name">
                                      <br>
                                      <div>
                                        <input type="checkbox" class="to-check2 category-check" id="category<?= $category_id ?>" />
                                        <p>
                                            <label
                                            title="<?= getCategoryNameById($category_id) ? getCategoryNameById($category_id) : 'Divers' ?>"
                                            for="category<?= $category_id ?>">
                                                <?= getCategoryNameById($category_id) ? getCategoryNameById($category_id) : 'Divers' ?>
                                            </label>
                                        </p>
                                      </div>
                                    </td>
                                </tr>

                                <!-- Tasks in the category -->
                                <?php foreach ($cat_tasks as $task): ?>
                                    <?php if ($task->getAuthor()): ?>
                                        <tr
                                        class="table_row_main<?= $task->getIsDone() ? ' done-task' : '' ?> <?= $task->getIsDone() ? 'done_' : '' ?>task<?= $task->getId() ?>"
                                        v-show="<?= $task->getIsDone() ? '' : '!' ?>done_task">
                                            <td class="table_col_main">
                                                <div class="border_all">
                                                    <div class="left-side-task-mosaic">
                                                        <input
                                                            type="checkbox"
                                                            class="check_js to-check2 in-category<?= $task->getCategoryId() ? $task->getCategoryId() : '-1' ?>"
                                                            :class="<?= $task->getIsDone() ? 'done_task' : '!done_task' ?> ? 'active' : ''" />
                                                        <img src="public/img/edit_task_bar.png" class="invertcent tick2" alt="" />
                                                        <a href="index.php?action=endTask&id=<?= $task->getId() ?>">
                                                            <img src="public/img/tick.png" class="invertcent trash-btn" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="task_name_mozaic">
                                                        <p><?= $task->getName() ?></p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p id="message-task-none">Pas de tâche pour le moment...</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- All of modals -->
<div id="modals" style="display:none;">
    <?php if (isset($tasks)): ?>
        <?php foreach ($tasks as $task) {
    if ($task->getAuthor()): ?>
            <!-- Tasks modals -->
            <modal id="<?= $task->getIsDone() ? 'done_' : '' ?>task<?= $task->getId() ?>_modal" name="popup_modal_task">
                <span class="close_add close-modal">&times;</span>
                <div class="top-colour">
                  <h1>Détails de la tâche <?= $task->getIsDone() ? 'effectuée ' : '' ?></h1>
                </div>
                <div class="bottom-colour">
                  <h3>Par <?= $task->getAuthor() ?>, le <?= $task->getCreateDate() ?> : </h3>
                  <h3><strong>Détails de la tâche : </strong></h3>
                  <br>
                  <div class="details-task" >
                      <h3><u>Titre de la tâche :</u> <?= $task->getName() ?></h3>
                      <h3><u>Description de la tâche :</u> <?= $task->getDescription() ? $task->getDescription() : '<i>Pas de description</i>' ?></h3>
                      <h3><u>Catégorie de la tâche :</u> <?= $task->getCategoryId() ? $task->getCategory() : 'Divers' ?></h3>
                      <br><br>
                      <table class="bottom-task-modal">
                        <tr>
                          <td>
                            <div class="span_input_img" title="Marquer comme <?= $task->getIsDone() ? 'non ' : '' ?>effectuée">
                                <a href="index.php?action=endTask&id=<?= $task->getId() ?>">
                                    <img class=" invertcent input_img tick" src="public/img/tick.png" alt="" />
                                    <p>Marquer comme <?= $task->getIsDone() ? 'non ' : '' ?> effectuée</p>
                                </a>
                            </div>
                          </td>
                          <td>
                            <div onclick="setTimeout(()=>{modals.show('task<?= $task->getId() ?>_edit')},500)" class="close-modal" title="Éditer la tâche">
                                <img src="public/img/edit_task_bar.png" class="invertcent tick2" alt="" />
                                <p class="trash2">Editer la tâche</p>
                            </div>
                          </td>
                          <td>
                            <div onclick="setTimeout(() => deleteTask(<?= $task->getId() ?>), 500)" class="close-modal" title="Supprimer la tâche">
                                <img class="brightnessmax trash2 close-modal" src="public/img/trash.png" alt="" />
                                <p class="trash2">Supprimer la tâche</p>
                            </div>
                          </td>
                        </tr>
                      </table>

                  </div>
                </div>
            </modal>

            <!--Tasks edit modals -->
            <modal id="<?= $task->getIsDone() ? 'done_' : '' ?>task<?= $task->getId() ?>_edit" name="edit_popup_modal">
                <span class="section_ligne_haut_edit">
                    <br><br><br>
                    <p class="colorred title_task_modal"><strong class="colorred">Modifier la tâche</strong></p>
                    <span class="close_edit close_add close-modal">&times;</span>
                </span>
                <span class="section_ligne_bas_edit">
                    <form method="POST" action="index.php?action=editTask&id=<?= $task->getId() ?>">
                      <h1 class="colorred">Titre de la tâche (80 caractères maximum)</h1>
                      <input class="textarea_title input" name="title" type="text" value="<?= $task->getName()?>" maxlength="80" required>
                      <h1 class="colorred">Catégorie de la tâche (15 caractères maximum)</h1>
                      <div class="category_flex">
                        <select name="category">
                            <option <?php if (!$task->getCategory()) {
        echo 'selected="selected" ';
    } ?>value="-1">Divers</option>
                            <?php foreach ($categories as $category): ?>
                                <option <?php if ($task->getCategoryId() == $category->getId()) {
        echo 'selected="selected" ';
    } ?>value="<?= $category->getId() ?>"><?= $category->getName() ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="button" name="" class="new_cat_button2">Nouvelle Catégorie</button>
                        <input maxlength=15 type="text" placeholder="Nom de la catégorie" class="input_new_cat2" name="add_category" />
                      </div>
                      <h1 class="colorred">Description de la tâche (Optionnel)</h1>
                      <textarea class="textarea_desc_edit" name="description" type="text" placeholder="Description"><?= $task->getDescription()?></textarea>

                      <span class="button_line_edit">
                          <button class="backtrans close-modal" name="cancel_button_edit_task" type="button">Annuler</button>
                          <button class="backtrans" name="submit_button_edit_task" type="submit">Valider</button>
                      </span>
                    </form>
                </span>
            </modal>
        <?php endif;
} ?>
    <?php endif; ?>

    <!--Add task modal-->
    <modal id="add_task">
        <span id="section_ligne_haut">
          <br><br><br>
            <p><strong class="colorred">Ajouter une tâche</strong></p>
            <span id="close_add" class="close_add close-modal">&times;</span>
        </span>
        <span id="section_ligne_bas">
            <form method="POST" action="index.php?action=addTask">
                <h1 class="colorred">Titre de la tâche (80 caractères maximum)</h1>
                <input id="addtask_title" class="textarea_title input" name="title" type="text" placeholder="Titre" maxlength="80" required>
                <h1 class="colorred">Catégorie de la tâche (15 caractères maximum)</h1>
                <div class="category_flex">
                  <select name="category">
                    <option selected="selected" value="-1">Divers</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category->getId() ?>"><?= $category->getName() ?></option>
                    <?php endforeach; ?>
                  </select>
                  <button type="button" class="new_cat_button2">Nouvelle Catégorie</button>
                  <input maxlength=15 type="text" placeholder="Nom de la catégorie" class="input_new_cat2" name="add_category" />
                </div>
                <h1 class="colorred">Description de la tâche (Optionnel)</h1>
                <textarea id="textarea_desc" name="description" type="text" placeholder="Description"></textarea>

                <span id="button_line">
                    <button name="cancel_button_create_task" id="addtask_cancel" class="close-modal boutons_bas" type="button">Annuler</button>
                    <button name="submit_button_create_task" class="boutons_bas" type="submit">Valider</button>
                </span>
            </form>
        </span>
    </modal>

    <!--MODAL CONFIRM DELETE TASK-->

    <modal id="delete_task">
      <span class="close_settings close-modal close_add">&times;</span>
      <h1 class="colorred">CONFIRMATION de suppression de tâche(s)</h1>
      <br>
      <h2>Êtes vous sûr(e) de vouloir supprimer <span id="nb_tasks">0</span> tâche(s) ?</h2>
      <br>
      <div id="flex_confirm" class="flex_confirm">
        <p id="no_delete_task" class="close-modal no_delete_task">Non je veux la/les conserver</p>

        <p id="yes_delete_task" class="colorred yes_delete_task">Oui je veux la/les supprimer définitivement</p>
      </div>
    </modal>

    <?php require('template/modals.php'); ?>

</div>

<?php
$content = ob_get_clean();
require('template/template.php');
