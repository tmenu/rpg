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
				<dt>Santé</dt>
				<dd>
					<?php
					$percent = ($character->getHealth() * 100) / $character->getHealth_max();
					$bar_color = '';

					if ($percent >= 50) {
						$bar_color = 'success';
					}
					else if ($percent >= 20) {
						$bar_color = 'warning';
					}
					else {
						$bar_color = 'danger';
					}

					?>
					<div class="progress">
						<div class="progress-bar progress-bar-<?php echo $bar_color; ?>" role="progressbar" aria-valuenow="<?php echo $character->getHealth(); ?>" aria-valuemin="0" aria-valuemax="<?php echo $character->getHealth_max(); ?>" style="width: <?php echo $percent; ?>%;">
						</div>
						<div class="value">
							<?php echo $character->getHealth(); ?> / <?php echo $character->getHealth_max(); ?>
						</div>
					</div>
				</dd>

				<dt>Vie</dt>
				<dd><?php echo $character->getLife(); ?></dd>

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