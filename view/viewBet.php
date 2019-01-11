<?php $this->_title = 'Pronostic';
//EN FONCTION DE LA VARIABLE TYPE ON AFFICHE DIFFENRENTE INFORMATION 
if(empty($type))
{
// SI LE TYPE EST VIDE ALORS ON AFFICHE LA JOURNEE A PRONOSTIQUER
?>
<div class="row bet">
	<div class="col-12">
		<div class="row paging mt-4 justify-content-center">
			<nav>
				<ul class="pagination flex-wrap ">
				<?php 
				for($i=20;$i<=39;$i++)
				{
				?>
					<li class="page-item <?php if($day==$i){echo "active";} ?>"><a class="page-link" href="index.php?controller=bet&action=default&id=<?= $i;?>"><?= $i;?></a></li>
				<?php
				}
				?>
				</ul>
			</nav>	
		</div>

		<div class="row betday mb-4 rounded border-dark border d-flex justify-content-center">
			<div class="col-12 text-center"><h2><span class="d-none d-sm-inline-block">JOURNEE</span><span class="d-inline-block d-sm-none">J </span> <?= $day;?></h2></div>
			<?php require_once 'components/message.php';
			if(empty($matchs))
			{
				echo "pas encore de journée rentrée";
			}
			else
			{
				//ON LISTE LES MATCH GRACE AU TABLEAU D OBJET $MATCHS
				?>
				<table class="table table-striped">
					<tr><th>Equipe domicile</th><th class="text-center">Pronos</th><th class="text-right">Equipe exterieur</th><th class="d-none d-sm-inline-block">Date limite</th></tr>
				<?php
				$i=0;
				foreach($matchs as $match)
				{
					?>
					<tr><td class="text-left"><?=$match->getHome_team();?></td><td class="text-center"><?php if(!empty($bets)){ echo $bets[$i]->getBet();}?></td><td class="text-right"><?= $match->getOutside_team();?></td><td class="d-none d-sm-inline-block"><?= $match->getDeadline();?></td></tr>	
					<?php
					$i++;
				}
				?>
				</table>
				<?php
				// ON VERIFIE SI LES PRONOS ONT DEJA ETAIT FAIS POUR AFFICHER LE BON LIEN
				if(empty($bets))
				{
				?>
					<a href="index.php?controller=Bet&action=addBet&id=<?= $match->getDay();?>" class="btn btn-dark " role="button">Faire vos pronsotics</a>
				<?php
				}
				else
				{
				?>
					<a href="index.php?controller=Bet&action=updateBet&id=<?= $match->getDay();?>" class="btn btn-dark " role="button">Modifier vos pronsotics</a>
				<?php
				}
			}
		echo "</div>";
	echo "</div>";
echo "</div>";
}
//SI LE TYPE EST ADDBET ALORS ON AFFICHE LE FORMUALIRE POUR EFFECTUER SES PRONOS
elseif($type=='addBet')
{
?>
<div class="row bet">
	<div class="col-12 mt-4">
		<div class="row betday mb-4 rounded border-dark border d-flex justify-content-center">
			<div class="col-12 text-center"><h2><span class="d-none d-sm-inline-block">JOURNEE</span><span class="d-inline-block d-sm-none">J </span> <?= $day;?></h2></div>
			<form method="post" action="index.php" class="text-center">
				<input type="hidden" name="controller" value="Bet">
			    <input type="hidden" name="action" value="addBet">
			    <input type="hidden" name="id" value="<?= $day;?>">
			    <input type="hidden" name="user_id" value="<?= $_SESSION['id'];?>">
			    <?php
			    $i=1;
			    foreach($matchs as $match)
			    {
			    date_default_timezone_set("Europe/Paris");
			    $deadline=$match->getDeadline();
			    $now = date("d-m-Y  H:i:s", time());
			    ?>
			   
			    <input type="hidden" name="match_id<?= $i;?>" value="<?= $match->getId();?>">
			 	<p><?= $match->getHome_team();?>--<?= $match->getOutside_team();?></p>
			 	<p>Date limite : <?= $deadline;?></p>
			    <?php 
			    // SI LA DEADLINE EST DEPASSE LE MATCH NE PEUT PLUS ETRE PRONOSTIQUER ET LE PARI VAUT 0
			    if(strtotime($deadline)>=strtotime($now))
			     	{
			     		?>
			     		
  							
							   <input type="radio" name="bet<?= $i;?>" id="option1" value="1" /> 1
							
	  						
	    						<input type="radio" name="bet<?= $i;?>" id="option2" value="2" checked/>N
	  						
	    						<input type="radio" name="bet<?= $i;?>" id="option3" value="3"/>2
	  					
						
			     		<hr/>
			     		<?php
			     	}
			     	else
			     	{
			     	?>
			     		<div class="alert alert-danger" role="alert">Match deja commencé.</div>
			     		<input  type="hidden" name="bet<?= $i;?>"  value="0"  /><br/>
			     	<?php
			     	}
			    $i++;
			    }
				?>
			<input type="submit" name="submit" class="btn btn-dark " role="button" value="Valider" />
			</form>
		</div>
	</div>
</div>
<?php
}
else
//LE TYPE EST UPDATE DONC ON AFFICHE LE FORMUALIRE POUR MODIFIER SES PRONOSTICS
{
?>
<div class="row bet">
	<div class="col-12 mt-4">
		<div class="row betday mb-4 rounded border-dark border d-flex justify-content-center">
			<div class="col-12 text-center"><h2><span class="d-none d-sm-inline-block">JOURNEE</span><span class="d-inline-block d-sm-none">J </span> <?= $day;?></h2></div>
			<form method="post" action="index.php" class="text-center">
				<input type="hidden" name="controller" value="Bet">
			    <input type="hidden" name="action" value="updateBet">
			    <input type="hidden" name="id" value="<?= $day;?>">
			    <input type="hidden" name="user_id" value="<?= $_SESSION['id'];?>">
			    <?php
			    $i=1;
			    $j=0;
			    foreach($matchs as $match)
			    {
			    date_default_timezone_set("Europe/Paris");
			    $deadline=$match->getDeadline();
			    $now = date("d-m-Y  H:i:s", time());
			    ?>
				
			    <input type="hidden" name="match_id<?= $i;?>" value="<?= $match->getId();?>">
			 	<p><?= $match->getHome_team();?>--<?= $match->getOutside_team();?></p>
			    <p>Date limite : <?= $deadline;?></p>
			    <?php if(strtotime($deadline)>=strtotime($now))
			     	{
			     		$bet=$bets[$j]->getBet();
			     		?>
			     		
  							
							   <input type="radio" name="bet<?= $i;?>" id="option1" value="1" <?php if($bet==1){echo "checked";}?>/> 1
							
	    						<input type="radio" name="bet<?= $i;?>" id="option2" value="2" <?php if($bet==2){echo "checked";}?>/>N
	  						
	    						<input type="radio" name="bet<?= $i;?>" id="option3" value="3" <?php if($bet==3){echo "checked";}?>/>2
	  						
						
			     		<hr/>
			     		<?php
			     	}
			     	else
			     	{
			     	?>
			     		<div class="alert alert-danger" role="alert">Match deja commencé.</div>
			     		<input  type="hidden" name="bet<?= $i;?>"  value="<?= $bets[$j]->getBet();?>"  /><br/>
			     	<?php
			     	}
			    $j++;
			    $i++;
			    }
				?>
			<input type="submit" name="submit" class="btn btn-dark " role="button" value="Valider" />
			</form>
		</div>
	</div>
</div>
	<?php
}
?>