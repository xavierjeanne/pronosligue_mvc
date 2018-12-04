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
	private $_ranking = 0;
	private $_ranking_before = 0;
	private $_form_1 = 0 ;
	private $_form_2 = 0;
	private $_form_3 = 0;
	private $_form_4 = 0;
	private $_form_5 = 0;
	private $_home_form_1 = 0;
	private $_home_form_2 = 0;
	private $_home_form_3 = 0;
	private $_home_form_4 = 0;
	private $_home_form_5 = 0;
	private $_outside_form_1 = 0;
	private $_outside_form_2 = 0;
	private $_outside_form_3 = 0;
	private $_outside_form_4 = 0;
	private $_outside_form_5 = 0;
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
	public function getId(){
		return $this->_id;
	}

	public function setId($id){
		$this->_id = $id;
	}

	public function getName(){
		return $this->_name;
	}

	public function setName($name){
		$this->_name = $name;
	}

	public function getAlias(){
		return $this->_alias;
	}

	public function setAlias($alias){
		$this->_alias = $alias;
	}

	public function getFlag(){
		return $this->_flag;
	}

	public function setFlag($flag){
		$this->_flag = $flag;
	}

	public function getJersey(){
		return $this->_jersey;
	}

	public function setJersey($jersey){
		$this->_jersey = $jersey;
	}

	public function getDay(){
		return $this->_day;
	}

	public function setDay($day){
		$this->_day = $day;
	}

	public function getPoint(){
		return $this->_point;
	}

	public function setPoint($point){
		$this->_point = $point;
	}

	public function getWon(){
		return $this->_won;
	}

	public function setWon($won){
		$this->_won = $won;
	}

	public function getDrawn(){
		return $this->_drawn;
	}

	public function setDrawn($drawn){
		$this->_drawn = $drawn;
	}

	public function getLost(){
		return $this->_lost;
	}

	public function setLost($lost){
		$this->_lost = $lost;
	}

	public function getGoal_for(){
		return $this->_goal_for;
	}

	public function setGoal_for($goal_for){
		$this->_goal_for = $goal_for;
	}

	public function getGoal_against(){
		return $this->_goal_against;
	}

	public function setGoal_against($goal_against){
		$this->_goal_against = $goal_against;
	}

	public function getGoal_difference(){
		return $this->_goal_difference;
	}

	public function setGoal_difference($goal_difference){
		$this->_goal_difference = $goal_difference;
	}

	public function getRanking(){
		return $this->_ranking;
	}

	public function setRanking($ranking){
		$this->_ranking = $ranking;
	}

	public function getRanking_before(){
		return $this->_ranking_before;
	}

	public function setRanking_before($ranking_before){
		$this->_ranking_before = $ranking_before;
	}

	public function getForm_1(){
		return $this->_form_1;
	}

	public function setForm_1($form_1){
		$this->_form_1 = $form_1;
	}

	public function getForm_2(){
		return $this->_form_2;
	}

	public function setForm_2($form_2){
		$this->_form_2 = $form_2;
	}

	public function getForm_3(){
		return $this->_form_3;
	}

	public function setForm_3($form_3){
		$this->_form_3 = $form_3;
	}

	public function getForm_4(){
		return $this->_form_4;
	}

	public function setForm_4($form_4){
		$this->_form_4 = $form_4;
	}

	public function getForm_5(){
		return $this->_form_5;
	}

	public function setForm_5($form_5){
		$this->_form_5 = $form_5;
	}

	public function getHome_form_1(){
		return $this->_home_form_1;
	}

	public function setHome_form_1($home_form_1){
		$this->_home_form_1 = $home_form_1;
	}

	public function getHome_form_2(){
		return $this->_home_form_2;
	}

	public function setHome_form_2($home_form_2){
		$this->_home_form_2 = $home_form_2;
	}

	public function getHome_form_3(){
		return $this->_home_form_3;
	}

	public function setHome_form_3($home_form_3){
		$this->_home_form_3 = $home_form_3;
	}

	public function getHome_form_4(){
		return $this->_home_form_4;
	}

	public function setHome_form_4($home_form_4){
		$this->_home_form_4 = $home_form_4;
	}

	public function getHome_form_5(){
		return $this->_home_form_5;
	}

	public function setHome_form_5($home_form_5){
		$this->_home_form_5 = $home_form_5;
	}

	public function getOutside_form_1(){
		return $this->_outside_form_1;
	}

	public function setOutside_form_1($outside_form_1){
		$this->_outside_form_1 = $outside_form_1;
	}

	public function getOutside_form_2(){
		return $this->_outside_form_2;
	}

	public function setOutside_form_2($outside_form_2){
		$this->_outside_form_2 = $outside_form_2;
	}

	public function getOutside_form_3(){
		return $this->_outside_form_3;
	}

	public function setOutside_form_3($outside_form_3){
		$this->_outside_form_3 = $outside_form_3;
	}

	public function getOutside_form_4(){
		return $this->_outside_form_4;
	}

	public function setOutside_form_4($outside_form_4){
		$this->_outside_form_4 = $outside_form_4;
	}

	public function getOutside_form_5(){
		return $this->_outside_form_5;
	}

	public function setOutside_form_5($outside_form_5){
		$this->_outside_form_5 = $outside_form_5;
	}

	public function getCreated_at(){
		return $this->_created_at;
	}

	public function setCreated_at($created_at){
		$this->_created_at = $created_at;
	}

	public function getUpdated_at(){
		return $this->_updated_at;
	}

	public function setUpdate_at($updated_at){
		$this->_updated_at = $updated_at;
	}
}