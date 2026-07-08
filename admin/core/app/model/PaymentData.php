<?php
	class PaymentData
	{
		public static $tablename = "pagos";
		public static $tablename2 = "factura";
		public static $tablename3 = "sale_product";


		public function PaymentData()
		{
			$this->name = "";
			$this->lastname = "";
			$this->email = "";
			$this->password = "";
			$this->created_at = "NOW()";
		}

		public function add()
		{
			$sql = "insert into " . self::$tablename . " (amount,sell_id,alumn_id,created_at) ";
			$sql .= "value ($this->amount,\"$this->sell_id\",$this->alumn_id,NOW())";
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

		// partiendo de que ya tenemos creado un objecto PaymentData previamente utilizamos el contexto
		public function update()
		{
			$sql = "update " . self::$tablename . " set name=\"$this->name\" where id=$this->id";
			Executor::doit($sql);
		}

		public static function getById($id)
		{
			$sql = "select * from " . self::$tablename . " where id=$id";
			$query = Executor::doit($sql);
			return Model::one($query[0], new PaymentData());
		}

		public static function getAll()
		{
			$sql = "select * from " . self::$tablename . " ORDER BY id DESC";
			$query = Executor::doit($sql);
			return Model::many($query[0], new PaymentData());
		}

		public static function getAllJoin($onlySQL = true)
		{
			$sql = "SELECT 
						pa.id as id_pago,
						pa.idPerson,
						CONCAT (per.name, ' ',per.lastname) name_person,
						per.email,
						per.code as matricula,
						per.name_periodo,
						per.carrera,
						pa.description,
						pa.multisale,
						pa.multiplanes,
						prt.product_name,
						prt.note,
						pa.total,
						pa.id_plan,
						pa.number_card,
						pa.tipo_pago,
						pa.order_id,
						pa.status,
						pa.vinculacion,
						pa.payment_date,
						CASE
							WHEN pa.status = 1 THEN 'Pagado'
							WHEN pa.status = 0 THEN 'Pendiente'
							ELSE 'Estado desconocido'
						END as Pago,
						DATE_FORMAT(date_created, '%d-%m-%Y') as date_created
					FROM " . self::$tablename . " pa 
					LEFT JOIN person per ON pa.idPerson = per.id LEFT JOIN products prt ON pa.description = prt.product_id ";
			if ($onlySQL) {
				# --> Le concatemanos el order by
				$sql = $sql . "ORDER BY pa.id DESC";
				$query = Executor::doit($sql);
				return Model::many($query[0], new PaymentData());
			} else {
				return $sql;
			}
		}

		public static function ReporteVentasExcel($dates)
		{
			$sqlJoin = self::getAllJoin(false);
			# --> Hacemos el WHERE BETWEEN (col BETWEEN '' AND '') para la consulta
			$where = "WHERE (date_created BETWEEN '$dates[start_date] 00:00:00' AND '$dates[end_date] 23:59:59') ORDER BY pa.id DESC;";
			# --> Ejecutamos la consulta
			$query = Executor::doit($sqlJoin . $where);
			return Model::many($query[0], new PaymentData());
		}

		public static function getAllByUserId($id)
		{
			$sql = "select * from " . self::$tablename . " where user_id=$id";
			$query = Executor::doit($sql);
			return Model::many($query[0], new PaymentData());
		}

		public static function getFavoritesByUserId($id)
		{
			$sql = "select * from " . self::$tablename . " where user_id=$id and is_favorite=1";
			$query = Executor::doit($sql);
			return Model::many($query[0], new PaymentData());
		}


		public static function getLike($q)
		{
			$sql = "select * from " . self::$tablename . " where name like '%$q%'";
			$query = Executor::doit($sql);
			return Model::many($query[0], new PaymentData());
		}

		//Para facturar se descoemnta
		public static function noFacturados($id){
			$sql = "SELECT COUNT(*) as count FROM " . self::$tablename2 . " WHERE ticket_id = {$id}";
			$query = Executor::doit($sql);
			$result = Model::one($query[0], new PaymentData());
			return $result->count > 0 ? 1 : 0;

		}

		public static function getNameConceptos($id_plan) {
		
			// Ahora, consultamos sale_product para obtener el registro usando el sale_id obtenido y el mismo id_plan
			$sql = "SELECT p.product_name 
					FROM sale_product sp 
					INNER JOIN products p ON sp.product_id = p.product_id 
					WHERE  sp.id_plan = $id_plan";
			$query = Executor::doit($sql);
			
			// Se utiliza Model::many para obtener un array de objetos de ProductsData.
			return Model::many($query[0], new PaymentData());
		}
		
	
		public static function getNameConceptos2($id_plan,$sale_number) {
			// Primero, obtenemos el sale_id de la tabla sales donde id_plan coincide.
			$sqlSale = "SELECT sale_id FROM sales WHERE sale_number = $sale_number LIMIT 1";
			$querySale = Executor::doit($sqlSale);
			// Se asume que tienes un método para obtener un único objeto de resultado, por ejemplo Model::one()
			$saleData = Model::one($querySale[0], new PaymentData());
			
			if (!$saleData) {
				throw new Exception("No se encontró un registro en sales para id_plan = $id_plan");
			}
			$sale_id = $saleData->sale_id;
			
			// Ahora, consultamos sale_product para obtener el registro usando el sale_id obtenido y el mismo id_plan
			$sql = "SELECT p.product_name 
				FROM sale_product sp 
				INNER JOIN products p ON sp.product_id = p.product_id 
				WHERE sp.sale_id = $sale_id AND (sp.id_plan = $id_plan OR sp.id_plan IS NULL)";
			$query = Executor::doit($sql);
			
			// Se utiliza Model::many para obtener un array de objetos de PaymentData.
			return Model::many($query[0], new PaymentData());
			// return $sale_id;
			// return $id_plan;
		}

		public static function getDatainculacionID($id) {
			$sql = "SELECT name, lastname FROM centro_vinculacion WHERE id = $id";
			$query = Executor::doit($sql);

			// Revisar si hay resultados
			if (!$query || count($query) === 0) {
				return null; // No se encontró nada
			}

			return Model::one($query[0], new PaymentData());
		}

		public static function getProductVinculacion($id, $description) {
			// Si viene vacío, mejor retornamos null
			if (empty($description)) {
				return null;
			}

			// Convertir string en array y filtrar solo números válidos
			$descArray = array_filter(array_map('intval', explode(',', $description)), function($n) {
				return $n > 0;
			});

			// Si después de filtrar no queda nada, retornar null
			if (empty($descArray)) {
				return null;
			}

			// Lista para consulta SQL
			$descList = implode(',', $descArray);

			$sql = "SELECT product_name, monto 
					FROM conceptos 
					WHERE centro_id = " . intval($id) . " 
					AND id IN ($descList)";
			
			$query = Executor::doit($sql);

			// Validar que $query tenga resultados
			if (!$query || !isset($query[0]) || empty($query[0])) {
				return null;
			}

			return Model::many($query[0], new PaymentData());
		}

		public static function cancelacion($id_pago, $order, $status,  $kind_cancelacion) {
			$con = Database::getCon(); 

			try {
				$con->begin_transaction();

				// 1. Buscar el pago
				$sqlPago = "SELECT * FROM pagos WHERE id = $id_pago";
				$queryPago = Executor::doit($sqlPago);
				$pagoData = Model::one($queryPago[0], new PaymentData());

				if (!$pagoData) {
					throw new Exception("No se encontró el registro en pagos");
				}

				$multisale = $pagoData->multisale;
				$id_plan = $pagoData->id_plan;

				// 2. Actualizar pago
				$sqlUpdatePago = "UPDATE pagos SET status = $status,  kind_cancelacion =  $kind_cancelacion WHERE id = $id_pago";
				Executor::doit($sqlUpdatePago);

				if ($con->affected_rows <= 0) {
					throw new Exception("No se pudo actualizar el registro en pagos: " . $con->error);
				}

				
				//Proceso de multipagos
				if ($multisale == 1) {
					// echo "Entro";
					// die;
					$multiplanes_array = [];

					//Si es diferente de SN es por que hay por lo menos un plan de pago
					if (!empty($pagoData->multiplanes) && strtoupper($pagoData->multiplanes) !== "SN") {
						// Convertir string en array
						$items = explode(",", $pagoData->multiplanes);

						// Filtrar y asegurar que sean números
						foreach ($items as $item) {
							$num = intval(trim($item));
							if ($num > 0) {
								$multiplanes_array[] = $num;
							}
						}
					}

					// Ahora $multiplanes_array contiene solo los números, listo para SQL
					// Ejemplo: SELECT * FROM sales WHERE id_plan IN (1,4,8,12,3)
					if (!empty($multiplanes_array)) {
						$in = implode(",", $multiplanes_array);
						// echo $in;
						// die();
						list($result, $insert_id) = Executor::doit("UPDATE plan_de_pago SET status = 7 WHERE id IN ($in)");

						// Revisar filas afectadas directamente del $result
						if ($result === false || $con->affected_rows <= 0) {
							throw new Exception("No se pudo actualizar el registro en planes de pago Multi");
						}
					}

				}else{
					if ($id_plan !== null && $id_plan != 0) {
						list($result, $insert_id) = Executor::doit("UPDATE plan_de_pago SET status = 7 WHERE id = $id_plan");

						if ($result === false || $con->affected_rows <= 0) {
							throw new Exception("No se pudo actualizar el registro en plan de pago único");
						}
						
					}
				}




				// 3. Ahora vamos con sales
				if (strpos($order, "ord_") === 0) {
					// order tipo ord_xxxxxx → buscamos por id_plan
					$sqlSale = "SELECT * FROM sales WHERE id_plan = '$id_plan' LIMIT 1";
					$querySales = Executor::doit($sqlSale);
					$saleData = Model::one($querySales[0], new PaymentData());

					if (!$saleData) {
						throw new Exception("No se encontró el registro en sales con id_plan=$id_plan");
					}

					$sqlUpdateSales = "UPDATE sales SET status = $status,  kind_cancelacion =  $kind_cancelacion WHERE id_plan = '$id_plan'";
					Executor::doit($sqlUpdateSales);

					if ($con->affected_rows <= 0) {
						throw new Exception("No se pudo actualizar el registro en sales (por id_plan): " . $con->error);
					}

				} else {
					// order numérico → buscamos por sale_number
					$order = intval($order);
					$sqlSale = "SELECT * FROM sales WHERE sale_number = $order LIMIT 1";
					$querySales = Executor::doit($sqlSale);
					$saleData = Model::one($querySales[0], new PaymentData());

					if (!$saleData) {
						throw new Exception("No se encontró el registro en sales con sale_number=$order");
					}

					$sqlUpdateSales = "UPDATE sales SET status = $status,  kind_cancelacion =  $kind_cancelacion WHERE sale_number = $order";
					Executor::doit($sqlUpdateSales);

					if ($con->affected_rows <= 0) {
						throw new Exception("No se pudo actualizar el registro en sales (por sale_number): " . $con->error);
					}
				}

				$con->commit();
				return true;

			} catch (Exception $e) {
				
				$con->rollback();
				
				// Registrar el error en el log para su posterior revisión
		 		error_log("Error: " . $e->getMessage());
				throw $e;
			}
		}
	}

	?>