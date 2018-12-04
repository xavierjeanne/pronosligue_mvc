<?php $this->title = 'Classement';?>
<table>
		<tr><th>Classement</th><th>Pseudo</th><th>Point</th></tr>
	<?php
	$i=1;
	foreach($users as $user)
	{
	?>
		<tr><td><?= $i;?></td><td><?= $user->getPseudo();?></td><td><?= $user->getTotal_point();?></td></tr>

	<?php
	$i++;
	}
	?>
</table>