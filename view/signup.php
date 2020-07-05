<?php

$title = "Inscription";
ob_start();

?>

<form action="index.php?action=checkSignUp" method="post">
  <input type="text" name="pseudo" placeholder="Pseudo" />
  <br>
  <input type="password" name="password" placeholder="Mot de passe" />
  <br>
  <input type="password" name="confirm" placeholder="Confirmer mot de passe" />
  <br>
  <input type="submit" value="Envoyer" />
</form>

<?php

$content = ob_get_clean();
require('template/template.php');

?>
