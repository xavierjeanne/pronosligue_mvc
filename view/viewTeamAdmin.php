<?php $this->_title = 'Administration des équipes';
// SI LE TYPE EST VIDE ON AFFICHE LA LISTE DES EQUIPES
if(empty($type))
{
?>
	<div class="row admin">
		<div class="col-12">
			<div class="row adminnav mt-4 mb-4 rounded border-dark border d-flex justify-content-center">
			<?php require_once 'components/message.php';?>
				<table class="table table-striped">
					<tr><th class="d-none d-sm-inline-block">Fanion</th><th class="d-none d-sm-inline-block">Maillot</th><th>Diminutif</th><th>Nom du club</th><th>Modifier</th></tr>
				<?php
				foreach($teams as $team)
				{
				?>
					<tr><td class="d-none d-sm-inline-block"><img src="<?= $team->getFlag();?>" alt="<?= $team->getName();?>"/></td><td class="d-none d-sm-inline-block"><img src="<?= $team->getJersey();?>" alt="<?= $team->getName();?>"/></td><td><?= $team->getAlias();?></td><td><?= $team->getName();?></td><td class="modifier"><a href="index.php?controller=teamAdmin&action=updateTeam&id=<?= $team->getId();?>"><i class="fas fa-pen-square"></i></a></td></tr>
				<?php
				}
				?>
				</table>
				<div class="col-12 mt-4  text-center">
					<a class="btn btn-dark" href="index.php?controller=TeamAdmin&action=addTeam">Ajouter</a>
				</div>
			</div>
		</div>
	</div>
<?php	
}
//SI LE TYPE EST ADDTEAM ON AFFICHE LE FORMUALIRE POUR L AJOUT D UNE EQUIPE
elseif($type=='addTeam')
{
?>
	<div class="row admin">
		<div class="col-12">
			<div class="row adminnav mt-4 mb-4 rounded border-dark border d-flex justify-content-center">
				<div class="col-12 text-center"><h2><i class="fas fa-users-cog"></i> Ajouter une équipe</h2></div>
				<div class="col-12 mt-4 mb-4 text-center">
				<?php require_once 'components/message.php';?>
				<form method="post" action="index.php">
					<input type="hidden" name="controller" value="teamAdmin">
				    <input type="hidden" name="action" value="addTeam">
				    <input type="hidden" name="id" value="">
				    <div class="form-group row">
				     	<label for="name" class="col-sm-3 col-form-label  text-left">Nom du club :</label>
                    	<div class="col-sm-9">
				    		<input class="form-control" id="name" name="name" type="text" placeholder="Nom de l'équipe" required/>
				    	</div>
				    </div>
				    <div class="form-group row">
				     	<label for="alias" class="col-sm-3 col-form-label  text-left">Nom du club :</label>
                    	<div class="col-sm-9">
	    					<input class="form-control" id="alias" name="alias" type="text" placeholder="Alias" required /><br />
	    				</div>
	    			</div>
	    			<div class="form-group row">
				     	<label for="town" class="col-sm-3 col-form-label  text-left">Nom du club :</label>
                    	<div class="col-sm-9">
	   						<input class="form-control" id="town" name="town" type="text" placeholder="Nom de la ville" required/><br/>
	   					</div>
	   				</div>
	    			<div class="form-group row">
                    	<div class="col-12">
                        	<input type="submit" name="submit" class="btn btn-dark" value="Ajouter"/>
                    	</div>
                	</div>
            	</form><br/>
				</div>
			</div>
		</div>
	</div>
<?php
}
//SI LE TYPE EST UPDATE ON AFFICHE LE FORMUALIRE D UPDATE
else
{
?>
	<div class="row admin">
		<div class="col-12">
			<div class="row adminnav mt-4 mb-4 rounded border-dark border d-flex justify-content-center">
				<div class="col-12 text-center"><h2><i class="fas fa-users-cog"></i> Ajouter une équipe</h2></div>
				<div class="col-12 mt-4 mb-4 text-center">
				<?php require_once 'components/message.php';?>
				<form method="post" action="index.php">
				<input type="hidden" name="controller" value="teamAdmin">
			    <input type="hidden" name="action" value="updateTeam">
			    <input type="hidden" name="id" value="<?= $team->getId();?>">
			    <div class="form-group row">
				    <label for="name" class="col-sm-3 col-form-label  text-left">Nom du club :</label>
                    <div class="col-sm-9">
			    		<input  class="form-control" id="name" name="name" type="text" placeholder="Nom de l'équipe" value="<?= $team->getName();?>" required/>
			    	</div>
			    </div>
			    <div class="form-group row">
				    <label for="alias" class="col-sm-3 col-form-label  text-left">Nom du club :</label>
                    <div class="col-sm-9">
	    				<input class="form-control" id="alias" name="alias" type="text" placeholder="Alias" value="<?= $team->getAlias();?>" required />
	    			</div>
	    		</div>
	    		<div class="form-group row">
				    <label for="town" class="col-sm-3 col-form-label  text-left">Nom du club :</label>
                    <div class="col-sm-9">
	    				<input class="form-control" id="town" name="town" type="text" placeholder="Nom de la ville" required/>
	    			</div>
	    		</div>
	    		<div class="form-group row">
				    <label for="town" class="col-sm-3 col-form-label  text-left">Journee :</label>
                    <div class="col-sm-9">
	    				<input class="form-control" id="day" name="day" type="text" placeholder="Journée" required/>
	    			</div>
	    		</div>
	    		<div class="form-group row">
				    <label for="town" class="col-sm-3 col-form-label  text-left">Point :</label>
                    <div class="col-sm-9">
	    				<input class="form-control" id="point" name="point" type="text" placeholder="Point" required/>
	    			</div>
	    		</div>
	    		<div class="form-group row">
				    <label for="town" class="col-sm-3 col-form-label  text-left">Victoire :</label>
                    <div class="col-sm-9">
	    				<input class="form-control" id="won" name="won" type="text" placeholder="Victoire" required/>
	    			</div>
	    		</div>
	    		<div class="form-group row">
				    <label for="town" class="col-sm-3 col-form-label  text-left">Match nul :</label>
                    <div class="col-sm-9">
	    				<input class="form-control" id="drawn" name="drawn" type="text" placeholder="Match nul" required/>
	    			</div>
	    		</div>
	    		<div class="form-group row">
				    <label for="town" class="col-sm-3 col-form-label  text-left">Defaite :</label>
                    <div class="col-sm-9">
	    				<input class="form-control" id="lost" name="lost" type="text" placeholder="Défaite" required/>
	    			</div>
	    		</div>
	    		<div class="form-group row">
				    <label for="town" class="col-sm-3 col-form-label  text-left">But pour :</label>
                    <div class="col-sm-9">
	    				<input class="form-control" id="goal_for" name="goal_for" type="text" placeholder="But pour" required/>
	    			</div>
	    		</div>
	    		<div class="form-group row">
				    <label for="town" class="col-sm-3 col-form-label  text-left">But contre :</label>
                    <div class="col-sm-9">
	    				<input class="form-control" id="goal_against" name="goal_against" type="text" placeholder="But contre" required/>
	    			</div>
	    		</div>
	    		<div class="form-group row">
                    <div class="col-12">
                        <input type="submit" name="submit" class="btn btn-dark" value="Ajouter"/>
                    </div>
                </div>
     			</form>
     			</div>
     		</div>
     	</div>
    </div>
<?php
}