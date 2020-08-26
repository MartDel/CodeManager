<?php

$title = "Inscription";
ob_start();

?>

<form action="index.php?action=checkSignUp" method="post">
    <input type="text" name="firstname" placeholder="Prénom" required />
    <br>
    <input type="text" name="lastname" placeholder="Nom" required />
    <br>
    <input type="text" name="pseudo" placeholder="Pseudo" required />
    <br>
    <input type="mail" name="mail" placeholder="Addresse mail" required />
    <br>
    <input type="password" name="password" placeholder="Mot de passe" required />
    <br>
    <input type="password" name="confirm" placeholder="Confirmer mot de passe" required />
    <br>
    <input type="submit" value="Envoyer" />
</form>

<?php

$content = ob_get_clean();
require('template/home.php');

?>
