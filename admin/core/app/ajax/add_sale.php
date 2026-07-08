<?php
require "../../../libraries/inventory.php";
include "../../controller/Database.php";
// add_sale1.php

// Conectarse a la base de datos
$con = Database::getCon();

$sale_number = intval($_POST['sale_number']);
$person_id = intval($_POST['person_id']);
$sale_by = 0;
$sale_date = date("Y-m-d H:i:s");
$tax = floatval($_POST['tax']);
$descuento = floatval($_POST['descuento']);
$type_document = 2;
$payment_method = 5;
$payid = intval($_POST['payid']);
$total = intval($_POST['payablePrice']);
$pago = intval($_POST['pago']);

add_saler($sale_number, $person_id, $sale_by, $sale_date, $tax, $descuento, $type_document, $payment_method, $payid, $pago);

function add_saler($sale_number, $person_id, $sale_by, $sale_date, $tax_value, $discount_value, $type_document, $payment_method, $payid, $pago)
{
    global $con;
    

    // // Obtener el id del producto del plan_de_pago
    $sql = "SELECT * FROM plan_de_pago WHERE id = $payid";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $nomprod = $row['concepto'];

    // // Obtener el precio de venta del producto
    // // $precioprod = "SELECT selling_price FROM products WHERE product_id = $nomprod";
    // // $result1 = mysqli_query($con, $precioprod);
    // // $row1 = mysqli_fetch_assoc($result1);
    // // $netos = $row1 ? $row1['selling_price'] : 0;

    $precioprod = "SELECT selling_price FROM products WHERE product_id = '$nomprod'";
    $result = mysqli_query($con, $precioprod);
    $row = mysqli_fetch_assoc($result);
     $netos = $row['selling_price'];

    $total_venta = number_format($pago, 2, '.', '');
    $total_iva = 0;
    $discount_value = number_format($discount_value, 2, '.', '');
    

    $sql = "INSERT INTO sales
        (sale_number, person_id, sale_by, subtotal, tax, total, sale_date, tax_value, discount_value, type_document, payment_method, id_plan) 
        VALUES ('$sale_number', '$person_id', '$sale_by', '$netos', ' $total_iva', '$total_venta', '$sale_date', '$tax_value', '$discount_value', '$type_document', '$payment_method', '$payid')";
    $query = mysqli_query($con, $sql);
    echo $sql;
    $sql = "SELECT * FROM sales WHERE id_plan = $payid";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $sale_id = $row['sale_id'];

    $qty = 1;
    $unit_price = $netos;
    $product_id = $nomprod;
    add_sale_product($sale_id, $product_id, $qty, $unit_price, $payid);
    add_historial($sale_number, $product_id, $person_id);
}



