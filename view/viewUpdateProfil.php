<?php $this->title = 'Modification des infos'; ?>
<legend>Modification des infos persos</legend>
<form method="post" action="index.php">
	<input type="hidden" name="controller" value="profil">
    <input type="hidden" name="action" value="updateProfil">
    <input type="hidden" name="id" value="">
    <input id="pseudo" name="pseudo" type="text" placeholder="Votre pseudo" required value="<?php if(isset($_SESSION['pseudo_modification'])){ echo $_SESSION['pseudo_modification'];}else{ echo $user->getPseudo();};?>"/><br />
    <input id="email" name="email" type="email" placeholder="Votre email" required value="<?php if(isset($_SESSION['email_modification'])){ echo $_SESSION['email_modification'];}else{ echo $user->getEmail();};?>"/><br />
    <input id="password" name="password" type="password" placeholder="Votre nouveau mot de passe" required /><br />
    <input id="password_check" name="password_check" type="password" placeholder="retaper votre mot de passe" required /><br />
    <input type="submit" name="submit" value="Modification" />
</form>

<?= $error;?>