<?php

class BecasData

{

	public static $tablename = "becas";

	public static $tablename1 = "alumns_bec_prom";





	public function BecasData()

	{

		$this->name = "";

		$this->porcentaje = "";

		$this->description = "";

		$this->state = "";

	}



	public function add()

	{

		$sql = "INSERT INTO " . self::$tablename . " (name,porcentaje,descripcion,tipo,state) ";/* campos de BD */

		$sql .= "value (\"$this->name\",\"$this->porcentaje\",\"$this->descripcion\",\"$this->tipo\",\"$this->state\")";/* variables a insrtar */

		return Executor::doit($sql);

	}

		/*Se inserta la informacion en la tabla alumns_bec_prom*/

		public function add_becas_prom()
		{
			$sql = "INSERT INTO " . self::$tablename1 . " (code,name,lastname,beca,promocion,email,created_at)";
			$sql .= "value (\"$this->code\",\"$this->name\",\"$this->lastname\",\"$this->beca\",\"$this->promocion\",\"$this->email\",NOW())";
			return Executor::doit($sql);
		}
		public static function getByCode($code)
		{
			$sql = "SELECT * FROM " . self::$tablename1 . " WHERE code = '" . $code . "' ORDER BY created_at DESC ";
			$query = Executor::doit($sql);
			return Model::many($query[0], new BecasData());
		}

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



	// partiendo de que ya tenemos creado un objecto BecasData previamente utilizamos el contexto

	public function update()

	{

		$sql = "update " . self::$tablename . " set name=\"$this->name\",porcentaje=\"$this->porcentaje\",descripcion=\"$this->descripcion\" where id=$this->id";

		Executor::doit($sql);

	}



	public static function getById($id)

	{

		$sql = "select * from " . self::$tablename . " where id=$id";

		$query = Executor::doit($sql);

		return Model::one($query[0], new BecasData());

	}

	// se crea funcion para traer los de tipo 1
	public static function getType1()
	{
		$sql = "select * from " . self::$tablename . " where tipo= '1' AND id >= 2";
		$query = Executor::doit($sql);
		return Model::many($query[0], new BecasData());
	}

	// se crea funcion para traer los de tipo 2
	public static function getType2()
	{
		$sql = "select * from " . self::$tablename . " where tipo= '2' AND id >2 ";
		$query = Executor::doit($sql);
		return Model::many($query[0], new BecasData());
	}

	public static function getAll()

	{

		$sql = "select * from " . self::$tablename;

		$query = Executor::doit($sql);

		return Model::many($query[0], new BecasData());

	}



	public static function getAllByUserId($id)

	{

		$sql = "select * from " . self::$tablename . " where user_id=$id";

		$query = Executor::doit($sql);

		return Model::many($query[0], new BecasData());

	}



	public static function getFavoritesByUserId($id)

	{

		$sql = "select * from " . self::$tablename . " where user_id=$id and is_favorite=1";

		$query = Executor::doit($sql);

		return Model::many($query[0], new BecasData());

	}





	public static function getLike($q)

	{

		$sql = "select * from " . self::$tablename . " where name like '%$q%'";

		$query = Executor::doit($sql);

		return Model::many($query[0], new BecasData());

	}

	/* Beca  */
	public static function getBeca()
	{
		$sql = "select * from " . self::$tablename . " where tipo='1'";
		$query = Executor::doit($sql);
		return Model::many($query[0], new BecasData());
	}
	/* FUncion para asporante */
	public static function getPromociones()
	{
		$sql = "select * from " . self::$tablename . " where tipo='2'";
		$query = Executor::doit($sql);
		return Model::many($query[0], new BecasData());
	}
	/**************/

	public static function getByNombre($id)

	{

		$sql = "select * from " . self::$tablename . " where id=$id";

		$query = Executor::doit($sql);

		return Model::one($query[0], new BecasData());

	}

	/* becas paga pago */

	public static function getAllBec()

	{/* llamada del ID  */

		if (isset($_SESSION["alumn_id"])) {

			$estudiantes = PersonData::getById($_SESSION["alumn_id"])->id;

		}

		/* consulta por tabla person */

		$con = Database::getCon();

		$sqlb = mysqli_query($con, "SELECT * FROM person WHERE id='$estudiantes'");

		$rosw = mysqli_fetch_array($sqlb);

		$becas_id = $rosw['beca'];



		$sql = "select * from " . self::$tablename . " where id=$becas_id";

		$query = Executor::doit($sql);

		return Model::many($query[0], new BecasData());

	}

	/****************************/

}

