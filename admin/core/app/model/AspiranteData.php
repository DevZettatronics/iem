<?php

class AspiranteData { //nombre de la tabla de la BD empesando por mayuscula, el Data hace la cionexion

	public static $tablename = "aspirante"; //nombre de la tabla 

	public function AspiranteData(){ //conexion de la BD

		$this->name = "";

		$this->lastname = "";

		$this->email = "";

		$this->password = "";

		$this->created_at = "NOW()";

		$this->country_id = "";

	} // fin de la coneion

	public function add(){ //registro hacia la BD

		$sql = "INSERT INTO ".self::$tablename." (name,lastname,fecha_n,nacionalidad,country_id,curp,genero,person_email,phone,carrera,beca,promocion) "; //insercion de los campos

		$sql .= "value (\"$this->name\",\"$this->lastname\",\"$this->fecha_n\",\"$this->nacionalidad\",\"$this->country_id\",\"$this->curp\",\"$this->genero\",\"$this->person_email\",\"$this->phone\",\"$this->carrera\",\"$this->beca\",\"$this->promocion\")"; //values y variable parala BD el $this se pone en cada variable

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

// partiendo de que ya tenemos creado un objecto AsignatureData previamente utilizamos el contexto

	public function update(){ //Edicion de la BD

		$sql = "update ".self::$tablename." set name=\"$this->name\",lastname=\"$this->lastname\",nacionalidad=\"$this->nacionalidad\",country_id=\"$this->country_id\",fecha_n=\"$this->fecha_n\",curp=\"$this->curp\",genero=\"$this->genero\",person_email=\"$this->person_email\",phone=\"$this->phone\",carrera=\"$this->carrera\",beca=\"$this->beca\",promocion=\"$this->promocion\" where id=$this->id"; //variables

		Executor::doit($sql);

	}

	

	public static function getById($id){

		$sql = "select * from ".self::$tablename." where id=$id";

		$query = Executor::doit($sql);

		return Model::one($query[0],new AspiranteData()); //solo se cambia el nombre de la BD

	}

	public static function getAll(){

		$sql = "select * from ".self::$tablename;

		$query = Executor::doit($sql);

		return Model::many($query[0],new AspiranteData()); //solo se cambia el nombre de la BD

	}

	public static function getAllByUserId($id){

		$sql = "select * from ".self::$tablename." where user_id=$id";

		$query = Executor::doit($sql);

		return Model::many($query[0],new AspiranteData()); //solo se cambia el nombre de la BD

	}

	public static function getFavoritesByUserId($id){

		$sql = "select * from ".self::$tablename." where user_id=$id and is_favorite=1";

		$query = Executor::doit($sql);

		return Model::many($query[0],new AspiranteData()); //solo se cambia el nombre de la BD

	}

	

	public static function getLike($q){

		$sql = "select * from ".self::$tablename." where name like '%$q%'";

		$query = Executor::doit($sql);

		return Model::many($query[0],new AspiranteData()); //solo se cambia el nombre de la BD

	}

	  /* public function getPro(){ return EducationalProgramData::getAll($this->carrera);}  */ /* iguala la ifnormacion y cae en tabla por el getPro */

	/*  public function getBeca(){ return PromocionesData::getById($this->beca);} */ /* iguala la ifnormacion y cae en tabla por el getPro */

}

