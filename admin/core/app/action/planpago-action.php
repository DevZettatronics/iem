<?php

// Verificar si se ha enviado el formulario y el parámetro "opt" es igual a "add"
if (isset($_GET["opt"]) && $_GET["opt"] == "add") {
    // Verificar si se ha enviado algún dato en el formulario
    if (count($_POST) > 0) {
        $con = Database::getCon();
        $periodo = $_POST["periodo"];
        $grupo = $_POST["grupo"];
        $alumn_id = $_POST["alumn_id"];
        $productos = $_POST["productos"];
        $cuenta_beca = $_POST["cuen_beca"];
        $cuenta_prom = $_POST["cuen_prom"];

        // Obtener los meses seleccionados
        $meses =  $_POST["meses"];
        
        //Comenzamos transaccion (eficiente para consulta atomicas)
        mysqli_begin_transaction($con,MYSQLI_TRANS_START_READ_WRITE);
        
        try {
            // Recorrer los alumnos, productos y meses seleccionados
            foreach ($meses as $mes) {
                foreach ($alumn_id as $alumno) {
                    foreach ($productos as $producto) {
                        
                        $fechaInicioName = 'fecha_inicio_' . $mes;
                        $fechaFinName = 'fecha_fin_' . $mes;
                
                        // Verificar si se han proporcionado las fechas de inicio y fin de pago para el mes actual
                            
                        // Obtener las fechas de inicio y fin de pago
                        $fechaInicio = $_POST[$fechaInicioName];
                        $fechaFin = $_POST[$fechaFinName];
        
                        $fecha = new DateTime($fechaInicio);
                        $anio = $fecha->format('Y');
                
                        // 🔥 Bloquear la fila del alumno para evitar inserciones simultáneas
                        $query_lock = mysqli_query($con, "SELECT * FROM plan_de_pago WHERE alumno=$alumno AND concepto=$producto AND mes=$mes AND EXTRACT(YEAR FROM fecha_inicio_pago) = $anio FOR UPDATE");

                        // Verificar si el alumno ya está registrado con este producto
                        $query = mysqli_query($con, "SELECT 1 FROM plan_de_pago WHERE alumno=$alumno AND concepto = $producto AND mes = $mes AND EXTRACT(YEAR FROM fecha_inicio_pago) = $anio LIMIT 1");
                        $filas = mysqli_num_rows($query);
        
                        if ($filas >= 1) {
                            throw new Exception("El/Los alumno(s) ya está(n) registrado(s) con este producto.");
                        } else {
                            // Insertar el registro en la base de datos
                            $sql = "INSERT INTO plan_de_pago (periodo, carrera, alumno, concepto, status, cuenta_beca, cuenta_promocion, date_added, fecha_inicio_pago, fecha_fin_pago, mes) 
                                    VALUES ('$periodo', '$grupo', '$alumno', '$producto', '1', '$cuenta_beca', '$cuenta_prom', NOW(), '$fechaInicio', '$fechaFin', '$mes')";
                            
                            if (!mysqli_query($con, $sql)) {
                                throw new Exception("El registro falló: " . mysqli_error($con));
                            }
                        }

                        // Simulación de un error para realizar el rollback
                        // throw new Exception("Error simulado para realizar rollback");
                    }
                }
            }

            //Confirmamos transaccion
            mysqli_commit($con);
            Core::alert("Plan de pago registrado exitosamente");
        } catch (Exception $e) {
                //Revertir si hubo algun error
                mysqli_rollback($con);
                Core::alert("Error: " . $e->getMessage());
        } 
        //Direccionamos a la lista
        Core::redir("./?view=planpago&opt=all");  
    }
}

if (isset($_GET["opt"]) && $_GET["opt"] == "reporte_excel_pagos") {
	# --> Creamos las variables con lo que nos envian desde el front
	$dates = ["start_date" => $_GET["start_date"], "end_date" => $_GET["end_date"]];
	# --> Mandamos a traer el SQL del JOIN que hicimos
	$data = PlandepagoData::ReporteVentasExcel($dates);

	# --> Metadata para crear excel
	$extension = 'xls';
	header("'Content-type:application/$extension");
	header("Content-Disposition: attachment; filename=Reporte_Ventas_" . date('d_m_Y') . "." . $extension);
	header('Content-Type: text/html; charset=utf-8');

	# Manera numero 1 de mandar a llamar el require_once ocupando $_SERVER['DOCUMENT_ROOT']
	// include $_SERVER['DOCUMENT_ROOT'] . "/admin/core/app/view/reportes/reporte_excel_pdpagos.php";
	# Manera numero 2 de mandar a llamar el require_once bajando de niveles
	include "../admin/core/app/view/reportes/reporte_excel_pdpagos.php";
}



if (isset($_GET["opt"]) && $_GET["opt"] == "edit") { /*EDICION */



    if (count($_POST) > 0) {



        $a = PlandepagoData::getById($_POST["id"]);
        $a1 = PlandepagoData::getById($_POST["id"]);


        $a->concepto = $_POST["concepto"];
        $a1->concepto1 = $_POST["concepto2"];

        $u = $a->update();
        $u2 = $a1->update1();


        Core::alert("Se actualizaron los datos");



        Core::redir("./?view=planpago&opt=all");



    }



}



if (isset($_GET["opt"]) && $_GET["opt"] == "del") {/*ELIMINACION  */

    // $user = PlandepagoData::getById($_GET["id"]);

    // $user->del();

    // Core::redir("./?view=planpago&opt=all");
    header('Content-Type: application/json; charset=utf-8');
    
    if (empty($_GET["id"])) {
        echo json_encode([
            "success" => false,
            "error" => "Falta el ID del plan"
        ]);
        exit;
    }

    $user = PlandepagoData::getById($_GET["id"]);
    
    if($user){
        $user->del();
        echo json_encode([
            "success" => true,
            "message" => "Plan eliminado correctamente",
            "redirect" => "./?view=planpago&opt=all"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "error" => "No se encontró el plan"
        ]);
    }
    exit;
}







if (isset($_GET["opt"]) && $_GET["opt"] == "val") {/*Validar  */







    $valid = PlandepagoData::getById($_GET["id"]);



    $valid->val();







    Core::redir("./?view=planpago&opt=all");



}



