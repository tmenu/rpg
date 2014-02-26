<?php
use Lib\Map\Map;
use Lib\Router;

$character = $game->getCharacter();
$map       = $game->getMap();

// Récupération des données de la map
$size = array(
	'height' => $game->getMap()->getSize_height(),
	'width'  => $game->getMap()->getSize_width()
);
$visible = array(
	'x' => $game->getMap()->getVisible_x(),
	'y'  => $game->getMap()->getVisible_y()
);
$origin = array(
	'x' => $game->getMap()->getOrigin_x(),
	'y'  => $game->getMap()->getOrigin_y()
);

// Définition des bordures pour rendre les limites de la map visibles
$table_borders = '';

if ($origin['x'] == 0) { $table_borders .= 'bleft '; }
if ($origin['y'] == 0) { $table_borders .= 'btop '; }

if ($origin['x'] + $visible['x'] == $size['width']) { $table_borders .= 'bright '; }
if ($origin['y'] + $visible['y'] == $size['height']) { $table_borders .= 'bbottom '; }

?>

<section class="map-panel">

	<div class="struct"></div>

	<table id="map" class="<?php echo $table_borders; ?> vcenter">

		<?php for  ($row = $origin['y']; $row < $size['height'] && $row < $visible['y'] + $origin['y']; $row++): ?>

			<tr>

				<?php for ($col = $origin['x']; $col < $size['width'] && $col < $visible['x'] + $origin['x']; $col++):

					// Récupération de la case courante
					$box = $map->getMap()[ $row ][ $col ];

					// Définition des classes en fonction du type de case
					$class = '';

					if ($box & Map::GROUND) { $class .= 'ground'; }
					else if ($box & Map::WALL) { $class .= 'wall'; }

					if ($box & Map::ENTRY) { $class .= ' entry'; }
					else if ($box & Map::OUT) { $class .= ' out'; }

					?>
					
					<td class="box <?php echo $class; ?>">

						<?php if ($character->getPosition_x() == $col && $character->getPosition_y() == $row): ?>
							<div class="<?php echo $character->getRef() . ' ' . strtolower($character->getDirection()); ?>"></div>
						<?php else: ?>
							<?php foreach ($map->getMonsters() as $monster): ?>
								
								<?php if ($monster->getPosition_x() == $col && $monster->getPosition_y() == $row): ?>
									<div class="<?php echo $monster->getRef() . ' ' . strtolower($monster->getDirection()); ?>"></div>
								<?php endif; ?>

							<?php endforeach; ?>
						<?php endif; ?>

					</td>

				<?php endfor; // Fin parcours des lignes ?>

			</tr>

		<?php endfor; // Fin parcours des colonnes ?>

	</table>

	<aside id="commands" class="vcenter">

		<div id="directions-btn">
			<div class="row">
				<div class="col-sm-12">
					<a href="<?php echo Router::generateUrl('map.moveUp'); ?>" title="Monter">
						<span class="glyphicon glyphicon-arrow-up"></span>
					</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<a href="<?php echo Router::generateUrl('map.moveLeft'); ?>" title="Aller à gauche">
						<span class="glyphicon glyphicon-arrow-left"></span>
					</a>
				</div>
				<div class="col-sm-6">
					<a href="<?php echo Router::generateUrl('map.moveRight'); ?>" title="Aller à droite">
						<span class="glyphicon glyphicon-arrow-right"></span>
					</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<a href="<?php echo Router::generateUrl('map.moveDown'); ?>" title="Descendre">
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