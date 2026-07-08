<?php
class PersonData
{
	public static $tablename = "person";
	public static $tablename1 = "alumns_bec_prom";
	public static $tablename2 = "parents_options";
	public $id_into_group; // <-- Esto debe existir
	public function PersonData()
	{
		$this->title = "";
		$this->email = "";
		$this->image = "";
		$this->password = "";
		$this->is_public = "0";
		$this->created_at = "NOW()";
	}
	/* se agregaron 05 julio  */
	public function getBe()
	{
		return BecasData::getById($this->beca);
	}
	public function getCa()
	{
		return TeamData::getById($this->carrera);
	}
	public function getProgam()
	{
		return ProgramData::getById($this->program);
	}
	/* fin 05 julio */
	public function add()
	{
		$sql = "insert into " . self::$tablename . " (code,password,name,lastname,address,phone,email,year,kind,created_at) ";
		$sql .= "value (\"$this->code\",\"$this->password\",\"$this->name\",\"$this->lastname\",\"$this->address\",\"$this->phone\",\"$this->email\",\"$this->year\",$this->kind,$this->created_at)";
		return Executor::doit($sql);
	}
	public function add_alumn()
	{
		$sql = "insert into " . self::$tablename . " (code,password,name,lastname,address,phone,email,kind,parent_id,created_at) ";
		$sql .= "value (\"$this->code\",\"$this->password\",\"$this->name\",\"$this->lastname\",\"$this->address\",\"$this->phone\",\"$this->email\",3,$this->parent_id, $this->created_at)";
		return Executor::doit($sql);
	}
	/*validacion aspirante*/
	public function add_insert()
	{
		$sql = "insert into " . self::$tablename . " (name,lastname,f_nacimiento,nationality,curp,gender,person_email,phone,carrera,beca,promocion,code,email,kind,name_periodo,periodo_as)";
		$sql .= "value (\"$this->name\",\"$this->lastname\",\"$this->f_nacimiento\",\"$this->nacionalidad\",\"$this->curp\",\"$this->gender\",\"$this->person_email\",\"$this->phone\",\"$this->carrera\",\"$this->beca\",\"$this->promocion\",\"$this->code\",\"$this->email\",3,\"$this->name_periodo\",\"$this->periodo_as\")";
		return Executor::doit($sql);
	}
	/*fin validacion*/
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
	// partiendo de que ya tenemos creado un objecto PersonData previamente utilizamos el contexto
	public function update_active()
	{
		$sql = "update " . self::$tablename . " set last_active_at=NOW() where id=$this->id";
		Executor::doit($sql);
	}
	public function update_passwd()
	{
		$sql = "update " . self::$tablename . " set password=\"$this->password\" where id=$this->id";
		Executor::doit($sql);
	}
	/* editar la beca */
	public function updatebeca()
	{
		$sql = "update " . self::$tablename . " set beca=\"$this->beca\", promocion=\"$this->promocion\" where id=$this->id"; //filename=\"$this->filename\"
		Executor::doit($sql);
	}
	/***************/
	public function update()
	{
		$sql = "update " . self::$tablename . " set code=\"$this->code\",name=\"$this->name\",lastname=\"$this->lastname\",address=\"$this->address\",phone=\"$this->phone\",email=\"$this->email\",year=\"$this->year\",tarjeta=\"$this->tarjeta\" where id=$this->id"; //filename=\"$this->filename\"
		Executor::doit($sql);
	}
	/* se edito para modificar beca y curp 05 julio */
	public function update_alumn()
	{
		$sql = "update " . self::$tablename . " set name=\"$this->name\",lastname=\"$this->lastname\",email=\"$this->email\",gender=\"$this->genero\",f_nacimiento=\"$this->f_nacimiento\",nationality=\"$this->nacionalidad\",phone=\"$this->phone\",person_email=\"$this->correo\",civil=\"$this->civil\",address=\"$this->address\",phone_contact=\"$this->telemergencia\",name_contact=\"$this->namecontacto\",beca=\"$this->beca\",curp=\"$this->curp\",parent_id=$this->parent_id  where id=$this->id";
		Executor::doit($sql);
	}
	/* fin de la modificacion  */
	public static function getById($id)
	{
		$sql = "select * from " . self::$tablename . " where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new PersonData());
	}
	public static function getByCodeAlumn($code)
	{
		$sql = "select * from " . self::$tablename . " where code = '" . $code . "'";
		$query = Executor::doit($sql);
		return Model::one($query[0], new PersonData());
	}

	
	public static function getAll()
	{
		$sql = "select * from " . self::$tablename . " order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PersonData());
	}
	public static function getAllByPersonId($id)
	{
		$sql = "select * from " . self::$tablename . " where parent_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PersonData());
	}
	public static function getAlumns()
	{
		$sql = "select * from " . self::$tablename . " where kind=3 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PersonData());
	}
	public static function getParents()
	{
		$sql = "select * from " . self::$tablename2;
		$query = Executor::doit($sql);
		return Model::many($query[0], new PersonData());
	}
	public static function getTeachers()
	{
		$sql = "select * from " . self::$tablename . " where kind=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PersonData());
	}
	public static function getAllUnActive()
	{
		$sql = "select * from client where last_active_at<=date_sub(NOW(),interval 3 second)";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PersonData());
	}
	public function getUnreads()
	{
		return MessageData::getUnreadsByClientId($this->id);
	}
	public static function getLike($q)
	{
		$sql = "select * from " . self::$tablename . " where title like '%$q%' or email like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PersonData());
	}
	/*Se inserta la informacion en la tabla alumns_bec_prom*/
	public function add_becas_proms()
	{
		$sql = "INSERT INTO " . self::$tablename1 . " (code,name,lastname,beca,promocion,email,created_at)";
		$sql .= "value (\"$this->code\",\"$this->name\",\"$this->lastname\",\"$this->beca\",\"$this->promocion\",\"$this->email\",NOW())";
		return Executor::doit($sql);
	}
}
