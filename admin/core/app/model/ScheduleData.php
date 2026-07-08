<?php
class ScheduleData {
	public static $tablename = "schedule";


	public function ScheduleData(){
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->password = "";
		$this->created_at = "NOW()";
	}

	public function getTeacher(){ return TeacherData::getById($this->teacher_id);}
	public function getAsignature(){ return AsignatureData::getById($this->asignature_id);}
	public function getRoom(){ return RoomData::getById($this->room_id);}

	public function add(){
		$sql = "insert into ".self::$tablename." (room_id,asignation_id,d,time_start,time_end,created_at) ";
		$sql .= "value (\"$this->room_id\",\"$this->asignation_id\",\"$this->d\",\"$this->time_start\",\"$this->time_end\",NOW())";
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

// partiendo de que ya tenemos creado un objecto ScheduleData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set grade=\"$this->grade\",letter=\"$this->letter\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ScheduleData());
	}

	public static function getExist($asignation,$room,$d,$start,$end){
		 $sql = "select * from ".self::$tablename." where asignation_id=$asignation and room_id=$room and d=\"$d\" and time_start=\"$start\" and time_end=\"$end\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ScheduleData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new ScheduleData());
	}

	public static function getAllByAsignationId($id){
		$sql = "select * from ".self::$tablename." where asignation_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ScheduleData());
	}

	public static function getFavoritesByUserId($id){
		$sql = "select * from ".self::$tablename." where user_id=$id and is_favorite=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ScheduleData());
	}

	
	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],Inscription());
	}


}

?>