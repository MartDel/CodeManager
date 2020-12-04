<?php

$title = "Connexion";
$_SESSION['last_page'] = 'signin';
$cssfile = "project_creation";
$jsfile = "template/manage_forms";
ob_start();

?>

<div class="title_form_container">
  <h1 class="form_title">Créez votre premier projet</h1>
  <br>
</div>
<div class="form_container">
  <br>
  <form action="index.php?action=createProject" method="post">
    <h1>Nom du Projet (20 caractères max.)</h1>
    <input class="colorblack" name="name" id="new_project_name" maxlength="20" placeholder="Nom du projet" required></input><br><br>
    <h1>Description du projet (optionnel)</h1>
    <textarea class="colorblack" name="description" id="new_project_desc" placeholder="Description du projet"></textarea><br><br>
    <h2>GitHub (optionnel)</h2>
    <div class="flex_git_links">
      <input class="colorblack" name="github_pseudo" id="new_project_git_name" placeholder="Pseudo GitHub"></input><br><br>
      <input class="colorblack" name="remote" id="new_project_git_repo" placeholder="Nom du projet GitHub"></input>
    </div>
    <div class="flex_button_create">
      <br><br>
      <button name="create_project_button" class=" button_create_project" type="submit">Créer un nouveau projet</button>
  </form>
  <br><br>
</div>

<script type="text/javascript">
    window.onload = () => {
        checkMessage()
    }
</script>

<?php require('template/message.php'); ?>

<?php

$content = ob_get_clean();
require('template/home.php');

?>
