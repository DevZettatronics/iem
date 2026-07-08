<?php
include "../../controller/Database.php";
// add_sale1.php

// Conectarse a la base de datos
$con = Database::getCon();

$sale_number = intval($_POST['sale_number']);
$person_id = intval($_POST['person_id']);
$tax = floatval($_POST['tax']);
$descuento = floatval($_POST['descuento']);
$payid = intval($_POST['payid']);
$total = intval($_POST['payablePrice']);
$pago = intval($_POST['pago']);
$sale_by = 0;
$type_document = 2;
$payment_method = 5;
// $sale_date = date("Y-m-d H:i:s");

add_sale1($sale_number, $person_id, $sale_by, $tax, $descuento, $type_document, $payment_method, $payid, $total, $pago);

function add_sale1($sale_number, $person_id, $sale_by, $tax_value, $discount_value, $type_document, $payment_method, $payid, $total, $pago)
{
    global $con;

    mysqli_begin_transaction($con);
    try {
        // Obtener el id del producto del plan_de_pago
        $sql = mysqli_prepare($con,"SELECT * FROM plan_de_pago WHERE id = ?");
        if (!$sql) {
            throw new Exception("Error al preparar la consulta 1");
        }
        mysqli_stmt_bind_param($sql, "i", $payid);  // Bind del parámetro

        //Ejecutamos la consulta
        if (!mysqli_stmt_execute($sql)) {
            throw new Exception("Error al ejecutar la consulta 1: " . mysqli_error($con));
        }

        //Obtenemos resultado
        $result = mysqli_stmt_get_result($sql);
        if (mysqli_num_rows($result) == 0) {
            throw new Exception("No se encontró el plan de pagos");
        }

        $row = mysqli_fetch_assoc($result);
        $nomprod = $row['concepto'];

        // --------------------- siguiente consulta
        $precioprod = mysqli_prepare($con,"SELECT selling_price FROM products WHERE product_id = ? ");
        if (!$precioprod) {
            throw new Exception("Error al preparar la consulta 2");
        }
        mysqli_stmt_bind_param($precioprod, 'i', $nomprod);

        //Ejecutamos la consulta
        if (!mysqli_stmt_execute($precioprod)) {
            throw new Exception("Error al ejecutar la consulta 2: " . mysqli_error($con));
        }

        //Obtenemos resultados
        $result2 = mysqli_stmt_get_result($precioprod);
        if (mysqli_num_rows($result2) == 0) {
            throw new Exception("No se encontro el precio asignado.");
            
        }

        $row2 = mysqli_fetch_assoc($result2);
        $netos = $row2['selling_price'];

        // ------------------------------------- LLamadas a otras funciones
        $total_venta = number_format($pago, 2, '.', '');
        $total_iva = $tax_value;
        $discount_value = number_format($discount_value, 2, '.', '');

        //Realizamos la consulta para sales
        $consultaSales = mysqli_prepare($con,"INSERT INTO sales (
                                                sale_number,
                                                person_id,
                                                sale_by,
                                                subtotal,
                                                tax,
                                                total,
                                                tax_value,
                                                discount_value,
                                                type_document,
                                                payment_method,
                                                id_plan
                                            ) VALUES (
                                                ?,?,?,?,?,?,?,?,?,?,?
                                            ) ");
        if(!$consultaSales){ throw new Exception("Error al preparar la consulta 3"); }

        mysqli_stmt_bind_param($consultaSales,"iiidddddiii",
                                    $sale_number,
                                    $person_id,
                                    $sale_by,
                                    $netos,
                                    $total_iva,
                                    $total_venta,
                                    $tax_value,
                                    $discount_value,
                                    $type_document,
                                    $payment_method,
                                    $payid
                                );
        //Ejecutamos la consulta
        if (!mysqli_stmt_execute($consultaSales)) {
            throw new Exception("Error al ejecutar la consulta 3: " . mysqli_error($con));
        }                       

        // Obtener el último ID insertado (el valor de sale_id)
        $sale_id = mysqli_insert_id($con);
        if (!$sale_id) {
            throw new Exception("No se pudo obtener el ID de la venta");
        }

        $qty = 1;
        $unit_price = $netos;  //Reasignamos valor a nueva variable para saber que es
        $product_id = $nomprod; //Reasignamos valor a nueva variable para saber que es

        //LLamamos la funcion para insertar en sale_product
        add_sale_product1($sale_id, $product_id, $qty, $unit_price, $payid);

        //LLamamos la funcion para insertar en historial
        add_historial1($sale_number, $product_id, $person_id);

        //Si todo sale bien confirmamos
        mysqli_commit($con);

        echo json_encode([
            'status' => 'success',
            'message' => 'Informacion Actualizada'
        ]);

        exit;
    } catch (Exception $e) {
        // Si algo sale mal, revertimos todas las operaciones
        mysqli_rollback($con);
        error_log($e->getMessage());

        echo json_encode([
            'status' => 'error',
            'message' => 'Hubo un problema al actualizar la informacion: ' . $e->getMessage()
        ]);
        exit;
    }

}

function add_sale_product1($sale_id, $product_id, $qty, $unit_price, $payid)
{
    global $con;

    // mysqli_begin_transaction($con);
    try {
        $consultaSaleP = mysqli_prepare($con,"INSERT INTO sale_product (sale_id, product_id, qty, unit_price, id_plan)
		VALUES (?,?,?,?,?)");

        //Verificamos Consulta
        if (!$consultaSaleP) {
            throw new Exception("Error al preparar la consulta 4");
        }
        mysqli_stmt_bind_param($consultaSaleP,"isidi",$sale_id, $product_id, $qty, $unit_price, $payid);

        if (!mysqli_stmt_execute($consultaSaleP)) {
            throw new Exception("Error al ejecutar la consulta 4: " . mysqli_error($con));
            
        }

        //Confirmamos la consutla
        // mysqli_commit($con);
    } catch (Exception $e) {
       //Manejo de errores
    //    mysqli_rollback($con);
       error_log($e->getMessage());  // Guarda el mensaje de error en el log del servidor
       throw $e;  // Lanza el error para manejarlo fuera de la función si es necesario
    }

}

function add_historial1($sale_id, $product_id, $person_id)
{
    global $con;

    // mysqli_begin_transaction($con);

    try {
        //Preparamos la consutla
        $consultaHirial= mysqli_prepare($con,"INSERT INTO historial (sale_id,product_id,person_id) VALUES (?,?,?)");
        if (!$consultaHirial) {
            throw new Exception("Error al preparar la consulta 5");
        }

        // Prueba Forzar error 
        // throw new Exception("Error forzado: Simulando un fallo.");

        mysqli_stmt_bind_param($consultaHirial,"isi", $sale_id, $product_id, $person_id);

        if (!mysqli_stmt_execute($consultaHirial)) {
            throw new Exception("Error al ejecutar la consulta 5" . mysqli_error($con));
            
        }

        //Confirmamos 
        // mysqli_commit($con);
    } catch (Exception $e) {
        // mysqli_rollback($con);
        error_log($e->getMessage());  // Guarda el mensaje de error en el log del servidor
        throw $e;  // Lanza el error para manejarlo fuera de la función si es necesario
    }

}
?>
