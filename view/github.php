<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>GitHub</title>
    </head>
    <body>
        <?php if ($commits_available): ?>
            <ul id="commits"></ul>
            <p id="loading" style="display:none;">Chargement...</p>
            <button type="button" id="more" style="display:none;" title="Cliquez ici pour affichez des commits plus anciens">Afficher plus de commits</button>
        <?php else: ?>
            <p>Dépôt GitHub manquant...</p>
        <?php endif; ?>

        <?php if ($commits_available): ?>
            <input type="hidden" id="username" value="<?= $project->getRemotePseudo() ?>" />
            <input type="hidden" id="project" value="<?= $project->getRemoteName() ?>" />
            <script type="text/javascript" src="public/JS/github.js"></script>
            <script type="text/javascript" src="public/JS/template/Commit.js"></script>
        <?php endif; ?>
    </body>
</html>
