<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //Se esta ejecutando desde cron en un entorno diferente al del navegador, lo cual rompe las rutas relativas (include(...)).
    include(__DIR__ . "/../../controller/Database.php"); 
    
    //Para trabajar en local
    // include "../../controller/Database.php";
    $con = Database::getCon();

    date_default_timezone_set('America/Mexico_City');
    $fechaActual = date('Y-m-d');

    $vencido = 6; //Vencido
    $pendiente = 1; //Pendiente

    mysqli_begin_transaction($con);

    try {
         //Consultamos todos los planes de pago que por fecha fin
        $consulta = mysqli_prepare($con,"UPDATE plan_de_pago SET status = ? WHERE fecha_fin_pago < ? AND status = ? ");
        if (!$consulta) {
            throw new Exception("Error al preparar al consulta");
        }

        mysqli_stmt_bind_param($consulta,"isi",$vencido,$fechaActual,$pendiente);
        if (!mysqli_stmt_execute($consulta)) {
            throw new Exception("Error al ejecutar la consulta: " . mysqli_stmt_error($consulta));
        }

        //Verificamos cuanto se actualizaron
        $filasActualizadas = mysqli_stmt_affected_rows($consulta);

        
        mysqli_commit($con);

        //Para pruebas locales descomentar y comentar el de abajo, ejecutar este archivo directo por url llamandolo
        // if ($filasActualizadas > 0) {
        //     echo "Se actualizaron $filasActualizadas registros a estado 'Vencido'.";
        // } else {
        //     echo "No se encontraron registros pendientes que estén vencidos.";
        // }

        if ($filasActualizadas > 0) {
            error_log("Se actualizaron $filasActualizadas registros a estado 'Vencido' Servicios. Fecha de ejecución: " . $fechaActual);
        } else {
            error_log("No se encontraron registros pendientes que estén vencidos en Servicios. Fecha de ejecución: " . $fechaActual);
        }
    } catch (Exception $e) {
        mysqli_rollback($con);
        error_log($e->getMessage()); // Para ver el error exacto en los logs
        echo "Ocurrió un error: " . $e->getMessage(); // Opcional: útil en pruebas locales
    }
   
?>