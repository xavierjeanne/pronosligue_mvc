<?php $this->title = 'Page admin des equipes';
if(empty($type))
{
	if(!empty($message))
	{
		echo $message;
	}
	?>
	<p><a href="teamAdmin/addTeam" >Ajouter uen équipe</a></p>
	<table>
		<tr><th>Fanion</th><th>Maillot</th><th>Diminutif</th><th>Nom du club</th></tr>
	<?php
	foreach($teams as $team)
	{
	?>
		<tr><td><img src="<?= $team->getFlag();?>" alt="<?= $team->getName();?>"/></td><td><img src="<?= $team->getJersey();?>" alt="<?= $team->getName();?>"/></td><td><?= $team->getAlias();?></td><td><?= $team->getName();?><a href="teamAdmin/updateTeam/<?= $team->getId();?>">Modifier</a></td></tr>

	<?php
	}
	?>
	</table>
	<?php	
}
elseif($type=='addTeam')
{
?>
	<legend>Ajouter une équipe</legend>
	<form method="post" action="index.php">
		<input type="hidden" name="controller" value="teamAdmin">
	    <input type="hidden" name="action" value="addTeam">
	    <input type="hidden" name="id" value="">
	    <input id="name" name="name" type="text" placeholder="Nom de l'équipe" required/><br />
	    <input id="alias" name="alias" type="text" placeholder="Alias" required /><br />
	    <input id="town" name="town" type="text" placeholder="Nom de la ville" required/><br/>
	    <input type="submit" name="submit" value="Ajouter" />
	</form>
<?php
}
else
{
?>
	<legend>Modifier une équipe</legend>
	<form method="post" action="index.php">
		<input type="hidden" name="controller" value="teamAdmin">
	    <input type="hidden" name="action" value="updateTeam">
	    <input type="hidden" name="id" value="<?= $team->getId();?>">
	    <input id="name" name="name" type="text" placeholder="Nom de l'équipe" value="<?= $team->getName();?>" required/><br />
	    <input id="alias" name="alias" type="text" placeholder="Alias" value="<?= $team->getAlias();?>" required /><br />
	    <input id="town" name="town" type="text" placeholder="Nom de la ville" required/><br/>
	    <input type="submit" name="submit" value="Modifier" />
	</form>
<?php
}