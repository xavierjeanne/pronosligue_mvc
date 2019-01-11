<?php $this->_title = 'Accueil'; ?>

<div class="row">
	<div class="col-12 home pt-4">
		<div class="row day mb-4 rounded border-dark border">
			<div class="col-12">
				<div class="row text-center mb-2">
					<div class="col-12"><h2><span class="d-none d-sm-inline-block">JOURNEE</span><span class="d-inline-block d-sm-none">J </span> <?= $day;?></h2></div>
					<div class=" col-6 arrow-left">
					<?php if($day>20)
					{
						$id=$day-1;
						echo "<a href=\"index.php?controller=home&action=default&id=$id\"><i class=\"fas fa-arrow-alt-circle-left\"></i></a>";
					}
					?>
					</div>	
					<div class="col-6 arrow-right">
					<?php if($day<38)
					{
					$id=$day+1;
					echo "<a href=\"index.php?controller=home&action=default&id=$id\"><i class=\"fas fa-arrow-alt-circle-right\"></i></a>";
					}
					?>
					</div>	
				</div>
				<div class="row d-flex justify-content-center">
					<table class="table table-striped">
						<tr><th class="text-left">Domicile</th><th class="text-center">Score</th><th class="text-right">Exterieur</th></tr>
					<?php 
					//AFFICHAGE DE LA JOURNEE EN COURS OU CHOISIT
					foreach($matchs as $match)
					{
						$home_team=$match->getHome_team();
						$outside_team=$match->getOutside_team();
						$score=$match->getScore();
						echo "<tr class=\"align-middle\"><td class=\"text-left \">$home_team</td><td class=\"text-center\">$score</td><td class=\"text-right\">$outside_team</td></tr>";
					}
					?>
					</table>
				</div>
			</div>
		</div>
		<div class="row daymenu text-center border-dark border">
				<div class="col-12 col-lg-4"><a href="index.php?controller=bet&action=default&id=<?= $day;?>">Pronostic</a></div>
				<div class="col-12 col-lg-4"><a href="index.php?controller=result&action=default&id=<?= $day;?>">Résultat</a></div>
				<div class="col-12 col-lg-4 "><a href="index.php?controller=dayPoint&action=default&id=<?= $day;?>">Score</a></div>
		</div>
	</div>
</div>





