<?php $this->_title = 'Score des journées'; ?>
<div class="row point">
	<div class="col-12">
		<div class="row paging mt-4 justify-content-center">
			<nav>
				<ul class="pagination flex-wrap ">
				<?php 
				for($i=20;$i<=39;$i++)
				{
				?>
					<li class="page-item <?php if($day==$i){echo "active";} ?>"><a class="page-link" href="index.php?controller=dayPoint&action=default&id=<?= $i;?>"><?= $i;?></a></li>
				<?php
				}
				?>
				</ul>
			</nav>	
		</div>
		<div class="row daypoint mb-4 rounded border-dark border d-flex justify-content-center">
			<div class="col-12 text-center"><h2><span class="d-none d-sm-inline-block">JOURNEE</span><span class="d-inline-block d-sm-none">J </span> <?= $day;?></h2></div>
			<?php 
			//ON LISTE LES DONNEES DU TABLEAU D OBJET DAYPOINT
			if(empty($dayPoints))
			{
				echo "Il n'y a pas de Score pour cette journée";
			}
			else
			{
				$i=1;
				?>
				<table class="table table-striped">
					<tr><th>Classement</th><th>Pseudo</th><th>Point</th></tr>
				<?php
				foreach($dayPoints as $dayPoint)
				{
				?>
					<tr><td><?= $i;?></td><td><?=$dayPoint->getUser_id();?></td><td><?= $dayPoint->getDay_point();?></td></tr>

				<?php
				$i++;
				}
				?>
				</table>
				<?php
			}?>
		</div>
	</div>
</div>