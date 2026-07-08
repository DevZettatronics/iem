<?php
class PGAData {
	public static $tablename = "pga";
	public function getGrade(){ return GradeData::getById($this->grade_id);}
	public function getPlan(){ return PlanData::getById($this->plan_id);}
	public function getAsignature(){ return AsignatureData::getById($this->asignature_id);}

	public function PGAData(){
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->password = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (plan_id,grade_id,asignature_id) ";
		$sql .= "value (\"$this->plan_id\",$this->grade_id,$this->asignature_id)";
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

// partiendo de que ya tenemos creado un objecto PGAData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new PGAData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new PGAData());
	}

	public static function getAllByPlanId($id){
		$sql = "select * from ".self::$tablename." where plan_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PGAData());
	}



	
	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PGAData());
	}


}

?>