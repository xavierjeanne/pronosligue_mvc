<?php $this->_title = 'Classement';?>
<div class="row ranking">
	<div class="col-12 ">
		<div class="row rankingtable rounded border-dark border mt-4 mb-4">
			<table class="table table-striped">
				<tr><th class="text-center">Classement</th><th>Pseudo</th><th class="text-left">Total</th><th>Bonus</th><th>Point</th></tr>
				<?php
				$i=1;
				//AFFICHAGE DU CLASSEMENT PAR POINT DES JOUEURS
				foreach($users as $user)
				{
				?>
					<tr><td class="text-center"><?= $i;?></td><td><img src="<?= $user->getAvatar();?>" alt="<?= $user->getAvatar();?>"/><?= $user->getPseudo();?></td><td class="text-left"><?= $user->getTotal_point();?></td><td><?= $user->getTotal_bonus();?></td><td><?= $user->getPoint();?></td></tr>

				<?php
				$i++;
				}
				?>
			</table>
		</div>
	</div>
</div>