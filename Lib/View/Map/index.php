<?php
use Lib\Map\Map;
use Lib\Router;

$character = $game->getCharacter();

?>

<section class="map-panel">

	<div class="struct"></div>

	<div id="map">
		<?php include __DIR__.'/map.php'; ?>
	</div>

	<aside id="commands" class="vcenter">

		<div id="directions-btn">
			<div class="row">
				<div class="col-sm-12">
					<a href="<?php echo Router::generateUrl('map.moveUp'); ?>" title="Monter" id="moveUp">
						<span class="glyphicon glyphicon-arrow-up"></span>
					</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<a href="<?php echo Router::generateUrl('map.moveLeft'); ?>" title="Aller à gauche" id="moveLeft">
						<span class="glyphicon glyphicon-arrow-left"></span>
					</a>
				</div>
				<div class="col-sm-6">
					<a href="<?php echo Router::generateUrl('map.moveRight'); ?>" title="Aller à droite" id="moveRight">
						<span class="glyphicon glyphicon-arrow-right"></span>
					</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<a href="<?php echo Router::generateUrl('map.moveDown'); ?>" title="Descendre" id="moveDown">
						<span class="glyphicon glyphicon-arrow-down"></span>
					</a>
				</div>
			</div>
		</div>

		<div id="info-perso" class="well">

			<h3>
				<?php echo $character->getName(); ?>
			</h3>

			<dl class="dl-horizontal">
				<dt>Vie</dt>
				<dd>
					
					<div class="progress progress-striped">
						<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $character->getHealth(); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $character->getHealth(); ?>%;">
							Vie : <?php echo $character->getHealth(); ?>%
						</div>
					</div>

				</dd>

				<dt>Force</dt>
				<dd><?php echo $character->getStrength(); ?></dd>

				<dt>Résistance</dt>
				<dd><?php echo $character->getResistance(); ?></dd>

				<dt>Vitesse</dt>
				<dd><?php echo $character->getSpeed(); ?></dd>
			</dl>

		</div>

	</aside>

</section>