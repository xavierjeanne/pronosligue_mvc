<?php 
//ON INCLUT LA CLASSE MODEL
require_once 'framework/Model.php';
require_once 'models/Bet.php';
require_once 'models/UserManager.php';

class BetManager extends Model
{
	//METHODE POUR AFFICHER  LES PRONOSTICS D UN MEMBRE CONCERNANT UNE JOURNEE
	public function getBets($day='',$user_id='')
	{
		$bets=[];
		//PREPRATION DE LA REQUETE POUR RECUPERE LES PRONOS D UN JOUEUR SUR UNE JOURNEE
		$request ="SELECT * FROM days INNER JOIN bets ON days.id=bets.match_id  WHERE bets.user_id=? AND days.day=?";
		$results = $this->requestExec($request,array($user_id,$day));
	  	while ($data = $results->fetch())
	  	{
	  		$bet=$data['bet'];
	  		//ON AFFICHE UNE IMAGE DIFFERENTE EN FONCTION DU PRONOSTIC
	  		if($bet==0)
	  		{
	  			$bet="<img src=\"assets/img/design/pasdeprono.png\" alt=\"Pas de pronos\"/>";
	  		}
	  		elseif($bet==1)
	  		{
	  			$bet="<img src=\"assets/img/design/victoire.png\" alt=\"Victoire\"/>";
	  		}
	  		elseif($bet==2)
	  		{
	  			$bet="<img src=\"assets/img/design/match_nul.png\" alt=\"Match nul\"/>";
	  		}
	  		else
	  		{
	  			$bet="<img src=\"assets/img/design/defaite.png\" alt=\"Defaite\"/>";
	  		}
	  		$data['bet'] = $bet;
			//
	    	$bets[]=new Bet($data);
	  	}
	  	// ON RETOURNE  UN TABLEAU D OBJET DE PRONOSTIC D UN JOUEUR  SUR UNE JOURNEE
	  	return $bets;
	}

	//METHODE POUR RECUPERER LES PRONOSTICS DUN JOUEUR SUR UNE JOURNEE, UTILISATION DANS LES FORMULAIRES
	public function getBetsForm($day='',$user_id='')
	{
		$bets=[];
		$request ="SELECT * FROM days INNER JOIN bets ON days.id=bets.match_id  WHERE bets.user_id=? AND days.day=?";
		$results = $this->requestExec($request,array($user_id,$day));
	  	while ($data = $results->fetch())
	  	{
	    	$bets[]=new Bet($data);
	  	}
	  	return $bets;
	}

	//METHODE POUR RECUPERER LE PRONOSTIC D UN JOUEUR SUR UN MATCH
	public function getBet($user_id='',$match_id='')
	{
		$request = "SELECT * FROM bets  WHERE user_id=? AND match_id=? ";
	  	$results = $this->requestExec($request,array($user_id,$match_id));
	  	if ($results->rowCount() == 1)
	  	{
	    	$data = $results->fetch(); 
	    	//ON RENVOIE UN OBJET PARI
	    	return new Bet($data);
	  	}
	  	else
	  	{
	  		throw new Exception("Aucun pronostic n'a été trouvé");
	  	}
	}

	//METHODE POUR RECUPERER TOUT LES PARIS DES JOUEURS CONCERNANT UN MATCH
	public function getBetsMatch($match_id='')
	{
		$bets=[];
		$request = "SELECT * FROM bets WHERE match_id = ?";
		$results = $this->requestExec($request,array($match_id));
	  	//ON ACCEDE A LA PREMIERE LIGNE DE RESULTAT
	  	while ($data = $results->fetch())
	  	{
	    	$bets[]=new Bet($data);
	  	}
	  	return $bets;

	}

	//METHODE POUR AJOUTER UN PRONOSTIC ET L ENREGISTRER
	public function addBet(Bet $bet)
	{
		//ON TRANSMET UN OBJET PARI POUR L AJOUTER A LA BDD
		$request = "INSERT INTO bets (match_id,user_id,bet) VALUES (?,?,?)";
		$results = $this->requestExec($request,array(
						$bet->getMatch_id(),
						$bet->getUser_id(),
						$bet->getBet(),
			));
	}

	//METHODE POUR MODIOFIER UN PRONOSTIC
	public function updateBet(Bet $bet)
	{
		//ON TRANSMET UN OBJET PARI POUR MODIFIER LA BASE DE DONNEES
		$request = "UPDATE bets SET match_id=?,user_id=?,bet=?,result=? WHERE id = ? ";
		$results = $this->requestExec($request,array(
						$bet->getMatch_id(),
						$bet->getUser_id(),
						$bet->getBet(),
						$bet->getResult(),
						$bet->getId()
			));
	}

	//METHODE POUR RECUPERER TOUT LES PRONSOTICS DES MATCHS CONCERNANT UNE JOURNEE
	function getBetsDay($day='')
    {
        try
        {
        	$bets=[];
        	//ON RECUPERE LE NUMERO DE LA JOURNEE
        	$request = "SELECT id FROM days WHERE days.day=?";
        	$results=$this->requestExec($request,array($day));
        	$i=0;
        	while($data = $results->fetch())
            {  
            	//POUR CHAQUE MATCH DE CETTE JOURNEE ON VA RECUPERER LE PRONOSTIC DES JOEURS ET LE STOCKER DANS UN TABLEAU A DEUX DIMENSIONS POUR LES AFFICHER DANS LA PAGE RESULTAT
               	$id_match=$data['id'];
               	$requestbis = "SELECT * FROM bets INNER JOIN users ON bets.user_id = users.id WHERE bets.match_id=? ORDER BY users.pseudo ASC";
               	$resultsbis = $this->requestExec($requestbis,array($id_match));
              	 while($databis=$resultsbis->fetch())
              	{
               	$bets[$i][]	=$databis;
               	}
               	$i++;
            }
            return $bets;
        }
        catch (PDOException $e)	 	
        {
            //GESTION DES ERREURS
            throw new Exception('Erreur de récupération : ' . utf8_encode($e->getMessage()));
        }
    }

    //METHODE POUR OBTENIR LE NOMBRE DE PARI SUR UNE JOURNEE
    function countBetsDay($day='')
    {
    	try
        {
        	$request = "SELECT COUNT(DISTINCT(user_id)) AS count_bets FROM days INNER JOIN bets ON days.id=bets.match_id WHERE days.day=?";
        	$results=$this->requestExec($request,array($day));
        	$data=$results->fetch();
        	return $count_bets=$data['count_bets'];
        }
        catch (PDOException $e)	 	
        {
            //GESTION DES ERREURS
            throw new Exception('Erreur d\' authentification : ' . utf8_encode($e->getMessage()));
        }
    }
}