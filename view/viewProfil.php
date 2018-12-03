<?php $this->title = 'Page profil'; ?>

<?php if(isset($user))
{
	echo $user->getPseudo();
	echo "<br/>";
	echo $user->getId();
	echo $user->getEmail();
}
else
{
	echo "pas de client";
}
?>