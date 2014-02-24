<?php require('./Lib/autoload.php'); ?>
<!DOCTYPE html>
<html>
	<head>

		<meta charset="utf8" />
		<link href="css/styles.css" type="text/css" rel="stylesheet" />

	</head>
	<body>

		<main>

			<?php

			$application = new Lib\Application();

			$application->run();

			?>

		</main>

	</body>
</html>