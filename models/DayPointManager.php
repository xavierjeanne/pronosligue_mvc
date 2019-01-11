<?php 
//ON INCLUT LA CLASSE MODEL
require_once 'framework/Model.php';
require_once 'models/DayPoint.php';
require_once 'models/UserManager.php';

class DayPointManager extends Model
{
	private $_usermanager;
	//CONSTRUCTEUR
	public function __construct()
	{
		
		$this->usermanager = new UserManager();
	}

	//METHODE POUR AFFICHER LES POINTS DES JOUEURS D UNE JOURNEE
	public function getDayPoints($day='')
	{
		$dayPoints=[];
		$request ="SELECT * FROM day_points INNER JOIN users ON day_points.user_id=users.id  WHERE  day_points.day=? ORDER BY day_points.day_point DESC ";
		$results = $this->requestExec($request,array($day));
	  	while ($data = $results->fetch())
	  	{
	  		$user_id=$data['user_id'];
	  		$user=$this->usermanager->getUser($user_id);
	  		$avatar=$user->getAvatar($user_id);
	  		$avatar = "<img src=\"$avatar\" alt=\"$avatar\"/>";
	  		$user_id=$user->getPseudo();
	  		$data['user_id']=$avatar.' '.$user_id;
	    	$dayPoints[]=new DayPoint($data);
	  	}
	  	return $dayPoints;
	}

	//METHODE POUR AFFICHER LES POINTS D UN JOUEUR SUR UNE JOURNEE
	public function getDayPoint($user_id='',$day='')
	{
		$request = "SELECT * FROM day_points  WHERE user_id=? AND day=? ";
	  	$results = $this->requestExec($request,array($user_id,$day));
	  	if ($results->rowCount() == 1)
	  	{
	    	$data = $results->fetch(); 
	    	return new DayPoint($data);
	  	}
	  	else
	  	{
	  		throw new Exception("Aucun point pour la journee n'a été trouvé");
	  	}
	}

	//METHODE POUR AFFICHER TOUT LES POINTS D UN JOUEUR
	public function getAllDayPoints($user_id)
	{
		$dayPoints=[];
		$request ="SELECT * FROM day_points INNER JOIN users ON day_points.user_id=users.id  WHERE  users.id=? ORDER BY day_points.day ASC" ;
		$results = $this->requestExec($request,array($user_id));
	  	while ($data = $results->fetch())
	  	{
	    	$dayPoints[]=new DayPoint($data);
	  	}
	  	return $dayPoints;
	}

	//METHODE POUR AJOUTER UN POINT DE JOURNEE
	public function addDayPoint(DayPoint $dayPoint)
	{
		$request = "INSERT INTO day_points (user_id,day,day_point,match_number) VALUES (?,?,?,?)";
		$results = $this->requestExec($request,array(
						$dayPoint->getUser_id(),
						$dayPoint->getDay(),
						$dayPoint->getDay_point(),
						$dayPoint->getMatch_number(),
			));
	}

	//METHODE POUR METTRE A JOUR   UN POINT DE JOURNEE
	public function updateDayPoint(DayPoint $dayPoint)
	{
		
		$request = "UPDATE day_points SET user_id=?,day=?,day_point=?,match_number=? WHERE id = ? ";
		$results = $this->requestExec($request,array(
						$dayPoint->getUser_id(),
						$dayPoint->getDay(),
						$dayPoint->getDay_point(),
						$dayPoint->getMatch_number(),
						$dayPoint->getId()
			));
	}
}