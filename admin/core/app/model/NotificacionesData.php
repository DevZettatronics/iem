<?php
class NotificacionesData {
	public static $tablename = "notificaciones";


	public function NotificacionesData(){
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->password = "";
		$this->fecha = "NOW()";
	}

	//---------------inserta notificaciones------------------

	public function add(){
		$sql = "insert into ".self::$tablename." (mensaje,id_receptor,user_id,fecha) ";
		$sql .= "value (\"$this->mensaje\",\"$this->id_receptor\",$this->user_id,NOW())";
		return Executor::doit($sql);
	}

	//-------------fin inserta notificaciones------------------
	
	//---------------Eliminar notificaciones------------------
	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	//-------------fin eliminar notificaciones------------------

	//-------------actualizar notificaciones------------------
	// partiendo de que ya tenemos creado un objecto NotificacionData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set mensaje=\"$this->mensaje\",id_receptor=\"$this->id_receptor\" where id=$this->id";
		Executor::doit($sql);
	}

	//-------------fin actualizar notificaciones------------------



	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new NotificacionesData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new NotificacionesData());
	}

	

	public static function getAllByQ($q){
		$sql = "select * from ".self::$tablename." ".$q;
		$query = Executor::doit($sql);
		return Model::many($query[0],new NotificacionesData());
	}


	public static function getAllByUserId($id){
		$sql = "select * from ".self::$tablename." where user_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new NotificacionesData());
	}

	public static function getFavoritesByUserId($id){
		$sql = "select * from ".self::$tablename." where user_id=$id and is_favorite=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new NotificacionesData());
	}

	
	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new NotificacionesData());
	}


}

?>