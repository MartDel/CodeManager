<!DOCTYPE html>
<html>
	<head>
	    <title><?= $title ?></title>
		<meta charset="utf-8" />
	    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	    <link rel="stylesheet" href="public/CSS/<?= $cssfile ?>.css" />

		<!-- CSS for JS transitions -->
	    <link rel="stylesheet" href="public/CSS/transitions.css" />

	    <link rel="icon" type="image/png" href="" />
	    <link rel="shortcut icon" href="public/img/programmer2.png">
	    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

	    <!--Start of Tawk.to Script-->
	    <script type="text/javascript">
	        var Tawk_API = Tawk_API || {},
	            Tawk_LoadStart = new Date();
	        (function () {
	            var s1 = document.createElement("script"),
	                s0 = document.getElementsByTagName("script")[0];
	            s1.async = true;
	            s1.src = 'https://embed.tawk.to/5f3cf6161e7ade5df442289f/1egl19u2n';
	            s1.charset = 'UTF-8';
	            s1.setAttribute('crossorigin', '*');
	            s0.parentNode.insertBefore(s1, s0);
	        })();
	    </script>
	    <!--End of Tawk.to Script-->

	</head>

	<?= $content ?>

	<script type="text/javascript" src="public/JS/<?= $jsfile ?>.js"></script>
</html>
