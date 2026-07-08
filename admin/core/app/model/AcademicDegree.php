<?php
class AcademicDegree {
	public static $tablename = "academic_degree";

  
	public function AcademicDegree(){
		$this->degree = "";
	}

	

	public static function getA(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new AcademicDegree());
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new AcademicDegree());
	}

	public static function getDee($id){
		$sql = "select degree from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new AcademicDegree());
	}


}

?>