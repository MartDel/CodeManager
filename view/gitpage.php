<?php
$title = "Tâches | NameProject";
$page = 'tasks';
$cssfile = "tasks";
$jsfile = "tasksjs";
$_SESSION['last_page'] = 'tasks';
ob_start();
?>

<div style="flex-grow:1;text-align:center; align-items:center;font-family:'Product Sans Regular';">
  Page en développement... :/
</div>

<!-- All of modals -->
<div id="modals" style="display:none;">
</div>

<?php
$content = ob_get_clean();
require('template/template.php');
