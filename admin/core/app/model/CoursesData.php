<?php
class CoursesData
{
	public static $tablename = "courses";

	public function add()
	{
		$sql = "INSERT INTO " . self::$tablename . " (name,url,kind,date,star_time,end_time) ";
		$sql .= "VALUE (\"$this->name\",\"$this->url\",\"$this->kind\",\"$this->date\",\"$this->star\",\"$this->end\")";
		return Executor::doit($sql);
	}

	public function addCourseTeacher()
	{
		$sql = "INSERT INTO " . self::$tablename . " (id_course,id_person) ";
		$sql .= "VALUE (\"$this->id_course\",\"$this->teacher\")";
		return Executor::doit($sql);
	}

	public function del()
	{
		$sql = "delete from " . self::$tablename . " where id=$this->id";
		Executor::doit($sql);
	}

	public function update()
	{
		$sql = "UPDATE " . self::$tablename . " SET name=\"$this->name\",url=\"$this->url\",kind=\"$this->kind\",date=\"$this->date\",star_time=\"$this->star\",end_time=\"$this->end\" WHERE id=$this->id";
		Executor::doit($sql);
	}

	public function updatestatus()
	{
		$sql = "UPDATE " . self::$tablename . " SET is_active=\"$this->is_active\" WHERE id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id)
	{
		$sql = "select * from " . self::$tablename . " where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new CoursesData());
	}

	public static function getAll()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], new CoursesData());
	}
	public static function getAllTeacher()
	{
		$sql = "select * from " . self::$tablename . " WHERE kind = 1 AND is_active = 1";
		$query = Executor::doit($sql);
		return Model::many($query[0], new CoursesData());
	}
}
