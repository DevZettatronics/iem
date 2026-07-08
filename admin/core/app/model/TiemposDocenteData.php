<?php
class TiemposDocenteData { //nombre de la tabla de la BD empesando por mayuscula, el Data hace la cionexion
	public static $tablename = "tiempo_docentes"; //nombre de la tabla 


	public function TiemposDocenteData(){ //conexion de la BD
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->password = "";
		$this->created_at = "NOW()";
	} // fin de la coneion

	public function add(){ //registro hacia la BD
		$sql = "insert into ".self::$tablename." (code,name,apellido,fecha_hora,tipo,fecha) "; //insercion de los campos
		$sql .= "value (\"$this->\",\"$this->\",\"$this->\",\"$this->\",\"$this->\",\"$this->\")";
		return Executor::doit($sql);
	}
			
	
	//no se mueve nada 
	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

/* 	public function update(){ //Edicion de la BD
		$sql = "update ".self::$tablename." set name=\"$this->name\" where id=$this->id";
		Executor::doit($sql);
	} */
	
	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new TiemposDocenteData()); //solo se cambia el nombre de la BD
	}
	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new TiemposDocenteData()); //solo se cambia el nombre de la BD
	}

	public static function getAllByUserId($id){
		$sql = "select * from ".self::$tablename." where user_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new TiemposDocenteData()); //solo se cambia el nombre de la BD
	}

	public static function getFavoritesByUserId($id){
		$sql = "select * from ".self::$tablename." where user_id=$id and is_favorite=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new TiemposDocenteData()); //solo se cambia el nombre de la BD
	}

	
	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new TiemposDocenteData()); //solo se cambia el nombre de la BD
	}
}
