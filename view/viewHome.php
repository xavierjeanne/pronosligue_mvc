<?php $this->title = 'Accueil'; ?>



<?php if(isset($users))
{
	foreach($users as $user )
	{
	?>
		<a href="home/display/<?= $user->getId();?>"><?= $user->getPseudo();?></a>

	<?php
	}
}
elseif(isset($user))
{
	echo $user->getPseudo();
	echo "<br/>";
	echo $user->getId();

}
else
{
	echo "pas de client";
}
?>



