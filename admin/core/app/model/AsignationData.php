<?php
class AsignationData
{
	public static $tablename = "asignation";


	public function AsignationData()
	{
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->password = "";
		$this->created_at = "NOW()";
	}

	public function getTeam()
	{
		return TeamData::getById($this->team_id);
	}
	public function getTeacher()
	{
		return PersonData::getById($this->teacher_id);
	}
	public function getAsignature()
	{
		return AsignatureData::getById($this->asignature_id);
	}

	public function add()
	{
		$sql = "insert into " . self::$tablename . " (teacher_id,asignature_id,period_id,team_id,asignature_type,created_at) ";
		$sql .= "value (\"$this->teacher_id\",\"$this->asignature_id\",\"$this->period_id\",$this->team_id,\"$this->asignature_type\",NOW())";
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

	// partiendo de que ya tenemos creado un objecto AsignationData previamente utilizamos el contexto
	public function update()
	{
		$sql = "update " . self::$tablename . " set teacher_id=\"$this->teacher_id\",asignature_id=\"$this->asignature_id\",asignature_type=\"$this->asignature_type\" where id=$this->id";
		Executor::doit($sql);
	}
	public function finish()
	{
		$sql = "update " . self::$tablename . " set status=2 where id=$this->id";
		Executor::doit($sql);
	}
	public static function getById($id)
	{
		$sql = "select * from " . self::$tablename . " where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new AsignationData());
	}

	public static function getByPT($p, $te)
	{
		$sql = "select * from " . self::$tablename . " where period_id=$p and team_id=$te";
		$query = Executor::doit($sql);
		return Model::one($query[0], new AsignationData());
	}


	public static function getByPAT($t, $a, $p, $te)
	{
		$sql = "select * from " . self::$tablename . " where period_id=$p and asignature_id=$a and team_id=$te";
		$query = Executor::doit($sql);
		return Model::one($query[0], new AsignationData());
	}


	public static function getByTPAT($t, $a, $p, $te)
	{
		$sql = "select * from " . self::$tablename . " where teacher_id=$t and period_id=$p and asignature_id=$a and team_id=$te";
		$query = Executor::doit($sql);
		return Model::one($query[0], new AsignationData());
	}

	public static function getAll()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], new AsignationData());
	}

	public static function getAllByTeamId($id)
	{
		$sql = "select * from " . self::$tablename . " where team_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0], new AsignationData());
	}

	public static function getAllByTP($id, $period)
	{
		$sql = "select * from " . self::$tablename . " where team_id=$id and period_id=$period";
		$query = Executor::doit($sql);
		return Model::many($query[0], new AsignationData());
	}


	public static function getDocen($id, $period, $teach)
	{
		$sql = "select * from " . self::$tablename . " where team_id=$id and period_id=$period or teacher_id=$teach";
		$query = Executor::doit($sql);
		return Model::many($query[0], new AsignationData());
	}

	public static function getAllByTeacherId($id)
	{
		$sql = "select * from " . self::$tablename . " where teacher_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0], new AsignationData());
	}

	public static function getActiveByTeacherId($id)
	{
		$sql = "select * from " . self::$tablename . " where teacher_id=$id and status=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], new AsignationData());
	}

	public static function getFinishedByTeacherId($id)
	{
		$sql = "select * from " . self::$tablename . " where teacher_id=$id and status=2";
		$query = Executor::doit($sql);
		return Model::many($query[0], new AsignationData());
	}

	public static function getFavoritesByUserId($id)
	{
		$sql = "select * from " . self::$tablename . " where user_id=$id and is_favorite=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], new AsignationData());
	}


	public static function getLike($q)
	{
		$sql = "select * from " . self::$tablename . " where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0], Inscription());
	}
}
