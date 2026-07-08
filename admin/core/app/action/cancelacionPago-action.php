<?php
if (isset($_GET["opt"]) && $_GET["opt"] === "cancelar") {
    header('Content-Type: application/json; charset=utf-8');

    if (empty($_GET["id_pago"]) || empty($_GET["order"]) || empty($_GET["nombreCancelacion"])) {
        echo json_encode([
            "success" => false,
            "error"   => "Faltan parámetros"
        ]);
        exit;
    }

    $status = 7;
    $id_pago = intval($_GET["id_pago"]);
    $order  = trim($_GET["order"]);
    $kind_cancelacion  = intval($_GET["nombreCancelacion"]);

    try {
        PaymentData::cancelacion($id_pago, $order, $status, $kind_cancelacion);

        echo json_encode([
            "success"  => true,
            "message"  => "Pago cancelado correctamente",
            "redirect" => "./?view=payments&opt=all"
        ]);
        exit; // 🔹 Muy importante
    } catch (Exception $e) {
        error_log("Error en cancelacion: " . $e->getMessage());

        echo json_encode([
            "success" => false,
            "error"   => "Ocurrió un error al cancelar el pago"
        ]);
        exit; // 🔹 Muy importante
    }
}
