<?php use Lib\Application as App; ?>
<table id="map">

	<?php foreach ($this->app->getMap() as $row): ?>

		<tr>

			<?php foreach ($row as $box):

				$class = '';

				if ($box & App::GROUND) {
					$class .= 'ground';
				}
				else if ($box & App::WALL) {
					$class .= 'wall';
				}

				if ($box & App::ENTRY) {
					$class .= ' entry';
				}
				else if ($box & App::OUT) {
					$class .= ' out';
				}

				?>
				
				<td class="box <?php echo $class; ?>">

					<?php if ($box & App::PERSO): ?>
						<div class="perso"></div>
					<?php endif; ?>

				</td>

			<?php endforeach; ?>

		</tr>

	<?php endforeach; ?>

</table>

<aside id="commands">

	<div>commandes</div>

	<div>données</div>


</aside>