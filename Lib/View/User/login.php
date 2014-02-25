<?php
use Lib\Utils;
?>
<h1>Connexion</h1>

<form class="form-horizontal" role="form" method="post">
	<div class="form-group <?php echo ((isset($form_errors['username'])) ? 'has-error' : ''); ?>">
		<label for="username" class="col-sm-3 control-label">Nom d'utilisateur</label>
		<div class="col-sm-9">
			<input type="text" class="form-control" id="username" name="username" placeholder="Nom d'utilisateur" value="<?php echo Utils::postValue('username'); ?>">
			<?php if (isset($form_errors['username'])): ?>
				<div class="help-block"><?php echo $form_errors['username']; ?></div>
			<?php endif; ?>
		</div>
	</div>

	<div class="form-group <?php echo ((isset($form_errors['password'])) ? 'has-error' : ''); ?>">
		<label for="password" class="col-sm-3 control-label">Mot de passe</label>
		<div class="col-sm-9">
			<input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe">
			<?php if (isset($form_errors['password'])): ?>
				<div class="help-block"><?php echo $form_errors['password']; ?></div>
			<?php endif; ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9">
			<button type="submit" class="btn btn-lg btn-primary">Se connecter</button>
		</div>
	</div>
</form>