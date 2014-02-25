
<section class="panel">

	<div class="struct"></div>

	<div id="battle-zone" class="vcenter">

		<div class="media">
			<div class="pull-right face-<?php echo $monster->getRef(); ?> default"></div>
			<div class="media-body">
				<h4 class="media-heading"><?php echo $monster->getName(); ?></h4>
				<div class="progress progress-striped">
					<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
						<span class="">40%</span>
					</div>
				</div>
			</div>
		</div>

		<div id="versus">Versus</div>

		<div class="media">
			<div class="pull-left face-<?php echo $perso->getRef(); ?> default"></div>
			<div class="media-body">
				<h4 class="media-heading">Guillaume Le Conquérant</h4>
				<div class="progress progress-striped">
					<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100" style="width: 68%">
						<span class="">68%</span>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div id="battle-log" class="vcenter">

		<div class="infos">
		
			<?php
				echo($_SESSION['messageLog']['speed']) . '<br>';
				echo($_SESSION['messageLog']['attack']) . '<br>';
				echo($_SESSION['messageLog']['receive']) . '<br>';
			?>

		</div>

		<div class="text-center">
			<a href="#" title="Attaquer" class="btn btn-lg btn-primary">Attaquer</a>
			<a href="#" title="Défendre" class="btn btn-lg btn-primary">Défendre</a>
		</div>

	</div>

</section>