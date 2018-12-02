<?php $this->title = 'Page profil'; ?>



<?php if(isset($user))
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