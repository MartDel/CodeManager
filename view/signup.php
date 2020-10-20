<?php

$title = "Inscription";
$cssfile = "signup";
ob_start();

?>
<a href="index.php">
  <img class="back_to_main" src="public/img/left-arrowback.png" alt="">
</a>
<div class="title_form_container">
  <h1 class="form_title">Inscription</h1>
</div>
<div class="form_container">
  <form action="index.php?action=checkSignUp" method="post">
      <div class="name_container_flex">
        <input class="input_text_name" type="text" name="firstname" placeholder="Prénom" required />
        <br>
        <input class="input_text_name" type="text" name="lastname" placeholder="Nom" required />
        <br><br>
      </div>

      <input class="input_text" type="text" name="pseudo" placeholder="Pseudo" required />
      <br>
      <input class="input_text" type="mail" name="mail" placeholder="Addresse mail" required />
      <br>
      <input class="input_text" type="password" name="password" placeholder="Mot de passe" required />
      <br>
      <input class="input_text" type="password" name="confirm" placeholder="Confirmer mot de passe" required />
      <br><br><br>
      <input class="button_submit_signup" type="submit" value="S'inscrire" />
  </form>
  <br><br>
  <p>Vous avez déjà un compte ? Connectez-vous <a class="here" href="index.php?action=signin">ici</a></p>
</div>
<?php

$content = ob_get_clean();
require('template/home.php');

?>
