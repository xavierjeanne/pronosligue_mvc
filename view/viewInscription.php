<?php $this->title = 'Inscription'; ?>
<legend>Inscription</legend>
<form method="post" action="index.php">
	<input type="hidden" name="controller" value="inscription">
    <input type="hidden" name="action" value="inscription">
    <input type="hidden" name="id" value="">
    <input id="pseudo" name="pseudo" type="text" placeholder="Votre pseudo" required value="<?php if(isset($_SESSION['pseudo_inscription'])){ echo $_SESSION['pseudo_inscription'];};?>"/><br />
    <input id="email" name="email" type="email" placeholder="Votre email" required value="<?php if(isset($_SESSION['email_inscription'])){ echo $_SESSION['email_inscription'];};?>"/><br />
    <input id="password" name="password" type="password" placeholder="Votre mot de passe" required /><br />
    <input id="password_check" name="password_check" type="password" placeholder="retaper votre mot de passe" required /><br />
    <input type="submit" name="submit" value="Inscription" />
</form>
<p><a href="connection/connection">Connection</a></p>
<?= $error;?>