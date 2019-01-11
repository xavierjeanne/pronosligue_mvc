<?php 
//ON INCLUT LA CLASSE MODEL
require_once 'framework/Model.php';
require_once 'models/Team.php';

class TeamManager extends Model
{
	//METHODE POUR AFFICHER LA LISTE DES EQUIPES EN FONCTION D UN PARAMETRE 
	public function getTeams($order='')
	{
		$this->rangeTeams();
		$teams = [];
		//PREPARATION DE LA REQUETE
		if(empty($order))
		{
			$request = "SELECT * FROM teams ORDER BY point DESC , goal_difference DESC,day ASC";
		}
		else
		{
			$request = "SELECT * FROM teams ORDER BY $order ASC";
		}
		$results = $this->requestExec($request);
		while($data = $results->fetch())
		{
			$teams[] = new Team($data);
		}
		return $teams;
	}

	//METHODE POUR AFFICHER UNE EQUIPE
	public function getTeam($id='') 
	{

	  	$request = "SELECT * FROM teams WHERE id=?";
	  	$results = $this->requestExec($request,array($id));
	  	if ($results->rowCount() == 1)
	  	{
	    	$data = $results->fetch(); 
	    	return new team($data);
	  	}
	  	else
	  	{
	  		throw new Exception("Aucun équipe n'a été trouvée");
	  	}
	}
	
	//METHODE POUR AJOUTER UNE EQUIPE
	public function addTeam(Team $team)
	{
		$request = "SELECT 1 + count(*) as ranking FROM teams";
		$results = $this->requestExec($request);
		$data = $results->fetch();
		$ranking = $data['ranking'];
		$ranking_before = $data['ranking'];
		$requestbis = "INSERT INTO teams (name,alias,flag,jersey,ranking,ranking_before) VALUES (?,?,?,?,?,?)";
		$resultsbis = $this->requestExec($requestbis,array(
						$team->getName(),
						$team->getAlias(),
						$team->getFlag(),
						$team->getJersey(),
						$ranking,
						$ranking_before
			));
	}
	// //METHODE POUR METTRE A JOUR UNE EQUIPE
	public function updateTeam(Team $team)
	{
		$request = "UPDATE teams SET name=?,alias=?,flag=?,jersey=?,day=?,point=?,won=?,drawn=?,lost=?,goal_for=?,goal_against=?,goal_difference=?,ranking=?,ranking_before=? WHERE id = ? ";
		$results = $this->requestExec($request,array(
						$team->getName(),
						$team->getAlias(),
						$team->getFlag(),
						$team->getJersey(),
						$team->getDay(),
						$team->getPoint(),
						$team->getWon(),
						$team->getDrawn(),
						$team->getLost(),
						$team->getGoal_for(),
						$team->getGoal_against(),
						$team->getGoal_difference(),
						$team->getRanking(),
						$team->getRanking_before(),
						$team->getId()
			));
		$this->rangeTeams();
	}
	// METHODE POUR CLASSER LES EQUIPES
	public function rangeTeams()
	{
		$request = "SELECT * FROM teams ORDER BY point DESC ,goal_difference DESC,day ASC";
		$results = $this->requestExec($request);
		$i=1;
		while($data = $results->fetch())
		{
			$team = new Team($data);
			$ranking=$i;
			$ranking_before=$team->getRanking();
			$requestbis ="UPDATE teams SET ranking=?,ranking_before=? WHERE id = ?";
			$resultsbis = $this->requestExec($requestbis,array(
							$ranking,
							$ranking_before,
							$team->getId()
			));
			$ranking =[];
			if($i==1)
			{
				$podium1 = $team->getId();
			}
			elseif($i==2)
			{
				$podium2 = $team->getId();
			}
			elseif($i==3)
			{
				$podium3 = $team->getId();
			}
			elseif($i==18)
			{
				$relegation18 = $team->getId();
			}
			elseif($i==19)
			{
				$relegation19 = $team->getId();
			}
			elseif($i==20)
			{
				$relegation20 = $team->getId();
			}
			$i++;
		}
		return $ranking=[$podium1,$podium2,$podium3,$relegation18,$relegation19,$relegation20];

	}
	//METHODE POUR EFFACER UNE EQUIPE
	 public function delete(team $team)
  	{
  		$request = "DELETE FROM teams WHERE id = ?";
    	//ON APPELLE LA METHODE REQUETE DU MODELE
		$results = $this->requestExec($request,array($team->getId()));
  	}
}
	