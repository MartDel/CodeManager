<?php

$title = "Connexion";
$cssfile = "signin";
$_SESSION['last_page'] = 'signin';
ob_start();

?>

<a href="index.php">
  <img class="back_to_main" src="public/img/left-arrowback.png" alt="">
</a>
<div class="title_form_container">
  <h1 class="form_title">Connexion</h1>
</div>
<div class="form_container">
  <form action="index.php?action=checkSignIn" method="post">
    <input class="input_text" id="pseudo_field" type="mail" name="login" placeholder="Pseudo / Addresse mail" required />
    <br>
    <input class="input_text" id="passwd_field" type="password" name="password" placeholder="Mot de passe" required />
    <br>
    <div class="label_container">
      <label>
        Connexion automatique
        <input type="checkbox" name="auto" checked />
      </label>
    </div>
    <br>
    <br>
    <input class="button_submit_signin" type="submit" value="Se connecter" />
  </form>
  <br><br>
  <p>Vous n'avez pas encore de compte ? Inscrivez-vous <a class="here" href="index.php?action=signup">ici</a></p>
</div>

<script type="text/javascript">
    window.onload = () => {
        checkMessage()
    }
</script>

<?php require('template/message.php'); ?>

<?php

$content = ob_get_clean();
require('template/home.php');

?>
