<?php
class AsignatureData {
	public static $tablename = "asignature";  


	public function AsignatureData(){
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->password = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (code,name,program,credito,grado,id_program) ";
		$sql .= "value (\"$this->code_asignatura\",\"$this->name\",\"$this->program\",\"$this->credito\",\"$this->grado\",\"$this->id_program\")";
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

	//partiendo de que ya tenemos creado un objecto AsignatureData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set code=\"$this->code_asignatura\",name=\"$this->name\",program=\"$this->program\",credito=\"$this->credito\",grado=\"$this->grado\",id_program=\"$this->id_program\" where id=$this->id";
		Executor::doit($sql);
	}
	
	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new AsignatureData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new AsignatureData());
	}

	public static function getAllByUserId($id){
		$sql = "select * from ".self::$tablename." where user_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new AsignatureData());
	}

	public static function getFavoritesByUserId($id){
		$sql = "select * from ".self::$tablename." where user_id=$id and is_favorite=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new AsignatureData());
	}

	
	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new AsignatureData());
	}


}

?>