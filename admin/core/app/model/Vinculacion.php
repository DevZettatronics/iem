<?php

class Vinculacion {
    public static $tablename = "centro_vinculacion";
    public static $tablename2 = "conceptos";

    public $name;
    public $descripcion;
    public $responsable;
    public $direccion;
    public $telefono;
    public $parcialidades;

    //tabla conceptos
    public $centro_id;
    public $nombre;
    public $monto;


    public function __construct() {
        $this->name = "";
        $this->descripcion = "";
        $this->responsable = "";
        $this->address = "";
        $this->phone = "";
        $this->parcialidades = "";
        $this->lastname = "";
        $this->email = "";

        
        // Nuevas propiedades para la tabla 'conceptos'
        $this->centro_id = 0;
        $this->nombre = "";
        $this->monto = 0.00;
        }

    public function add() {
        $sql = "INSERT INTO " . self::$tablename . " (name, descripcion, responsable, address, phone, parcialidades,lastname, email) ";
        $sql .= "VALUES (\"$this->name\", \"$this->descripcion\", \"$this->responsable\", \"$this->address\", \"$this->phone\",
                         \"$this->parcialidades\", \"$this->lastname\", \"$this->email\")";
        return Executor::doit($sql);
    }

    public function all() {
        $sql = "SELECT * FROM " . self::$tablename . " ORDER BY id DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new Vinculacion());
    }

    public static function getById($id) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE id = $id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new self());
    }

    public function update() {
        $sql = "UPDATE " . self::$tablename . " SET 
                    name = \"$this->name\", 
                    descripcion = \"$this->descripcion\", 
                    responsable = \"$this->responsable\", 
                    address = \"$this->address\", 
                    phone = \"$this->phone\",
                    parcialidades = \"$this->parcialidades\",
                    lastname =  \"$this->lastname\", 
                    email = \"$this->email\"
                WHERE id = $this->id";
        return Executor::doit($sql);
    }

    public static function delete($id) {
        $sql = "DELETE FROM " . self::$tablename . " WHERE id = $id";
        return Executor::doit($sql); // no necesitas Model::one en un DELETE
    }

    // COnceptos------------------------------------------
    public function addConceptos() {
        $sql = "INSERT INTO " . self::$tablename2 . " (centro_id , product_name, monto) ";
        $sql .= "VALUES (\"$this->centro_id\", \"$this->nombre\", \"$this->monto\")";
        return Executor::doit($sql);
    }

    public function allConceptos($id) {
        $sql = "SELECT * FROM " . self::$tablename2 . " WHERE centro_id = $id ORDER BY id DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new Vinculacion());
    }

      public static function getByIdConcepto($id) {
        $sql = "SELECT * FROM " . self::$tablename2 . " WHERE id = $id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new self());
    }

    public function updateConcepto() {
        $sql = "UPDATE " . self::$tablename2 . " SET 
                    product_name = \"$this->nombre\", 
                    monto = \"$this->monto\"
                WHERE id = $this->id";
        return Executor::doit($sql);
    }

     public static function deleteConceptos($id) {
        $sql = "DELETE FROM " . self::$tablename2 . " WHERE id = $id";
        return Executor::doit($sql); // no necesitas Model::one en un DELETE
    }
}

