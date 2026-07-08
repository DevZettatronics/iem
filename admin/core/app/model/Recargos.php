<?php
class Recargos {
	public static $tablename = "recargos";

    public $nombre;
    public $descripcion;
    public $fecha_inicio;
    public $fecha_fin;
    public $intervalos;

	public function __construct() {
		$this->id = "";
        $this->nombre = "";
        $this->descripcion = "";
        $this->fecha_inicio = "";
        $this->fecha_fin = "";
        $this->intervalos = "";
    
    }

	public function add() {
        $sql = "INSERT INTO " . self::$tablename . " (nombre, descripcion, fecha_inicio, fecha_fin, intervalos) ";
        $sql .= "VALUES (\"$this->nombre\", \"$this->descripcion\", \"$this->fecha_inicio\", \"$this->fecha_fin\", \"$this->intervalos\")";
        return Executor::doit($sql);
    }

	public static function getAll(){
		$sql = "SELECT * FROM ".self::$tablename." ORDER BY id DESC";
		$query = Executor::doit($sql);
		return Model::many($query[0], new Recargos());
	}

	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id = $id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new Recargos());
	}

	public function update(){
		$sql = "update ".self::$tablename." set nombre=\"$this->nombre\", 
											descripcion=\"$this->descripcion\",
											fecha_inicio=\"$this->fecha_inicio\",
											fecha_fin=\"$this->fecha_fin\",
											intervalos=\"$this->intervalos\" where id=$this->id";
		return Executor::doit($sql);
	}


	public static function delete($id) {
        $sql = "DELETE FROM " . self::$tablename . " WHERE id = $id";
        return Executor::doit($sql); // no necesitas Model::one en un DELETE
    }

}

?>