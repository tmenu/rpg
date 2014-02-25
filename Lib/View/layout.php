<?php
use Lib\Router;
use Lib\Session;
?>
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

			<nav class="navbar navbar-default" role="navigation">
				<div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">RPG</a>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<li><a href="<?php echo Router::generateUrl('home'); ?>">Accueil</a></li>

							<?php if ($_SESSION['auth'] === true): ?>
								<li><a href="<?php echo Router::generateUrl('user.account'); ?>">Mon compte</a></li>
								<li><a href="<?php echo Router::generateUrl('user.logout'); ?>">Deconnexion</a></li>
							<?php else: ?>
								<li><a href="<?php echo Router::generateUrl('user.login'); ?>">Connexion</a></li>
								<li><a href="<?php echo Router::generateUrl('user.signup'); ?>">Inscription</a></li>
							<?php endif; ?>
							
							<!--<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="#">Action</a></li>
									<li><a href="#">Another action</a></li>
									<li><a href="#">Something else here</a></li>
									<li class="divider"></li>
									<li><a href="#">Separated link</a></li>
									<li class="divider"></li>
									<li><a href="#">One more separated link</a></li>
								</ul>
							</li>-->
						</ul>
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>

			<?php if (($flashs = Lib\Session::getFlashMessage()) !== false): ?>

                <?php foreach ($flashs as $flash): ?>
                    <div class="alert alert-<?php echo $flash['type']; ?> alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong><?php echo ucfirst($flash['type']); ?> :</strong> <?php echo $flash['message']; ?>
                    </div>
                <?php endforeach; ?>

            <?php endif; 

			echo $_CONTENT;

			?>

		</div>

		<script src="/js/jquery.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>

	</body>
</html>