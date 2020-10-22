<?php
$title = "Equipe | NameProject";
$cssfile = "tasks"; // CSS file name
$jsfile = "tasksjs"; // JS file name
ob_start();
?>

<!-- HTML content -->

<?php
$content = ob_get_clean();
require('template/template.php');
