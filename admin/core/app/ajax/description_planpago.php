<?php

include "../../controller/Database.php";

$con = Database::getCon();

if (isset($_GET['idProducto'])) {



    $idPlanPago = $_GET['idProducto']; #--> es el id del plan_de_pago con este sacamos el producto

    $queryBeca = "SELECT * FROM products, plan_de_pago, person, becas WHERE person.promocion=becas.id AND plan_de_pago.alumno=person.id AND plan_de_pago.id = $idPlanPago And plan_de_pago.concepto=products.product_id";
    $sql = mysqli_query($con, $queryBeca);
    while ($row = mysqli_fetch_array($sql)) {
        $porcentajePromocion = $row ['porcentaje'];
    }

    //$porcentajeBeca = $_GET['porcentajeBeca']; 

    // $porcentajePromocion = $_GET['porcentajePromocion'];



    //$queryPlanPago = mysqli_query($con, "SELECT * FROM plan_de_pago WHERE id = $idPlanPago");
    $queryPlanPago = mysqli_query($con,"SELECT * FROM products, plan_de_pago, person, becas WHERE person.beca=becas.id AND plan_de_pago.alumno=person.id AND plan_de_pago.id = $idPlanPago And plan_de_pago.concepto=products.product_id");

    if ($queryPlanPago->num_rows > 0) {

        $data = mysqli_fetch_array($queryPlanPago);
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
                    $precioFinal = $precio - (( ($precio * ($porcentajeBeca / 100) ) ) + ( ($precio * ($porcentajePromocion / 100) ) ));
                }
                if($cbeca == "SI" &&  $cprom == "NO"){
                    $precioFinal = $precio - ( ($precio * ($porcentajeBeca / 100) ) );
                }if($cbeca == "NO" &&  $cprom == "SI"){
                    $precioFinal = $precio - ( ($precio * ($porcentajePromocion / 100) ) );
                }
                if($cprom == "NO" && $cbeca == "NO"){
                    $precioFinal = $precio;
                }
                    //$precioFinal = $precio - (( ($precio * ($porcentajeBeca / 100) ) ) + ( ($precio * ($porcentajePromocion / 100) ) ));

                }

            $success = ['code' => 200, 'precioLista' => $precio, 'precioFinal' => $precioFinal, "idProducto" => $idProducto];

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

    $queryPlanPago = mysqli_query($con, "UPDATE plan_de_pago SET status = 2 WHERE id = $idPlanPago");

    if ($queryPlanPago) {

        $success = ['code' => 200, 'message' => 'Pago concluido'];

        echo json_encode($success);

    } else {

        $error = ['code' => 404, 'message' => 'Error al concluir el pago'];

        echo json_encode($error);

    }

} else {

    $error = ['code' => 404, 'message' => 'No se encontro informacion'];

    echo json_encode($error);

}