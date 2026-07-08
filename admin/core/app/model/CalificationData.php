<?php
class CalificationData
{
	public static $tablename = "calification";


	public function CalificationData()
	{
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->password = "";
		$this->created_at = "NOW()";
	}

	public function getTeacher()
	{
		return TeacherData::getById($this->teacher_id);
	}
	public function getAsignature()
	{
		return AsignatureData::getById($this->asignature_id);
	}
	public function getRoom()
	{
		return RoomData::getById($this->room_id);
	}

	public function add()
	{
		$sql = "insert into " . self::$tablename . " (alumn_id,block_id,val,block_id_father,created_at) ";
		$sql .= "value (\"$this->alumn_id\",\"$this->block_id\",\"$this->val\",\"$this->block_id_father\",NOW())";
		return Executor::doit($sql);
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

	// partiendo de que ya tenemos creado un objecto CalificationData previamente utilizamos el contexto
	public function update_val()
	{
		$sql = "update " . self::$tablename . " set val=\"$this->val\",block_id_father=\"$this->block_id_father\" where id=$this->id";
		Executor::doit($sql);
	}


	public static function getById($id)
	{
		$sql = "select * from " . self::$tablename . " where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new CalificationData());
	}

	public static function getAllByIdFather($alumn, $id)
	{
		$sql = "select * from " . self::$tablename . " where alumn_id= $alumn and block_id_father = $id";
		$query = Executor::doit($sql);
		return Model::many($query[0], new CalificationData());
	}

	public static function numeroBloques($alumn_id, $idIn)
	{
		$sql = "SELECT count(*) AS NumeroBloques FROM " . self::$tablename . " WHERE alumn_id = $alumn_id AND block_id in ($idIn)";
		$query = Executor::doit($sql);
		return Model::one($query[0], new CalificationData());
	}

	public static function numeroDeBloquesPadre($alumn_id, $idIn)
	{
		$sql = "SELECT distinct(block_id_father) as BloquePadre FROM " . self::$tablename . " WHERE alumn_id = $alumn_id AND block_id in ($idIn)";
		$query = Executor::doit($sql);
		return Model::many($query[0], new CalificationData());
	}

	public static function sumaBloquesPadre($alumn_id, $idFather)
	{
		$sql = "SELECT  sum(val) AS SumaDeBloque FROM " . self::$tablename . " WHERE alumn_id = $alumn_id AND block_id_father = $idFather";
		$query = Executor::doit($sql);
		return Model::one($query[0], new CalificationData());
	}

	public static function numeroHijosxBloque($alumn_id, $idFather)
	{
		$sql = "SELECT count(*) AS hijosDelBloque FROM " . self::$tablename . " WHERE alumn_id = $alumn_id AND block_id_father = $idFather";
		$query = Executor::doit($sql);
		return Model::one($query[0], new CalificationData());
	}

	public static function calificacionesL($alumn_id, $idFather)
	{
		$sql = "SELECT * FROM " . self::$tablename . " WHERE alumn_id = $alumn_id AND block_id_father = $idFather";
		$query = Executor::doit($sql);
		return Model::many($query[0], new CalificationData());
	}

	public static function getAllByIdFatherSumado($alumn, $id)
	{
		$sql = "select SUM(val) as Calificacion from " . self::$tablename . " where alumn_id= $alumn and block_id_father = $id";
		$query = Executor::doit($sql);
		return Model::many($query[0], new CalificationData());
	}

	public static function getExist($alumn, $block)
	{
		$sql = "select * from " . self::$tablename . " where alumn_id=$alumn and block_id=$block";
		$query = Executor::doit($sql);
		return Model::one($query[0], new CalificationData());
	}
	public static function getAll()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], new CalificationData());
	}

	public static function getAllByAsignationId($id)
	{
		$sql = "select * from " . self::$tablename . " where asignation_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0], new CalificationData());
	}

	public static function getFavoritesByUserId($id)
	{
		$sql = "select * from " . self::$tablename . " where user_id=$id and is_favorite=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], new CalificationData());
	}
	public static function getLike($q)
	{
		$sql = "select * from " . self::$tablename . " where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0], Inscription());
	}
}
