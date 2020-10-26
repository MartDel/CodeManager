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
                <div id="projet_princ"><?= /*$project->getName()*/ "TestTeam"?></div>
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
          <h1>Nom du Projet : <?= /*$project->getName()*/ "testtesttest" ?></h1>
          <br>
          <h1>Description du Projet : <?= /*$project->getDescription()*/ "this is a descrition" ?></h1>
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
