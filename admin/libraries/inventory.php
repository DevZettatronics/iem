<?php

function add_inventory($product_id, $product_quantity)

{

	global $con; //Variable de conexion

	$sql = mysqli_query($con, "select * from inventory where product_id='" . $product_id . "'"); //Consulta para verificar si el producto se encuentra reguistrado en  el inventario

	$count = mysqli_num_rows($sql);

	if ($count == 0) {

		$insert = mysqli_query($con, "insert into inventory (product_id, product_quantity) values ('$product_id','$product_quantity')"); //Ingresa un nuevo producto al inventario

	} else {

		$sql2 = mysqli_query($con, "select * from inventory where product_id='" . $product_id . "'");

		$rw = mysqli_fetch_array($sql2);

		$old_qty = $rw['product_quantity']; //Cantidad encontrada en el inventario

		$new_qty = $old_qty + $product_quantity; //Nueva cantidad en el inventario

		$update = mysqli_query($con, "UPDATE inventory SET product_quantity='" . $new_qty . "' WHERE product_id='" . $product_id . "'"); //Actualizo la nueva cantidad en el inventario

	}

}



function adjustment_inventory($product_id, $product_quantity)

{

	global $con; //Variable de conexion

	$sql = mysqli_query($con, "select * from inventory where product_id='" . $product_id . "'"); //Consulta para verificar si el producto se encuentra reguistrado en  el inventario

	$count = mysqli_num_rows($sql);

	if ($count == 0) {

		$insert = mysqli_query($con, "insert into inventory (product_id, product_quantity) values ('$product_id','$product_quantity')"); //Ingresa un nuevo producto al inventario

	} else {

		$update = mysqli_query($con, "UPDATE inventory SET product_quantity='" . $product_quantity . "' WHERE product_id='" . $product_id . "'"); //Actualizo la nueva cantidad en el inventario

	}

}



function remove_inventory($product_id, $product_quantity, $vinculacion)

{

	global $con; //Variable de conexion

	try {
		if ($vinculacion === 1) {
			return; // Salir de la función sin tocar inventario
		}else{

			// Prepara la consulta para obtener la cantidad actual en el inventario
			$sql = mysqli_prepare($con, "SELECT product_quantity FROM inventory WHERE product_id = ?");
			if (!$sql) {
				throw new Exception("Error al preparar la consulta 8.");
			}
	
			// Vincula el parámetro product_id
			mysqli_stmt_bind_param($sql, "i", $product_id);
			if (!mysqli_stmt_execute($sql)) {
				throw new Exception("Error al ejecutar la consulta 8: " . mysqli_error($con));
			}
	
			// Obtén el resultado de la consulta
			$resultado = mysqli_stmt_get_result($sql);
			if (mysqli_num_rows($resultado) == 0) {
				throw new Exception("Producto no encontrado en el inventario.");
			}
	
			$rw = mysqli_fetch_assoc($resultado);
	
			$old_qty = $rw['product_quantity']; // Cantidad actual en el inventario
			$new_qty = $old_qty - $product_quantity; // Nueva cantidad después de restar
	
			// Verifica si la cantidad nueva es válida
			if ($new_qty < 0) {
				throw new Exception("No hay suficiente cantidad en el inventario para realizar la operación.");
			}
	
			// Prepara la consulta para actualizar el inventario con la nueva cantidad
			$update = mysqli_prepare($con, "UPDATE inventory SET product_quantity = ? WHERE product_id = ?");
			if (!$update) {
				throw new Exception("Error al preparar la consulta, 8.1.");
			}
	
			// Vincula los parámetros para la actualización
			mysqli_stmt_bind_param($update, "ii", $new_qty, $product_id);
			if (!mysqli_stmt_execute($update)) {
				throw new Exception("Error al ejecutar la consulta 8.1: " . mysqli_error($con));
			}
		}

		//Error Forzado para pruebas
		// throw new Exception("Error forzado en remover Inventory.");
    } catch (Exception $e) {
        // Registrar el error en el log para su posterior revisión
        error_log("Error en la consulta: " . $e->getMessage());

        // Lanza la excepción original para que pueda ser manejada en una capa superior
        throw $e;
    }
}







function update_buying_price($product_id, $buying_price)

{

	global $con; //Variable de conexion

	$update = mysqli_query($con, "UPDATE products SET buying_price='" . $buying_price . "' WHERE product_id='" . $product_id . "'");

}



function update_selling_price($product_id, $buying_price)

{

	global $con; //Variable de conexion

	$sql = mysqli_query($con, "select profit from products where product_id='$product_id'");

	$rw = mysqli_fetch_array($sql);

	$utilidad = floatval($rw['profit']);





	$precio_venta = $buying_price + $utilidad;

	$selling_price = number_format($precio_venta, 2, '.', '');





	$update = mysqli_query($con, "UPDATE products SET selling_price='" . $selling_price . "' WHERE product_id='" . $product_id . "'");

}



function get_stock($product_id, $vinculacion)

{

	global $con; //Variable de conexion

	if ((int)$vinculacion === 1) {
        // No busca en la BD, devuelve valor fijo
        $stock = 1000000;
    }else{

		$sql = mysqli_query($con, "SELECT 	product_quantity FROM inventory WHERE product_id='" . $product_id . "'");
	
		$rw = mysqli_fetch_array($sql);
	
		$stock = number_format($rw['product_quantity'], 0, '.', '');
	}

	return $stock;

}







//valida si existe el produto en la tabla temp

//esta funcion se ejecuta solo en el modulo POS

// function validarTablaTemporal($id, $user_id)

function validarTablaTemporal($id, $user_id, $id_plan, $vinculacion)

{

	global $con;

	$validate = false;

	

		$sql = mysqli_query($con,"SELECT product_id 
									FROM product_tmp 
									WHERE product_id='" . $id . "' 
									AND user_id='" . $user_id . "' 
									AND id_plan='" . $id_plan . "' 
									AND vinculacion='" . $vinculacion . "'"
		);


		if (mysqli_num_rows($sql) > 0) {



			$validate = true;

		}

		
	
	return $validate;

}







function validarTablaVentas($id, $sale_id)

{ // validar tambien con el sale_id para ver a que venta pertenece

	global $con;

	$validate = false;

	$sql = mysqli_query($con, "SELECT product_id from sale_product where product_id='" . $id . "' and sale_id='" . $sale_id . "'");



	if (mysqli_num_rows($sql) > 0) {



		$validate = true;

	}



	return $validate;

}





//Agrega un nuevo registro a la tabla product_tmp

// function add_tmp($product_id, $qty, $unit_price, $user_id)

function add_tmp($product_id, $qty, $unit_price, $user_id, $id_plan, $vinculacion)

{

	global $con;

	$sql = mysqli_query($con, "insert into product_tmp 

	(id_tmp, product_id, qty, unit_price, user_id, id_plan, vinculacion)

	values (NULL, '$product_id','$qty','$unit_price','$user_id','$id_plan', $vinculacion)");

}



function actupp($id_pp)

{

	global $con;

	 // Asegúrate de que $id_pp sea un valor entero para evitar inyecciones SQL
	 $id_pp = intval($id_pp);

	// Usamos un bloque try-catch para capturar y manejar cualquier error que ocurra
	try {
        // Preparamos la consulta
        $sql = mysqli_prepare($con, "UPDATE plan_de_pago SET status = 2 WHERE id = ?");
        
        if (!$sql) {
            throw new Exception("Error al preparar la consulta: " . mysqli_error($con));
        }

        // Vinculamos el parámetro y lo ejecutamos
        mysqli_stmt_bind_param($sql, "i", $id_pp);

        // Ejecutamos la consulta
        if (!mysqli_stmt_execute($sql)) {
			throw new Exception("Error al ejecutar la consulta plan de pagos: " . mysqli_error($con));
        } 

    } catch (Exception $e) {
        // Captura cualquier excepción y muestra el mensaje de error
        error_log("Excepción en actupp: " . $e->getMessage());
         // Lanza una excepción con un mensaje más genérico
		 throw $e;
    }

}

//Elimina un registro de la tabla product_tmp

function remove_tmp($id_tmp)
{
    global $con;

    try {
        // Prepara la consulta para eliminar el registro de la tabla product_tmp
        $sql = mysqli_prepare($con, "DELETE FROM product_tmp WHERE id_tmp = ?");
        if (!$sql) {
            throw new Exception("Error al preparar la consulta 9.");
        }

        // Vincula el parámetro id_tmp
        mysqli_stmt_bind_param($sql, "i", $id_tmp);
        if (!mysqli_stmt_execute($sql)) {
            throw new Exception("Error al ejecutar la consulta 9: " . mysqli_error($con));
        }

		//Error Forzado para pruebas
		// throw new Exception("Error forzado en removet de tmp.");
		
    } catch (Exception $e) {
        // Registrar el error en el log para su posterior revisión
        error_log("Error en la consulta 9: " . $e->getMessage());

        // Lanza la excepción original para que pueda ser manejada en una capa superior
        throw $e;
    }
}


//Guarda una venta
/* insertar a tabla pago */
// $insert_tabla_pago = mysqli_query($con, "INSERT INTO pagos (name,description,total,tipo_pago,order_id,date_created,email,matricula,status,idPerson,id_plan) VALUES ('" . $union_nombre . "','" . $product_code . "','" . $total_compra . "','CAJA','" . $sale_number . "',now(),'" . $person_email . "','" . $person_code . "','1','" . $person_id . "','" . $idplanp . "');");
function add_sale($person_id, $sale_by, $tax_value, $discount_value, $type_document, $payment_method, $idpp, $recargo, $vinculacion, $datepago)

{
	// sale_number

	global $con;
	// mysqli_begin_transaction($con);
	
	try {
		
		$sum =  mysqli_prepare($con, "SELECT SUM(qty * unit_price) AS subtotal FROM product_tmp WHERE user_id = ?");
		if (!$sum) { throw new Exception("Error al preparar la consulta 2"); }

		mysqli_stmt_bind_param($sum, "i", $sale_by);
		if (!mysqli_stmt_execute($sum)) { throw new Exception("Error al ejecutar la consulta 2"); }

		$resultSubtotal = mysqli_stmt_get_result($sum);
		$rowSubtotal = mysqli_fetch_assoc($resultSubtotal);
		$sumador_total = $rowSubtotal['subtotal'];
		$tax = $tax_value;	
		$descuento = $discount_value;

		// Aplicamos descuento
		$precio_descuento = ($sumador_total * $descuento) / 100;
		// Total neto (subtotal - descuento)
		$total_neto = $sumador_total - $precio_descuento;

		// Calculamos IVA
		$total_iva = ($total_neto * $tax) / 100;

		// Total Final a pagar
		$total_venta = $total_neto + $total_iva;

		// Recargo si hay
		$total_venta = $total_venta + $recargo; //Aqui no importa hacer condicional ya que si no hay manda cero 
		// $netos = $total_neto - $precio_descuento;
	
		$sale_number = nex_sale_number(); //consulta 3

		//Consulta 4
		$sql = mysqli_prepare($con,"INSERT INTO sales (
							sale_number, 
							person_id, 
							sale_by, 
							subtotal, 
							tax, 
							recargo,
							total,
							tax_value, 
							discount_value, 
							type_document, 
							payment_method,
							id_plan,
							vinculacion,
							payment_date )  
							VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		if(!$sql){ throw new Exception("Error al preparar la consulta 4. "); }

		mysqli_stmt_bind_param($sql,"iiiddddddiiiis",$sale_number,$person_id,$sale_by,$sumador_total,$total_iva,$recargo,$total_venta,
													$tax_value,$discount_value,$type_document,$payment_method,$idpp,$vinculacion,$datepago);
		if (!mysqli_stmt_execute($sql)) {
			throw new Exception("Error al ejecutar la consulta 4 : " . mysqli_error($con));	
		}

		// Obtén el ID del último registro insertado
		$sale_id = mysqli_stmt_insert_id($sql); // Esto es lo correcto para consultas preparadas.

		$sql_tmp = mysqli_prepare($con, "SELECT * FROM product_tmp WHERE user_id = ?");
		if (!$sql_tmp) { throw new Exception("Error al preparar la consulta 5."); }

		mysqli_stmt_bind_param($sql_tmp,"i", $sale_by);
		if(!mysqli_stmt_execute($sql_tmp)){ throw new Exception("Error al ejecutar la consulta 5: " . mysqli_error($con)); }

		$resultadoS = mysqli_stmt_get_result($sql_tmp);
		if (mysqli_num_rows($resultadoS) == 0) { throw new Exception("Error, No se encontro concepto para venta 5: "); }

		
		while ($rw_tmp = mysqli_fetch_assoc($resultadoS)) {

			$id_tmp = $rw_tmp['id_tmp'];
			$product_id = $rw_tmp['product_id'];
			$qty = $rw_tmp['qty'];
			$unit_price = $rw_tmp['unit_price'];
			// $idpp =  $rw_tmp['id_plan'];

			add_sale_product($sale_id, $product_id, $qty, $unit_price, $idpp); //Agrego un registro  a la tabla sale_product consulta 6

			insert_pago($total_venta,$product_id,$person_id,$sale_number,$idpp,$recargo, $vinculacion, $datepago);

			add_historial($sale_number, $product_id, $person_id,  $vinculacion); //Agrego un registro  a la tabla sale_product consulta 7

			remove_inventory($product_id, $qty, $vinculacion); //Disminuye la cantidad en el inventario; consulta 8

			remove_tmp($id_tmp); //Elimina el item de la tabla temporal consulta 9

		}

		
		// mysqli_commit($con);
		
		// Devolver el sale_id al final del proceso
		return $sale_id; // Aquí devolvemos el ID de la venta

	} catch (Exception $e) {
		
		 // Registrar el error en el log para su posterior revisión
		 error_log("Error: " . $e->getMessage());

		 // Lanza la excepción original para que pueda ser manejada en una capa superior
		 throw $e;
		
	}
	
}





function add_sale1($sale_number, $person_id, $sale_by, $sale_date, $tax_value, $discount_value, $type_document, $payment_method, $idpp, $total)

{



	global $con;

	$idppl = $idpp;

	$sql = "SELECT * FROM plan_de_pago WHERE id = $idppl";

	$result = mysqli_query($con, $sql);

	$row = mysqli_fetch_assoc($result);

	$nomprod = $row ? $row['concepto'] : '';

	//echo $nomprod;

	//$precioprod = ProductsData::getById($nomprod);

	$precioprod = "SELECT * FROM products WHERE product_id = $nomprod";

	$result = mysqli_query($con, $precioprod);



	if ($result) {

		$row = mysqli_fetch_assoc($result);

		$netos = $row ? $row['selling_price'] : 0;

	} else {

		// Imprimir el mensaje de error de MySQL

		echo "Error en la consulta: " . mysqli_error($con);

		$netos = 0; // Asignar un valor predeterminado o mostrar un mensaje de error

	}



	$total_venta = $total;

	$total_iva = 0;

	$total_venta = number_format($total_venta, 2, '.', '');

	$discount_value = number_format($discount_value, 2, '.', '');

	$sale_id = next_insert_id('sales');



	$sql = "INSERT INTO sales

		(sale_id, sale_number, person_id, sale_by, subtotal, tax, total, sale_date,tax_value, discount_value, type_document, payment_method,id_plan) 

		VALUES ('$sale_id', '$sale_number', '$person_id', '$sale_by', '$netos', '$total_iva', '$total_venta', '$sale_date','$tax_value', '$discount_value', '$type_document', '$payment_method','$idpp');";

	$query = mysqli_query($con, $sql);









	// $product_id = $idprod->concepto;

	$qty = 1;

	$unit_price = $netos;

	$product_id = $nomprod;

	add_sale_product($sale_id, $product_id, $qty, $unit_price, $idpp); //Agrego un registro  a la tabla sale_product

	add_historial($sale_number, $product_id, $person_id); //Agrego un registro  a la tabla sale_product

	// remove_inventory($product_id, $qty); //Disminuye la cantidad en el inventario;



}



function add_sale3($sale_number, $person_id, $sale_by, $sale_date, $tax_value, $discount_value, $type_document, $payment_method, $idpp)

{



	global $con;

	$sql = "SELECT * FROM plan_de_pago WHERE id = $idpp";

	$result = mysqli_query($con, $sql);

	$row = mysqli_fetch_assoc($result);

	$nomprod = $row ? $row['concepto'] : '';



	$sum = mysqli_query($con, "select sum(qty*unit_price) as subtotal from product_tmp where user_id='$sale_by'");

	$rw_sum = mysqli_fetch_array($sum);

	$sumador_total = $rw_sum['subtotal'];

	$tax = $tax_value;

	$descuento = $discount_value;



	$total_parcial = number_format($sumador_total, 2, '.', '');

	$total_neto = $total_parcial;

	$total_neto = number_format($total_neto, 2, '.', '');

	//$total_iva=($total_neto*$tax) / 100;

	//$total_iva=number_format($total_iva,2,'.','');

	$precio_descuento = ($total_neto * $descuento) / 100;

	$precio_descuento = number_format($precio_descuento, 2, '.', '');



	if ($descuento > 0) {

		$precio_descuento = ($total_neto * $descuento) / 100;

		$total_descuento = ($total_neto - $precio_descuento);

		$total_iva = ($total_descuento * $tax) / 100;

		$total_venta = ($total_descuento + $total_iva);

	} else {



		$total_iva = ($total_neto * $tax) / 100;

		$total_iva = number_format($total_iva, 2, '.', '');

		$total_venta = $total_neto + $total_iva;

		$total_venta = number_format($total_venta, 2, '.', '');

	}





	$netos = $total_neto - $precio_descuento;

	//$total_venta=number_format($total_venta,2,'.','');

	$sale_id = next_insert_id('sales');

	$sql = "INSERT INTO sales

		(sale_id, sale_number, person_id, sale_by, subtotal, tax, total, sale_date,tax_value, discount_value, type_document, payment_method,id_plan) 

		VALUES ('$sale_id', '$sale_number', '$person_id', '$sale_by', '$netos', '$total_iva', '$total_venta', '$sale_date','$tax_value', '$discount_value', '$type_document', '$payment_method','$idpp');";

	$query = mysqli_query($con, $sql);





	$qty = 1;

	$unit_price = $netos;

	$product_id = $nomprod;

	add_sale_product($sale_id, $product_id, $qty, $unit_price, $idpp); //Agrego un registro  a la tabla sale_product

	add_historial($sale_number, $product_id, $person_id); //Agrego un registro  a la tabla sale_product

	//remove_inventory($product_id, $qty); //Disminuye la cantidad en el inventario;



}



function get_tax()

{

	global $con;

	$sql = mysqli_query($con, "SELECT tax FROM  business_profile where  business_profile.id=1");

	$row = mysqli_fetch_array($sql);

	$tax = $row["tax"];

	return $tax;

}


//No se ocupa ni para pos ni para pagos con tarjeta se puede eliminar
// function next_insert_id($table)

// {

// 	global $con;

// 	$next = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '" . DB_NAME . "' AND   TABLE_NAME   = '$table'";

// 	$query_next = mysqli_query($con, $next);

// 	$rw_next = mysqli_fetch_array($query_next);

// 	$next_insert = $rw_next['AUTO_INCREMENT'];

// 	return $next_insert;

// }



function add_sale_product($sale_id, $product_id, $qty, $unit_price, $idpp)

{

	global $con;

	try {
		$consulta = mysqli_prepare($con,"INSERT INTO sale_product (
													sale_id, 
													product_id, 
													qty, 
													unit_price, 
													id_plan
													) VALUES (?,?,?,?,?);");
		if(!$consulta){ throw new Exception("Error al preparar la consulta 6. "); }

		mysqli_stmt_bind_param($consulta,"isidi",$sale_id, $product_id, $qty, $unit_price, $idpp);
		if (!mysqli_stmt_execute($consulta)) {
			throw new Exception("Error al ejecutar la consulta 6: " . mysqli_error($con));
		}


	//Error Forzado para pruebas
	// throw new Exception("Error forzado en removet de sale_product.");
	
	} catch (Exception $e) {
		 // Registrar el error en el log
		 error_log("Error en consulta 6: " . $e->getMessage());

		 // Lanza una excepción con un mensaje más genérico
		 throw $e;
	}
}



function add_historial($sale_id, $product_id, $person_id, $vinculacion)

{

	global $con;

	try {
		$consulta = mysqli_prepare($con,"INSERT INTO historial (sale_id,product_id,person_id, direccion) VALUES (?,?,?,?)");
		if (!$consulta) {
			throw new Exception("Error al preparar la cosnulta 7");
		}

		mysqli_stmt_bind_param($consulta,"isii", $sale_id,$product_id,$person_id, $vinculacion);
		if (!mysqli_stmt_execute($consulta)) {
			throw new Exception("Error al ejecutar la consulta 7: " . mysqli_error($con));
		}

		//Error Forzado para pruebas
		// throw new Exception("Error forzado en removet de Historial.");
	} catch (Exception $e) {
		// Registrar el error en el log
		error_log("Error en consulta 7: " . $e->getMessage());

		// Lanza la excepción original para que pueda ser manejada en una capa superior
		throw $e;
	}
}



function is_valid_sale($sale_number)

{

	global $con;

	$sql = mysqli_query($con, "select sale_number from sales where sale_number='$sale_number'");

	$count = mysqli_num_rows($sql);

	if ($count == 0) {

		return true;

	} else {

		return false;

	}

}


function nex_sale_number()
{
	global $con;

	try {
		// Bloquea la tabla sales solo para escribir (LOCK)
		mysqli_query($con, "LOCK TABLES sales WRITE");

		$sql = mysqli_prepare($con, "SELECT sale_number FROM sales ORDER BY sale_id DESC LIMIT 1");
		if (!$sql) {
			throw new Exception("Error al preparar la consulta 3");
		}
		
		if (!mysqli_stmt_execute($sql)) {
			throw new Exception("Error al ejecutar la consulta 3: " . mysqli_error($con));
		}

		$resltID = mysqli_stmt_get_result($sql);

		// Verifica si no hay resultados
		if (mysqli_num_rows($resltID) == 0) {
			// Si no hay resultados, el siguiente número de venta podría ser 1
			$nex_sale_number = 1;
		} else {
			// Si hay resultados, obtenemos el último número de venta y sumamos 1
			$row = mysqli_fetch_assoc($resltID);
			$nex_sale_number = $row['sale_number'] + 1;
		}

		// Desbloquea la tabla
		mysqli_query($con, "UNLOCK TABLES");

		return $nex_sale_number;
	} catch (Exception $e) {
		// Lanza la excepción para que sea manejada en la función principal
		throw new Exception("Error en la función nex_sale_number: " . $e->getMessage());
	}
	
}




function nex_purchase_number()

{

	global $con;

	$sql = mysqli_query($con, "select purchase_order_number from purchases order by purchase_id desc limit 0,1");

	$rw = mysqli_fetch_array($sql);

	$purchase_number = $rw['purchase_order_number'];

	$nex_purchase_number = $purchase_number + 1;



	return $nex_purchase_number;

}



function count_tmp($user_id)

{

	global $con;

	$sql = mysqli_query($con, "select product_id from product_tmp where user_id='$user_id'");

	$count = mysqli_num_rows($sql);

	return $count;

}



//Guarda una compra

function add_purchase($order_number, $supplier_id, $purchase_by, $purchase_date, $tax_value)

{

	global $con;

	$sum = mysqli_query($con, "select sum(qty*unit_price) as subtotal from product_tmp where user_id='$purchase_by'");

	$rw_sum = mysqli_fetch_array($sum);

	$sumador_total = $rw_sum['subtotal'];

	$tax = $tax_value;

	$total_parcial = number_format($sumador_total, 2, '.', '');

	$total_neto = $total_parcial;

	$total_neto = number_format($total_neto, 2, '.', '');

	$total_iva = ($total_neto * $tax) / 100;

	$total_iva = number_format($total_iva, 2, '.', '');

	$total_compra = $total_neto + $total_iva;

	$total_compra = number_format($total_compra, 2, '.', '');

	$purchase_id = next_insert_id('purchases');



	$sql = "INSERT INTO purchases

		(purchase_id, purchase_order_number	, supplier_id, purchase_by, subtotal, tax, total, purchase_date,tax_value) 

		VALUES ('$purchase_id', '$order_number', '$supplier_id', '$purchase_by', '$total_neto', '$total_iva', '$total_compra', '$purchase_date','$tax_value');";

	$query = mysqli_query($con, $sql);

	if ($query) {

		$true = 1;

	} else {

		$true = 0;

	}

	$sql_tmp = mysqli_query($con, "select * from product_tmp where user_id='$purchase_by'");

	while ($rw_tmp = mysqli_fetch_array($sql_tmp)) {

		$id_tmp = $rw_tmp['id_tmp'];

		$product_id = $rw_tmp['product_id'];

		$qty = $rw_tmp['qty'];

		$unit_price = $rw_tmp['unit_price'];

		add_purchase_product($purchase_id, $product_id, $qty, $unit_price); //Agrego un registro  a la tabla purchase_product

		add_inventory($product_id, $qty); //Agrego la cantidad en el inventario;

		//update_buying_price($product_id,$unit_price);//Actualizo precio de compra

		update_selling_price($product_id, $unit_price); //Actualizo precio de venta

		remove_tmp($id_tmp); //Elimina el item de la tabla temporal

	}



	return $true;

}





function add_purchase_product($purchase_id, $product_id, $qty, $unit_price)

{

	global $con;

	$sql = "INSERT INTO purchase_product (purchase_product_id, purchase_id, product_id, qty, unit_price)

		VALUES (NULL, '$purchase_id', '$product_id', '$qty', '$unit_price');";

	$query = mysqli_query($con, $sql);

}

//La siguiente funcion obtine un campo de la base de datos pasando como

// parametros el nombre de la tabla, columna a retorna el campo a buscar dentro de  la dba_close

// y el termino de bussqueda en la base de datos. Retorna solo (1) resultado

// function get_id($table, $row, $condition, $equal)

// {

// 	global $con; //Variable de conexion

// 	$sql = mysqli_query($con, "select $row from $table where $condition='$equal' limit 0,1");

// 	$rw = mysqli_fetch_array($sql);

// 	$result = $rw[$row];

// 	return $result;

// }
function get_id($table, $column, $condition, $value)
{
    global $con;

    // Preparamos la consulta
    $sql = "SELECT {$column} FROM {$table} WHERE {$condition} = ? LIMIT 1";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) {
        throw new Exception("Error al preparar get_id ({$table}): " . mysqli_error($con));
    }

    // Determinar tipo de parámetro para bind_param
    // Asumimos 'i' para enteros y 's' para strings; ajustar según tus necesidades.
    $type = is_int($value) ? 'i' : 's';
    mysqli_stmt_bind_param($stmt, $type, $value);

    // Ejecutar
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error al ejecutar get_id ({$table}): " . mysqli_error($con));
    }

    // Obtener resultado
    $res = mysqli_stmt_get_result($stmt);
    if (!$res || mysqli_num_rows($res) === 0) {
        mysqli_stmt_close($stmt);
        return null;
    }

    $row = mysqli_fetch_assoc($res);
    mysqli_stmt_close($stmt);

    return $row[$column];
}


function insert_pago($total_venta,$product_id,$person_id,$sale_number,$idpp, $recargo, $vinculacion, $datepago){

	global $con; //Variable de conexion

	try {
		if ($vinculacion === 1) {
			// Primero obtenemos los datos del estudiante
			$consulta1 = mysqli_prepare($con, "SELECT name, lastname, email, code FROM centro_vinculacion WHERE id = ?");
			if (!$consulta1) { throw new Exception("Error al preparar la consulta de datos del centro_vinculacion." . mysqli_error($con)); }
	
			mysqli_stmt_bind_param($consulta1, "i", $person_id);
			if (!mysqli_stmt_execute($consulta1)) { throw new Exception("Error al ejecutar la consulta de datos del centro_vinculacion."); }
	
			$resultado1 = mysqli_stmt_get_result($consulta1);
			if (mysqli_num_rows($resultado1) == 0) { throw new Exception("No se encontró al centro_vinculacion."); }
		}else{

			// Primero obtenemos los datos del estudiante
			$consulta1 = mysqli_prepare($con, "SELECT name, lastname, email, code FROM person WHERE id = ?");
			if (!$consulta1) { throw new Exception("Error al preparar la consulta de datos del estudiante."); }
	
			mysqli_stmt_bind_param($consulta1, "i", $person_id);
			if (!mysqli_stmt_execute($consulta1)) { throw new Exception("Error al ejecutar la consulta de datos del estudiante."); }
	
			$resultado1 = mysqli_stmt_get_result($consulta1);
			if (mysqli_num_rows($resultado1) == 0) { throw new Exception("No se encontró al estudiante."); }
		}

        $row1 = mysqli_fetch_assoc($resultado1);
        $person_name = $row1['name'];
        $person_lastname = $row1['lastname'];
        $person_email = $row1['email'];
        // $person_code = $row1['code'];
		$person_code = (!empty($row1['code'])) ? $row1['code'] : 'sin code';
		$fullname = $person_name . " " . $person_lastname;
		$tipo_pago = "CAJA";
		$status = 1;
		
		// Insertamos en Pagos ya que viene de POS
		$consulta2 = mysqli_prepare($con, "INSERT INTO pagos (
			total,
			recargo,
			date_created,
			description,
			name,
			tipo_pago,
			email,
			order_id,
			idPerson,
			status,
			matricula,
			id_plan,
			vinculacion,
			payment_date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

		if (!$consulta2) { throw new Exception("Error al preparar la consulta de datos de pagos."); }

		// Obtener la fecha actual
		$date_created = date('Y-m-d H:i:s'); // Fecha actual en formato 'Y-m-d H:i:s'

		mysqli_stmt_bind_param($consulta2, "ddssssssiisiis",
			$total_venta,
			$recargo,
			$date_created,
			$product_id,  // Asegúrate de que este campo tiene el valor correcto
			$fullname,
			$tipo_pago,
			$person_email,
			$sale_number,
			$person_id,
			$status,
			$person_code,
			$idpp,
			$vinculacion,
			$datepago
		);

		// Ejecutamos la consulta de inserción
		if (!mysqli_stmt_execute($consulta2)) {
			throw new Exception("Error en la ejecucion de pagos: " . mysqli_error($con));
		}

		//Forsar Error para pruebas
		// throw new Exception("Error Forzado en Pagos");

	} catch (Exception $e) {
		// Registrar el error en el log para su posterior revisión
		error_log("Error en pagos: " . $e->getMessage());

		// Lanza la excepción original para que pueda ser manejada en una capa superior
		throw $e;
	}
		
}

function Multi_insert_pago($total_venta,$conceptos,$person_id,$sale_number,$idpp,$multisale, $multiplanes_str, $recargo, $vinculacion, $datepago){

	global $con; //Variable de conexion

	try {

		if ($vinculacion === 1) {
			// Primero obtenemos los datos del estudiante
			$consulta1 = mysqli_prepare($con, "SELECT name, lastname, email, code FROM centro_vinculacion WHERE id = ?");
			if (!$consulta1) { throw new Exception("Error al preparar la consulta de datos del centro_vinculacionMUlti."); }
	
			mysqli_stmt_bind_param($consulta1, "i", $person_id);
			if (!mysqli_stmt_execute($consulta1)) { throw new Exception("Error al ejecutar la consulta de datos del centro_vinculacionMUlti."); }
	
			$resultado1 = mysqli_stmt_get_result($consulta1);
			if (mysqli_num_rows($resultado1) == 0) { throw new Exception("No se encontró al centro_vinculacionMUlti."); }
		}else{

			// Primero obtenemos los datos del estudiante
			$consulta1 = mysqli_prepare($con, "SELECT name, lastname, email, code FROM person WHERE id = ?");
			if (!$consulta1) { throw new Exception("Error al preparar la consulta de datos del estudiante."); }

			mysqli_stmt_bind_param($consulta1, "i", $person_id);
			if (!mysqli_stmt_execute($consulta1)) { throw new Exception("Error al ejecutar la consulta de datos del estudiante."); }

			$resultado1 = mysqli_stmt_get_result($consulta1);
			if (mysqli_num_rows($resultado1) == 0) { throw new Exception("No se encontró al estudiante."); }
		}

        $row1 = mysqli_fetch_assoc($resultado1);
        $person_name = $row1['name'];
        $person_lastname = $row1['lastname'];
        $person_email = $row1['email'];
        // $person_code = $row1['code'];
		$person_code = (!empty($row1['code'])) ? $row1['code'] : 'sin code';
		$fullname = $person_name . " " . $person_lastname;
		$tipo_pago = "CAJA";
		$status = 1;
		$product_idM = 0;

		// Obtenemos los conceptos en lista (1,4,5)
		if (!empty($conceptos)) {
			$product_ids = array_column($conceptos, 'product_id'); // extrae solo los product_id
			$product_idM = implode(',', $product_ids); // convierte a string "1,14,5,8"
		}

		// Insertamos en Pagos ya que viene de POS
		$consulta2 = mysqli_prepare($con, "INSERT INTO pagos (
			total,
			recargo,
			date_created,
			description,
			name,
			tipo_pago,
			email,
			order_id,
			idPerson,
			status,
			matricula,
			id_plan,
			multisale,
			multiplanes,
			vinculacion,
			payment_date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

		if (!$consulta2) { throw new Exception("Error al preparar la consulta de datos de pagos."); }

		// Obtener la fecha actual
		$date_created = date('Y-m-d H:i:s'); // Fecha actual en formato 'Y-m-d H:i:s'

		mysqli_stmt_bind_param($consulta2, "ddssssssiisiisis",
			$total_venta,
			$recargo,
			$date_created,
			$product_idM,  // Es cero por que es multiconceptos y se poenen en sale_product directo
			$fullname,
			$tipo_pago,
			$person_email,
			$sale_number,
			$person_id,
			$status,
			$person_code,
			$idpp,
			$multisale,
			$multiplanes_str,
			$vinculacion,
			$datepago
		);

		// Ejecutamos la consulta de inserción
		if (!mysqli_stmt_execute($consulta2)) {
			throw new Exception("Error en la ejecucion de pagos: " . mysqli_error($con));
		}

		//Forsar Error para pruebas
		// throw new Exception("Error Forzado en Pagos");

	} catch (Exception $e) {
		// Registrar el error en el log para su posterior revisión
		error_log("Error en pagos: " . $e->getMessage());

		// Lanza la excepción original para que pueda ser manejada en una capa superior
		throw $e;
	}
		
}



function search_person($id)

{

	global $con; //Variable de conexion

	$query = "SELECT * FROM person WHERE id = $id";

	$execute = mysqli_query($con, $query);

	$rw = mysqli_fetch_array($execute);



	return ["matricula" => $rw['code'], "name" => $rw['name'] . " " . $rw['lastname'], "email" => $rw['email']];

}

function Multi_add_sale($person_id, $sale_by, $tax_value, $discount_value, $type_document, $payment_method, $conceptos, $recargo, $vinculacion, $datepago)

{
	// sale_number

	global $con;
	// mysqli_begin_transaction($con);
	
	try {
		
		$sum =  mysqli_prepare($con, "SELECT SUM(qty * unit_price) AS subtotal FROM product_tmp WHERE user_id = ?");
		if (!$sum) { throw new Exception("Error al preparar la multiconsulta 2"); }

		mysqli_stmt_bind_param($sum, "i", $sale_by);
		if (!mysqli_stmt_execute($sum)) { throw new Exception("Error al ejecutar la multiconsulta 2"); }

		$resultSubtotal = mysqli_stmt_get_result($sum);
		$rowSubtotal = mysqli_fetch_assoc($resultSubtotal);
		$sumador_total = $rowSubtotal['subtotal'];
		$tax = $tax_value;	
		$descuento = $discount_value;

		// Aplicamos descuento
		$precio_descuento = ($sumador_total * $descuento) / 100;
		// Total neto (subtotal - descuento)
		$total_neto = $sumador_total - $precio_descuento;

		// Calculamos IVA
		$total_iva = ($total_neto * $tax) / 100;

		// Total Final a pagar
		$total_venta = $total_neto + $total_iva;
		
		// Recargo si hay
		$total_venta = $total_venta + $recargo; //Aqui no importa hacer condicional ya que si no hay manda cero 
		
		// $netos = $total_neto - $precio_descuento;
	
		$sale_number = nex_sale_number(); //consulta 3

		// Recopilar los id_plan mayores a 0 desde el array $conceptos
		$multiplanes = array();
		foreach ($conceptos as $concepto) {
			// Verifica que id_plan exista y sea mayor a 0
			if (isset($concepto['id_plan']) && $concepto['id_plan'] > 0) {
				$multiplanes[] = $concepto['id_plan'];
			}
		}

		// Convierte el array en una cadena separada por comas, si hay registros, o asigna NULL si no
		$multiplanes_str = count($multiplanes) > 0 ? implode(",", $multiplanes) : "SN";
		
		$id_plan = 0;
		$multisale = 1;

		//Consulta 4
		$sql = mysqli_prepare($con,"INSERT INTO sales (
							sale_number, 
							person_id, 
							sale_by, 
							subtotal, 
							tax,
							recargo, 
							total,
							tax_value, 
							discount_value, 
							type_document, 
							payment_method,
							id_plan,
							multisale,
							multiplanes,
							vinculacion,
							payment_date )  
							VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		if(!$sql){ throw new Exception("Error al preparar la consulta 4. "); }

		mysqli_stmt_bind_param($sql,"iiiddddddiiiisis",$sale_number,
									$person_id, $sale_by, $sumador_total,
									$total_iva, $recargo, $total_venta,
									$tax_value, $discount_value,
									$type_document, $payment_method,
									$id_plan, $multisale, $multiplanes_str, $vinculacion,$datepago);

		if (!mysqli_stmt_execute($sql)) {
			throw new Exception("Error al ejecutar la consulta 4 : " . mysqli_error($con));	
		}

		
		// Obtén el ID del último registro insertado
		$sale_id = mysqli_stmt_insert_id($sql); // Esto es lo correcto para consultas preparadas.

		$sql_tmp = mysqli_prepare($con, "SELECT * FROM product_tmp WHERE user_id = ?");
		if (!$sql_tmp) { throw new Exception("Error al preparar la consulta 5."); }

		mysqli_stmt_bind_param($sql_tmp,"i", $sale_by);
		if(!mysqli_stmt_execute($sql_tmp)){ throw new Exception("Error al ejecutar la consulta 5: " . mysqli_error($con)); }

		$resultadoS = mysqli_stmt_get_result($sql_tmp);
		if (mysqli_num_rows($resultadoS) == 0) { throw new Exception("Error, No se encontro concepto para venta 5: "); }


		while ($rw_tmp = mysqli_fetch_assoc($resultadoS)) {

			$id_tmp = $rw_tmp['id_tmp'];
			$product_id = $rw_tmp['product_id'];
			$qty = $rw_tmp['qty'];
			$unit_price = $rw_tmp['unit_price'];
			$idpp =  $rw_tmp['id_plan'];

			add_sale_product($sale_id, $product_id, $qty, $unit_price, $idpp); //Agrego un registro  a la tabla sale_product consulta 6

			// insert_pago($total_venta,$product_id,$person_id,$sale_number,$idpp);

			add_historial($sale_number, $product_id, $person_id, $vinculacion); //Agrego un registro  a la tabla sale_product consulta 7

			remove_inventory($product_id, $qty, $vinculacion); //Disminuye la cantidad en el inventario; consulta 8

			remove_tmp($id_tmp); //Elimina el item de la tabla temporal consulta 9

		}

		Multi_insert_pago($total_venta,$conceptos,$person_id,$sale_number,$idpp,$multisale, $multiplanes_str, $recargo, $vinculacion, $datepago);
		
		// mysqli_commit($con);
		
		// Devolver el sale_id al final del proceso
		return $sale_id; // Aquí devolvemos el ID de la venta

	} catch (Exception $e) {
		
		 // Registrar el error en el log para su posterior revisión
		 error_log("Error: " . $e->getMessage());

		 // Lanza la excepción original para que pueda ser manejada en una capa superior
		 throw $e;
		
	}
	
}