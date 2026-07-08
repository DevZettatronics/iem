<?php

include("config/db.php");
include("config/conexion.php");
include("libraries/inventory.php");
//include("libraries/correo.php");

ob_start();
//Ontengo variables pasadas por GET
$person_id = $_GET['idPerson'];
$order = $_GET['order'];
$vinculacion = $_GET['vinculacion'];
$payment_date = $_GET['payment_date'];

if (!empty($payment_date)) {
	// Convertir a formato DD/MM/YYYY
	$fecha_formateada = date("d/m/Y", strtotime($payment_date));
	// echo $fecha_formateada;
} else {
	$fecha_formateada = null;
}
//Consultamos los requerimientos 
mysqli_begin_transaction($con);


try {
	if (!empty($order) &&  !is_numeric($order)) {
		//El pago fue a traves de conekta
		$consultaPa = mysqli_prepare($con,"SELECT * FROM pagos  WHERE order_id = ? AND idPerson = ?");
		if(!$consultaPa){ throw new Exception("Error al preparar la consulta pagos"); }
		
		mysqli_stmt_bind_param($consultaPa,"si", $order, $person_id);
		if (!mysqli_stmt_execute($consultaPa)) { throw new Exception("Error al ejecutar la consulta pagos"); }

		$resultPa = mysqli_stmt_get_result($consultaPa);
		if (mysqli_num_rows($resultPa) == 0) {
			throw new Exception("No se encontro el registro en pagos");
		}
		$dataPA = mysqli_fetch_array($resultPa, MYSQLI_ASSOC);
		$id_planPa = $dataPA['id_plan'];

		$consultaS = mysqli_prepare($con,"SELECT * FROM sales  WHERE id_plan = ? AND person_id = ?");
		if(!$consultaS){ throw new Exception("Error al preparar la consulta sale"); }
		
		mysqli_stmt_bind_param($consultaS,"ii", $id_planPa, $person_id);
	}else{

		$consultaS = mysqli_prepare($con,"SELECT * FROM sales  WHERE sale_number = ? AND person_id = ?");
		if(!$consultaS){ throw new Exception("Error al preparar la consulta sale"); }
		
		mysqli_stmt_bind_param($consultaS,"ii", $order, $person_id);
	}
	if(!mysqli_stmt_execute($consultaS)){ throw new Exception("Error al ejecutar la consulta sales: " . mysqli_error($con)); }

	$result1 = mysqli_stmt_get_result($consultaS);
	if (mysqli_num_rows($result1) == 0) {
		throw new Exception("No se encontro el registro sales");
	}
	$data1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
		$sale_by = $data1['sale_by'];
		$sale_number = $data1['sale_number'];
		$sale_id = $data1['sale_id'];
		$descuento = $data1['discount_value'];
		$tax_value = $data1['tax_value']; //porcentaje en IVA
		$sale_date = date('d/m/Y', strtotime($data1['sale_date']));
		$recargo = $data1['recargo'];
		$vinculacion = $data1['vinculacion'];
		$payment_method = $data1['payment_method'];

		$operacion = '';
		
	//Inicializamos unas variables
	$namePeriodo = 0;
	$id_program = 0;

	//veridficamos si viene de vinculacion 
	if ($vinculacion === 1) {
		//Consulta a  la tabla person para la informacion de la persona relacionada a la venta sales
		$consultaP = mysqli_prepare($con,"SELECT * FROM centro_vinculacion WHERE id = ? ");
		if(!$consultaP){ throw new Exception("Error al preparar la consulta centro_vinculacion"); }
	}else{

		//Consulta a  la tabla person para la informacion de la persona relacionada a la venta sales
		$consultaP = mysqli_prepare($con,"SELECT * FROM person WHERE id = ? ");
		if(!$consultaP){ throw new Exception("Error al preparar la consulta person"); }

	}

	mysqli_stmt_bind_param($consultaP,"i", $person_id);
	if(!mysqli_stmt_execute($consultaP)) { throw new Exception("Error al ejecutar la consulta person: " . mysqli_error($con)); }

	$result2 = mysqli_stmt_get_result($consultaP);
	if (mysqli_num_rows($result2) == 0) {
		throw new Exception("No se encontro el registro en person");
	}

	$data2 = mysqli_fetch_array($result2);
		$person_id = $data2['id'];
		// $person_code = $data2['code'];
		$person_code = !empty($data2['code']) ? $data2['code'] : 'sin code';
		// $person_curp = $data2['curp'];
		$person_curp = (isset($data2['curp']) && !empty($data2['curp'])) ? $data2['curp'] : 'sin curp';
		$person_name = $data2['name'];
		$person_lastname = $data2['lastname'];
		$person_email = $data2['email'];
		$phone_id = $data2['phone'];
		$person_address = $data2['address'];
		$union_nombre = $person_name . " " . $person_lastname;
	
		if ($vinculacion !== 1) {
			
			$Cuatrimestre = $data2['name_periodo'];
			$carrera = $data2['carrera'];
			// echo 'Cuatrimestre: ' . $Cuatrimestre;
			// echo 'carrera: '  . $carrera;

			//---Hacemos consulta para periodo.
			if (is_numeric($Cuatrimestre)) {
				// Es un número (por ejemplo: "1", "2", "10")
				// echo "El valor es numérico: $Cuatrimestre";
				$consultaPe = mysqli_prepare($con,"SELECT name FROM period WHERE id = ?");
				if (!$consultaPe) { throw new Exception("Error al preparar la consulta period"); }
		
				mysqli_stmt_bind_param($consultaPe,"i",$Cuatrimestre);
				if (!mysqli_stmt_execute($consultaPe)) { throw new Exception("Error al ejecutar la consulta period: " . mysqli_error($con)); }
				
				$resultPe = mysqli_stmt_get_result($consultaPe);
				if (mysqli_num_rows($resultPe) == 0) {
					// El motivo es qeu en la tabla person el usuario en el campo name_periodo no tine numero
					throw new Exception("No se encontro el registro en period, La venta se realizo exitosamente, Favor de contactar a soporte");
				}
		
				$dataPe = mysqli_fetch_array($resultPe);
				$namePeriodo = $dataPe['name'];

			} else {
				// Es un string (por ejemplo: "Primero", "Segundo", "Verano")
				// echo "El valor es texto: $Cuatrimestre";
				$namePeriodo = $Cuatrimestre;
			}

			$typeProgram= 0; //Inicialisamos la variable que contendra ma modalidad por grupo 
			// Aquí entra solo si tiene valor y es número
			if (!empty($Cuatrimestre) && is_numeric($Cuatrimestre)) {
				$Cuatrimestre = intval($Cuatrimestre);
				//--- Consultamos inscripciones (optenemosperiodo team(grupo))
				$consultaCa = mysqli_prepare($con,"SELECT * FROM inscription WHERE alumn_id  = ? AND period_id = ?");
				if(!$consultaCa){ throw new Exception("Error al preparar la consulta inscription");}
		
				mysqli_stmt_bind_param($consultaCa,"ii",$person_id, $Cuatrimestre);
				if (!mysqli_stmt_execute($consultaCa)) { throw new Exception("Error al ejecutar la consulta inscription, La venta se realizo exitosamente, Favor de contactar a soporte: " . mysqli_error($con)); }
		
				$resultCa = mysqli_stmt_get_result($consultaCa);
				if (mysqli_num_rows($resultCa) == 0) {
					// El motivo es qeu en la tabla person el usuario en el campo carrera no tine numero
					// throw new Exception("No se encontro el registro en inscription, La venta se realizo exitosamente, Favor de contactar a soporte");
					$typeProgram = "Aun sin Inscripcion";
				}else{

					$dataCa = mysqli_fetch_array($resultCa);
					$team_id  = $dataCa['team_id'];
					// echo '$team_id: ' . $team_id . "<br>";
	
					//--- ya teniendo el id del grupo (Team) podemos buscar el grupo y la modalidad del mismo
					$consultaCa2 = mysqli_prepare($con,"SELECT * FROM team WHERE id  = ?");
					if(!$consultaCa2){ throw new Exception("Error al preparar la consulta team");}
			
					mysqli_stmt_bind_param($consultaCa2,"i",$team_id);
					if (!mysqli_stmt_execute($consultaCa2)) { throw new Exception("Error al ejecutar la consulta team, La venta se realizo exitosamente, Favor de contactar a soporte: " . mysqli_error($con)); }
			
					$resultCa2 = mysqli_stmt_get_result($consultaCa2);
					if (mysqli_num_rows($resultCa2) == 0) {
						// El motivo es qeu en la tabla person el usuario en el campo carrera no tine numero
						throw new Exception("No se encontro el registro en team, La venta se realizo exitosamente, Favor de contactar a soporte");
					}
			
					$dataCa2 = mysqli_fetch_array($resultCa2);
					$id_program  = $dataCa2['id_program']; //Por el momento no se ocupa por que ya tenemos el grade (carrera en tema)
					$modalidad  = $dataCa2['modalidad']; //Ademas de modalidad podemos sacar el nombre de la carrera (grade) peroc omo ocupamos tabla program mas adelante lo sacamos de ahi
					// echo '$modalidad: ' . $modalidad . "<br>";
					
					// Si el grupo en team no tiene modalidad (campo vacio)
					if (is_null($modalidad) || $modalidad === '') {
						// echo "❌ Error: El grupo " . $team_id . "no tiene asignada una modalidad";
						$typeProgram = "Sin modalidad aún";
					}else{
	
						// Consultamos tablña de modalidades
						$consultaCa3 = mysqli_prepare($con,"SELECT * FROM modalidad WHERE id_modalidad   = ?");
						if(!$consultaCa3){ throw new Exception("Error al preparar la consulta modalidad");}
				
						mysqli_stmt_bind_param($consultaCa3,"i",$modalidad);
						if (!mysqli_stmt_execute($consultaCa3)) { throw new Exception("Error al ejecutar la consulta modalidad, La venta se realizo exitosamente, Favor de contactar a soporte: " . mysqli_error($con)); }
				
						$resultCa3 = mysqli_stmt_get_result($consultaCa3);
						if (mysqli_num_rows($resultCa3) == 0) {
							// El motivo es qeu en la tabla person el usuario en el campo carrera no tine numero
							throw new Exception("No se encontro el registro en modalidad, La venta se realizo exitosamente, Favor de contactar a soporte");
						}
				
						$dataCa3 = mysqli_fetch_array($resultCa3);
						$typeProgram  = $dataCa3['nombre']; //Nombred emodalidad por grupo
					}
				}
		

			}
	
			// COn el carrera consultamos nombre y modalidad
			$consultaPro = mysqli_prepare($con,"SELECT name,grade,type FROM program WHERE id = ?");
			if(!$consultaPro){ throw new Exception("Error al preparar la consulta program"); }
	
			mysqli_stmt_bind_param($consultaPro,"i",$carrera);
			if(!mysqli_stmt_execute($consultaPro)){ throw new Exception("Error al ejecutar la consulta program: " . mysqli_error($con)); }
	
			$resultPro = mysqli_stmt_get_result($consultaPro);
			if (mysqli_num_rows($resultPro) == 0) {
				throw new Exception("No se encontro el registro en program");
			}
	
			$dataPro = mysqli_fetch_array($resultPro);
				$nameProgram = $dataPro['name'];//Nombre de carrera el mismo que podemos sacar de team el campo grade
				$gradeProgram = $dataPro['grade']; //Licenciatura, Mestria ligada 
				// $typeProgram = $dataPro['type'];
		}

	$sumador_total = 0;

	//Consulta a la tabla product,sale_product
	$consultaIner = mysqli_prepare($con,"SELECT p.product_code,
												p.product_name,
												sp.qty,
												sp.unit_price
										FROM  products AS p 
										INNER JOIN  sale_product AS sp ON p.product_id = sp.product_id
										WHERE sp.sale_id = ?
										");
	if(!$consultaIner){ throw new Exception("Error al preparar la consulta recibo 3"); }

	mysqli_stmt_bind_param($consultaIner,"i", $sale_id);
	if (!mysqli_stmt_execute($consultaIner)) {
		throw new Exception("Error al ejecutar la consulta Inner Join: " . mysqli_error($con));
	}

	$result3 = mysqli_stmt_get_result($consultaIner);
	if (mysqli_num_rows($result3) == 0 ) {
		throw new Exception("No se encontraron registros.");
	}

	while ($data3 = mysqli_fetch_assoc($result3)) {
		$product_code = $data3['product_code'];
		$product_name = $data3['product_name'];
		$qty = $data3['qty'];
		$unit_price = number_format($data3['unit_price'], $currency_format['precision_currency'], '.', '');
		$precio_total = $unit_price * $qty;
		$precio_total = number_format($precio_total, $currency_format['precision_currency'], '.', ''); //Precio total formateado
		$sumador_total += $precio_total; //Sumador
		
	}

	//Consulta de datos para facturar tabla business_profile
	$consultaE = mysqli_prepare($con, "SELECT 
											bp.name,
											bp.tax,
											bp.address,
											c.symbol,
											bp.city,
											bp.state,
											bp.postal_code,
											bp.phone,
											bp.email,
											bp.logo_url
										FROM business_profile AS bp
										INNER JOIN currencies AS c
											ON bp.currency_id = c.id
										WHERE bp.id = ?
									");
	if (!$consultaE) {
		throw new Exception("Error al preparar la consulta de empresa: " . mysqli_error($con));
	}

	// Asumimos que la empresa con id = 1
	$empresa_id = 1;
	mysqli_stmt_bind_param($consultaE, "i", $empresa_id);

	if (!mysqli_stmt_execute($consultaE)) {
		throw new Exception("Error al ejecutar la consulta de empresa: " . mysqli_error($con));
	}

	$resultE = mysqli_stmt_get_result($consultaE);
	if (mysqli_num_rows($resultE) === 0) {
		throw new Exception("No se encontró la empresa con ID {$empresa_id}");
	}

	// Obtenemos los datos
	$rw_empresa = mysqli_fetch_assoc($resultE);

	$moneda         = $rw_empresa["symbol"];
	$bussines_name  = $rw_empresa["name"];
	$tax            = $rw_empresa["tax"];
	$address        = $rw_empresa["address"];
	$city           = $rw_empresa["city"];
	$state          = $rw_empresa["state"];
	$postal_code    = $rw_empresa["postal_code"];
	$phone          = $rw_empresa["phone"];
	$email          = $rw_empresa["email"];
	$logo_url       = $rw_empresa["logo_url"];
	
	$tax_txt = get_id("taxes", "name", "value", $tax);
	$total_sales = get_id("sales", "total", "sale_id", $sale_id);

	$ancho = 75;
	$alto = 470;
	$orientation = "P";

	$productos = [];

	// $consultaPS = mysqli_prepare($con, "SELECT DISTINCT *
	// 	FROM `products`
	// 	JOIN `sale_product` ON products.product_id = sale_product.product_id
	// 	LEFT JOIN `plan_de_pago` ON sale_product.id_plan = plan_de_pago.id
	// 	WHERE (sale_product.id_plan = 0 OR plan_de_pago.id IS NOT NULL)
	// 	AND sale_product.sale_id = ?");

	// if($consultaPS) {
	// 	mysqli_stmt_bind_param($consultaPS, "i", $sale_id); 

	// 	mysqli_stmt_execute($consultaPS);

	// 	$result = mysqli_stmt_get_result($consultaPS);

	// 	while ($row = mysqli_fetch_assoc($result)) {
	// 		$productos[] = $row;
	// 	}

	// 	mysqli_stmt_close($consultaPS);
	// } else {
	// 	// En caso de error
	// 	throw new Exception("Error al preparar la consulta de productos.");
	// }

	if ($vinculacion === 1) { //Me quede aqui
		// Consulta alternativa
		$consultaPS = mysqli_prepare($con, "
			SELECT DISTINCT *
			FROM `conceptos`
			JOIN `sale_product` ON conceptos.id = sale_product.product_id 
			WHERE sale_product.id_plan = 0 
			AND sale_product.sale_id = ?

		");

		if ($consultaPS) {
			mysqli_stmt_bind_param($consultaPS, "i", $sale_id); // Usa $product en esta consulta
			mysqli_stmt_execute($consultaPS);
			$result = mysqli_stmt_get_result($consultaPS);

			while ($row = mysqli_fetch_assoc($result)) {
				$productos[] = $row;
			}

			mysqli_stmt_close($consultaPS);
		} else {
			throw new Exception("Error al preparar la consulta de productos para validación 1.");
		}

	} else {
		// Consulta original
		$consultaPS = mysqli_prepare($con, "
			SELECT DISTINCT *
			FROM `products`
			JOIN `sale_product` ON products.product_id = sale_product.product_id
			LEFT JOIN `plan_de_pago` ON sale_product.id_plan = plan_de_pago.id
			WHERE (sale_product.id_plan = 0 OR plan_de_pago.id IS NOT NULL)
			AND sale_product.sale_id = ?
		");

		if ($consultaPS) {
			mysqli_stmt_bind_param($consultaPS, "i", $sale_id);
			mysqli_stmt_execute($consultaPS);
			$result = mysqli_stmt_get_result($consultaPS);

			while ($row = mysqli_fetch_assoc($result)) {
				$productos[] = $row;
			}

			mysqli_stmt_close($consultaPS);
		} else {
			throw new Exception("Error al preparar la consulta de productos original.");
		}
	}


	require_once(dirname(__FILE__) . '/pdf/html2pdf.class.php');

	// Capturamos el contenido del ticket
	include(dirname('__FILE__') . "/pdf/documentos/html/tickets1.php");
	$content = ob_get_clean();

	try {
		$html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
		$html2pdf->pdf->SetDisplayMode('fullpage');

		// Escribimos el contenido en el PDF
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));

		// Mostramos el PDF en pantalla
		$html2pdf->Output('Recibo_de_Pago.pdf');

		// Guardamos copia local
		$path_ticket = "./storage/recibos/";
		if (!file_exists($path_ticket)) {
			if (!mkdir($path_ticket, 0777, true)) {
				throw new Exception("No se pudo crear el directorio de recibos.");
			}
		}

		$file_name = $path_ticket . "ticket_venta_" . $sale_id . ".pdf";

		// S = output as string
		file_put_contents($file_name, $html2pdf->Output('', 'S'));

	} catch (HTML2PDF_exception $e) {
		echo $e;
		exit;
	}

	// Si todo sale bien, realizamos el commit de la transacción
	mysqli_commit($con);
	echo "<script>console.log('listo todo');</script>";

} catch (Exception $e) {
	mysqli_rollback($con);
	error_log("Error en la transaccion pdf: " . $e->getMessage());
	// Enviamos el mensaje de error

	 // Aquí agregamos el console.log para ver el error en la consola
	 echo "<script>console.log('Error en la transacción: " . addslashes($e->getMessage()) . "');</script>";
		echo json_encode([
			"status" => "error",
			"message" => $e->getMessage() // Mensaje de la excepción
		]);
}

?>