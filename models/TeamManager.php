<?php 
//ON INCLUT LA CLASSE MODEL
require_once 'framework/Model.php';
require_once 'models/Team.php';

class TeamManager extends Model
{
	//METHODE POUR AFFICHER LA LISTE DES EQUIPES
	public function getTeams()
	{
		$teams = [];
		//PREPARATION DE LA REQUETE
		$request = "SELECT * FROM teams ORDER BY point DESC , goal_difference DESC";
		//ON APPELLE LA METHODE REQUETE DU MODELE
		$results = $this->requestExec($request);
		while($data = $results->fetch())
		{
			$teams[] = new Team($data);
		}
		return $teams;
	}

	//METHODE POUR AFFICHER UNE EQUIPE
	public function getTeam($id="") 
	{

	  	$request = "SELECT * FROM teams WHERE id=?";
	  	$results = $this->requestExec($request,array($id));
	  	//ON ACCEDE A LA PREMIERE LIGNE DE RESULTAT
	  	if ($results->rowCount() == 1)
	  	{
	    	$data = $results->fetch(); 
	    	//ON RENVOIE UN OBJET EQUIPE
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
		$request = "INSERT INTO teams (name,alias,flag,jersey,created_at,updated_at) VALUES (?,?,?,?,?,?)";
		$created_at=date("Y-m-d H:i:s");
		$updated_at=date("Y-m-d H:i:s");
		$results = $this->requestExec($request,array(
						$team->getName(),
						$team->getAlias(),
						$team->getFlag(),
						$team->getJersey(),
						$created_at,
						$updated_at
			));
	}
	// //METHODE POUR METTRE A JOUR UNE EQUIPE
	public function updateTeam(Team $team)
	{
		$request = "UPDATE teams SET name=?,alias=?,flag=?,jersey=?,day=?,point=?,won=?,drawn=?,lost=?,goal_for=?,goal_against=?,goal_difference=?,ranking=?,ranking_before=?,form_1=?,form_2=?,form_3=?,form_4=?,form_5=?,home_form_1=?,home_form_2=?,home_form_3=?,home_form_4=?,home_form_5=?,outside_form_1=?,outside_form_2=?,outside_form_3=?,outside_form_4=?,outside_form_5=?,created_at=?,updated_at=? WHERE id = ? ";
		$updated_at=date("Y-m-d H:i:s");
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
						$team->getForm_1(),
						$team->getForm_2(),
						$team->getForm_3(),
						$team->getForm_4(),
						$team->getForm_5(),
						$team->getHome_form_1(),
						$team->getHome_form_2(),
						$team->getHome_form_3(),
						$team->getHome_form_4(),
						$team->getHome_form_5(),
						$team->getOutside_form_1(),
						$team->getOutside_form_2(),
						$team->getOutside_form_3(),
						$team->getOutside_form_4(),
						$team->getOutside_form_5(),
						$team->getCreated_at(),
						$updated_at,
						$team->getId()
			));
	}
	//METHODE POUR EFFACER UNE EQUIPE
	 public function delete(team $team)
  	{
  		$request = "DELETE FROM teams WHERE id = ?";
    	//ON APPELLE LA METHODE REQUETE DU MODELE
		$results = $this->requestExec($request,array($team->getId()));
  	}
}
	