<?php
class PlandepagoData
{
	public static $tablename = "plan_de_pago";
	public static $tablename2 = "pagos";
 	public  $productos;
    public  $total;

	public function PlandepagoData()
	{
		$this->periodo = "";
		$this->carrera = "";
		$this->alumno = "";
		$this->concepto = "";
		$this->status = "NOW()";
		$this->fecha_inicio_pago ="";
		$this->fecha_fin_pago = "";
	}

	//no se mueve nada 
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

	// partiendo de que ya tenemos creado un objecto AsignatureData previamente utilizamos el contexto
	public function update()
	{ //Edicion de la BD
		//$sql = "update " . self::$tablename . " SET  concepto=\"$this->concepto\" where id=$this->id"; //cambiar
		$sql = "update " . self::$tablename . " SET  fecha_inicio_pago=\"$this->concepto\" where id=$this->id";
		Executor::doit($sql);
	}

	public function update1()
	{ //Edicion de la BD
		//$sql = "update " . self::$tablename . " SET  concepto=\"$this->concepto\" where id=$this->id"; //cambiar
		$sql = "update " . self::$tablename . " SET  fecha_fin_pago=\"$this->concepto1\" where id=$this->id";
		Executor::doit($sql);
	}
	/* validar */
	public function val()
	{
		$sql = "update " . self::$tablename . " SET  status=2 where id=$this->id"; //variables
		Executor::doit($sql);
	}

	public static function getById($id)
	{
		$sql = "select * from " . self::$tablename . " where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new PlandepagoData()); //solo se cambia el nombre de la BD
	}

	public static function getByIdd($id)
	{
		$sql = "select * from " . self::$tablename . " where id= '$id' ";
		$query = Executor::doit($sql);
		return Model::one($query[0], new PlandepagoData()); //solo se cambia el nombre de la BD
	}

	public static function getAll()
	{
		$sql = "select * from " . self::$tablename ;
		$query = Executor::doit($sql);
		return Model::many($query[0], new PlandepagoData()); //solo se cambia el nombre de la BD
	}
	public static function getAllByUserId($id)
	{
		$sql = "select * from " . self::$tablename . " where user_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PlandepagoData()); //solo se cambia el nombre de la BD
	}

	public static function getFavoritesByUserId($id)
	{
		$sql = "select * from " . self::$tablename . " where user_id=$id and is_favorite=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PlandepagoData()); //solo se cambia el nombre de la BD
	}


	public static function getLike($q)
	{
		$sql = "select * from " . self::$tablename . " where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PlandepagoData()); //solo se cambia el nombre de la BD
	}

	public static function getPlanPagoByAlumno($idPerson)
	{
		$sql = "select * from " . self::$tablename . " where alumno=$idPerson and status=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PlandepagoData());
	}

	public static function planesactivos()
	{
		$sql = "select * from " . self::$tablename . " where status=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PlandepagoData());
	}
	public static function ReporteVentasExcel($dates)
	{

		$sql= "SELECT 
				pp.id,
				pp.total AS totalP,
				pp.status,
				pp.payment_date,
				pp.date_created,
				pp.description,
				pp.vinculacion,
				pp.kind_cancelacion,
				COALESCE(per.name, p.name_periodo) AS periodo_name,
				t.grade AS carrera_grade,
				p.code AS alumno_code,
				p.name AS alumno_name,
				p.lastname AS alumno_lastname,
				p.beca,
				p.promocion,
				b1.porcentaje AS porcentaje_beca,
				b2.porcentaje AS porcentaje_promocion
			FROM " . self::$tablename2 . " pp
			LEFT JOIN person p ON pp.idPerson = p.id
			LEFT JOIN period per 
				ON ((p.name_periodo REGEXP '^[0-9]+$' AND p.name_periodo = per.id)
					OR (p.name_periodo = per.name))
			LEFT JOIN team t ON p.carrera = t.id
			LEFT JOIN becas b1 ON p.beca = b1.id
			LEFT JOIN becas b2 ON p.promocion = b2.id
			WHERE DATE(pp.date_created) >= '{$dates['start_date']}'
			AND DATE(pp.date_created) <= '{$dates['end_date']}'
			AND pp.vinculacion = 2
			ORDER BY pp.id DESC;
			";

		$query = Executor::doit($sql);

		// ✅ Validación para evitar fetch_array() sobre false
		if (!$query[0]) {
			die("Error en SQL: " . $sql . " - " . mysqli_error(Database::getCon()));
		}

		return Model::many($query[0], new PaymentData());
	}

	public static function dataProduct($description)
	{
		$ids = array_filter(array_map('intval', explode(',', $description)));

		if (empty($ids)) {
			return [ (object) ['productos' => '', 'total' => 0] ];
		}

		$idList = implode(',', $ids);

		$sql = "SELECT 
					GROUP_CONCAT(product_name SEPARATOR ', ') AS productos, 
					SUM(selling_price) AS total 
				FROM products 
				WHERE product_id IN ($idList)";

		// Ejecutamos con Executor
		$query = Executor::doit($sql);

		// Si la consulta falla o no hay resultados
		if (!$query[0] || $query[0]->num_rows == 0) {
			return [ (object) ['productos' => '', 'total' => 0] ];
		}

		// Obtenemos la fila
		$row = $query[0]->fetch_assoc();

		return [ (object) [
			'productos' => $row['productos'],
			'total' => $row['total']
		]];
	}

}
