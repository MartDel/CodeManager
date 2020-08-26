<?php

$title = "Page d'accueil";
ob_start();

?>

<a href="index.php?action=signup">S'incrire</a>
<br><br>
<a href="index.php?action=signin">Se connecter</a>

<?php

$content = ob_get_clean();
require('template/home.php');

?>
