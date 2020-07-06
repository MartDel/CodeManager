<?php

$title = "CodeManager";
$pseudo = $_SESSION['pseudo'];
$mail = $_SESSION['mail'];

ob_start();

?>

<h1>Bienvenu <?= $pseudo ?></h1>
<h2>Ton addresse mail est <?= $mail ?></h2>
<br>
<a href="index.php?action=logout">Se déconnecter</a>

<?php

$content = ob_get_clean();
require('template/template.php');

?>
