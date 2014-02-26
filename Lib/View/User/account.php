<?php
use Lib\Utils;
use Lib\Router;
?>
<h1>Mon compte</h1>

<div class="panel panel-default">
	<div class="panel-heading">Mes parties en cours</div>
	<div class="panel-body">

		<table class="table table-condensed">
			<thead>
				<tr>
					<th>Personnage</th>
					<th>Map</th>
					<th>Monstres restants</th>
					<th>Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php if (empty($games_list)): ?>
					<tr>
						<td colspan="3" class="text-center"><i>Aucune partie en cours</i></td>
					</tr>
				<?php else: ?>
					<?php foreach ($games_list as $game): ?>
						<tr>
							<td>
								<?php echo $game->getCharacter()->getName(); ?>
							</td>
							<td>
								<?php echo $game->getMap()->getName(); ?>
							</td>
							<td>
								<?php echo count($game->getMap()->getMonsters()); ?>
							</td>
							<td>
								<a href="<?php echo Router::generateUrl('user.loadgame', array($game->getId())); ?>">Reprendre</a><br />
								<a href="<?php echo Router::generateUrl('user.cancelgame', array($game->getId())); ?>" onclick="return (confirm('Etes-vous sûr de vouloir supprimer cette partie ?') ? true : false);">Annuler</a>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>

	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">Créer une nouvelle partie</div>
	<div class="panel-body">

		<form class="form-horizontal" role="form" method="post">
			<div class="form-group <?php echo ((isset($form_errors['perso'])) ? 'has-error' : ''); ?>">
				<label for="perso" class="col-sm-3 control-label">Personnage</label>
				<div class="col-sm-9">
					<?php foreach ($characters_list as $character): ?>
						<label class="text-center">
							<div class="face-<?php echo $character->getRef(); ?> default"></div>
							<?php echo $character->getName(); ?><br />
							<input type="radio" name="perso" value="<?php echo $character->getId(); ?>" <?php echo ((Utils::postValue('perso') == $character->getId()) ? 'checked' : ''); ?>>
						</label>&nbsp;
					<?php endforeach; ?>

					<?php if (isset($form_errors['perso'])): ?>
						<div class="help-block"><?php echo $form_errors['perso']; ?></div>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group text-center">
				<button type="submit" class="btn btn-sm btn-primary" name="submit" value="new_game">Créer !</button>
			</div>
		</form>

	</div>
</div>