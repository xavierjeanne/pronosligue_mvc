<?php $this->_title = 'Administration des journées'; 
// SI LE TYPE EST VIDE ON AFFICHE LE FORMUALIRE POUR AFFICHER UNE JOURNEE
if(empty($type))
{
?>
	<div class="row admin">
		<div class="col-12">
			<div class="row paging mt-4 justify-content-center">
			<nav>
				<ul class="pagination flex-wrap ">
				<?php 
				for($i=20;$i<=39;$i++)
				{
				?>
					<li class="page-item <?php if($day==$i){echo "active";} ?>"><a class="page-link" href="index.php?controller=dayAdmin&action=default&id=<?= $i;?>"><?= $i;?></a></li>
				<?php
				}
				?>
				</ul>
			</nav>	
		</div>

			<div class="row adminnav mt-4 mb-4 rounded border-dark border d-flex justify-content-center">
				<div class="col-12 text-center"><h2><span class="d-none d-sm-inline-block">JOURNEE</span><span class="d-inline-block d-sm-none">J </span> <?= $day;?></h2></div>
				<?php require_once 'components/message.php';
				if(empty($matchs))
				{
					echo "pas encore de journée rentrée";
				}
				else
				{
				?>
					<table class="table table-striped">
						<tr><th>Equipe domicile</th><th class="text-right">Equipe exterieur</th><th class="d-none d-sm-inline-block">Date limite</th><th>Modifier</th><th>Valider</th></tr>
						<?php
						//ON LISTE LES MATCHS DE LA JOURNEE
						foreach($matchs as $match)
						{
						?>
						<tr><td class="text-left"><?=$match->getHome_team();?></td><td class="text-right"><?= $match->getOutside_team();?></td><td class="d-none d-sm-inline-block"><?= $match->getDeadline();?></td><td><a href="index.php?controller=dayAdmin&action=updateMatch&id=<?= $match->getId();?>" class="modifier" title="Modifier"><i class="fas fa-pen-square"></i></a></td><td><?php if($match->getScore()!=0){ echo "Déjà validé";}else{
						$id=$match->getId();echo" <a href=\"index.php?controller=score&action=default&id=$id\" class=\"valider\" title=\"Valider\"><i class=\"fas fa-check\"></i></a>";}?></td></tr>
						<?php
						}
						?>
					</table>
				<?php	
				}?>
				<div class="col-12 mt-4  text-center">
					<a class="btn btn-dark" href="index.php?controller=dayAdmin&action=addDay">Ajouter</a>
				</div>
			</div>
		</div>
	</div>
<?php
}
//SI LE TYPE EST ADDDAY ON AFFICHE LE FORMUALIRE POUR LA CREATION D UNE JOURNEE
elseif($type=='addDay')
{
	?>
	<div class="row admin">
		<div class="col-12">
			<div class="row adminnav mt-4 mb-4 rounded border-dark border d-flex justify-content-center">
				<div class="col-12 text-center"><h2><span class="d-none d-sm-inline-block">JOURNEE</span><span class="d-inline-block d-sm-none">J </span> <?= $day;?></h2></div>
				 <div class="col-12 mt-4 mb-4 text-center">
            	<?php require_once 'components/message.php';?>
                	<form method="post" action="index.php">
                		<div class="form-group row">
							<input type="hidden" name="controller" value="DayAdmin">
						    <input type="hidden" name="action" value="addDay">
						    <input type="hidden" name="id" value="">
						    <input type="hidden" name="day" value="<?= $day;?>">
							<label for="home_team1" class="col-sm-3 col-form-label  text-left">Equipe domicile</label>
							<div class="col-sm-9">
								<select class="form-control" name="home_team1">
								<?php
								foreach($teams as $team)
								{
								?>
									<option value="<?= $team->getId();?>"><?= $team->getName();?></option>
								<?php
								}
								?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="outside_team1" class="col-sm-3 col-form-label  text-left">Equipe exterieur</label>
							<div class="col-sm-9">
								<select class="form-control" name="outside_team1">
								<?php
								foreach($teams as $team)
								{
								?>
									<option value="<?= $team->getId();?>"><?= $team->getName();?></option>
								<?php
								}
								?>
								</select><br/>
							</div>
						</div>
						<div class="form-group row">
							<label for="deadline1" class="col-sm-3 col-form-label  text-left">Deadline</label>
							<div class="col-sm-9">
								<input class="form-control" type="date" name="deadline1" />
							</div>
						</div>
						<div class="form-group row">
							<label for="heure1" class="col-sm-3 col-form-label  text-left">Heure</label>
							<div class="col-sm-9">
								<input class="form-control" type="time" name="heure1" min="12:00" max="22:00" step="900"/>
							</div>
						</div>
						<hr/>
						<div class="form-group row">
							<label for="home_team2" class="col-sm-3 col-form-label  text-left">Equipe domicile</label>
								<div class="col-sm-9">
									<select class="form-control" name="home_team2">
										<?php
										foreach($teams as $team)
										{

										?>
											<option value="<?= $team->getId();?>"><?= $team->getName();?></option>
										<?php
										}
										?>
									</select>
								</div>
						</div>
						<div class="form-group row">
							<label for="outside_team2" class="col-sm-3 col-form-label  text-left">Equipe exterieur</label>
							<div class="col-sm-9">
								<select class="form-control" name="outside_team2">
								<?php
								foreach($teams as $team)
								{
								?>
									<option value="<?= $team->getId();?>"><?= $team->getName();?></option>
								<?php
								}
								?>
								</select><br/>
							</div>
						</div>
						<div class="form-group row">
							<label for="deadline2" class="col-sm-3 col-form-label  text-left">Deadline</label>
							<div class="col-sm-9">
								<input class="form-control" type="date" name="deadline2" />
							</div>
						</div>
						<div class="form-group row">
							<label for="heure2" class="col-sm-3 col-form-label  text-left">Heure</label>
							<div class="col-sm-9">
								<input class="form-control" type="time" name="heure2" min="12:00" max="22:00" step="900"/>
							</div>
						</div>
						<hr/>
						<div class="form-group row">
							<label for="home_team3" class="col-sm-3 col-form-label  text-left">Equipe domicile</label>
								<div class="col-sm-9">
									<select class="form-control" name="home_team3">
										<?php
										foreach($teams as $team)
										{

										?>
											<option value="<?= $team->getId();?>"><?= $team->getName();?></option>
										<?php
										}
										?>
									</select>
								</div>
						</div>
						<div class="form-group row">
							<label for="outside_team3" class="col-sm-3 col-form-label  text-left">Equipe exterieur</label>
							<div class="col-sm-9">
								<select class="form-control" name="outside_team3">
								<?php
								foreach($teams as $team)
								{
								?>
									<option value="<?= $team->getId();?>"><?= $team->getName();?></option>
								<?php
								}
								?>
								</select><br/>
							</div>
						</div>
						<div class="form-group row">
							<label for="deadline3" class="col-sm-3 col-form-label  text-left">Deadline</label>
							<div class="col-sm-9">
								<input class="form-control" type="date" name="deadline3" />
							</div>
						</div>
						<div class="form-group row">
							<label for="heure3" class="col-sm-3 col-form-label  text-left">Heure</label>
							<div class="col-sm-9">
								<input class="form-control" type="time" name="heure3" min="12:00" max="22:00" step="900"/>
							</div>
						</div>
						<hr/>
						<div class="form-group row">
							<label for="home_team4" class="col-sm-3 col-form-label  text-left">Equipe domicile</label>
								<div class="col-sm-9">
									<select class="form-control" name="home_team4">
										<?php
										foreach($teams as $team)
										{

										?>
											<option value="<?= $team->getId();?>"><?= $team->getName();?></option>
										<?php
										}
										?>
									</select>
								</div>
						</div>
						<div class="form-group row">
							<label for="outside_team4" class="col-sm-3 col-form-label  text-left">Equipe exterieur</label>
							<div class="col-sm-9">
								<select class="form-control" name="outside_team4">
								<?php
								foreach($teams as $team)
								{
								?>
									<option value="<?= $team->getId();?>"><?= $team->getName();?></option>
								<?php
								}
								?>
								</select><br/>
							</div>
						</div>
						<div class="form-group row">
							<label for="deadline4" class="col-sm-3 col-form-label  text-left">Deadline</label>
							<div class="col-sm-9">
								<input class="form-control" type="date" name="deadline4" />
							</div>
						</div>
						<div class="form-group row">
							<label for="heure4" class="col-sm-3 col-form-label  text-left">Heure</label>
							<div class="col-sm-9">
								<input class="form-control" type="time" name="heure4" min="12:00" max="22:00" step="900"/>
							</div>
						</div>
						<hr/>
						<div class="form-group row">
							<label for="home_team5" class="col-sm-3 col-form-label  text-left">Equipe domicile</label>
								<div class="col-sm-9">
									<select class="form-control" name="home_team5">
										<?php
										foreach($teams as $team)
										{

										?>
											<option value="<?= $team->getId();?>"><?= $team->getName();?></option>
										<?php
										}
										?>
									</select>
								</div>
						</div>
						<div class="form-group row">
							<label for="outside_team5" class="col-sm-3 col-form-label  text-left">Equipe exterieur</label>
							<div class="col-sm-9">
								<select class="form-control" name="outside_team5">
								<?php
								foreach($teams as $team)
								{
								?>
									<option value="<?= $team->getId();?>"><?= $team->getName();?></option>
								<?php
								}
								?>
								</select><br/>
							</div>
						</div>
						<div class="form-group row">
							<label for="deadline5" class="col-sm-3 col-form-label  text-left">Deadline</label>
							<div class="col-sm-9">
								<input class="form-control" type="date" name="deadline5" />
							</div>
						</div>
						<div class="form-group row">
							<label for="heure5" class="col-sm-3 col-form-label  text-left">Heure</label>
							<div class="col-sm-9">
								<input class="form-control" type="time" name="heure5" min="12:00" max="22:00" step="900"/>
							</div>
						</div>
						<hr/>
						<div class="form-group row">
							<label for="home_team6" class="col-sm-3 col-form-label  text-left">Equipe domicile</label>
								<div class="col-sm-9">
									<select class="form-control" name="home_team6">
										<?php
										foreach($teams as $team)
										{

										?>
											<option value="<?= $team->getId();?>"><?= $team->getName();?></option>
										<?php
										}
										?>
									</select>
								</div>
						</div>
						<div class="form-group row">
							<label for="outside_team6" class="col-sm-3 col-form-label  text-left">Equipe exterieur</label>
							<div class="col-sm-9">
								<select class="form-control" name="outside_team6">
								<?php
								foreach($teams as $team)
								{
								?>
									<option value="<?= $team->getId();?>"><?= $team->getName();?></option>
								<?php
								}
								?>
								</select><br/>
							</div>
						</div>
						<div class="form-group row">
							<label for="deadline6" class="col-sm-3 col-form-label  text-left">Deadline</label>
							<div class="col-sm-9">
								<input class="form-control" type="date" name="deadline6" />
							</div>
						</div>
						<div class="form-group row">
							<label for="heure6" class="col-sm-3 col-form-label  text-left">Heure</label>
							<div class="col-sm-9">
								<input class="form-control" type="time" name="heure6" min="12:00" max="22:00" step="900"/>
							</div>
						</div>
						<hr/>
						<div class="form-group row">
							<label for="home_team7" class="col-sm-3 col-form-label  text-left">Equipe domicile</label>
								<div class="col-sm-9">
									<select class="form-control" name="home_team7">
										<?php
										foreach($teams as $team)
										{

										?>
											<option value="<?= $team->getId();?>"><?= $team->getName();?></option>
										<?php
										}
										?>
									</select>
								</div>
						</div>
						<div class="form-group row">
							<label for="outside_team7" class="col-sm-3 col-form-label  text-left">Equipe exterieur</label>
							<div class="col-sm-9">
								<select class="form-control" name="outside_team7">
								<?php
								foreach($teams as $team)
								{
								?>
									<option value="<?= $team->getId();?>"><?= $team->getName();?></option>
								<?php
								}
								?>
								</select><br/>
							</div>
						</div>
						<div class="form-group row">
							<label for="deadline7" class="col-sm-3 col-form-label  text-left">Deadline</label>
							<div class="col-sm-9">
								<input class="form-control" type="date" name="deadline7" />
							</div>
						</div>
						<div class="form-group row">
							<label for="heure7" class="col-sm-3 col-form-label  text-left">Heure</label>
							<div class="col-sm-9">
								<input class="form-control" type="time" name="heure7" min="12:00" max="22:00" step="900"/>
							</div>
						</div>
						<hr/>
						<div class="form-group row">
							<label for="home_team8" class="col-sm-3 col-form-label  text-left">Equipe domicile</label>
								<div class="col-sm-9">
									<select class="form-control" name="home_team8">
										<?php
										foreach($teams as $team)
										{

										?>
											<option value="<?= $team->getId();?>"><?= $team->getName();?></option>
										<?php
										}
										?>
									</select>
								</div>
						</div>
						<div class="form-group row">
							<label for="outside_team8" class="col-sm-3 col-form-label  text-left">Equipe exterieur</label>
							<div class="col-sm-9">
								<select class="form-control" name="outside_team8">
								<?php
								foreach($teams as $team)
								{
								?>
									<option value="<?= $team->getId();?>"><?= $team->getName();?></option>
								<?php
								}
								?>
								</select><br/>
							</div>
						</div>
						<div class="form-group row">
							<label for="deadline8" class="col-sm-3 col-form-label  text-left">Deadline</label>
							<div class="col-sm-9">
								<input class="form-control" type="date" name="deadline8" />
							</div>
						</div>
						<div class="form-group row">
							<label for="heure8" class="col-sm-3 col-form-label  text-left">Heure</label>
							<div class="col-sm-9">
								<input class="form-control" type="time" name="heure8" min="12:00" max="22:00" step="900"/>
							</div>
						</div>
						<hr/>
						<div class="form-group row">
							<label for="home_team9" class="col-sm-3 col-form-label  text-left">Equipe domicile</label>
								<div class="col-sm-9">
									<select class="form-control" name="home_team9">
										<?php
										foreach($teams as $team)
										{

										?>
											<option value="<?= $team->getId();?>"><?= $team->getName();?></option>
										<?php
										}
										?>
									</select>
								</div>
						</div>
						<div class="form-group row">
							<label for="outside_team9" class="col-sm-3 col-form-label  text-left">Equipe exterieur</label>
							<div class="col-sm-9">
								<select class="form-control" name="outside_team9">
								<?php
								foreach($teams as $team)
								{
								?>
									<option value="<?= $team->getId();?>"><?= $team->getName();?></option>
								<?php
								}
								?>
								</select><br/>
							</div>
						</div>
						<div class="form-group row">
							<label for="deadline9" class="col-sm-3 col-form-label  text-left">Deadline</label>
							<div class="col-sm-9">
								<input class="form-control" type="date" name="deadline9" />
							</div>
						</div>
						<div class="form-group row">
							<label for="heure9" class="col-sm-3 col-form-label  text-left">Heure</label>
							<div class="col-sm-9">
								<input class="form-control" type="time" name="heure9" min="12:00" max="22:00" step="900"/>
							</div>
						</div>
						<hr/>
						<div class="form-group row">
							<label for="home_team10" class="col-sm-3 col-form-label  text-left">Equipe domicile</label>
								<div class="col-sm-9">
									<select class="form-control" name="home_team10">
										<?php
										foreach($teams as $team)
										{

										?>
											<option value="<?= $team->getId();?>"><?= $team->getName();?></option>
										<?php
										}
										?>
									</select>
								</div>
						</div>
						<div class="form-group row">
							<label for="outside_team10" class="col-sm-3 col-form-label  text-left">Equipe exterieur</label>
							<div class="col-sm-9">
								<select class="form-control" name="outside_team10">
								<?php
								foreach($teams as $team)
								{
								?>
									<option value="<?= $team->getId();?>"><?= $team->getName();?></option>
								<?php
								}
								?>
								</select><br/>
							</div>
						</div>
						<div class="form-group row">
							<label for="deadline10" class="col-sm-3 col-form-label  text-left">Deadline</label>
							<div class="col-sm-9">
								<input class="form-control" type="date" name="deadline10" />
							</div>
						</div>
						<div class="form-group row">
							<label for="heure10" class="col-sm-3 col-form-label  text-left">Heure</label>
							<div class="col-sm-9">
								<input class="form-control" type="time" name="heure10" min="12:00" max="22:00" step="900"/>
							</div>
						</div>
						<hr/>
					 <div class="form-group row">
                        <div class="col-12">
                            <input type="submit" name="submit" class="btn btn-dark" value="Ajouter"/>
                        </div>
                    </div>
				</form>
			</div>
		</div>
	</div>
<?php
}
//SI LE TYPE EST UPDATE ON AFFCIHE LE FORMULAIRE POUR MODIFIER UN MATCH
elseif($type='update_match')
{
?>
<div class="row admin">
	<div class="col-12">
		<div class="row adminnav mt-4 mb-4 rounded border-dark border d-flex justify-content-center">
			<div class="col-12 text-center"><h2><span class="d-none d-sm-inline-block">JOURNEE</span><span class="d-inline-block d-sm-none">J </span> <?= $match->getDay();?></h2></div>
			<div class="col-12 mt-4 mb-4 text-center">
            	<?php require_once 'components/message.php';?>
				<form method="post" action="index.php">
					<input type="hidden" name="controller" value="DayAdmin">
					<input type="hidden" name="action" value="updateMatch">
					<input type="hidden" name="id" value="<?= $match->getId();?>">
					<input type="hidden" name="day" value="<?= $match->getDay();?>">
					<div class="form-group row">
						<label for="deadline" class="col-sm-3 col-form-label  text-left">Deadline</label>
						<div class="col-sm-9">
							<input class="form-control" type="date" name="deadline" value="<?= $match->getDeadline();?>"/>
						</div>
					</div>
					<div class="form-group row">
						<label for="heure" class="col-sm-3 col-form-label  text-left">Heure</label>
						<div class="col-sm-9">
							<input class="form-control" type="time" name="heure" min="12:00" max="22:00" step="900"/>
						</div>
					</div>
					<div class="form-group row">
						<label for="home_team" class="col-sm-3 col-form-label  text-left">Equipe domicile</label>
						<div class="col-sm-9">
							<select class="form-control" name="home_team">
							<?php
							foreach($teams as $team)
							{

							?>
								<option value="<?= $team->getId();?>" <?php if($team->getId()==$match->getHome_team()) {echo "selected";}?>><?= $team->getName();?></option>
							<?php
							}
							?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="outside_team" class="col-sm-3 col-form-label  text-left">Equipe exterieur</label>
						<div class="col-sm-9">
							<select class="form-control" name="outside_team">
							<?php
							foreach($teams as $team)
							{
							?>
								<option value="<?= $team->getId();?>" <?php if($team->getId()==$match->getOutside_team()) {echo "selected";}?>><?= $team->getName();?></option>
							<?php
							}
							?>
							</select>
						</div>
					</div>
					<div class="form-group row">
                        <div class="col-12">
                            <input type="submit" name="submit" class="btn btn-dark" value="Modifier"/>
                        </div>
                    </div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php
}

