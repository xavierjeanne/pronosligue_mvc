<?php 

class DayPoint
{
	private $_id;
    private $_user_id;
    private $_day;
    private $_day_point = 0;
    private $_match_number = 0;

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
    public function getUser_id()
    {
        return $this->_user_id;
    }

    public function setUser_id($user_id)
    {
            $this->_user_id = $user_id;
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
   
    public function getDay_point()
    {
        return $this->_day_point;
    }

    public function setDay_point($day_point)
    {
        $day_point = (int) $day_point;

        if($day_point>=0)
        {
            $this->_day_point = $day_point;
        }
    }
    public function getMatch_number()
    {
        return $this->_match_number;
    }

    public function setMatch_number($match_number)
    {
        $match_number = (int) $match_number;

        if($match_number>=0)
        {
            $this->_match_number = $match_number;
        }
    }
}