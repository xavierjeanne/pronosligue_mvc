<?php 
//ON INCLUT LA CLASSE MODEL
require_once 'framework/Model.php';
require_once 'models/Day.php';
require_once 'models/TeamManager.php';

class DayManager extends Model
{

	private $_teammanager;
	//CONSTRUCTEUR
	public function __construct()
	{
		
		$this->teammanager = new TeamManager();
	}

	//METHODE POUR AFFICHER LES MATCHS D UNE JOURNEE 
	public function getDay($day='') 
	{
		$matchs=[];
	  	$request = "SELECT * FROM days WHERE day=?";
	  	$results = $this->requestExec($request,array($day));
	  	while ($data = $results->fetch())
	  	{
	  		//RECUPERATION DES DONNEES DES EQUIPES POUR L AFFICHAGE
	  		$home_team = $this->teammanager->getTeam($data['home_team']);
	  		$home_name = $home_team->getName();
	  		$home_flag = $home_team->getFlag();
	  		$home_alias = $home_team->getAlias();
	  		$outside_team = $this->teammanager->getTeam($data['outside_team']);
	  		$outside_name = $outside_team->getName();
	  		$outside_flag = $outside_team->getFlag();
	  		$outside_alias = $outside_team->getAlias();
	  		$deadline = $data['deadline'];
	  		$deadline = date("d-m-Y  H:i:s", strtotime($deadline));
	  		$score= $data['score'];
	  		//
	  		if($score==0)
	  		{
	  			$score="<img src=\"assets/img/design/pasdeprono.png\" alt=\"Pas de score\"/>";
	  		}
	  		elseif($score==1)
	  		{
	  			$score="<img src=\"assets/img/design/victoire.png\" alt=\"Victoire\"/>";
	  		}
	  		elseif($score==2)
	  		{
	  			$score="<img src=\"assets/img/design/match_nul.png\" alt=\"Match nul\"/>";
	  		}
	  		else
	  		{
	  			$score="<img src=\"assets/img/design/defaite.png\" alt=\"Defaite\"/>";
	  		}
	  		$data['home_team']="<img src=\"$home_flag\" title=\"$home_name\" alt=\"$home_name\"><span class=\" d-none d-lg-inline-block\">" .$home_name."</span><span class=\" d-inline-block d-lg-none\">" .$home_alias."</span>";
	  		$data['score'] = $score;
	  		$data['deadline']= $deadline;
	  		$data['outside_team']="<span class=\" d-none d-lg-inline-block\">" .$outside_name."</span><img src=\"$outside_flag\" title=\"$outside_name\" alt=\"$outside_name\"><span class=\" d-inline-block d-lg-none\">" .$outside_alias."</span>";
	    	$matchs[]=new day($data);
	  	}
	  	// ON RETOURNE UN TABLEAU DES MATCHS D UNE JOURNEE  POUR L AFFICHAGE
	    	
	  	return $matchs;
	}

	//METHODE POUR LE TRAITEMENT D UNE JOURNEE PAR LA PARTIE ADMIN
	public function getDayScore($day='') 
	{
		$matchs=[];
	  	$request = "SELECT * FROM days WHERE day=?";
	  	$results = $this->requestExec($request,array($day));
	  	while ($data = $results->fetch())
	  	{
	  		
	  		$home_team = $this->teammanager->getTeam($data['home_team']);
	  		$home_name = $home_team->getName();
	  		$home_flag = $home_team->getFlag();
	  		$home_alias = $home_team->getAlias();
	  		$outside_team = $this->teammanager->getTeam($data['outside_team']);
	  		$outside_name = $outside_team->getName();
	  		$outside_flag = $outside_team->getFlag();
	  		$outside_alias = $outside_team->getAlias();
	  		$deadline = $data['deadline'];
	  		$deadline = date("d-m-Y  H:i:s", strtotime($deadline));
	  		$data['deadline']= $deadline;
	  		$data['home_team']="<img src=\"$home_flag\" title=\"$home_name\" alt=\"$home_name\"><span class=\" d-none d-lg-inline-block\">" .$home_name."</span><span class=\" d-inline-block d-lg-none\">" .$home_alias."</span>";
	  		$data['outside_team']="<span class=\" d-none d-lg-inline-block\">" .$outside_name."</span><img src=\"$outside_flag\" title=\"$outside_name\" alt=\"$outside_name\"><span class=\" d-inline-block d-lg-none\">" .$outside_alias."</span>";
	    	$matchs[]=new day($data);
	  	}
	  	// ON RETOURNE UN TABLEAU DES MATCHS D UNE JOURNEE  POUR LE TRAITEMENT DES SCORES
	  	return $matchs;
	}

	//METHODE POUR AFFICHER LA JOURNEE EN COURS
	public function getCurrentDay()
	{
		$request = "SELECT day FROM days WHERE score=0";
		$results = $this->requestExec($request);
		$data=$results->fetch();
		return $data['day'];
	}
	
	//METHODE POUR AVOIR LA DERNIERE JOURNEE ENREGISTRE DANS LA BDD
	public function getLastDay()
	{
		$request = "SELECT day FROM days ORDER BY id DESC LIMIT 1";
		$results = $this->requestExec($request);
		if($data=$results->fetch())
		{
		$id= $data['day'];
		return $last=$id + 1;	
		}
		else
		{
			return $last=20;
		}
	}


	//METHODE POUR AJOUTER UNE JOURNEE ET LA SAUVEGARDE
	public function addDay(Day $day)
	{
		$request = "INSERT INTO days (day,home_team,outside_team,deadline) VALUES (?,?,?,?)";
		$results = $this->requestExec($request,array(
						$day->getDay(),
						$day->getHome_team(),
						$day->getOutside_team(),
						$day->getDeadline(),

			));
	}

	// //METHODE POUR METTRE A JOUR UN MATCH D UNE JOURNEE
	public function updateDay(Day $day)
	{
		$request = "UPDATE days SET day=?,home_team=?,outside_team=?,deadline=?,home_goal=?,outside_goal=?,score=? WHERE id = ? ";
		$results = $this->requestExec($request,array(
						$day->getDay(),
						$day->getHome_team(),
						$day->getOutside_team(),
						$day->getDeadline(),
						$day->getHome_goal(),
						$day->getOutside_goal(),
						$day->getScore(),
						$day->getId()
			));
	}

	//METHODE POUR EFFACER UNE JOURNEE
	 public function delete(day $day)
  	{
  		$request = "DELETE FROM days WHERE id = ?";
		$results = $this->requestExec($request,array($day->getId()));
  	}

  	//METHODE POUR RECUPERER UN MATCH POUR LE TRAITEMENT DES RESULTATS
  	public function getMatchView($id='')
  	{
  	$request = "SELECT * FROM days WHERE id=?";
  	$results = $this->requestExec($request,array($id));
  	if ($results->rowCount() == 1)
	  	{
	    	$data = $results->fetch(); 
	    	$teammanager = new TeamManager();
	  		$home_team = $teammanager->getTeam($data['home_team']);
	  		$home_name = $home_team->getName();
	  		$home_flag = $home_team->getFlag();
	  		$data['home_team']="<img src=\"$home_flag\" alt=\"$home_name\">" .$home_name;
	  		$outside_team = $teammanager->getTeam($data['outside_team']);
	  		$outside_name = $outside_team->getName();
	  		$outside_flag = $outside_team->getFlag();
	  		$data['outside_team']=$outside_name. "<img src=\"$outside_flag\" alt=\"$outside_name\">";
	    	return new Day($data);
	  	}
	  	else
	  	{
	  		throw new Exception("Aucun match n'a été trouvée");
	  	}
  	}

  	//METHODE UTULISE POUR LE TRAITEMENT DES DONNEES D UNE MATCH  PAR LA PARTIE ADMIN
  	public function getMatch($id='')
  	{
  	$request = "SELECT * FROM days WHERE id=?";
  	$results = $this->requestExec($request,array($id));
  	if ($results->rowCount() == 1)
	  	{
	    	$data = $results->fetch(); 
	    	return new Day($data);
	  	}
	  	else
	  	{
	  		throw new Exception("Aucun match n'a été trouvée");
	  	}
  	}
}