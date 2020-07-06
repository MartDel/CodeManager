<?php

$title = "Connection";
ob_start();

?>

<form action="index.php?action=checkSignIn" method="post">
  <input type="text" name="login" placeholder="Pseudo / Addresse mail" />
  <br>
  <input type="password" name="password" placeholder="Mot de passe" />
  <br>
  <label>
    Connexion automatique
    <input type="checkbox" name="auto" checked />
  </label>
  <br>
  <br>
  <input type="submit" value="Envoyer" />
</form>

<?php

$content = ob_get_clean();
require('template/template.php');

?>
