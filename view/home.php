<?php

$title = "Page d'accueil";
ob_start();

?>

<a href="index.php?action=signup" style="color:#fff;">S'incrire</a>
<br><br>
<a href="index.php?action=signin" style="color:#fff;">Se connecter</a>

<?php

$content = ob_get_clean();
require('template/template.php');

?>
