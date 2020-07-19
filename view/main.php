<?php

$title = "CodeManager";
$css = "task";

ob_start();

?>

<body id="htmlbody">
    <div class="div_table_haut">
        <table class="table_haut">
            <tr class=ligne_menu_haut>
                <td class='colonne_menu_haut'>

                </td>
                <td class='colonne_menu_haut'>
                    <p id="titre_document"><strong>Tâches - CodeManager</strong></p>
                </td>
                <td class='colonne_menu_haut'>
                    <a href="index.php?action=logout"><img class="user" src="public/img/logout.png"></a>
                    <a href=""><img class="user" src="public/img/web_essentials/png/053-user.png"></a>
                </td>
            </tr>


        </table>
    </div>


    <div>
        <table id="edit_tasks">
            <tr id="edit_tasks_line">
                <td class="edit_tasks_col" id="add" onmouseover="demitour1()" onmouseleave="demitour1leave()">
                    <img class="img_edit_tasks" id="add_photo" src="public/img/web_essentials/png/066-add.png">
                    <p class="text_edit_tasks">Ajouter une tâche</p>
                </td>
                <!--<td class="edit_tasks_col" id="delete" onmouseover="demitour2()" onmouseleave="demitour2leave()">
                    <img class="img_edit_tasks" id="delete_photo" src="public/img/web_essentials/png/059-cancel.png">
                    <p class="text_edit_tasks">Supprimer la tâche</p>
                </td>
                <td class="edit_tasks_col" id="edit" onmouseover="demitour3()" onmouseleave="demitour3leave()">
                    <img class="img_edit_tasks" id="edit_photo" src="public/img/web_essentials/png/047-pencil.png">
                    <p class="text_edit_tasks">Éditer la tâche</p>
                </td>-->
            </tr>
        </table>
    </div>

    <table id="table_tache">
        <tbody id="tbody_table_tache">
          <?php
          if($tasks == null){
          ?>
          <tr class='tr_task'>
              <td class="td_task">
                Il n'y a rien à faire ! Mais ça ne durera pas...
              </td>
          </tr>
          <?php
          } else {
            foreach ($tasks as $key => $task) {
          ?>
          <tr class='tr_task'>
              <td class="td_task">
                  ☼
              </td>
              <td class="td_task" onclick="expand_menu()">
                  <?= $task->getName() ?>
              </td>
              <td class="td_task" id="td_menu_burger" onclick="burgerclicktask()">
                  <img id="expand_menu" src="public/img/menu.png">
              </td>

          </tr>
          <tr>
              <div id="expand_div_task">
                  <div id="nom_tache"><?= $task->getName() ?></div>
                  <div id="desc_tache_div">
                    <?php
                    if($task->getDescription() == null){
                      echo "Aucune description, pour l'instant...";
                    } else {
                      echo $task->getDescription();
                    }
                    ?>
                  </div>

                  <div>
                      <li>
                          <?= $task->getAuthor() ?>
                      </li>
                      <li>
                          Créée le <?= $task->getCreateDate() ?>
                      </li>
                      <table id="delete_edit_table">
                          <td class="edit_tasks_col" id="delete" onmouseover="demitour2()"
                              onmouseleave="demitour2leave()">
                              <img class="img_edit_tasks" id="delete_photo"
                                  src="public/img/web_essentials/png/059-cancel.png">
                              <p class="text_edit_tasks">Supprimer la tâche</p>
                          </td>
                          <td class="edit_tasks_col" id="edit" onmouseover="demitour3()"
                              onmouseleave="demitour3leave()">
                              <img class="img_edit_tasks" id="edit_photo" src="public/img/web_essentials/png/047-pencil.png">
                              <p class="text_edit_tasks">Éditer la tâche</p>
                          </td>
                      </table>
                  </div>
              </div>
          </tr>
          <div id="burger_tache_droit">
              <table id="burger_tache_droit_table">
                  <tr>
                      <td>Éditer</td>
                  </tr>
                  <tr>
                      <td>Supprimer</td>
                  </tr>
              </table>
          </div>
          <?php
            }
          }
          ?>
        </tbody>
    </table>


    <!--<table id="table_tache2">
        <thead id="thead_table_tache">
            <tr id="tr_thead_table_tache">
                <td id="td2_thead_table_tache2">
                    Tâche
                </td>
                <td id="td3_thead_table_tache2">
                    Rôle
                </td>
            </tr>
        </thead>
        <tbody id="tbody_table_tache">
            <tr>
                <td class="td_task">
                    <input id="task_input" name="task" placeholder="Tâche à effectuer"></input>
                </td>
                <td class="td_task" id="select_td">
                    <select name="utilise" id="selection">
                        <option value="toujours">Administrateur</option>
                        <option value="parfois">Développeur</option>
                        <option value="jamais">Intégrateur</option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>-->






    <div id="affichage_droit_div">
        <table id="affichage_droit">
            <tr>
                <td>
                    Nombre de Tâches effectuées : <?= $done ?>
                </td>
            </tr>
            <tr>
                <td>
                    Nombre de Tâches non effectuées : <?= $to_do ?>
                </td>
            </tr>
            <tr>
                <td>
                    Progression : <?= $percentage ?>%
                </td>
            </tr>
            <tr>
                <td>

                </td>
            </tr>
            <tr>
                <td>

                </td>
            </tr>
            <tr>
                <td>

                </td>
            </tr>
            <tr>
                <td>

                </td>
            </tr>
            <tr>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    <div id="more_div">
                        <li>Actualiser</li>
                        <li>Tout supprimer</li>
                    </div>
                    <img onclick="burger_hover()" id="img_menu" src="public/img/menu.png">
                </td>
            </tr>
            <tr>
                <td>

                </td>
            </tr>
        </table>
    </div>





    <div id="div_menu_de_gauche">
        <table id="menu_de_gauche">
            <tbody>
                <tr class=ligne_menu_gauche>
                    <td>
                        <img class="img_menu_gauche" id="img_logo" src="public/img/programmer2.png">
                    </td>
                </tr>
                <tr class=ligne_menu_gauche>
                    <td>
                        <div class="trait_separation" id="trait_separation"></div>
                    </td>
                </tr>
                <tr class=ligne_menu_gauche class="bon_pour_trait">
                    <td class="colonne_menu_gauche">
                        <img onmouseover="blur1(); agrandissement1()" onmouseleave="blur1leave(); retrecissement1()"
                            class="img_menu_gauche" id="img_code" src="public/img/list.png">
                    </td>
                </tr>

                <tr class=ligne_menu_gauche class="bon_pour_trait">
                    <td>
                        <img onmouseover="blur2(); agrandissement2()" onmouseleave="blur2leave(); retrecissement2()"
                            class="img_menu_gauche" id="img_list" src="public/img/goal.png">
                    </td>
                </tr>
                <tr class=ligne_menu_gauche class="bon_pour_trait">
                    <td>
                        <img onmouseover="blur3(); agrandissement3()" onmouseleave="blur3leave(); retrecissement3()"
                            class="img_menu_gauche" id="img_group" src="public/img/group.png">
                    </td>
                </tr>
                <tr class=ligne_menu_gauche class="bon_pour_trait">
                    <td>
                        <img onmouseover="blur4(); agrandissement4()" onmouseleave="blur4leave(); retrecissement4()"
                            class="img_menu_gauche" id="img_people" src="public/img/people.png">
                    </td>
                </tr>
                <tr class=ligne_menu_gauche class="bon_pour_trait">
                    <td>
                        <img onmouseover="blur5(); agrandissement5()" onmouseleave="blur5leave(); retrecissement5()"
                            class="img_menu_gauche" id="img_network" src="public/img/network.png">
                    </td>
                </tr>
                <tr class=ligne_menu_gauche>
                    <td>
                        <div class="trait_separation" id="trait_separation2"></div>
                    </td>
                </tr>
                <tr class=ligne_menu_gauche>
                    <td>

                    </td>
                </tr>
                <tr class=ligne_menu_gauche>
                    <td>

                    </td>
                </tr>
            </tbody>
        </table>


        <table id="menu_de_gauche2">
            <tbody>
                <tr class=ligne_menu_gauche>
                    <td>
                        <p id="text_affichage_gauchemenu">Menu</p>
                    </td>
                </tr>
                <tr class=ligne_menu_gauche>
                    <td>
                        <div id="trait_separation_deroulant"></div>
                    </td>
                </tr>
                <tr class=ligne_menu_gauche>
                    <td class="colonne_menu_gauche">
                        <p id="text_affichage_gauche1">Tâches</p>
                    </td>
                </tr>

                <tr class=ligne_menu_gauche>
                    <td>
                        <p id="text_affichage_gauche2">Objectifs</p>
                    </td>
                </tr>
                <tr class=ligne_menu_gauche>
                    <td>
                        <p id="text_affichage_gauche3">Participants</p>
                    </td>
                </tr>
                <tr class=ligne_menu_gauche>
                    <td>
                        <p id="text_affichage_gauche4">Discussion</p>
                    </td>
                </tr>
                <tr class=ligne_menu_gauche>
                    <td>
                        <p id="text_affichage_gauche5">GitHub</p>
                    </td>
                </tr>
                <tr class=ligne_menu_gauche>
                    <td>

                    </td>
                </tr>
                <tr class=ligne_menu_gauche>
                    <td>

                    </td>
                </tr>
                <tr class=ligne_menu_gauche>
                    <td>

                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <script type="text/javascript" src="public/tasks.js"></script>
</body>

<?php

$content = ob_get_clean();
require('template/template.php');

?>