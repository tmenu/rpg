<?php
use Lib\Map\Map;
use Lib\Router;
?>
<table id="map" class="pull-left">

	<?php foreach ($map->getMap() as $y => $row): ?>

		<tr>

			<?php foreach ($row as $x => $box):

				$class = '';

				if ($box & Map::GROUND) {
					$class .= 'ground';
				}
				else if ($box & Map::WALL) {
					$class .= 'wall';
				}

				if ($box & Map::ENTRY) {
					$class .= ' entry';
				}
				else if ($box & Map::OUT) {
					$class .= ' out';
				}

				?>
				
				<td class="box <?php echo $class; ?>">

					<?php if ($perso->getPosition()['x'] == $x && $perso->getPosition()['y'] == $y): ?>
						<div class="mage01 <?php echo $perso->getDirection(); ?>"></div>
					<?php else: ?>
						<?php foreach ($map->getMonsters() as $monster): ?>
							
							<?php if ($monster->getPosition()['x'] == $x && $monster->getPosition()['y'] == $y): ?>
								<div class="<?php echo $monster->getRef() . ' ' . $monster->getDirection(); ?>"></div>
							<?php endif; ?>

						<?php endforeach; ?>
					<?php endif; ?>

				</td>

			<?php endforeach; ?>

		</tr>

	<?php endforeach; ?>

</table>

<aside id="commands" class="pull-left">

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

	<div id="info-perso">

		

	</div>

</aside>