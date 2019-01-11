<?php $this->_title = 'Page profil'; ?>

<div class="row profil">
	<div class="col-12 mt-4 mb-4">
		<div class="row profilinfo rounded border-dark border">
			<div class="col-12 text-center"><h2><i class="fas fa-users"></i>Profil</h2></div>
			<div class="col-12 text-center">
			<?php require_once 'components/message.php';?>
			</div>
			<div class="col-12 text-center">
				<p><?= $user->getPseudo();?></p>
				<p><?php $avatar=$user->getAvatar();?><img src="<?= $avatar;?>" alt="<?= $avatar;?>"/></p>
				<p><?= $user->getEmail();?></p>
				<p class="update"><a href="index.php?controller=profil&action=updateProfil" title="Modifier"><i class="fas fa-users-cog"></i></a></p>
			</div>
			<div class="col-12 profilpoint text-center">
				<div class="col-12 text-center"><h2>Point par journée</h2></div>
				<div class="table-responsive">
					<table class="table mt-3">
						<thead class="thead-dark">
							<tr>
								<?php 
								for($i=1;$i<20;$i++)
								{
									echo "<th>$i</th>";
								}
								?>
							</tr>
						</thead>
						<tr>
							<?php 
							for($j=0;$j<19;$j++)
							{
								if(isset($dayspoints[$j]))
								{
									$point=$dayspoints[$j]->getDay_point();
										echo "<th>$point</th>";	
								}
								else
								{
									echo "<th>--</th>";	
								}
							}
							?>
						</tr>
					</table>
				</div>
			</div>
			<div class="col-12 profilpodium text-center">
				<div class="row">
					<div class="col-12 col-lg-6 text-center">
						<h2>Podium</h2>
						<p class="text-left"><img src="<?= $podium1->getFlag();?>"/><?= $podium1->getName();?></p>
						<p class="text-left"><img src="<?= $podium2->getFlag();?>"/><?= $podium2->getName();?></p>
						<p class="text-left"><img src="<?= $podium3->getFlag();?>"/><?= $podium3->getName();?></p>
						<a class="btn btn-success" href="index.php?controller=Profil&action=podium">Modifier</a>
					</div>
					<div class="col-12 col-lg-6 text-center">
						<h2>Relégable</h2>
						<p class="text-left"><img src="<?= $relegation18->getFlag();?>"/><?= $relegation18->getName();?></p>
						<p class="text-left"><img src="<?= $relegation19->getFlag();?>"/><?= $relegation19->getName();?></p>
						<p class="text-left"><img src="<?= $relegation20->getFlag();?>"/><?= $relegation20->getName();?></p>
						<a class="btn btn-success" href="index.php?controller=Profil&action=podium">Modifier</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	
