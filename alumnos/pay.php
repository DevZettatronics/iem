<?php
require_once("business/Payment.php");
extract($_REQUEST);

$oPayment = new Payment($conektaTokenId, $card, $name, $description, $total, $email, $idAlumno);

if ($oPayment->pay()) {
    $success = ["code" => 200, "message" => "Pago realizado correctamente"];
    echo json_encode($success);
} else {
    $error = ["code" => 404, "message" => $oPayment->error];
    echo json_encode($error);
}
