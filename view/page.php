<?php

$title = "title";
ob_start();

?>

<!-- CONTENT -->

<?php

$content = ob_get_clean();
require('template/template.php');

?>
