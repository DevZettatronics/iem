<?php
class PeriodTypeData {
	public static $tablename = "period_type";

  
	public function PeriodTypeData(){
		$this->tipo = "";
        $this->id_type = "";
	}
	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new PeriodTypeData());
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id_type=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new PeriodTypeData()); //solo se cambia el nombre de la BD
	}


}

?>