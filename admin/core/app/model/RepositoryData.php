<?php
class RepositoryData
{
	public static $tablename = "repository";



	public static function delById($id)
	{
		$sql = "DELETE FROM " . self::$tablename . " WHERE id=$id";
		Executor::doit($sql);
	}
	public function del()
	{
		$sql = "DELETE FROM " . self::$tablename . " WHERE id=$this->id";
		Executor::doit($sql);
	}

	public function updatestatus()
	{
		$sql = "UPDATE " . self::$tablename . " SET status=\"$this->status\" WHERE id= $this->id";
		Executor::doit($sql);
	}

	public static function getByCode($code)
	{
		$sql = "select * from " . self::$tablename . " where code_person = $code";
		$query = Executor::doit($sql);
		return Model::one($query[0], new RepositoryData());
	}

	public static function getById($id)
	{
		$sql = "SELECT * FROM " . self::$tablename . " WHERE id = $id ";
		$query = Executor::doit($sql);
		return Model::one($query[0], new RepositoryData());
	}


	public static function getAll()
	{
		$sql = "SELECT * FROM " . self::$tablename . " ORDER BY id DESC";
		$query = Executor::doit($sql);
		return Model::many($query[0], new RepositoryData());
	}
}
