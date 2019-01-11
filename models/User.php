<?php 

class User 
{
	private $_id;
	private $_pseudo;
	private $_avatar;
	private $_total_point = 0;
	private $_total_bonus = 0;
	private $_point = 0;
	private $_bonus7 = 0;
	private $_bonus8 = 0;
	private $_bonus9 = 0;
	private $_bonus10 = 0;
	private $_password;
	private $_email;
	private $_podium1=0;
	private $_podium2=0;
	private $_podium3=0;
	private $_relegation18=0;
	private $_relegation19=0;
	private $_relegation20=0;
	private $_step = 0;
	private $_admin = 0;
	private $_stake = 0;
	private $_ranking;
	private $_ranking_before;
	private $_notification = 0;
	
	//CONSTRUCTEUR
	public function __construct(array $data)
	{
		$this->hydrate($data);
		$this->_total_point = ($this->_total_bonus) + ($this->_point);
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

	public function getPseudo()
	{
		return $this->_pseudo;
	}

	public function setPseudo($pseudo)
	{
		if(is_string($pseudo))
		{
			$this->_pseudo = $pseudo;
		}
	}

	public function getAvatar()
	{
		return $this->_avatar;
	}

	public function setAvatar($avatar)
	{
		if(is_string($avatar))
		{
			$this->_avatar = $avatar;
		}
	}

	
	public function getTotal_bonus()
	{
		return $this->_total_bonus;
	}

	public function setTotal_bonus($total_bonus='')
	{
		$total_bonus = (int) $total_bonus;

		if($total_bonus>=0)
		{
			$this->_total_bonus = $total_bonus;
		}
	}
	public function getBonus7()
	{
		return $this->_bonus7;
	}

	public function setBonus7($bonus7='')
	{
		$bonus7 = (int) $bonus7;

		if($bonus7>=0)
		{
			$this->_bonus7 = $bonus7;
		}
	}
	public function getBonus8()
	{
		return $this->_bonus8;
	}

	public function setBonus8($bonus8='')
	{
		$bonus8 = (int) $bonus8;

		if($bonus8>=0)
		{
			$this->_bonus8 = $bonus8;
		}
	}
	public function getBonus9()
	{
		return $this->_bonus9;
	}

	public function setBonus9($bonus9='')
	{
		$bonus9 = (int) $bonus9;

		if($bonus9>=0)
		{
			$this->_bonus9 = $bonus9;
		}
	}
	public function getBonus10()
	{
		return $this->_bonus10;
	}

	public function setBonus10($bonus10='')
	{
		$bonus10 = (int) $bonus10;

		if($bonus10>=0)
		{
			$this->_bonus10 = $bonus10;
		}
	}
	public function getPoint()
	{
		return $this->_point;
	}

	public function setPoint($point='')
	{
		$point = (int) $point;

		if($point>=0)
		{
			$this->_point = $point;
		}
	}
	
	public function getTotal_point()
	{
		
		return $this->_total_point;
	}
	public function setTotal_point($total_point='')
	{
		$total_point = (int) $total_point;

		if($total_point>=0)
		{
			$this->_total_point = $total_point;
		}
	}

	public function getPassword()
	{
		return $this->_password;
	}

	public function setPassword($password)
	{
		if(is_string($password))
		{
			$this->_password = $password;
		}
	}

	public function getEmail()
	{
		return $this->_email;
	}

	public function setEmail($email)
	{
		if(is_string($email))
		{
			$this->_email = $email;
		}
	}

	public function getPodium1()
	{
		return $this->_podium1;
	}

	public function setPodium1($podium1='')
	{
		$podium1 = (int) $podium1;

		if($podium1>=1 and $podium1<=20)
		{
			$this->_podium1 = $podium1;
		}
	}
	public function getPodium2()
	{
		return $this->_podium2;
	}

	public function setPodium2($podium2='')
	{
		$podium2 = (int) $podium2;

		if($podium2>=1 and $podium2<=20)
		{
			$this->_podium2 = $podium2;
		}
	}
	public function getPodium3()
	{
		return $this->_podium3;
	}

	public function setPodium3($podium3='')
	{
		$podium3 = (int) $podium3;

		if($podium3>=1 and $podium3<=20)
		{
			$this->_podium3 = $podium3;
		}
	}
	public function getRelegation18()
	{
		return $this->_relegation18;
	}

	public function setRelegation18($relegation18='')
	{
		$relegation18 = (int) $relegation18;

		if($relegation18>=0 and $relegation18<=20)
		{
			$this->_relegation18 = $relegation18;
		}
	}
	public function getRelegation19()
	{
		return $this->_relegation19;
	}

	public function setRelegation19($relegation19='')
	{
		$relegation19 = (int) $relegation19;

		if($relegation19>=0 and $relegation19<=20)
		{
			$this->_relegation19 = $relegation19;
		}
	}
	public function getRelegation20()
	{
		return $this->_relegation20;
	}

	public function setRelegation20($relegation20='')
	{
		$relegation20 = (int) $relegation20;

		if($relegation20>=0 and $relegation20<=20)
		{
			$this->_relegation20 = $relegation20;
		}
	}
	public function getStep()
	{
		return $this->_step;
	}

	public function setStep($step='')
	{
		$step = (int) $step;
		if($step>=0)
		{
			$this->_step = $step;	
		}
	}
	public function getAdmin()
	{
		return $this->_admin;
	}

	public function setAdmin($admin='')
	{
		$admin = (int) $admin;
		if($admin>=0)
		{
			$this->_admin = $admin;	
		}
	}
	public function getStake()
	{
		return $this->_stake;
	}

	public function setStake($stake='')
	{
		$stake = (int) $stake;
		if($stake>=0)
		{
			$this->_stake = $stake;	
		}
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
	public function getNotification()
	{
		return $this->_notification;
	}

	public function setNotification($notification='')
	{
		$notification = (int) $notification;
		if($notification>=0)
		{
			$this->_notification = $notification;	
		}
	}
}