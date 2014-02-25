<?php
use Lib\Utils;
?>
<h1>Inscription</h1>

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

	<div class="form-group <?php echo ((isset($form_errors['confirm_password'])) ? 'has-error' : ''); ?>">
		<label for="confirm_password" class="col-sm-3 control-label">Confirmer mot de passe</label>
		<div class="col-sm-9">
			<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirmer mot de passe">
			<?php if (isset($form_errors['confirm_password'])): ?>
				<div class="help-block"><?php echo $form_errors['confirm_password']; ?></div>
			<?php endif; ?>
		</div>
	</div>

	<div class="form-group <?php echo ((isset($form_errors['email'])) ? 'has-error' : ''); ?>">
		<label for="email" class="col-sm-3 control-label">Adresse email</label>
		<div class="col-sm-9">
			<input type="email" class="form-control" id="email" name="email"  placeholder="adresse@mail.com" value="<?php echo Utils::postValue('email'); ?>">
			<?php if (isset($form_errors['email'])): ?>
				<div class="help-block"><?php echo $form_errors['email']; ?></div>
			<?php endif; ?>
		</div>
	</div>

	<div class="form-group <?php echo ((isset($form_errors['perso'])) ? 'has-error' : ''); ?>">
		<label for="perso" class="col-sm-3 control-label">Personnage</label>
		<div class="col-sm-9">
			<label class="text-center">
				<div class="face-mage01 default"></div>
				Guillaume<br />
				<input type="radio" name="perso" value="1">
			</label>&nbsp;
			<label class="text-center">
				<div class="face-mage02 default"></div>
				Rozy<br />
				<input type="radio" name="perso" value="2">
			</label>&nbsp;
			<label class="text-center">
				<div class="face-mage04 default"></div>
				Johan<br />
				<input type="radio" name="perso" value="4">
			</label>&nbsp;
			<label class="text-center">
				<div class="face-mage03 default"></div>
				Kévina<br />
				<input type="radio" name="perso" value="3">
			</label>
			<?php if (isset($form_errors['perso'])): ?>
				<div class="help-block"><?php echo $form_errors['perso']; ?></div>
			<?php endif; ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9">
			<button type="submit" class="btn btn-lg btn-primary">S'inscrire</button>
		</div>
	</div>
</form>