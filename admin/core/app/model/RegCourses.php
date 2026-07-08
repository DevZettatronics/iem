<?php
class RegCourses {
	public static $tablename = "reg_courses";

	public function add(){
		$sql = "insert into ".self::$tablename." (name) ";
		$sql .= "value (\"$this->name\")";
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
	public function delperson(){
		$sql = "delete from ".self::$tablename." where id_person = $this->person and id_course = $this->course";
		Executor::doit($sql);
	}

// partiendo de que ya tenemos creado un objecto RoomData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new RegCourses());
	}

	public static function getByIdPersonCourse($id_person,$id_course){
		$sql = "select * from ".self::$tablename." where id_person = $id_person AND id_course = $id_course";
		$query = Executor::doit($sql);
		return Model::one($query[0],new RegCourses());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new RegCourses());
	}

	public static function getAllByUserId($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id_person =$id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new RegCourses());
	}
	public static function getAllByCourseId($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id_course =$id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new RegCourses());
	}

	public static function getFavoritesByUserId($id){
		$sql = "select * from ".self::$tablename." where user_id=$id and is_favorite=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new RegCourses());
	}

	
	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new RegCourses());
	}


}
