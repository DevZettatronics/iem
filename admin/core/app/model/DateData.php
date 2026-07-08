<?php



class DateData



{
	public static $tablename = "meses";
	public static $tablename2 = "plan_de_pago";


	public static function getAll()



	{



		$sql = "select * from " . self::$tablename;



		$query = Executor::doit($sql);



		return Model::many($query[0], new DateData());



	}
	

}