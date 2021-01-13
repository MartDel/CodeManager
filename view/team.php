<?php
$title = "Equipe | NameProject";
$page = 'team';
$cssfile = "team"; // CSS file name
$jsfile = "teamjs"; // JS file name
$_SESSION['last_page'] = 'team';
ob_start();
?>

  <section class="main-content">
    <div class="add_remove_user_bar">
      <span title="Ajouter un utilisateur">
          <img id="new_user_img" src="public/img/plus.png" alt="">
      </span>
      <span title="Rafraîchir">
          <img id="refresh" src="public/img/refresh.png" alt="" onclick="location.reload()" />
      </span>
    </div>
    <div class="main-table-user">
      <table>
        <tr>
          <?php foreach ($users as $user): ?>
              <td>
                <div class="img_user_profile">
                  <img src="public/img/<?= $user->getPictureName() ? 'users/' . $user->getPictureName() : 'defaultuser.png' ?>" alt="Photo de profile de <?= $user->getPseudo() ?>" />
                </div>
                <h1><?= $user->getPseudo() ?></h1>
                <p><?= $user->getMail() ?></p>
                <br>
                <p><?= $user->getFinalRole() ?></p>
                <?php if ($user->getId() != $_SESSION['user_id'] && $_SESSION['permissions'] == 2): ?>
                    <a href="index.php?action=removeUserFromTeam&id=<?= $user->getId() ?>">
                      <div class="delete_user_div">
                        <img src="public/img/trash.png" alt="">
                        <h2>Supprimer le collaborateur</h2>
                      </div>
                    </a>
                <?php endif; ?>
              </td>
          <?php endforeach; ?>
        </tr>
      </table>
    </div>
  </section>
</section>
<div id="modals" style="display:none;">

    <modal id="add">
      <span id="close_account_modal" class="close-modal close_account_modal">&times;</span>
      <form action="index.php?action=searchUser" method="post">
          <h1>Ajouter un collaborateur</h1>
          <br><br>
          <h2>Adresse e-mail du collaborateur :</h2>
          <br>
          <input class="mailadd" type="email" name="mail" placeholder="Adresse e-mail du collaborateur" value="" />
          <br><br><br>
          <div class="flex_add_user">
            <input class="yes_add_user" type="submit" value="Valider" />
            <a href="#" class="close-modal no_add_user">Annuler</a>
          </div>
      </form>
    </modal>
    <?php require('template/modals.php'); ?>
</div>

<?php
$content = ob_get_clean();
require('template/template.php');
