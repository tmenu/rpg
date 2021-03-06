<?php
use Lib\Router;
?>
<div class="struct"></div>
<div id="battle-zone" class="vcenter well">

	<div class="media">
		<div class="pull-right face-<?php echo $monster->getRef(); ?> default"></div>
		<div class="media-body">
			<h4 class="media-heading"><?php echo $monster->getName(); ?></h4>
			<?php
			$percent = ($monster->getHealth() * 100) / $monster->getHealth_max();
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
			<div id="monster_health" class="progress">
				<div class="progress-bar progress-bar-<?php echo $bar_color; ?>" role="progressbar" aria-valuenow="<?php echo $monster->getHealth(); ?>" aria-valuemin="0" aria-valuemax="<?php echo $monster->getHealth_max(); ?>" style="width: <?php echo $percent; ?>%;">
				</div>
				<div class="value">
					<?php echo $monster->getHealth(); ?> / <?php echo $monster->getHealth_max(); ?>
				</div>
			</div>
		</div>
	</div>

	<img src="/img/versus.png" class="versus" />

	<div class="media">
		<div class="pull-left face-<?php echo $character->getRef(); ?> default"></div>
		<div class="media-body">
			<h4 class="media-heading"><?php echo $character->getName(); ?></h4>
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
			<div id="character_health" class="progress">
				<div class="progress-bar progress-bar-<?php echo $bar_color; ?>" role="progressbar" aria-valuenow="<?php echo $character->getHealth(); ?>" aria-valuemin="0" aria-valuemax="<?php echo $character->getHealth_max(); ?>" style="width: <?php echo $percent; ?>%;">
				</div>
				<div class="value">
					<?php echo $character->getHealth(); ?> / <?php echo $character->getHealth_max(); ?>
				</div>
			</div>
		</div>
	</div>

</div>

<div id="battle-log" class="vcenter">
	<div class="infos text-center well">
		<strong><?php echo $fight_log; ?></strong>
	</div>

	<div class="text-center">
		<?php if (isset($_SESSION['current_fight'])): ?>

			<?php if ($monster->getRound() == 1): ?>
				<a href="<?php echo Router::generateUrl('fight.continue'); ?>" title="Continuer ..." id="continue" class="btn btn-lg btn-primary">Continuer ...</a>
			<?php else: ?>
				<a href="<?php echo Router::generateUrl('fight.attack'); ?>" title="Attaquer" id="attack" class="btn btn-lg btn-primary">Attaquer</a>
				<a href="<?php echo Router::generateUrl('fight.counter'); ?>" title="Défendre" id="counter" class="btn btn-lg btn-primary">Contrer</a>
			<?php endif; ?>

		<?php elseif (isset($_SESSION['game_over'])): unset($_SESSION['game_over']); ?>
			<a href="<?php echo Router::generateUrl('user.account'); ?>" title="Retour à la map" class="btn btn-lg btn-primary">Mon compte</a>
		<?php else: ?>
			<a href="<?php echo Router::generateUrl('map.index'); ?>" title="Retour à la map" class="btn btn-lg btn-primary">Retour à la map</a>
		<?php endif; ?>
	</div>
</div>