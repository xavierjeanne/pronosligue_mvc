<?php $this->title = 'Classement';?>
<table>
		<tr><th>Classement</th><th>Fanion</th><th>Nom du club</th><th>Pts</th><th>J</th><th>G</th><th>N</th><th>P</th><th>Bp</th><th>Bc</th><th>Db</th></tr>
	<?php
	$i=1;
	foreach($teams as $team)
	{
	?>
		<tr><td><?= $i;?></td><td><img src="<?= $team->getFlag();?>" alt="<?= $team->getName();?>"/></td><td><?= $team->getName();?></td><td><?= $team->getPoint();?></td><td><?= $team->getDay();?></td><td><?= $team->getWon();?></td><td><?= $team->getDrawn();?></td><td><?= $team->getLost();?></td><td><?= $team->getGoal_for();?></td><td><?= $team->getGoal_against();?></td><td><?= $team->getGoal_difference();?></td></tr>

	<?php
	$i++;
	}
	?>
</table>