<!-- COMO SERIA HACER EL CODIGO DEL ARCHIVO PRUEBA.PHP 
AGREGANDO LA FUNCION DE ARRIBA PARA CREAR DEL JSON EL XML -->
<?php
require_once("../config/db.php");
require_once("../config/conexion.php");

$XML = $_POST['dato']['XML'];
$UUID = $_POST['dato']['UUID'];
$NoCertificado = $_POST['dato']['NoCertificado'];
$NoCertificadoSAT = $_POST['dato']['NoCertificadoSAT'];
$CadenaOriginal = $_POST['dato']['CadenaOriginal'];
$CadenaOriginalSAT = $_POST['dato']['CadenaOriginalSAT'];
$Sello = $_POST['dato']['Sello'];
$SelloSAT = $_POST['dato']['SelloSAT'];
$CodigoQR = $_POST['dato']['CodigoQR'];
$FechaTimbrado = $_POST['dato']['FechaTimbrado'];

$id_tmp = $_POST['tmp'];
$codigo = $_POST['codigo'];

if ($codigo == 500) {
    $errors[] = $codigo;
} elseif ($codigo == 200) {
    $sel_T = mysqli_query($con, "SELECT * FROM tmp_fac where ticket_id=$id_tmp");
    $rsel_T = mysqli_num_rows($sel_T);
    $ticket_T = $rsel_T['ticket_id'];
    if ($rsel_T >= 1) {
        $query = "INSERT INTO factura SELECT * FROM tmp_fac where ticket_id=$id_tmp";        
        $in = mysqli_query($con, $query);
        $query = "UPDATE factura SET create_added=NOW() where ticket_id=$id_tmp";
        $in = mysqli_query($con, $query);
        $del = mysqli_query($con, "DELETE FROM tmp_fac where ticket_id=$id_tmp");

        $sel = mysqli_query($con, "SELECT * FROM factura where ticket_id=$id_tmp");
        $rsel = mysqli_fetch_array($sel);
        $ticket = $rsel['ticket_id'];

        //$jSON = json_decode($datoXML,false); //true para que lo muestre como array , false para que se un objeto 

        // $xml = array2xml($js, false);
        //CREA XML  creating object of SimpleXMLElement
        $xml_template_info = new SimpleXMLElement("$XML");
        //GUARDA EL ARCHIVO XML saving generated xml file
        $xml_template_info->asXML("../storage/factura/$ticket.xml");


        // QR
        $rutaImagenSalida = "../storage/factura/$ticket.png";
        $imagenBinaria = base64_decode($CodigoQR);
        $bytes = file_put_contents($rutaImagenSalida, $imagenBinaria);

        // Se actualiza el mismo registro , para agregar la ruta del xml
        $query_sql = "UPDATE factura set r_xml='/storage/factura/$ticket.xml' where ticket_id=$ticket";
        $upda = mysqli_query($con, $query_sql);
        $s_fa = mysqli_query($con, "SELECT * FROM factura where ticket_id=$ticket");
        $q_fac = mysqli_fetch_array($s_fa);
        $id_fac = $q_fac['id'];

        /* include("factura_pdf2.php"); */

        $id_fac = strval($id_fac);
        $sumador_total1 = 0;
        $sql_cDet = mysqli_query($con, "SELECT * from products, sale_product where products.product_id=sale_product.product_id and sale_product.sale_id='$ticket';");
        while ($row = mysqli_fetch_array($sql_cDet)) {
            $clave_sat = $row['clave_sat'];
            $unidad = $row['presentation'];

            $sql_clave = mysqli_query($con, "SELECT * from c_claveunidad where idClaveUnidad='$unidad';");
            $row_c = mysqli_fetch_array($sql_clave);
            $clave_tabla = $row_c['Nombre'];
            $clave_tablaU = $row_c['ClaveUnidad'];

            $product_code = $row['product_code'];
            $qty = $row['qty'];
            $product_name = $row['product_name'];
            $unit_price = number_format($row['unit_price'], $currency_format['precision_currency'], '.', '');
            $precio_total = $unit_price * $qty;
            $precio_total = number_format($precio_total, $currency_format['precision_currency'], '.', ''); //Precio total formateado
            $sumador_total += $precio_total; //Sumador

            $precio_unitario = number_format($unit_price, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']);
            $importe_producto = number_format($precio_total, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']);

            $concepto_det = strval($row['note']);

            $clave_sat_det = strval($clave_sat);
            $unidad_det = strval($unidad);
            $qty_det = strval($qty);
            $precio_unitario_det = strval($precio_unitario);
            $importe_producto_det = strval($importe_producto);
            //var_dump($importe_producto_det);

            $s_det = "INSERT INTO det_fact (id_f,cve_pro,concepto,unidad,cant,pu,imp) 
            VALUES('$id_fac','$clave_sat_det','$concepto_det','$unidad_det','$qty_det','$precio_unitario_det','$importe_producto_det');";
            //var_dump($queryDet = mysqli_query($con, $s_det));
            echo $sumador_total1 += $sumador_total1;
        }

        if ($in and $del) {
            $messages[] = ".";
        }

        if (mysqli_error($con)) {
            $errors[] = base64_encode(mysqli_error($con));
        }
    }else{
        $errors[] = "No se ha encontrado el siguiente ID:" .$id_tmp;
    }
}

if (isset($errors)) {

?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Error!</strong>
        <?php
        foreach ($errors as $error) {
            echo $error;
        }
        ?>
    </div>
<?php
}
if (isset($messages)) {

?>
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>¡Bien hecho!</strong>
        <?php
        foreach ($messages as $message) {
            echo $message;
        }
        ?>
    </div>
<?php
}
//funcion para convertir de JSON a XML 
// function array2xml($array, $xml = false)
// {

//     if ($xml === false) {
//         $xml = new SimpleXMLElement('<result/>');
//     }

//     foreach ($array as $key => $value) {
//         if (is_array($value)) {
//             array2xml($value, $xml->addChild($key));
//         } else {
//             $xml->addChild($key, $value);
//         }
//     }

//     return $xml->asXML();
// }
?>