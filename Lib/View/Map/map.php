<?php
use Lib\Entity\Map;
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
<table class="<?php echo $table_borders; ?> vcenter">

	<?php for  ($row = $origin['y']; $row < $size['height'] && $row < $visible['y'] + $origin['y']; $row++): ?>

		<tr>

			<?php for ($col = $origin['x']; $col < $size['width'] && $col < $visible['x'] + $origin['x']; $col++):

				// Récupération de la case courante
				$box = $map->getMap()[ $row ][ $col ];

				// Définition des classes en fonction du type de case
				$class = '';

				if ($box & Map::GRASS) { $class .= 'grass'; }
				else if ($box & Map::MOUNTAIN) { $class .= 'mountain'; }
				else if ($box & Map::MOUNTAIN2) { $class .= 'mountain2'; }

				else if ($box & Map::DESERT) { $class .= 'desert'; }
				else if ($box & Map::DESERT2) { $class .= 'desert2'; }
				else if ($box & Map::SAND) { $class .= 'sand'; }

				if ($box & Map::ENTRY) { $class .= ' entry'; }
				else if ($box & Map::OUT && $box & Map::GRASS) { $class .= ' out-grass'; }
				else if ($box & Map::OUT && $box & Map::SAND) { $class .= ' out-sand'; }

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
						<?php foreach ($map->getItems() as $item): ?>
							
							<?php if ($item->getPosition_x() == $col && $item->getPosition_y() == $row): ?>
								<div class="<?php echo $item->getRef(); ?>"></div>
							<?php endif; ?>

						<?php endforeach; ?>
					<?php endif; ?>

				</td>

			<?php endfor; // Fin parcours des lignes ?>

		</tr>

	<?php endfor; // Fin parcours des colonnes ?>

</table>