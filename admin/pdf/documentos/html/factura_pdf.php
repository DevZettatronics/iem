<?php header('Content-Type: text/html; charset=utf-8'); ?>
<?php /* TODAS LAS SIGUIENTES LINEAS SON PARA EXTRAER LOS DATOS DE LA TABLA FACTURAS Y QUE ESTEN DISPONIBLES PARA IMPRIMIR */
mysqli_set_charset($con, "utf8mb4");
// CONSULTA Y EXTRACCION DE DATOS DE LA VENTA
$id_ticket = $_REQUEST['ticket_id'];
$plan = $_REQUEST['plan'];

if($plan ==0 || $plan == null)
{
    $sql_ticket = mysqli_query($con, "SELECT * FROM sales WHERE sale_id = $id_ticket");
    $rwt = mysqli_fetch_array($sql_ticket);
    $ticket = $rwt['sale_number'];
    $subtotal = $rwt['subtotal'];
    $total = $rwt['total'];
    $tax = $rwt['tax']; // lo que sale del iva
    $sale_date = $rwt['sale_date'];
    $discount_value = $rwt['discount_value'];
    $metodoPago = $rwt['payment_method'];
}
else 
{
    $sql_ticket = mysqli_query($con, "SELECT * FROM sales WHERE id_plan = $plan");
    $rwt = mysqli_fetch_array($sql_ticket);
    $ticket = $rwt['sale_number'];
    $subtotal = $rwt['subtotal'];
    $total = $rwt['total'];
    $tax = $rwt['tax']; // lo que sale del iva
    $sale_date = $rwt['sale_date'];
    $discount_value = $rwt['discount_value'];
    $metodoPago = $rwt['payment_method'];
    $id_ticket = $rwt['sale_id'];
}

if ($metodoPago == 1) {
    $mPago = 1;
} elseif ($metodoPago == 2) {
    $mPago = 23;
} elseif ($metodoPago == 6) {
    $mPago = 4;
} elseif ($metodoPago == 7) {
    $mPago = 18;
} elseif ($metodoPago == 3) {
    $mPago = 3;
}
 

//Informacion de la empresa falta agregae el campo
$sql_empresa = mysqli_query($con, "SELECT * FROM business_profile ");
$rw_r = mysqli_fetch_array($sql_empresa);
$empresa_rfc = $rw_r['rfc'];
$empresa_name = $rw_r['name'];
$empresa_address = $rw_r['address'];
$empresa_cp = $rw_r['postal_code'];
$empresa_muni = $rw_r['state'];
$empresa_city = $rw_r['city'];
$empresa_rsocial = $rw_r['r_social'];
$empresa_logo = $rw_r['logo_url'];
$empresa_countryid = $rw_r['country_id'];
$sql_country = mysqli_query($con, "SELECT * FROM countries where id=$empresa_countryid ");
$rw_ct = mysqli_fetch_array($sql_country);
$empresa_country = $rw_ct['capital'];
$regimen = "601";

//Informacion de la tabla factura y sales
$sql_tmp = mysqli_query($con, "SELECT * FROM tmp_fac where ticket_id=$id_ticket"); // esta tabla debe ser cambiada cuando se agrege el timbrado para la visualizacion ya que dejara de estar en una tabla "temporal" a una tabla fija para tener el registro sin cambios
$rw_tf = mysqli_fetch_array($sql_tmp);
$ish = $rw_tf['ish'];
$folio = $rw_tf['folio'];
$ticket_id = $rw_tf['ticket_id'];
$rfc_cliente_factura = $rw_tf['rfc_cli'];

//Informacion del alumno 
$sql_alumn = mysqli_query($con, "SELECT * FROM pagos where order_id=$id_ticket"); // esta tabla debe ser cambiada cuando se agrege el timbrado para la visualizacion ya que dejara de estar en una tabla "temporal" a una tabla fija para tener el registro sin cambios
$rw_alm = mysqli_fetch_array($sql_alumn);
$idPerson = $rw_alm['idPerson'];
$sql_alumn1 = mysqli_query($con, "SELECT * FROM person WHERE id=$idPerson"); // esta tabla debe ser cambiada cuando se agrege el timbrado para la visualizacion ya que dejara de estar en una tabla "temporal" a una tabla fija para tener el registro sin cambios
$rw_alm1 = mysqli_fetch_array($sql_alumn1);
$codealum = $rw_alm1['code'];
$nalum = $rw_alm1['name'];
$aalum = $rw_alm1['lastname'];
$curpalum = $rw_alm1['curp'];

// Informacion del cliente relacionado con el ticket
$sql_cliente = mysqli_query($con, "SELECT * FROM customers where rfc like '$rfc_cliente_factura'");
$datos_cliente = mysqli_fetch_array($sql_cliente);
$customers_name = $datos_cliente['name'];
$customers_last_name = $datos_cliente['last_name'];
$customers_rfc = $datos_cliente['rfc'];
$customers_ad = $datos_cliente['address1'];
$customers_city = $datos_cliente['city'];
$customers_state = $datos_cliente['state'];
$customers_muni = $datos_cliente['muni'];
$customers_country  = $datos_cliente['country'];
$customers_cp = $datos_cliente['postal_code'];
$customers_id_regimen = $datos_cliente['regimen'];

$sql_cliente_r = mysqli_query($con, "SELECT * FROM c_regimenfiscal where idregimenfiscal = '$customers_id_regimen'");
$datos_cliente_r = mysqli_fetch_array($sql_cliente_r);
$customers_regimen = $datos_cliente_r['c_RegimenFiscal'];
$customers_regimen_descripcion= $datos_cliente_r['Descripcion'];


$tf_tipo_c = $rw_tf['tipo_comp'];

$sql_tipo = mysqli_query($con, "SELECT * FROM c_tipodecomprobante where tipoDeComprobante='$tf_tipo_c' ");
$rw_tipo = mysqli_fetch_array($sql_tipo);
$tf_tipo = $rw_tipo['descripcion'];
$tf_uso_n = $rw_tf['uso'];
$query = "SELECT * FROM c_usocfdi where c_UsoCFDI='" . (empty($tf_uso_n) ? $ish : $tf_uso_n) . "' ";
$sql_uso = mysqli_query($con, $query);
$rw_uso = mysqli_fetch_array($sql_uso);
$tf_uso = $rw_uso['Descripcion'];

$tf_folio = $rw_tf['folio'];
$tf_serie = $rw_tf['serie'];
$tf_stotal = $rw_tf['stotal'];
$tf_iva = $rw_tf['iva'];
$tf_total = $rw_tf['total'];
$tf_estado = $rw_tf['estado'];

$tf_f_pago = $rw_tf['forma_p'];
$sql_fpago = mysqli_query($con, "SELECT * FROM c_formapago where c_FormaPago=$tf_f_pago ");
$rw_fp = mysqli_fetch_array($sql_fpago);
$tf_fpago = $rw_fp['Descripcion'];

$tf_m_pago = $rw_tf['metodo_p'];
$sql_mpago = mysqli_query($con, "SELECT * FROM c_metodopago where c_MetodoPago='$tf_m_pago' ");
$rw_mp = mysqli_fetch_array($sql_mpago);
$tf_mpago = $rw_mp['Descripcion'];

$tf_moneda = $rw_tf['moneda'];
$tf_emision = $rw_tf['emision'];
$tf_descu = $rw_tf['descu'];
$tf_fecha = $rw_tf['emision'];


?>

<head></head>
<style type="text/css">
    .table-container {
    display: flex;
    justify-content: flex-start;

  }

  .table-container div {
    margin: 10px; /* Espacio entre las tablas */
  }
    .logo {
        position: absolute;
        width: 200px;
    }

    .celdalogo {
        position: absolute;
        margin-left: 20px;
        margin-top: 20px;
        margin-bottom: 50px;
    }



    @page {
        page-border-surround-header: no;
        page-border-surround-footer: no;
    }

    @page WordSection1 {
        page
    }

    .WordSection1 {
        page: WordSection1;
    }

    .wordSection1 {
        background-color: yellow;
        position: relative;
        top: 20;
        left: 20;

    }

    .info {
        position: absolute;
        left: 20px;
        top: 20px;
        text-align: center;
        color: #000000;
        vertical-align: middle;
        border: none;
    }

    .info td {
        background-color: #fff;
        /* width: 253px; */
        vertical-align: -3px;
        font-size: 12px;
        font-weight: bold;
    }

    .info1 {
        position: absolute;
        left: 625px;
        top: 10px;
        text-align: center;
        color: #000000;
        vertical-align: middle;
        border-color: #000; 
        border:  1px;  
        float:right;
        
    }

    .info1 td {
        background-color: #fff;
        font-size: 9px;
        font-weight: bold;
        width: 150px;
        height: 20px;
        vertical-align: middle;
        text-align: center; 
    }

    .tabinfoemp {
        background-color: #fff;
        position: absolute;
        left: 20px;
        top: 135px;
        color: #000;
        vertical-align: middle;
        /* padding-left: 20px; */
        font-size: 10px;
        border: 1px #000;
    }

    .tabinfoemp td {
        width: 500px;
        height: 12px;
    }

    .tabinfosat{
        background-color: #fff;
        position: absolute;
        left: 535px;
        top: 135px;
        color: #000;
        vertical-align: middle;
        text-align: center;
        /* padding-left: 20px; */
        font-size: 9.9px;
        border: 1px #000;
    }
    .tabinfosat td{
        width: 250px;
        height: 1px;
    }

    .tabinfocte {
        background-color: #e4e4e4;
        position: absolute;
        left: 20px;
        top: 255px;
        color: #fff;
        vertical-align: middle;
        padding-left: 20px;

        font-size: 10px;
    }

    .tabinfocte td {
        width: 369px;
        color: black;
        height: 25px;
    }

    .tabproducts {
        background-color: #fff;
        position: absolute;
        left: 20px;
        top: 295px;;
        color: black;
        vertical-align: middle;
        font-size: 9px;
        border: 1px #000;
    }

    .tabproducts1 {
        background-color: #fff;
        position: absolute;
        left: 20px;
        top: 262px;
        color: black;
        vertical-align: middle;
        font-size: 9px;
        border: 1px #000;
    }

    .tabproducts1 td {
        width: 500px;
    }


    .tabproducts th {
        background-color: #e4e4e4;
        width: 100px;
        text-align: center;
        height: 30px;
    }

    .tabproducts td {
        text-align: center;
        font-size: 9px;
        
    }

    .tabproducts tr:nth-child(even) {
        background-color: #e4e4e4;
    }

    .tabinfocomp {
        
        position: absolute;
        top: 680px;
        background-color: #fff;
        margin-left: 20px;
        color: black;
        vertical-align: middle;
        font-size: 10px;
        border: 1px #000;
    }

    .tabinfocomp td {
        width: 500px;
        height: 12px;
        
        
    }

    .tabtot{
        position: absolute;
        top: 680px;
        left: 514px;
        height: 30;
        background-color: #fff;
        margin-left: 20px;
        color: black;
        vertical-align: middle;
        font-size: 10px;
        border: 1px #000;
    }
    .tabtot td{
        width: 125px;
        height: 14px;
        text-align: center;
    }

    .tabSHCP {
        position: absolute;
        top: 845px;
        background-color: #fff;
        margin-left: 20px;
        color: black;
        vertical-align: middle;
        font-size: 9px;
        border: 1px #000;
        text-align: justify;

    }

    .tabSHCP td {
        width: 770px;
        border-spacing: 0;
        text-align: center;
    }

    .tabSHCP2{
        position: absolute;
        top: 970px;
        background-color: #fff;
        margin-left: 10px;
        color: black;
        vertical-align: middle;
        font-size: 9px;
        border: 1px #000;
        text-align: justify;

    }

    .tabSHCP2 td {
        width: 770px;
        border-spacing: 0;
        text-align: center;
    }

    .tabSHCP3{
        position: absolute;
        top: 900px;
        left: 150px;
        background-color: #e4e4e4;
        margin-left: 20px;
        color: black;
        vertical-align: middle;
        font-size: 9px;
        border: 1px #000;
        text-align: justify;

    }

    .tabSHCP3 td {
        width: 620px;
        border-spacing: 1;
        text-align: center;
    }

    
</style>

<body lang=ES-MX>

    <!-- **********ENCABEZADO************* -->
    <div class="table-container">
    <table class="info" style="float: left;">
        <tr>
            <td class="celdalogo" rowspan="3" style="vertical-align:middle; text-align: center"><img class="logo" src="<?php echo "../".$empresa_logo; ?>"></td>
            <td >UNIVERSIDAD GESTALT DE AMÉRICA S.C.</td>
        </tr>
        <tr>
            <td>RFC: <?php echo $empresa_rfc ?></td><br>
        </tr>
        <tr>
            <td>Regimen Fiscal:<?php echo $regimen; ?> - Personas morales del régimen general</td>
        </tr>
    </table>
    <div style="float: right;">
    <table class="info1">
        
    <tr>
            <td style="font-size:15;">
                FACTURA
            </td>
        </tr>
        <tr>
            <td>
                Folio: <?php echo  $tf_serie . " - " . $tf_folio ?>
            </td>
        </tr>
        <tr>
            <td style="background-color: #e4e4e4;">
                FECHA/HORA DE CERTIFICACION
            </td>
        </tr>
        <tr>
            <td >
                <?php echo $tf_fecha;?>
            </td>
        </tr>
    </table>
    </div>
    </div>


    <table class="tabinfoemp">
        <tr>
            <td style="background-color: #e4e4e4; font-size:12;">
                <b>Receptor del Comprobante Fiscal</b>
            </td>
        </tr>
        <tr>
            <td>
            <?php echo " " .$customers_name . " " . $customers_last_name ?> <br><br> 
            <b>RFC: </b><?php echo $customers_rfc ?> <br><br>
            <b>Regimen Fiscal: </b><?php echo $customers_regimen ." - ".$customers_regimen_descripcion ?><br><br>
            <b>Código postal:</b><?php echo " (".$customers_cp.") ".$customers_city .", ". $customers_state .", ". $customers_muni ?> <br><br>
            <b>Uso del CFDI: </b><?php echo (empty($tf_uso_n) ? $ish : $tf_uso_n) . " " . $tf_uso; ?><br>
            
            </td>
        </tr>
    </table>

    <table class="tabinfosat">
        <tr>
            <td style="background-color: #e4e4e4; font-size:10;">
                <b>FOLIO FISCAL</b>
            </td>
        </tr>
        <tr>
            <td>
                <br><br><br>
            </td>
        </tr>
        <tr>
            <td style="background-color: #e4e4e4; font-size:10;">
                <b>SERIE DEL CERTIFICADO DEL EMISOR</b>
            </td>
        </tr>
        <tr>
            <td>
                <br><br><br>
            </td>
        </tr>
        <tr>
            <td style="background-color: #e4e4e4; font-size:10;">
                <b>No. SERIE CERTIFICADO DEL SAT</b>
            </td>
        </tr>
        <tr>
            <td>
                <br><br><br>
            </td>
        </tr>
    </table>
    
    <table class="tabproducts1">
            <tr>
                    <td style="background-color: #e4e4e4;">
                        <b>Alumno</b>
                    </td>
            </tr>
            <tr>
                <th style="width: 100%;"><b>MATRICULA: </b><?php echo $codealum ?><b>  NOMBRE: </b><?php echo $aalum." ".$nalum ?> <b>  CURP: </b><?php echo $curpalum ?><br></th>
            </tr>
    </table>
    <!-- Inicia la seccion  de productos y servicios. -->
    <table class="tabproducts">
        <thead>
            <tr>
            <th style="width: 90px;">Clave Unidad<br>SAT</th>
                <th style="width: 50px;">Cantidad</th>
                <th style="width: 110px;">Unidad de Medida</th>
                <th style="width: 273px;">Descripción</th>
                <th>Valor<br>Unitario</th>
                <th >Importe</th>
            </tr>
        </thead>
        <?php
         $sql_tickets = mysqli_query($con, "SELECT * FROM pagos WHERE id = '$id_ticket'");
        $rowt = mysqli_fetch_array($sql_tickets);
        $order_id = $rowt['order_id'];
         $sql_tickets = mysqli_query($con, "SELECT * FROM sales WHERE sale_number = '$order_id'");
        $rowt = mysqli_fetch_array($sql_tickets);
        $ticket = $rowt['sale_id'];
        $sumador_total = 0;
        $sql_c = mysqli_query($con, "SELECT * from products, sale_product where products.product_id=sale_product.product_id and sale_product.sale_id='$ticket';");
        while ($row = mysqli_fetch_array($sql_c)) {
            $clave_sat = $row['clave_sat'];
            $unidad = $row['presentation'];

            $sql_clave = mysqli_query($con, "SELECT * from c_claveunidad where idClaveUnidad='$unidad';");
            $row_c = mysqli_fetch_array($sql_clave);
            $clave_tabla = $row_c['Nombre'];
            $clave_tablaU = $row_c['ClaveUnidad'];

            $product_code = $row['product_code'];
            $qty = $row['qty'];
            $product_name = $row['product_name'];
            $product_note = $row['note'];
            $unit_price = number_format($row['unit_price'], $currency_format['precision_currency'], '.', '');
            $precio_total = $unit_price * $qty;
            $precio_total = number_format($precio_total, $currency_format['precision_currency'], '.', ''); //Precio total formateado
            $sumador_total += $precio_total; //Sumador

            $precio_unitario = number_format($unit_price, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']);
            $importe_producto = number_format($precio_total, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']);
            
            // $formatter = new NumberFormatter("es", NumberFormatter::SPELLOUT);
            // // Traducir el número a letras
            // $numeroEnLetras = $formatter->format($tf_total);
            // // Convertir la primera letra a mayúscula
            // $numeroEnLetras = ucfirst($numeroEnLetras);

            $formatter = new NumberFormatter("es", NumberFormatter::SPELLOUT);

            // Convertir la variable de texto a un número flotante
            $tf_total_numero = floatval($tf_total);
            
            $partes = explode('.', $tf_total);
            $parte_entera = $partes[0];
            $parte_decimal = isset($partes[1]) ? substr($partes[1], 0, 2) : '00'; // Tomar solo los primeros dos dígitos

            // Convertir la parte entera a letras
            $numero_entero_en_letras = $formatter->format(intval($parte_entera));
            $numero_entero_en_letras = ucfirst($numero_entero_en_letras);

            // Convertir la parte decimal a letras
            $numero_decimal_en_letras = $formatter->format(intval($parte_decimal));
            $numero_decimal_en_letras = ucfirst($numero_decimal_en_letras);

            // Construir la frase completa
            $numeroEnLetras = "$numero_entero_en_letras pesos $parte_decimal/100 M.N. ";

            $stot = floatval($tf_stotal); // Convierte el string a número flotante

            // Formatear el número con separadores de miles y decimales
            $tf_stotal_formateado = number_format($stot, 2, '.', ',');

            $tot = floatval($tf_total); // Convierte el string a número flotante

            // Formatear el número con separadores de miles y decimales
            $tf_total_formateado = number_format($tot, 2, '.', ',');


            ?>
            <tbody>
                <tr>
                    <td style="width: 90px;"><?php echo $clave_sat; ?></td>
                    <td style="width: 60px;"><?php echo $qty; ?></td>
                    <td style="width: 120px;"><?php echo $clave_tablaU ."-". $clave_tabla ; ?></td>
                    <td style="width: 273px;"><?php echo $product_name." - ". $product_note; ?></td>
                    <td><?php echo $precio_unitario ?></td>
                    <td><?php echo $importe_producto ?></td>
                </tr>
            </tbody>
        <?php } ?>
    </table>

    <!-- *************************footer************************* -->
    
    <table class="tabinfocomp">
        <tr>
            <td>
                <br><br>
                <b>Importe con letra: </b><?php echo $numeroEnLetras?> <br><br>
                <b>Tipo de Cambio: Forma de pago: </b><?php echo  $tf_f_pago . " " . $tf_fpago; ?><br><br>
                <b>Método de pago: </b><?php echo $tf_m_pago . " - " . $tf_mpago; ?>  <b>Número de cuenta de pago:</b><br><br>
                <b>Tipo de comprobante: </b>  <?php echo $tf_tipo_c . " " . $tf_tipo ?><br><br>
                <b>Lugar de expedición: </b> <?php echo "(". $empresa_cp .") ". $empresa_address ." Alcaldía ".$empresa_muni ." ". $empresa_city ?> <br><br>
                <b>Observaciones: </b><br><br>
            </td>   
        </tr>
    </table>
    <table  class="tabtot">
        <tr>
            <td>
                <br><br>
                <b>Subtotal:</b><br><br>
                <b>Descuento:</b><br><br>
                <b>IVA:</b><br><br>
                <b>Total</b><br><br>
            </td> 
            <td>
            <br><br>
            <?php echo '$' . $tf_stotal_formateado . "<br><br>"; 
            echo '$' . ($tf_descu ? $tf_descu : '0'). "<br><br>"; 
            echo '$' .  $tf_iva. "<br><br>"; 
            echo '$' . $tf_total_formateado . "<br><br>"; ?></td>
        </tr>
    </table>
    <table class="tabSHCP">
    <tr>
            <td><b>Cadena original del complemento de certificación digital del SAT</b></td>
        </tr>
        <tr>
            <td></td>
        </tr>
    </table>

    <table class="tabSHCP2">
        <tr>
            <td rowspan="7" style="padding-top:10px; text-align: center; padding-bottom:10px; background-color:#fff; width:160px;"></td> 
        </tr>
    </table>
    <table class="tabSHCP3">
    <tr>
            <td >Sello digital del CFDI</td>
        </tr>
        <tr  style="background-color: #fff;">
            <td></td>
        </tr>
        <tr>
            <td >Sello del SAT</td>
        </tr>
        <tr>
            <td  style="background-color: #fff;"></td>
        </tr>
    </table>
    <p style=" text-align: center; font-size: 12px;">ESTE DOCUMENTO ES UNA REPRESENTACION IMPRESA DE UN CFDI</p>
    
</body>

</html>