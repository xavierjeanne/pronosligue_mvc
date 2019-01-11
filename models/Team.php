<?php 

class Team
{
	private $_id;
	private $_name;
	private $_alias;
	private $_flag;
	private $_jersey;
	private $_day = 0;
	private $_point = 0;
	private $_won = 0;
	private $_drawn = 0;
	private $_lost = 0;
	private $_goal_for = 0;
	private $_goal_against = 0;
	private $_goal_difference = 0;
	private $_ranking;
	private $_ranking_before;
	
	

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

	public function getName()
	{
		return $this->_name;
	}

	public function setName($name)
	{
		if(is_string($name))
		{
			$this->_name = $name;
		}
	}

	public function getAlias(){
		return $this->_alias;
	}

	public function setAlias($alias)
	{
		if(is_string($alias))
		{
			$this->_alias = $alias;
		}
	}

	public function getFlag(){
		return $this->_flag;
	}

	public function setFlag($flag)
	{
		if(is_string($flag))
		{
			$this->_flag = $flag;
		}
	}

	public function getJersey(){
		return $this->_jersey;
	}

	public function setJersey($jersey)
	{
		if(is_string($jersey))
		{
			$this->_jersey = $jersey;
		}
	}

	public function getDay(){
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

	public function getPoint()
	{
		return $this->_point;
	}

	public function setPoint($point)
	{
		$point = (int) $point;

		if($point>=0)
		{
			$this->_point = $point;
		}
	}

	public function getWon()
	{
		return $this->_won;
	}

	public function setWon($won)
	{
		$won = (int) $won;

		if($won>=0)
		{
			$this->_won = $won;
		}
	}

	public function getDrawn()
	{
		return $this->_drawn;
	}

	public function setDrawn($drawn)
	{
		$drawn = (int) $drawn;

		if($drawn>=0)
		{
			$this->_drawn = $drawn;
		}
	}

	public function getLost()
	{
		return $this->_lost;
	}

	public function setLost($lost)
	{
		$lost = (int) $lost;

		if($lost>=0)
		{
			$this->_lost = $lost;
		}
	}

	public function getGoal_for()
	{
		return $this->_goal_for;
	}

	public function setGoal_for($goal_for)
	{
		$goal_for = (int) $goal_for;

		if($goal_for>=0)
		{
			$this->_goal_for = $goal_for;
		}
	}

	public function getGoal_against()
	{
		return $this->_goal_against;
	}

	public function setGoal_against($goal_against)
	{
		$goal_against = (int) $goal_against;

		if($goal_against>=0)
		{
			$this->_goal_against = $goal_against;
		}
	}

	public function getGoal_difference()
	{
		return $this->_goal_difference;
	}

	public function setGoal_difference($goal_difference)
	{
		
			$this->_goal_difference = $goal_difference;
	}

	public function getRanking()
	{
		return $this->_ranking;
	}

	public function setRanking($ranking)
	{
		$ranking = (int) $ranking;
		if($ranking>=0)
		{
			$this->_ranking = $ranking;	
		}
		
	}
	public function getRanking_before()
	{
		return $this->_ranking_before;
	}

	public function setRanking_before($ranking_before)
	{
		$ranking_before = (int) $ranking_before;
		if($ranking_before>=0)
		{
			$this->_ranking_before = $ranking_before;	
		}
	}
	
}