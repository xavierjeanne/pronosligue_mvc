<?php $this->title = 'Page profil'; ?>

<?php if(isset($user))
{
	echo $user->getPseudo();
	echo "<br/>";
	echo $user->getId();
	echo $user->getEmail();
	echo "<p><a href=\"profil/updateProfil\">Modifier</a></p>";
}
else
{
	echo "pas de client";
}
?>
<?php
if(isset($message))
{
	echo $message;
}