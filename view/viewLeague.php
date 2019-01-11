<?php $this->_title = 'Ligue 1';?>
<div class="row league">
	<div class="col-12">
		<div class="row leaguetable rounded border-dark border mt-4 mb-4">
			<div class="table-responsive">
				<table class="table table-striped">
					<tr><th>Classement</th><th >Fanion</th><th class="d-none d-md-inline-block">Nom du club</th><th>Pts</th><th>J</th><th>G</th><th>N</th><th>P</th><th>Bp</th><th>Bc</th><th>Db</th></tr>
					<?php
					$i=1;
					//ON PRESENTE LE CLASSEMENT DES EQUIPES PAR POINTS
					foreach($teams as $team)
					{
					?>
						<tr><td><?= $i;?></td><td><img src="<?= $team->getFlag();?>" alt="<?= $team->getName();?>"/></td><td class="d-none d-md-inline-block"><?= $team->getName();?></td><td><?= $team->getPoint();?></td><td><?= $team->getDay();?></td><td><?= $team->getWon();?></td><td><?= $team->getDrawn();?></td><td><?= $team->getLost();?></td><td><?= $team->getGoal_for();?></td><td><?= $team->getGoal_against();?></td><td><?= $team->getGoal_difference();?></td></tr>

					<?php
					$i++;
					}
					?>
				</table>
			</div>
		</div>
	</div>
</div>