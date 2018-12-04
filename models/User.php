<?php 

class User 
{
	private $_id;
	private $_pseudo;
	private $_avatar = '';
	private $_notification = 0;
	private $_total_point = 0;
	private $_total_day_point= 0;
	private $_bonus_10 = 0;
	private $_bonus_9 = 0;
	private $_bonus_8 = 0;
	private $_bonus_7 = 0;
	private $_podium_1 = 0;
	private $_podium_2 = 0;
	private $_podium_3 = 0;
	private $_relegable_18 = 0;
	private $_relegable_19 = 0;
	private $_relegable_20= 0;
	private $_ranking = 0;
	private $_ranking_before = 0;
	private $_step = 0;
	private $_password;
	private $_email;
	private $_admin = 0;
	private $_created_at;
	private $_updated_at;
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

	public function setAvatar($avatar='')
	{
		if(is_string($avatar))
		{
		$this->_avatar = $avatar;
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

	public function getTotal_day_point()
	{
		return $this->_total_day_point;
	}

	public function setTotal_day_point($total_day_point='')
	{
		$total_day_point = (int) $total_day_point;

		if($total_day_point>=0)
		{
			$this->_total_day_point = $total_day_point;
		}
	}

	public function getBonus_10()
	{
		return $this->_bonus_10;
	}

	public function setBonus_10($bonus_10='')
	{
		$bonus_10 = (int) $bonus_10;

		if($bonus_10>=0)
		{
			$this->_bonus_10 = $bonus_10;
		}
	}

	public function getBonus_9()
	{
		return $this->_bonus_9;
	}

	public function setBonus_9($bonus_9='')
	{
		$bonus_9 = (int) $bonus_9;

		if($bonus_9>=0)
		{
			$this->_bonus_9 = $bonus_9;
		}
	}

	public function getBonus_8()
	{
		return $this->_bonus_8;
	}

	public function setBonus_8($bonus_8='')
	{
		$bonus_8 = (int) $bonus_8;

		if($bonus_8>=0)
		{
			$this->_bonus_8 = $bonus_8;
		}
	}

	public function getBonus_7()
	{
		return $this->_bonus_7;
	}

	public function setBonus_7($bonus_7='')
	{
		$bonus_7 = (int) $bonus_7;

		if($bonus_7>=0)
		{
			$this->_bonus_7 = $bonus_7;
		}
	}

	public function getPodium_1()
	{
		return $this->_podium_1;
	}

	public function setPodium_1($podium_1='')
	{
		$podium_1 = (int) $podium_1;

		if($podium_1>=0)
		{
			$this->_podium_1 = $podium_1;
		}
	}

	public function getPodium_2()
	{
		return $this->_podium_2;
	}

	public function setPodium_2($podium_2='')
	{
		$podium_2 = (int) $podium_2;

		if($podium_2>=0)
		{
			$this->_podium_2 = $podium_2;
		}
	}

	public function getPodium_3()
	{
		return $this->_podium_3;
	}

	public function setPodium_3($podium_3='')
	{
		$podium_3 = (int) $podium_3;

		if($podium_3>=0)
		{
			$this->_podium_3 = $podium_3;
		}
	}

	public function getRelegable_18()
	{
		return $this->_relegable_18;
	}

	public function setRelegable_18($relegable_18='')
	{
		$relegable_18 = (int) $relegable_18;

		if($relegable_18>=0)
		{
			$this->_relegable_18 = $relegable_18;
		}
	}

	public function getRelegable_19()
	{
		return $this->_relegable_19;
	}

	public function setRelegable_19($relegable_19='')
	{
		$relegable_19 = (int) $relegable_19;

		if($relegable_19>=0)
		{
			$this->_relegable_19 = $relegable_19;
		}
	}

	public function getRelegable_20()
	{
		return $this->_relegable_20;
	}

	public function setRelegable_20($relegable_20='')
	{
		$relegable_20 = (int) $relegable_20;

		if($relegable_20>=0)
		{
			$this->_relegable_20 = $relegable_20;
		}
	}

	public function getRanking()
	{
		return $this->_ranking;
	}

	public function setRanking($ranking='')
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

	public function setRanking_before($ranking_before='')
	{
		$ranking_before = (int) $ranking_before;

		if($ranking_before>=0)
		{
			$this->_ranking_before = $ranking_before;
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

	public function getAdmin()
	{
		return $this->_admin;
	}

	public function setAdmin($admin='')
	{
		$this->_admin = $admin;
	}

	public function getCreated_at()
	{
		return $this->_created_at;
	}

	public function setCreated_at($created_at)
	{
		$this->_created_at = $created_at;
	}

	public function getUpdated_at()
	{
		return $this->_updated_at;
	}

	public function setUpdated_at($updated_at)
	{
		$this->_updated_at = $updated_at;
	}
}