<?php $this->_title = 'Connection'; ?>
<div class="row connection">
	<div class="col-12 mt-4">
		<div class="row connection_form rounded border-dark border">
			<div class="col-12 text-center"><h2><i class="fas fa-users"></i> Connexion</h2></div>
			<div class="col-12 mt-4 mb-4 text-center">
			<?php require_once 'components/message.php';?>
				<form method="post" action="index.php">
					<div class="form-group row">
						<input type="hidden" name="controller" value="connection">
					    <input type="hidden" name="action" value="connection">
					    <input type="hidden" name="id" value="">
					    <label for="pseudo" class="col-sm-3 col-form-label  text-left">Pseudo :</label>
					    <div class="col-sm-9">
					    	<input class="form-control" id="pseudo" name="pseudo" type="text" placeholder="Votre pseudo" required value="<?php if(isset($_SESSION['pseudo_connection'])){ echo $_SESSION['pseudo_connection'];};?>"/>
					    </div>
					</div>
					<div class="form-group row">
					    <label for="password" class="col-sm-3 col-form-label text-left">Mot de passe :</label>
					    <div class="col-sm-9 ">
					    	<input class="form-control" id="password" name="password" type="password" placeholder="Votre password" required />
					    </div>
					</div>
  					<div class="form-group row">
    					<div class="col-12">
					    	<input type="submit" name="submit" class="btn btn-dark" value="Connection"/>
					    </div>
					</div>
				</form><br/>
			</div>
			<div class="col-12 text-center">
				<a href="index.php?controller=inscription">Inscription</a>
			</div>
		</div>
	</div>
</div>