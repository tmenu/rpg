<?php require('./Lib/autoload.php'); ?>
<!DOCTYPE html>
<html>
	<head>

		<meta charset="utf8" />
		<link rel="stylesheet" href="/css/bootstrap.min.css">
		<link rel="stylesheet" href="/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="/css/styles.css" />

	</head>
	<body>

		<div class="container">

			<?php

			$application = new Lib\Application();

			$application->run();

			?>

		</div>

		<script src="/js/jquery.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>

	</body>
</html>