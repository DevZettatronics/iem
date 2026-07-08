<?php
class TeamData
{
	public static $tablename = "team";


	public function TeamData()
	{
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->password = "";
		$this->created_at = "NOW()";
	}

	// public function getEdP($d){ return EducationalProgramData::getById($d); }

	public function add()
	{
		$sql = "insert into " . self::$tablename . " (grade,letter,semestre,id_program,id_identifica, modalidad) ";
		$sql .= "value (\"$this->grade\",\"$this->letter\",\"$this->semestre\",\"$this->id_program\",\"$this->historial_asg\",\"$this->modalidad\")";
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

	// partiendo de que ya tenemos creado un objecto TeamData previamente utilizamos el contexto
	public function update()
	{
		$sql = "UPDATE " . self::$tablename . 
							" set grade=\"$this->grade\",
							  letter=\"$this->letter\",
							  semestre=\"$this->semestre\",
							  id_program=\"$this->programa\",
							  id_identifica=\"$this->id_identifica\",
							  modalidad=\"$this->modalidad\"
							   WHERE id= $this->id";
		Executor::doit($sql);
	}

	public static function getById($id)
	{
		$sql = "select * from " . self::$tablename . " where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new TeamData());
	}

	public static function getAll()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], new TeamData());
	}

	public static function getAllByUserId($id)
	{
		$sql = "select * from " . self::$tablename . " where user_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0], new TeamData());
	}

	public static function getFavoritesByUserId($id)
	{
		$sql = "select * from " . self::$tablename . " where user_id=$id and is_favorite=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], new TeamData());
	}


	public static function getLike($q)
	{
		$sql = "select * from " . self::$tablename . " where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0], new TeamData());
	}

	// public  function getL($p,$id)
	// {
	// 	$sql = "SELECT t.id id_grupo,p.id id_programa,t.id_program id,p.name nombre, p.type tipo , p.nc nomen, p.grade grado,t.letter FROM " . self::$tablename . " t JOIN program p on t.id_program=$p and t.id=$id and p.id=$p ";
	// 	$query = Executor::doit($sql);
	// 	return Model::many($query[0], new TeamData());
	// }


	//cosas de barrabas
	public static function getCarrera()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], new TeamData());
	}
}
