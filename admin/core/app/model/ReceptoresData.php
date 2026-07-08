<?php

class ReceptoresData

{

	public static $tablename = "customers";

	public function ReceptoresData()

	{


	}


	    public function add()
	    {
    
	    	$sql = "INSERT INTO " . self::$tablename . " (name,porcentaje,descripcion,tipo,state) ";/* campos de BD */
    
	    	$sql .= "VALUE (\"$this->name\",\"$this->porcentaje\",\"$this->descripcion\",\"$this->tipo\",\"$this->state\")";/* variables a insrtar */
    
	    	return Executor::doit($sql);
    
	    }

		public static function getById($id)
		{
			$sql = "SELECT * FROM " . self::$tablename . " WHERE id = '" . $id . "' ";
			$query = Executor::doit($sql);
			return Model::many($query[0], new ReceptoresData);
		}

    	public static function getAll()
	{
		$sql = "SELECT * FROM " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], new ReceptoresData()); //solo se cambia el nombre de la BD
	}
	/****************************/

	public function del()

	{

		$sql = "DELETE FROM " . self::$tablename . " WHERE id=$this->id";

		Executor::doit($sql);

	}

	public function addMoral()
	{

		$sql = "INSERT INTO " . self::$tablename . " (created_at,name,address1,telefono,email,city,state,postal_code,muni,rfc,country,razon,regimen,descuento) ";/* campos de BD */
    
		$sql .= "VALUES (NOW(),\"$this->name\",\"$this->address1\",\"$this->telefono\",\"$this->email\",\"$this->city\",\"$this->state\",\"$this->postal_code\",\"$this->muni\",\"$this->rfc\",\"$this->country\",'1',\"$this->regimen\",\"$this->descuento\")";/* variables a insrtar */

		return Executor::doit($sql);


	}

	public  function addFisica()
	{

		$sql = "INSERT INTO " . self::$tablename . " (created_at,name,last_name,address1,telefono,email,city,state,postal_code,muni,rfc,country,razon,regimen,descuento) ";/* campos de BD */

		$sql .= "VALUES (NOW(),\"$this->name\",\"$this->last_name\",\"$this->address1\",\"$this->telefono\",\"$this->email\",\"$this->city\",\"$this->state\",\"$this->postal_code\",\"$this->muni\",\"$this->rfc\",\"$this->country\",'1',\"$this->regimen\",\"$this->descuento\")";/* variables a insrtar */

		return Executor::doit($sql);

	}
	public function updateMoral()
	{

		$sql = "UPDATE " . self::$tablename . " set name=\"$this->name\",address1=\"$this->address1\",telefono=\"$this->telefono\",email=\"$this->email\",city=\"$this->city\",state=\"$this->state\",postal_code=\"$this->postal_code\",muni=\"$this->muni\",rfc=\"$this->rfc\",country=\"$this->country\",regimen=\"$this->regimen\",descuento=\"$this->descuento\" WHERE id = \"$this->id\"  ";/* campos de BD */

		Executor::doit($sql);

	}

	public  function updateFisica()
	{

		$sql = "UPDATE " . self::$tablename . " set name=\"$this->name\",last_name=\"$this->last_name\",address1=\"$this->address1\",telefono=\"$this->telefono\",email=\"$this->email\",city=\"$this->city\",state=\"$this->state\",postal_code=\"$this->postal_code\",muni=\"$this->muni\",rfc=\"$this->rfc\",country=\"$this->country\",regimen=\"$this->regimen\",descuento=\"$this->descuento\" WHERE id = \"$this->id\" ";/* campos de BD */

		return Executor::doit($sql);

	}

	public static function getByIdOnly($id)
	{

		$sql = "SELECT id FROM " . self::$tablename . " WHERE id = '" . $id . "' ";
		$query = Executor::doit($sql);
		return Model::one($query[0], new ReceptoresData);

	}


}
?>
