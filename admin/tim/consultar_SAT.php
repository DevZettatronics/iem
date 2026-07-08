<?php
session_start();
include_once('../config/db.php');
include_once('../config/conexion.php');
$id_factura = $_GET['id'];
$sql = "SELECT r_xml FROM factura WHERE folio = '$id_factura' ";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_row($query);
$contenido = file_get_contents("../" . $row[0]);

$contenido = str_replace("<tfd:", "<cfdi:", $contenido);
$contenido = str_replace("<cfdi:", "<", $contenido);
$contenido = str_replace("</cfdi:", "</", $contenido);
$contenido = str_replace("@attributes", "attributes", $contenido);


$contenido = (array) simplexml_load_string($contenido);

$rfc_emisor = strval($contenido["Emisor"]["Rfc"]);
$rfc_receptor = strval($contenido["Receptor"]["Rfc"]);
$total = strval($contenido["@attributes"]["Total"]);
$contenido = (array)($contenido["Complemento"]);
$contenido = (array)($contenido["TimbreFiscalDigital"]);
$UUID = strval($contenido["@attributes"]["UUID"]);
$array_product = array(
    'Emisor' => $rfc_emisor,
    'Receptor' => $rfc_receptor,
    'Total' => $total,
    'UUID' => $UUID
);
echo json_encode($array_product);