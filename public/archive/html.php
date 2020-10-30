<modal id="edit">
  <section id="section_ligne_haut">
      <img id="logo_add_task" src="public/img/essai_logo.png" alt="" />
      <p><strong>Modifier la tâche</strong></p>
      <span id="close_add" class="close_add close-modal">&times;</span>
  </section>
  <section id="section_ligne_bas">
      <form method="POST" action="index.php?action=addtask">
          <h1>Titre de la tâche (80 caractères maximum)</h1>
          <input class="textarea_title" name="title" type="text" placeholder="<?= $task->getName()?>" maxlength="80" required></input>
          <h1>Description de la tâche (Optionnel)</h1>
          <input id="textarea_desc" name="description" type="text" placeholder="<?= $task->getDescription()?>"></input>
          <h2></h2>
          <section id="button_line">
              <button name="cancel_button_create_task" id="addtask_cancel" class="close-modal" type="button">Annuler</button>
              <button name="submit_button_create_task" type="submit">Valider</button>
          </section>
      </form>
  </section>
</modal>
