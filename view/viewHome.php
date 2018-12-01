<?php $this->title = 'Accueil'; ?>

<form method="post" action="home/add">
    <input id="pseudo" name="pseudo" type="text" placeholder="Votre pseudo" required /><br />
    <input id="email" name="email" type="text" placeholder="Votre mail" required /><br />
    <input id="password" name="password" type="text" placeholder="Votre password" required /><br />
    <input type="submit" value="Ajouter" />
</form>

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



