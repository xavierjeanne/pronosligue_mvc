<?php $this->_title = 'Modification du profil'; ?>
<div class="row updateprofil">
    <div class="col-12 mt-4">
        <div class="row updateprofilform rounded border-dark border">
            <div class="col-12 text-center"><h2><i class="fas fa-users-cog"></i> Modifier le profil</h2></div>
            <div class="col-12 mt-4 mb-4 text-center">
            <?php require_once 'components/message.php';?>
            <form method="post" action="index.php">
                <div class="form-group row">
                	<input type="hidden" name="controller" value="profil">
                    <input type="hidden" name="action" value="updateProfil">
                    <input type="hidden" name="id" value="">
                    <label for="pseudo" class="col-sm-3 col-form-label  text-left">Pseudo :</label>
                    <div class="col-sm-9">
                        <input class="form-control" id="pseudo" name="pseudo" type="text" placeholder="Votre pseudo" required value="<?php if(isset($_SESSION['pseudo_modification'])){ echo $_SESSION['pseudo_modification'];}else{ echo $user->getPseudo();};?>"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label text-left">Email :</label>
                    <div class="col-sm-9 ">
                        <input class="form-control" id="email" name="email" type="email" placeholder="Votre email" required value="<?php if(isset($_SESSION['email_modification'])){ echo $_SESSION['email_modification'];}else{ echo $user->getEmail();};?>"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="avatar" class="col-sm-3 col-form-label text-left">Club de coeur :</label>
                    <div class="col-sm-9 ">
                        <select class="form-control" name="avatar">
                        	<?php 
                        	foreach($teams as $team)
                        		{
                        			$name=$team->getName();
                        			$jersey=$team->getJersey();
                        			echo "<option value=\"$jersey\">$name</option>";
                        		}
                        	?>
                        	<option value="assets/img/jersey/pronosligue.png" selected>pas de club de coeur</option>
                        </select>
                    </div>
                 </div>
                 <div class="form-group row">
                    <label for="password" class="col-sm-3 col-form-label text-left">Mot de passe :</label>
                    <div class="col-sm-9 ">
                        <input class="form-control" id="password" name="password" type="password" placeholder="Votre nouveau mot de passe" required />
                    </div>
                </div>
                 <div class="form-group row">
                    <label for="password_check" class="col-sm-3 col-form-label text-left">Retaper le mot de passe :</label>
                    <div class="col-sm-9 ">
                        <input  class="form-control" id="password_check" name="password_check" type="password" placeholder="retaper votre mot de passe" required />
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <input type="submit" name="submit" class="btn btn-dark" value="Modification"/>
                    </div>
                </div>
            </form><br/>
            </div>
            <div class="col-12 text-center">
                <a href="index.php?controller=profil">Retour au profil</a>
            </div>
        </div>
    </div>
</div>

