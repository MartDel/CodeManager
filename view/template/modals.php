<!--SEARCH MODALS-->
<modal id="not_find">
  <span id="close_settings" class="close-modal close_settings">&times;</span>
  <h1 class="colorred">Erreur de recherche</h1><br><br><br><br>
  <p>L'élément n'a pas été trouvé</p>
</modal>

<modal id="no_text">
  <span id="close_settings" class="close-modal close_settings">&times;</span>
  <h1 class="colorred">Erreur de recherche</h1><br><br><br><br>
  <p>Vous n'avez entré aucun texte</p>
</modal>


<!--SETTINGS MODAL-->
<modal id="settings">
    <div class="colorred" id="settings_title">Réglages</div>
    <span id="close_settings" class="close-modal cross_settlings close_settings">&times;</span>
    <div class="grayback row_settings">
        <p>Mode Sombre : </p>
        <input class="apple-switch" id="dark_mode" type="checkbox">
    </div>
    <div class="grayback row_settings">
        <p>Night Shift : </p>
        <input class="apple-switch" id="night_shift" type="checkbox">
    </div>
    <div class="row_settings_title" id="col_settings">
        <form class="form_bug_report" method="POST" action="index.php?action=reportbug">
            <p>Vous avez trouvé un Bug ? Faîtes le nous savoir ci dessous : </p>
            <textarea id="textarea_bug" placeholder="Message" name="mess" id=""></textarea>
            <button type="submit" id="bug_submission" name="bug_report_submit_button">Envoyer</button>
        </form>
        <br>
    </div>
</modal>

<!--ACCOUNT MODAL-->
<modal id="account">
    <img id="bc_img_logo_account" src="public/img/<?= isset($_SESSION['pp']) ? 'users/' . $_SESSION['pp'] : 'defaultuser.png' ?>" alt="Photo de profil">
    <span id="close_account_modal" class="close-modal close_account_modal">&times;</span>
    <p class="name_user_title"><?= $_SESSION['pseudo'] ?></p>
    <p class="mail_user_title"><?= $_SESSION['mail'] ?></p>
    <a id="button_my_account" class="button_my_account close-modal">Mon compte</a>
    <div class="flex_button_account">
        <a id="button_option" class="close-modal button_option">Options</a>
        <a href="index.php?action=logout" name="deconnexion_button" class="button_deconnect">Déconnexion</a>
    </div>
</modal>

<!--MY ACCOUNT MODAL-->
<modal id="my_informations">
    <h1 class="colorred">Mes Informations</h1>
    <div class="account_change_column">
      <a href="#">
        <div class="img_account_change">
          <img id="img_account_changeimg" src="public/img/<?= isset($_SESSION['pp']) ? 'users/' . $_SESSION['pp'] : 'defaultuser.png' ?>" alt="Photo de profil">
            <form id="form_add_img" class="form_add_img" action="index.php?action=editPP" method="post" enctype="multipart/form-data" onmouseover="hover_change()" onmouseleave="leave_change()">
              <input class="input_img" size="0" id="input_img" type="file" name="pp" />
              <input type="submit" value="Envoyer" />
            </form>
            <h3 class="colorwhite" id="img_text">Changer</h3>
          </div>
      </a>
      <span id="close_settings" class="close-modal close_settings">&times;</span>
      <br><br>
      <form class="" action="index.php?action=editaccount" method="post">
        <div class="account_change_row">
          <p>Pseudo :</p>
          <input class="input_fields" id="textarea_pseudo" tabindex="1" name="pseudo" disabled="true" value="<?= $_SESSION['pseudo'] ?>"></input>
          <img id="modify_textarea_pseudo" class="brightnessmax modify_textarea" src="public/img/pencil.png" alt="">
          <img id="validate_textarea_pseudo" class="brightnessmax validate_textarea" src="public/img/done.png" alt="">
        </div>

        <div class="account_change_row">
          <p>Mon adresse Mail : </p>
          <input class="input_fields" name="mail" disabled="true" value="<?= $_SESSION['mail'] ?>" id="textarea_mail" ></input>
        </div>

        <!-- <div class="account_change_row">
          <p>Mon mot de passe : </p>
          <input class="input_fields" name="password" disabled="true" id="textarea_pass" value="Mot De passe en points" type="password"></input>
          <img id="modify_textarea_pass" class="modify_textarea" src="public/img/pencil.png" alt="">
          <img id="validate_textarea_pass" class="validate_textarea" src="public/img/done.png" alt="">
        </div> -->
        <br><br>
        <button type="button" id="cancel_submit_changes" name="button">Annuler</button>
      </form>
      <br><br><br>
      <div class="account_change_row buttons_delete_support">
        <a href="#" id="confirm_open" class="close-modal">Supprimer mon compte</a>
        <a href="#">Besoin d'aide ?</a>
      </div>
    </div>
</modal>

<!--CONFIRMATION SUPPRESSION COMPTE-->

<modal id="delete">
  <span id="close_settings" class="close-modal close_settings">&times;</span>
  <h1 class="colorred">CONFIRMATION de suppression de compte</h1>
  <h2>Êtes vous sûr(e) de vouloir supprimer votre compte ?</h2>
  <br><br>
  <div class="flex_confirm">
    <a href="#" id="no_delete" class="colorblack close-modal no_delete">Non je veux garder mon compte</a>
    <br><br>
    <a class="colorred yes_delete" href="index.php?action=deleteAccount">Oui je veux supprimer mon compte</a>

  </div>
</modal>

<!--SWAP PROJECT MODAL-->
<modal id="project">
    <section id="header_project_modal">
        <p class="colorred">Changer de projet</p>
        <span id="close_swap" class="close_swap close-modal">&times;</span>
        <br><br>
    </section>
    <br><br><br><br>
    <section id="body_project_modal">
        <section id="flex_arrow">
            <p id="change_title">Changer de projet :</p>

            <form class="form-select-user" action="index.php?action=switchProject" method="post">
              <select class="select-general" name="project" onchange='if(this.value != <?= $_SESSION['project_id'] ?>) { this.form.submit(); }'>
                <?php foreach ($project_list as $current_project): ?>
                    <option value="<?= $current_project->getId() ?>" <?= $current_project->getId() == $_SESSION['project_id'] ? 'selected' : '' ?>>
                        <?= $current_project->getName() ?>
                    </option>
                <?php endforeach; ?>
              </select>
            </form>
        </section>

        <br><br>
        <div id="div_form_new_project"></div>
        <div class="info_current_project">
          <br>
          <h1>Nom du Projet : <?= $project->getName() ?></h1>
          <br>
          <h1>Description du Projet : <?= $project->getDescription() ? $project->getDescription() : '<i>Pas de description</i>' ?></h1>
          <br>
        </div>
        <br><br>
        <div class="flex_project_modification">
          <a id="edit_project_opener" class="colorred close-modal edit_project_button" href="#">Éditer le projet en cours</a>
          <br>
          <a id="create_project_opener" class="colorred close-modal create_project_button" href="#">Créer un nouveau projet</a>
        </div>
    </section>
</modal>

<!--MODAL CREATE PROJECT-->

<modal id="create">
  <section id="header_create_project">
      <p class="colorred">Créer un projet</p>
      <span id="close_swap" class="close_swap close-modal">&times;</span>
      <br><br><br><br>
  </section>
  <form name="create_project_form" action="index.php?action=createProject" method="POST">
      <h1>Nom du Projet (20 caractères max.)</h1>
      <input class="colorblack" name="name" id="new_project_name" maxlength="20" placeholder="Nom du projet" required></input><br><br>
      <h1>Description du projet (optionnel)</h1>
      <textarea class="colorblack" name="description" id="new_project_desc" placeholder="Description du projet"></textarea><br><br>
      <h2>GitHub (optionnel)</h2>
      <div class="flex_git_links">
        <input class="colorblack" name="github_pseudo" id="new_project_git_name" placeholder="Pseudo GitHub"></input><br><br>
        <input class="colorblack" name="remote" id="new_project_git_repo" placeholder="Nom du projet GitHub"></input>
      </div>
      <div class="flex_button_create">
        <br><br>
        <button name="create_project_button" class=" button_create_project" type="submit">Créer un nouveau projet</button>
        <button class=" close-modal button_cancel_create_project" name="cancel_create_project_button" type="submit">Annuler</button>
      </div>
  </form>
</modal>

<!--Edit project modal-->
<modal id="edit_project">
  <section id="header_edit_project">
      <p class="colorred">Modifier le projet</p>
      <span id="close_swap" class="close_swap close-modal">&times;</span>
      <br><br><br><br>
  </section>
  <form name="edit_project_form" action="index.php?action=editProject" method="POST">
      <h1>Nom du Projet (20 caractères max.)</h1>
      <input class="colorblack" name="name" id="edit_project_name" maxlength="20" placeholder="Nom du projet" value="<?= $project->getName() ?>" required></input><br><br>
      <h1>Description du projet (optionnel)</h1>
      <textarea class="colorblack" name="description" id="edit_project_desc" placeholder="Description du projet"><?= $project->getDescription() ? $project->getDescription() : '' ?></textarea><br><br>
      <h2>GitHub (optionnel)</h2>
      <div class="flex_git_links">
        <input class="colorblack" name="github_pseudo" id="edit_project_git_name" placeholder="Pseudo GitHub" value="<?= $project->getRemotePseudo() ?>" /><br><br>
        <input class="colorblack" name="remote" id="edit_project_git_repo" placeholder="Nom du projet GitHub"  value="<?= $project->getRemoteName() ?>" />
      </div>
      <div class="flex_button_edit">
        <br><br>
        <button name="edit_project_button" class="button_edit_project" type="submit">Modifier le  projet</button>
        <a class="button_cancel_edit_project" name="cancel_create_project_button" href="index.php?action=deleteProject">Supprimer le projet</a>
        <button class="close-modal button_cancel_edit_project" name="cancel_create_project_button" type="submit">Annuler</button>
      </div>
  </form>
</modal>


<!--HELP MODAL-->
<div class="grayback" id="help_modal">
    <span class="span_help">
        <img src="public/img/plus.png" alt="" />
        <p> Ajouter</p>
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
        <img src="public/img/task_done0.png" alt="" />
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
