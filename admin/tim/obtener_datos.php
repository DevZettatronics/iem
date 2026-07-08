<?php
include_once("../config/db.php");
include_once("../config/conexion.php");
if(isset($_POST["id"]) ){
    $id_customer = $_POST["id"];
    $sql_user = mysqli_query($con, "SELECT * FROM customers where id = '$id_customer'");
    $rw = mysqli_fetch_array($sql_user);

    $customers_id = $rw['id'];
    $customers_name = $rw['name'];
    $customers_last_name = $rw['last_name'];
    $cp = $rw['postal_code'];
    $pais = $rw['country'];
    $estado = $rw['state'];
    $ciudad = $rw['city'];
    $calle = $rw['address1'];
    $rfc = $rw['rfc'];
    $regimen = $rw['regimen'];
}
echo json_encode(array(
    "nombre" => $customers_name . " " . $customers_last_name,
    "rfc"=>$rfc,
    "direccion" => $pais . "," . $estado . "," . $ciudad . ", Calle y No." . $calle,
    "cp" => $cp

));
?>