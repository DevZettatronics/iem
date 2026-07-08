<?php

include "../../controller/Database.php";

$con = Database::getCon();

if (isset($_GET['idProducto'])) {



    $idPlanPago = $_GET['idProducto']; #--> es el id del plan_de_pago con este sacamos el producto

    // $queryBeca = "SELECT * FROM products, plan_de_pago, person, becas WHERE person.promocion=becas.id AND plan_de_pago.alumno=person.id AND plan_de_pago.id = $idPlanPago And plan_de_pago.concepto=products.product_id";
    // $sql = mysqli_query($con, $queryBeca);
    // while ($row = mysqli_fetch_array($sql)) {
    //     $porcentajePromocion = $row ['porcentaje'];
    // }
    $queryBeca = "
        SELECT becas.porcentaje
        FROM plan_de_pago
        INNER JOIN person ON plan_de_pago.alumno = person.id
        INNER JOIN becas ON person.promocion = becas.id
        WHERE plan_de_pago.id = $idPlanPago
    ";
    $sql = mysqli_query($con, $queryBeca);
    $porcentajePromocion = 0;

    if ($row = mysqli_fetch_array($sql)) {
        $porcentajePromocion = $row['porcentaje'];
    }

    //$porcentajeBeca = $_GET['porcentajeBeca']; 

    // $porcentajePromocion = $_GET['porcentajePromocion'];


    // $queryPlanPago = mysqli_query($con,"SELECT * FROM products, plan_de_pago, person, becas WHERE person.beca=becas.id AND plan_de_pago.alumno=person.id AND plan_de_pago.id = $idPlanPago And plan_de_pago.concepto=products.product_id");
    $queryPlanPago = "
                        SELECT 
                            becas.id AS idBeca,
                            becas.porcentaje,
                            plan_de_pago.id AS idplan,
                            plan_de_pago.concepto,
                            plan_de_pago.cuenta_beca,
                            plan_de_pago.cuenta_promocion
                        FROM plan_de_pago
                        INNER JOIN person ON plan_de_pago.alumno = person.id
                        INNER JOIN becas ON person.beca = becas.id
                        WHERE plan_de_pago.id = $idPlanPago
                    ";
    $resultado = mysqli_query($con, $queryPlanPago);               
    if ($resultado && $resultado->num_rows > 0) {

        $data = mysqli_fetch_array($resultado);
        $porcentajeBeca = $data['porcentaje'];
        $idProducto = $data['concepto'];
        $cbeca = $data['cuenta_beca'];
        $cprom = $data['cuenta_promocion'];
        
        $query = "SELECT * FROM products WHERE product_id = $idProducto";

        $queryProducto = mysqli_query($con, $query);

        if ($queryProducto->num_rows > 0) {

            $row = mysqli_fetch_array($queryProducto);

            $precio = $row['selling_price'];

            if ($row==TRUE) {
                if($cprom == "SI" && $cbeca == "SI"){
                    $porcentaje = $porcentajeBeca + $porcentajePromocion;
                    $precioFinal = $precio - (( ($precio * ($porcentajeBeca / 100) ) ) + ( ($precio * ($porcentajePromocion / 100) ) ));
                }
                if($cbeca == "SI" &&  $cprom == "NO"){
                    $porcentaje = $porcentajeBeca;
                    $precioFinal = $precio - ( ($precio * ($porcentajeBeca / 100) ) );
                }if($cbeca == "NO" &&  $cprom == "SI"){
                    $porcentaje =  $porcentajePromocion;
                    $precioFinal = $precio - ( ($precio * ($porcentajePromocion / 100) ) );
                }
                if($cprom == "NO" && $cbeca == "NO"){
                    $porcentaje = 0;
                    $precioFinal = $precio;
                }
                    //$precioFinal = $precio - (( ($precio * ($porcentajeBeca / 100) ) ) + ( ($precio * ($porcentajePromocion / 100) ) ));

                }

            $success = ['code' => 200, 'precioLista' => $precio, 'precioFinal' => $precioFinal, 'descuento'=>$porcentaje, "idProducto" => $idProducto];

            echo json_encode($success);

        } else {

            $error = ['code' => 404, 'message' => 'No se encontro el producto'];

            echo json_encode($error);

        }

    } else {

        $error = ['code' => 404, 'message' => 'No se encontro el plan de pago'];

        echo json_encode($error);

    }

} elseif (isset($_POST["idPlanDePago"])) {

    $idPlanPago = $_POST["idPlanDePago"];

    mysqli_begin_transaction($con);

    try {
        $queryPlanPago = mysqli_query($con, "UPDATE plan_de_pago SET status = 2 WHERE id = $idPlanPago");

        if(!$queryPlanPago){
            throw new Exception("Error al actualizar tu plan de pagos.");
        }

        //Si todo salio biew confirmamos transaccion
        mysqli_commit($con);
    
        $success = ['code' => 200, 'message' => 'Pago concluido', 'message2' => 'Actualizando información, por favor espera'];
    
        echo json_encode($success);
    
    } catch (Exception  $e) {
        mysqli_rollback($con);
        $error = ['code' => 404, 'message' => $e->getMessage()];
        echo json_encode($error);
    }
   

} else {

    $error = ['code' => 404, 'message' => 'No se encontro informacion'];

    echo json_encode($error);

}