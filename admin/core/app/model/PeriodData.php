<?php
class PeriodData
{
	public static $tablename = "period";


	public function PeriodData()
	{
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->password = "";
		$this->created_at = "NOW()";
	}

	public function add()
	{
		$sql = "insert into " . self::$tablename . " (name,periodo,start_at,finish_at) ";
		$sql .= "value (\"$this->name\",\"$this->periodo\",\"$this->start_at\",\"$this->finish_at\")";
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

	// partiendo de que ya tenemos creado un objecto PeriodData previamente utilizamos el contexto
	public function update()
	{
		$sql = "update " . self::$tablename . " set name=\"$this->name\",periodo=\"$this->periodo\",start_at=\"$this->start_at\",finish_at=\"$this->finish_at\" where id=$this->id";
		Executor::doit($sql);
	}


	public function set_started()
	{
		$sql = "update " . self::$tablename . " set is_started=1,start_at=NOW() where id=$this->id";
		Executor::doit($sql);
	}

	public function set_finished()
	{
		$sql = "update " . self::$tablename . " set is_finished=1,finish_at=NOW() where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id)
	{
		$sql = "select * from " . self::$tablename . " where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new PeriodData());
	}

	public static function getAll()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], new PeriodData());
	}
	/* seleccion de periodo */
	public static function getAlll()
	{
		$sql = "select * from " . self::$tablename . " WHERE is_finished != 1";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PeriodData());
	}
	/* fin de sellecion de periodo */
	public static function getAllActive()
	{
		$sql = "select * from " . self::$tablename . " where is_finished=0";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PeriodData());
	}


	public static function getAllByUserId($id)
	{
		$sql = "select * from " . self::$tablename . " where user_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PeriodData());
	}

	public static function getFavoritesByUserId($id)
	{
		$sql = "select * from " . self::$tablename . " where user_id=$id and is_favorite=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PeriodData());
	}


	public static function getLike($q)
	{
		$sql = "select * from " . self::$tablename . " where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PeriodData());
	}
}
