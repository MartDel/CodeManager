<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>GitHub</title>
        <link rel="stylesheet" type="text/css" href="public/CSS/template/message.css" />
        <style media="screen" type="text/css">
            #container{
                padding: 5px;
                position: absolute;
                top: 15%;
                left: 20%;
                height: 50%;
                width: 60%;
                border: 1px solid black;
                overflow-y: scroll;
            }
        </style>
    </head>
    <body>
        <?php if ($commits_available): ?>
            <select name="branch" id="switch_branch">
                <?php foreach ($branches as $branch): ?>
                    <option value="<?= $branch ?>"><?= $branch ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <div id="container">
                <ul id="commits"></ul>
                <p id="loading" style="display:none;">Chargement...</p>
                <p id="no_commit" style="display:none">Aucun commit sur cette branche</p>
            </div>
            <button type="button" id="more" style="display:none;" title="Cliquez ici pour affichez des commits plus anciens">Afficher plus de commits</button>
        <?php else: ?>
            <p>Dépôt GitHub manquant...</p>
        <?php endif; ?>

        <?php require('template/message.php'); ?>

        <!-- JS code -->
        <?php if ($commits_available): ?>
            <input type="hidden" id="username" value="<?= $project->getRemotePseudo() ?>" />
            <input type="hidden" id="project" value="<?= $project->getRemoteName() ?>" />
            <input type="hidden" id="branch" value="<?= $current_branch ?>" />
            <script type="text/javascript" src="public/JS/github.js"></script>
            <script type="text/javascript" src="public/JS/template/Commit.js"></script>
        <?php endif; ?>
		<script type="text/javascript" src="public/JS/template/message.js"></script>
		<script type="text/javascript" src="public/JS/template/manage_messages.js"></script>
    </body>
</html>
