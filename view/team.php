<?php
$title = "Equipe | NameProject";
$page = 'team';
$cssfile = "team"; // CSS file name
$jsfile = "teamjs"; // JS file name
ob_start();
?>

<!-- HTML content -->
<div id="modals" style="display:none;">
    <?php require('template/modals.php'); ?>
</div>

<?php
$content = ob_get_clean();
require('template/template.php');
