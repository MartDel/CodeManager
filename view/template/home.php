<!DOCTYPE html>
<html>
	<head>
	    <title><?= $title ?></title>
	    <meta charset="utf-8" />
	    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="public/CSS/template/message.css" />
		<link rel="stylesheet" type="text/css" href="public/CSS/<?= $cssfile ?>.css" />

	    <link rel="icon" type="image/png" href="" />
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
		<script type="text/javascript" src="public/JS/template/Message.js"></script>
		<script type="text/javascript" src="public/JS/template/manage_messages.js"></script>
		<?php if(isset($jsfile)): ?>
			<script type="text/javascript" src="public/JS/<?= $jsfile ?>.js"></script>
		<?php endif; ?>
	</body>
</html>
