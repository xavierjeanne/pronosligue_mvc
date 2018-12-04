<?php $this->title = 'Connection'; ?>
<legend>Connexion</legend>
<form method="post" action="index.php">
	<input type="hidden" name="controller" value="connection">
    <input type="hidden" name="action" value="connection">
    <input type="hidden" name="id" value="">
    <input id="pseudo" name="pseudo" type="text" placeholder="Votre pseudo" required value="<?php if(isset($_SESSION['pseudo_connection'])){ echo $_SESSION['pseudo_connection'];};?>"/><br />
    <input id="password" name="password" type="password" placeholder="Votre password" required /><br />
    <input type="submit" name="submit" value="Connection" />
</form>
<p><?= $error;?></p>
<p><a href="inscription">Inscription</a></p>
