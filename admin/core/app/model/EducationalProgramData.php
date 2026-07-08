<?php
class EducationalProgramData {
	public static $tablename = "program";
	public static $tablename2 = "modalidad ";
   

	public function EducationalProgramData(){
		$this->name = "";
		$this->grade = "";
		$this->type = "";
		$this->nc = "";
		$this->rvoe = "";
		$this->created_at = "NOW()";
		$this->p_a= "";
		
	}

	// public function getGrado(){ return AcademicDegree::getById($this->grade);}

	public function add(){
		$sql = "insert into ".self::$tablename." (id_p,name,grade,clavep,type,no_rvoe,frvoe,nc,created_at,periodo_academico,clave_plan,calmin,calmax,calap) ";
		$sql .= "value (\"$this->id_p\",\"$this->name\",\"$this->grado\",\"$this->clavep\",\"$this->tipo\",\"$this->no_rvoe\",\"$this->frvoe\",\"$this->nc\",$this->created_at,\"$this->p_a\",\"$this->clave_plan\",\"$this->calmin\",\"$this->calmax\",\"$this->calap\")";
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

// partiendo de que ya tenemos creado un objecto EducationalProgramData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set id_p=\"$this->id_p\",name=\"$this->name\",grade=\"$this->grado\",clavep=\"$this->clavep\",type=\"$this->tipo\",no_rvoe=\"$this->no_rvoe\",frvoe=\"$this->frvoe\",nc=\"$this->nc\",periodo_academico=\"$this->p_a\",clave_plan=\"$this->clave_plan\",calmin=\"$this->calmin\",calmax=\"$this->calmax\",calap=\"$this->calap\" where id=$this->id";
		Executor::doit($sql);
	}
	
	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new EducationalProgramData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new EducationalProgramData());
	}

	public static function getAllByUserId($id){
		$sql = "select * from ".self::$tablename." where user_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new EducationalProgramData());
	}

	public static function getFavoritesByUserId($id){
		$sql = "select * from ".self::$tablename." where user_id=$id and is_favorite=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new EducationalProgramData());
	}

	
	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new EducationalProgramData());
	}

	// public static function getNC(){
	// 	$sql = "select nc,grade,id from ".self::$tablename ;
	// 	$query = Executor::doit($sql);
	// 	return Model::many($query[0],new EducationalProgramData());
	// }

	public static function getGrade(){
		$sql = "select grade from ".self::$tablename ." group by grade";
		$query = Executor::doit($sql);
		return Model::many($query[0],new EducationalProgramData());
	}
	public static function getName($name){
		$sql = "select name,id from ".self::$tablename." where grade="."'$name'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new EducationalProgramData());
	}

	public static function getAllTeam(){
		$sql = "select * from ".self::$tablename2;
		$query = Executor::doit($sql);
		return Model::many($query[0],new EducationalProgramData());
	}

}

?>