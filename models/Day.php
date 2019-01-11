<?php 

class Day
{
    private $_id;
    private $_day;
    private $_home_team;
    private $_outside_team;
    private $_deadline;
    private $_home_goal = 0;
    private $_outside_goal = 0;
    private $_score = 0;
    
    //CONSTRUCTEUR
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    //HYDRATATION DE L OBJET

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value)
        {
            $method = 'set'.ucfirst($key);
            //ON VERIFIE SI LE SETTER EXIST
            if (method_exists($this, $method))
            {
              // ON APPELLE LE SETTER
              $this->$method($value);
            }
        }
    }

    //GETTER ET SETTER
    public function getId()
    {
        return $this->_id;
    }

    public function setId($id)
    {
        $id = (int) $id;

        if($id>0)
        {
            $this->_id = $id;
        }
    }

    public function getDay()
    {
        return $this->_day;
    }

    public function setDay($day)
    {
        $day = (int) $day;

        if($day>0)
        {
            $this->_day = $day;
        }
    }

    public function getHome_team()
    {
        
        
        return $this->_home_team;
    }

    public function setHome_team($home_team)
    {
        $this->_home_team = $home_team;
    }

    public function getOutside_team()
    {
       
        return  $this->_outside_team;
    }

    public function setOutside_team($outside_team)
    {
            $this->_outside_team = $outside_team;
    }

    public function getDeadline()
    {
        return $this->_deadline;
    }

    public function setDeadline($deadline)
    {
        $this->_deadline = $deadline;
    }

    public function getHome_goal(){
        return $this->_home_goal;
    }

    public function setHome_goal($home_goal)
    {
        $home_goal = (int) $home_goal;

        if($home_goal>=0)
        {
            $this->_home_goal = $home_goal;
        }
    }

    public function getOutside_goal()
    {
        return $this->_outside_goal;
    }

    public function setOutside_goal($outside_goal)
    {
        $outside_goal = (int) $outside_goal;

        if($outside_goal>=0)
        {
            $this->_outside_goal = $outside_goal;
        }
    }

    public function getScore()
    {
        return $this->_score;
    }

    public function setScore($score)
    {
            $this->_score = $score;
    }
}