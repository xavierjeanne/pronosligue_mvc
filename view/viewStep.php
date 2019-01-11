<?php $this->_title = 'Page Etape'; ?>

<div class="row profil">
	<div class="col-12 mt-4">
		<div class="row profilinfo rounded border-dark border">
			<div class="col-12 text-center"><h2><i class="fas fa-users"></i>Vous devez choisir les équipes sur le podium et les relégables</h2></div>
			<div class="col-12 text-center">
				<?php require_once 'components/message.php';?>
			</div>
			<div class="col-12 text-center">
				<form method="post" action="index.php" class="text-center">
					<input type="hidden" name="controller" value="Step">
					<input type="hidden" name="action" value="">
					<input type="hidden" name="id" value="">
					<input type="hidden" name="user_id" value="<?= $_SESSION['id'];?>">
				<p class="text-left alert alert-success">Vous obtenez un point par bonne équipe classée, trois pour deux et cinq pour le tiercé dans l'ordre pour le podium et les relégables. Vous pouvez donc obtenir 10 points au maximum. Les points sont validés à la fin du jeu</p>
				<div class="form-group row">
					<label for="name" class="col-sm-3 col-form-label  text-left">Podium 1 :</label>
	                <div class="col-sm-9">
					   	<select class="form-control" name="podium1">
	                        <?php 
	                        foreach($teams as $team)
	                        {
	                        	$name=$team->getName();
	                        	$id=$team->getId();
	                        	$ranking=$team->getRanking();
	                        	echo "<option value=\"$id\">$name ($ranking)</option>";
	                        }
	                        ?>
	                    </select>
					</div>
				</div>
				<div class="form-group row">
					<label for="alias" class="col-sm-3 col-form-label  text-left">Podium 2 :</label>
	                <div class="col-sm-9">
		    			<select class="form-control" name="podium2">
	                        <?php 
	                        foreach($teams as $team)
	                        {
	                        	$name=$team->getName();
	                        	$id=$team->getId();
	                        	$ranking=$team->getRanking();
	                        	echo "<option value=\"$id\">$name ($ranking)</option>";
	                        }
	                        ?>
	                    </select>
		    		</div>
		    	</div>
		    	<div class="form-group row">
					<label for="town" class="col-sm-3 col-form-label  text-left">Podium 3 :</label>
	                <div class="col-sm-9">
		   				<select class="form-control" name="podium3">
	                        <?php 
	                        foreach($teams as $team)
	                        {
	                        	$name=$team->getName();
	                        	$id=$team->getId();
	                        	$ranking=$team->getRanking();
	                        	echo "<option value=\"$id\">$name ($ranking)</option>";
	                        }
	                        ?>
	                    </select>
		   			</div>
		   		</div>
		   		<div class="form-group row">
					<label for="name" class="col-sm-3 col-form-label  text-left">Relégable 18 :</label>
	                <div class="col-sm-9">
					   	<select class="form-control" name="relegation18">
	                        <?php 
	                        foreach($teams as $team)
	                        {
	                        	$name=$team->getName();
	                        	$id=$team->getId();
	                        	$ranking=$team->getRanking();
	                        	echo "<option value=\"$id\">$name ($ranking)</option>";
	                        }
	                        ?>
	                    </select>
					</div>
				</div>
				<div class="form-group row">
					<label for="alias" class="col-sm-3 col-form-label  text-left">Relégable 19 :</label>
	                <div class="col-sm-9">
		    			<select class="form-control" name="relegation19">
	                        <?php 
	                        foreach($teams as $team)
	                        {
	                        	$name=$team->getName();
	                        	$id=$team->getId();
	                        	$ranking=$team->getRanking();
	                        	echo "<option value=\"$id\">$name ($ranking)</option>";
	                        }
	                        ?>
	                    </select>
		    		</div>
		    	</div>
		    	<div class="form-group row">
					<label for="town" class="col-sm-3 col-form-label  text-left">Relégable 20 :</label>
	                <div class="col-sm-9">
		   				<select class="form-control" name="relegation20">
	                        <?php 
	                        foreach($teams as $team)
	                        {
	                        	$name=$team->getName();
	                        	$id=$team->getId();
	                        	$ranking=$team->getRanking();
	                        	echo "<option value=\"$id\">$name ($ranking)</option>";
	                        }
	                        ?>
	                    </select>
		   			</div>
		   		</div>
				<input type="submit" name="submit" class="btn btn-dark " role="button" value="Valider" />
				</form>
			</div>
		</div>
	</div>
</div>