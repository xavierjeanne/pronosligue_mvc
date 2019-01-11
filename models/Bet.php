<?php 

class Bet
{
	private $_id;
    private $_match_id;
    private $_user_id;
    private $_bet;
    private $_result = 0;

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

    public function getMatch_id()
    {
        return $this->_match_id;
    }

    public function setMatch_id($match_id)
    {
        $match_id = (int) $match_id;

        if($match_id>0)
        {
            $this->_match_id = $match_id;
        }
    }

    public function getUser_id()
    {
        return $this->_user_id;
    }

    public function setUser_id($user_id)
    {
        $user_id = (int) $user_id;

        if($user_id>0)
        {
            $this->_user_id = $user_id;
        }
    }
   
    public function getBet()
    {
        return $this->_bet;
    }

    public function setBet($bet)
    {
        $this->_bet = $bet;
    
    }

    public function getResult()
    {
        return $this->_result;
    }

    public function setResult($result)
    {
        $result = (int) $result;

        if($result>=0)
        {
            $this->_result = $result;
        }
    }
}