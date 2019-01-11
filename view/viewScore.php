<?php $this->_title = 'Validation des scores';?>
<div class="row admin">
	<div class="col-12">
		<div class="row adminnav mt-4 mb-4 rounded border-dark border d-flex justify-content-center">
			<div class="col-12 text-center"><h2>Valider le match</h2></div>
			<div class="col-12 mt-4 mb-4 text-center">
            <?php require_once 'components/message.php';?>
			<form method="post" action="index.php">
				<input type="hidden" name="controller" value="Score">
				<input type="hidden" name="action" value="default">
				<input type="hidden" name="id" value="<?= $match->getId();?>">
				<div class="form-group row">
					<label for="home_goal" class="col-sm-3 col-form-label  text-left"><?= $match->getHome_team();?></label>
					<div class="col-sm-9">
						<select class="form-control" name="home_goal">
						<?php 
						for($i=0;$i<=9;$i++)
						{
							echo"<option value=\"$i\">$i</option>";
						}
						?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="outside_goal" class="col-sm-3 col-form-label  text-left"><?= $match->getOutside_team();?></label>
					<div class="col-sm-9">
						<select class="form-control" name="outside_goal">
							<?php for($i=0;$i<=9;$i++)
							{
								echo"<option value=\"$i\">$i</option>";
							}
							?>
						</select>
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

