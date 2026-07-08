<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("location: index.php"); // Redirige si no hay sesión activa
    exit;
}

include("config/db.php");
include("config/conexion.php");
include("libraries/inventory.php");

// Obtener los datos JSON enviados en la solicitud
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    // Acceder a los datos enviados a través de JSON
    $person_id = intval($data['person_id']);
    $payment_method = intval($data['payment_method']);  // Asegúrate de que 'payment_method' coincida
    $tax = floatval($data['taxes']);  // Asegúrate de que 'taxes' sea correcto
    $descuento = floatval($data['descuento']);
    $sale_by = $_SESSION['user_id'];
    $pago = floatval($data['payment']);
    $total = floatval($data['total']);  // Usamos float para total si es un decimal
    $recargo = floatval($data['recargo']);  
    $vinculacion = floatval($data['vinculacion']);  
    $datepago = $data['datepago'];  

    $status = 1;
    // Aquí deberías insertar los datos en la base de datos o hacer lo que necesites con ellos
    mysqli_autocommit($con, false);
    mysqli_begin_transaction($con);

    try {

        // Buscamos en product_tmp si hay productos agregados para la venta
        $consulta1 = mysqli_prepare($con, 'SELECT product_id, id_plan, vinculacion FROM product_tmp WHERE user_id=? ');
        
        if (!$consulta1) { throw new Exception("Error al preparar la consulta 1"); }

        mysqli_stmt_bind_param($consulta1,"i", $sale_by);
        if (!mysqli_stmt_execute($consulta1)) { throw new Exception("Error al ejecutar la consulta 1: " . mysqli_errno($con)); }

        // Obtener el resultado de la consulta
        $resultado = mysqli_stmt_get_result($consulta1);

        // if (mysqli_num_rows($resultado) == 0 ) {
        //     throw new Exception("No hay productos agregados a la factura.");
        // }

        $num_registros = mysqli_num_rows($resultado);
        
        //Evaluar si el dato de pago es menor al total para pagar en el pos
        if ($pago < $total) {
            throw new Exception("La cantidad a pagar es menor al total.");
        }

        $type_document = 2;

        if ($num_registros === 1 ) {
          
             // Solo hay un registro: Procesamos ese registro
            $row = mysqli_fetch_assoc($resultado);
            $product_id = $row['product_id'];
            $id_plan = $row['id_plan'];
            $vinculacion = intval($row['vinculacion']);
    
            //Insertamos en sales y en las demas tablas (sale_product, historial, edit product_tmp, inventory)
            $sale_id = add_sale($person_id, $sale_by, $tax, $descuento, $type_document, $payment_method, $id_plan, $recargo, $vinculacion, $datepago);
                
            // Actualizamos el plan de pagos correspondiente al pago y a la insercion en sales
            actupp($id_plan);
            
        }elseif ($num_registros >= 2) {
                // Vamos a Crear un array de todos los productos en tmp con el usuario que trabaja la session
                $conceptos = [];
                $vinculaciones = [];

                //Recorremos todos para guardarlso en la variable $conceptos
                while ($rowC = mysqli_fetch_assoc($resultado)) {
                    $conceptos[] = [
                            'product_id' => $rowC['product_id'],
                            'id_plan' => $rowC['id_plan']
                    ];

                    $vinculaciones[] = $rowC['vinculacion'];
                }

                // Validar que todas las vinculaciones sean iguales y que sean 1 o 2
                $vinculaciones_unicas = array_unique($vinculaciones);
                if (count($vinculaciones_unicas) > 1 || !in_array($vinculaciones_unicas[0], ['1', '2'])) {
                    throw new Exception("Solo se pueden hacer pagos de vinculación únicos (1 o 2), no combinados.");
                }

                // ✅ Asignar el valor único
                $vinculacion = (int)$vinculaciones_unicas[0];

                    //Ejecutamos la funcion para mandar los datos del conjunto de conceptos de un solo pago y los conceptos en el array
                    $sale_id = Multi_add_sale($person_id, $sale_by, $tax, $descuento, $type_document, $payment_method, $conceptos, $recargo, $vinculacion, $datepago);
                    
                    // Actualizar cada id_plan, puedes recorrer el array:
                    foreach ($conceptos as $concepto) {
                        if (isset($concepto['id_plan']) && $concepto['id_plan'] > 0) {
                            actupp($concepto['id_plan']);
                        }
                    }
        }else{
            throw new Exception("No hay productos agregados a la factura.");
        }

        // Si todo sale bien, realizamos el commit de la transacción
        mysqli_commit($con);

        // Enviamos el mensaje de éxito
        echo json_encode([
            "status" => "ok",
            "message" => "Pago procesado exitosamente",
            "sale_id" => $sale_id  // Incluimos el sale_id en la respuesta
        ]);

    } catch (Exception $e) {
        // En caso de error, hacemos rollback para deshacer todos los cambios realizados en la transacción
        mysqli_rollback($con);

        // Enviamos el mensaje de error
        echo json_encode([
            "status" => "error",
            "message" => $e->getMessage() // Mensaje de la excepción
        ]);
    }finally {
        mysqli_autocommit($con, true);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
}
?>
