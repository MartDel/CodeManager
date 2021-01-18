<!DOCTYPE html>
<html lang="fr">
	<head>
    <title><?= $title ?></title>
    <meta charset="utf-8" />

		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="public/CSS/template/message.css" />
		<link rel="stylesheet" type="text/css" href="public/CSS/<?= $cssfile ?>.css" />

		<link rel="shortcut icon" href="public/img/shortcuticon.png" />

        <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.js"></script>
	</head>
	<body>
		<?= $content ?>

		<!-- Implementations -->
		<script src="https://code.jquery.com/jquery-3.5.0.js"></script>

		<!-- JS code -->
		<script src="public/JS/template/Message.js"></script>
		<script src="public/JS/template/manage_messages.js"></script>
		<?php if(isset($jsfile)): ?>
			<script src="public/JS/<?= $jsfile ?>.js"></script>
		<?php endif; ?>
	</body>
</html>
