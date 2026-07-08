<?php

class InscriptionData {

	public static $tablename = "inscription";





	public function InscriptionData(){

		$this->name = "";

		$this->lastname = "";

		$this->email = "";

		$this->password = "";

		$this->created_at = "NOW()";

	}



	public function getAlumn(){ return PersonData::getById($this->alumn_id);}

	public function getPeriod(){ return PeriodData::getById($this->period_id);}

	public function getTeam(){ return TeamData::getById($this->team_id);}



	public function add(){

		$sql = "INSERT INTO ".self::$tablename." (alumn_id,period_id,team_id,created_at) ";

		$sql .= "VALUE (\"$this->alumn_id\",\"$this->period_id\",$this->team_id,NOW())";

		return Executor::doit($sql);

	}



	public static function delById($id){

		$sql = "delete from ".self::$tablename." where id=$id";

		Executor::doit($sql);

	}

	public function del(){

		$sql = "delete from ".self::$tablename." where id=$this->id";

		Executor::doit($sql);

	}



// partiendo de que ya tenemos creado un objecto InscriptionData previamente utilizamos el contexto

	public function update(){

		$sql = "update ".self::$tablename." set grade=\"$this->grade\",letter=\"$this->letter\" where id=$this->id";

		Executor::doit($sql);

	}



	public function finish(){

		$sql = "update ".self::$tablename." set status=2 where id=$this->id";

		Executor::doit($sql);

	}



	public static function getById($id){

		$sql = "select * from ".self::$tablename." where id=$id";

		$query = Executor::doit($sql);

		return Model::one($query[0],new InscriptionData());

	}



	public static function getActive($id){

		$sql = "select * from ".self::$tablename." where alumn_id=$id and is_finished=0";

		$query = Executor::doit($sql);

		return Model::one($query[0],new InscriptionData());

	}



	public static function getByAPT($a,$p,$t){

		$sql = "select * from ".self::$tablename." where alumn_id=$a and period_id=$p and team_id=$t";

		$query = Executor::doit($sql);

		return Model::one($query[0],new InscriptionData());

	}



	public static function getAll(){

		$sql = "select * from ".self::$tablename;

		$query = Executor::doit($sql);

		return Model::many($query[0],new InscriptionData());

	}





	public static function getAllByTeamId($id){

		$sql = "select * from ".self::$tablename." where team_id=$id";

		$query = Executor::doit($sql);

		return Model::many($query[0],new InscriptionData());

	}

	public static function getAllByTP($id,$period_id){

		$sql = "select * from ".self::$tablename." where team_id=$id and period_id=$period_id";

		$query = Executor::doit($sql);

		return Model::many($query[0],new InscriptionData());

	}





	public static function getAllByAlumnId($id){

		$sql = "select * from ".self::$tablename." where alumn_id=$id";

		$query = Executor::doit($sql);

		return Model::many($query[0],new InscriptionData());

	}



	public static function getFavoritesByUserId($id){

		$sql = "select * from ".self::$tablename." where user_id=$id and is_favorite=1";

		$query = Executor::doit($sql);

		return Model::many($query[0],new InscriptionData());

	}



	

	public static function getLike($q){

		$sql = "select * from ".self::$tablename." where name like '%$q%'";

		$query = Executor::doit($sql);

		return Model::many($query[0],Inscription());

	}





}



?>