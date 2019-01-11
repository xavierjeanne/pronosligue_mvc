<?php 

//ON INCLUT LA CLASSE MODEL
require_once 'framework/Model.php';
require_once 'models/TeamManager.php';
require_once 'models/BetManager.php';
require_once 'models/UserManager.php';
require_once 'models/DayPointManager.php';


class Score extends Model
{	
    private $_teammanager;
    private $_usermanager;
    private $_betmanager;
    private $_daypointmanager;
    
    
    
    //CONSTRUCTEUR
    public function __construct()
    {
        
        $this->teammanager = new TeamManager();
        $this->usermanager = new UserManager();
        $this->betmanager = new BetManager();
        $this->daypointmanager = new DayPointManager();

        
    }

    //METHODE POUR LA VALIDATION D UN MATCH
	function validateScore($match='')
    {
        try
        {
            //TRAITEMENT DU MATCH ET MISE A JOUR DES EQUIPES
            $home_team = $this->teammanager->getTeam($match->getHome_team());
        	$outside_team = $this->teammanager->getTeam($match->getoutside_team());
            //SI L EQUIPE A DOMICILE A GAGNE
            if($match->getScore()==1)
            {
                //ON MET A JOUR LES INFO CONCERNANT LES EQUIPES
                //EQUIPE DOMICILE
                $home_team->setWon($home_team->getWon()+1);
                $home_team->setPoint($home_team->getPoint()+3);
               
                //EQUIPE EXTERIEURE
                $outside_team->setLost($outside_team->getLost()+1);
            }
            //EN CAS DE MATCH NUL
            elseif($match->getScore()==2)
            {
                $home_team->setDrawn($home_team->getDrawn()+1);
                $home_team->setPoint($home_team->getPoint()+1);
                $outside_team->setDrawn($outside_team->getDrawn()+1);
                $outside_team->setPoint($outside_team->getPoint()+1);
            }
            //EN CAS DE VICTOIRE DE L EQUIPE EXTERIEURE
            else
            {
                $home_team->setLost($home_team->getLost()+1);

                $outside_team->setWon($outside_team->getWon()+1);
                $outside_team->setPoint($outside_team->getPoint()+3);
            }
            //ON MET A JOUR LE NOMBRE DE JOURNEE POUR LES DEUX EQUIPES ET LES BUTS 
            $home_team->setDay($home_team->getDay()+1);
            $outside_team->setDay($outside_team->getDay()+1);
            $home_team->setGoal_for($home_team->getGoal_for()+$match->getHome_goal());
            $home_team->setGoal_against($home_team->getGoal_against()+$match->getOutside_goal());
            $home_team->setGoal_difference($home_team->getGoal_for() - $home_team->getGoal_against());
            $outside_team->setGoal_for($outside_team->getGoal_for()+$match->getOutside_goal());
            $outside_team->setGoal_against($outside_team->getGoal_against()+$match->getHome_goal());
            $outside_team->setGoal_difference($outside_team->getGoal_for() - $outside_team->getGoal_against());
            //ON FINALISE LES CHANGEMENT EN APPELANT LA METHODE UPDATE POUR LES DEUX EQUIPES
            $this->teammanager->updateTeam($home_team);
            $this->teammanager->updateTeam($outside_team);
            //TRAITEMENT DES PARIS
            $bets = $this->betmanager->getBetsMatch($match->getId());
            //POUR CHAQUE PARI ON COMPARE LES PRONOS ET LE RESULTAT
            foreach($bets as $bet)
            {
                //SI LE PRONO ETAIT BON ON MET A JOUR LES INFOS
                if($bet->getBet()==$match->getScore())
                {
                    $bet->setResult(1);
                    $this->betmanager->updateBet($bet);
                }
                
                $id_user=$bet->getUser_id();
                $user = $this->usermanager->getUser($id_user);
                //ON MET A JOUR LES DONNEES DE L UTILISATEUR
                $daypoint = $this->daypointmanager->getDayPoint($id_user,$match->getDay());
                $daypoint->setDay_point($daypoint->getDay_point()+$bet->getResult());
                $daypoint->setMatch_number($daypoint->getMatch_number()+1);
                $match_number=$daypoint->getMatch_number();
                $day_point=$daypoint->getDay_point();
                //ON ATTRIBUE LES BONUS ET SI LE NOMBRE DE MATCH EST DE 10 ON MET A JOUR LES BONUS DES JOUEURS
                if($day_point==7)
                {
                    $day_point==8;
                    if($match_number==10)
                    {
                        $user->setBonus7($user->getBonus7()+1);
                    }
                }
                elseif($day_point==9)
                {
                    $day_point==10;
                    if($match_number==10)
                    {
                        $user->setBonus8($user->getBonus8()+1);
                    }
                }
                elseif($day_point==11)
                {
                     $day_point==12;
                     if($match_number==10)
                    {
                        $user->setBonus9($user->getBonus9()+1);
                    }
                }
                elseif($day_point==13)
                {
                    $day_point==15;
                    if($match_number==10)
                    {
                        $user->setBonus10($user->getBonus10()+1);
                    }
                }
                $daypoint->setDay_point($day_point);
                $this->daypointmanager->updateDayPoint($daypoint);
                // ON RECUPERE TOUT LES POINTS PAR JOURNEE D UN JOUEUR POUR OBTENIR LE TOTAL
                $daypoints = $this->daypointmanager->getAllDayPoints($id_user);
                $point=0;
                foreach($daypoints as $daypoint)
                {
                    $point += $daypoint->getDay_point();
                }
                $user->setPoint($point);
                $this->usermanager->updateUser($user);
            }            
            return true;
        }
        catch (PDOException $e)
        {
            //GESTION DES ERREURS
            throw new Exception('Erreur de validation : ' . utf8_encode($e->getMessage()));
        }
    }
}