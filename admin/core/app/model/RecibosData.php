<?php
class RecibosData
{ //nombre de la tabla de la BD empesando por mayuscula, el Data hace la cionexion
	public static $tablename = "recibos"; //nombre de la tabla 

	public function RecibosData()
	{ //conexion de la BD
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->password = "";
		$this->created_at = "NOW()";
	} // fin de la coneion

	public function add()
	{ //registro hacia la BD
		$sql = "insert into " . self::$tablename . " (code,filename,importe,code_user,folio,created_at) "; //insercion de los campos
		$sql .= "value (\"$this->code\",\"$this->foto\",\"$this->cantidad\",\"$this->alumn_id\",\"$this->folio\",$this->created_at)"; //values y variable parala BD el $this se pone en cada variable
		return Executor::doit($sql);
	}
	//no se mueve nada 
	public static function delById($id)
	{
		$sql = "delete from " . self::$tablename . " where id=$id";
		Executor::doit($sql);
	}
	public function del()
	{
		$sql = "delete from " . self::$tablename . " where id=$this->id";
		Executor::doit($sql);
	}
	/* cambio de estatus para validar */
	public function validar()
	{
		$status = '1';
		$sql = "update " . self::$tablename . " SET status=\"$status\" Where id=$this->id";
		$sql2 = "UPDATE plan_de_pago SET status = 2  WHERE id = $this->id_plan";
		Executor::doit($sql);
		Executor::doit($sql2);
	}
	/* cambio de estatus para rechazar */
	public function rechazar($motivo)
	{
		$con = Database::getCon();
		$status = '2';
		$sql = "UPDATE " . self::$tablename . " SET status=\"$status\" WHERE id=$this->id";

		// Obtener el valor actual de la columna "folio"
		$sql_select = "SELECT folio FROM " . self::$tablename . " WHERE id=$this->id";
		$result = mysqli_query($con, $sql_select); // Ejecutar consulta y obtener el resultado

		if ($result && mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result); // Extraer el resultado como una fila
			$folio = $row['folio']; // Asignar el valor de "folio" a la variable $folio
		}
		// Actualizar la columna "foliorechz" con el valor de "folio"
		$sql_update = "UPDATE " . self::$tablename . " SET folio=NULL, foliorechz=\"FR-$folio\" WHERE id=$this->id";
		$mot = $motivo;
		$sql_update2 = "UPDATE " . self::$tablename . " SET motivorech=\"$mot\" WHERE id=$this->id";

		$sql2 = "UPDATE plan_de_pago SET status = 1  WHERE id = $this->id_plan";
		Executor::doit($sql);
		Executor::doit($sql_update);
		Executor::doit($sql_update2);
		Executor::doit($sql2);
		
	}

	// partiendo de que ya tenemos creado un objecto AsignatureData previamente utilizamos el contexto
	public function update()
	{ //Edicion de la BD
		$sql = "update " . self::$tablename . " SET code_user=\"$this->alumn_id\",folio=\"$this->folio\",importe=\"$this->cantidad\" Where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id)
	{
		$sql = "select * from " . self::$tablename . " where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new RecibosData()); //solo se cambia el nombre de la BD
	}
	public static function getAll()
	{
		$sql = "select * from " . self::$tablename . " ORDER BY id DESC";
		$query = Executor::doit($sql);
		return Model::many($query[0], new RecibosData()); //solo se cambia el nombre de la BD
	}

	public static function getAllByUserId($id)
	{
		$sql = "select * from " . self::$tablename . " where user_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0], new RecibosData()); //solo se cambia el nombre de la BD
	}

	public static function getFavoritesByUserId($id)
	{
		$sql = "select * from " . self::$tablename . " where user_id=$id and is_favorite=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], new RecibosData()); //solo se cambia el nombre de la BD
	}


	public static function getLike($q)
	{
		$sql = "select * from " . self::$tablename . " where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0], new RecibosData()); //solo se cambia el nombre de la BD
	}
	public static function getByCodeId($idUserCode)
	{
        /**traer el pago x alumno  */
        $sql = "SELECT * FROM " . self::$tablename . " WHERE code_user = '$idUserCode' ORDER BY id DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new RecibosData());
	}
}
