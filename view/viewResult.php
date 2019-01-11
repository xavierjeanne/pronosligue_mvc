<?php $this->_title = 'Résultat'; ?>
<div class="row result">
	<div class="col-12">
		<div class="row paging mt-4 justify-content-center">
			<nav>
				<ul class="pagination flex-wrap ">
				<?php 
				for($i=20;$i<=39;$i++)
				{
				?>
					<li class="page-item <?php if($day==$i){echo "active";} ?>"><a class="page-link" href="index.php?controller=result&action=default&id=<?= $i;?>"><?= $i;?></a></li>
				<?php
				}
				?>
				</ul>
			</nav>	
		</div>
		<div class="row resulttable mb-4 rounded border-dark border d-flex justify-content-center">
			<div class="col-12 text-center"><h2><span class="d-none d-sm-inline-block">JOURNEE</span><span class="d-inline-block d-sm-none">J </span> <?= $day;?></h2></div>
			<?php 
			if(empty($matchs))
			{
				echo "pas encore de journée rentrée";
			}
			else
			{
				?>
				<table class="table table-striped">
					<tr><th>Equipe domicile</th><th class="text-center">Resultat</th><th class="text-right">Equipe exterieur</th></tr>
				<?php
				$i=0;
				//ON LISTE LES MATCHS DE LA JOURNNEE
				foreach($matchs as $match)
				{	
				?>
					<tr class="border border-dark"><td><?=$match->getHome_team();?></td><td class="text-center"><?= $match->getScore();?></td><td class="text-right"><?= $match->getOutside_team();?></td></tr>
					<?php
					for($j=0;$j<$count_bets;$j++)
					{
					?>
					<tr><td class="avatar"><img src="<?= $bets[$i][$j]['avatar'];?>" alt="<?= $bets[$i][$j]['avatar'];?>"/><?= $bets[$i][$j]['pseudo'];?></td><td class="text-center">
						<?php 
						//AFFICHAGE DES PARIS DE CHAQUE JOUEUR PAR MATCH
						if(($bets[$i][$j]['bet'])==0)
						{
							echo "<img src=\"assets/img/design/pasdeprono.png\" alt=\"Pas de pronos\"/>";
						}
						elseif(($bets[$i][$j]['bet'])==1)
						{
							echo "<img src=\"assets/img/design/victoire.png\" alt=\"Victoire\"/>";
						}
						elseif(($bets[$i][$j]['bet'])==2)
						{
							echo "<img src=\"assets/img/design/match_nul.png\" alt=\"Match nul\"/>";
						}
						else
						{
							echo "<img src=\"assets/img/design/defaite.png\" alt=\"Defaite\"/>";
						}
						?></td><td></td></tr>
					<?php
					}
				$i++;
				}
				?>
				</table>
			<?php
			}
		echo"</div>";
	echo"</div>";
echo"</div>";