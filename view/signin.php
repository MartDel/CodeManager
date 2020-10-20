<?php

$title = "Connexion";
$cssfile = "signin";
ob_start();

?>
<div class="title_form_container">
  <h1 class="form_title">Connexion</h1>
</div>
<div class="form_container">
  <form action="index.php?action=checkSignIn" method="post">
    <input class="input_text" type="text" name="login" placeholder="Pseudo / Addresse mail" />
    <br>
    <input class="input_text" type="password" name="password" placeholder="Mot de passe" />
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
</div>


<?php

$content = ob_get_clean();
require('template/home.php');

?>
