<?php
$title = "Equipe | NameProject";
$cssfile = "team"; // CSS file name
$jsfile = "teamjs"; // JS file name
ob_start();
?>

<!-- HTML content -->

<?php
$content = ob_get_clean();
require('template/template.php');
