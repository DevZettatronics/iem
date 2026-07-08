<?php
/* NOTAS. 
El formato esta puesto (segun) para la version 3.3
05/04/2022  se tiene la hora puesta manualmente ya que da errores con el servidor por los diferentes tipos de horas que se tienen y manda el error 401

Son ingresados por codigo ya que esa seccion no se tiene actualmente puesta. 
$impuesto = "002";
$TipoFactor = "Tasa";
$tasa0 = "0.160000";
$importe = "0.16";


*/
require_once("../config/db.php");
require_once("../config/conexion.php");
$update=mysqli_query($con,"UPDATE tmp_fac set emision = NOW()");

$row = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tmp_fac where id = '" . $_GET['tmp'] . "'"));

$version = "4.0";

$serie = $row['serie'];
$folio = $row['folio'];

$impuesto = "002"; // Impuesto puesto manual Este indica el impuesto tipo IVA 
$TipoFactor = "Tasa";
$tasa0 = "0.160000";
$importe = "0.16";

// Expostacion viene de una tabla exportacion la cual actualmete ese valor se pone manual
$exportacion="01";
//REGIMEN FISCAL. esto debe ser agregado desde el perfil de cada uno tanto dueño como clientes.
$regimenFiscal="601";
//OBJETOimps  esto debe ser visto , pero proviene de la tabla c_objetoImp
$objetoIm="01";



$date_added = $row['emision'];
list($date, $hora) = explode(" ", $date_added);
$f = strval($date . "T" .$hora);
// list($Y, $m, $d) = explode("-", $date);
// $fecha = $d . "/" . $m . "/" . $Y;

$formaPago = $row['forma_p'];
$metodoPago = $row['metodo_p'];

$idmoneda = $row['moneda'];
$qmoneda = mysqli_query($con, "SELECT c_Moneda FROM c_moneda where idmoneda = '" . $idmoneda . "'");
$rmoneda = mysqli_fetch_array($qmoneda);
$moneda = $rmoneda['c_Moneda'];

if($moneda == "MXN" or $moneda == "mxn"){
    $tipoCambio = 1;
}else{
    $tipoCambio = "";
}
$cp = $row['cp'];
$qbuss = mysqli_query($con, "SELECT * FROM business_profile");
$rbuss = mysqli_fetch_array($qbuss);
$nombre_r = $rbuss['r_social'];
$rfc_cliente=$row['rfc_cli'];
$qcustomers = mysqli_query($con, "SELECT * FROM customers where rfc='" . $row['rfc_cli'] . "';");
$rcustomers = mysqli_fetch_array($qcustomers);
$nombre_c = $rcustomers['name'];
$last_c = $rcustomers['last_name'];
$nCliente = $nombre_c;
$nombreCliente=rtrim($nCliente);
$calle = $rcustomers['address1'];
$ciudad = $rcustomers['city'];
$estado = $rcustomers['state'];
$municipio = $rcustomers['muni'];
$pais = $rcustomers['country'];
$cp = $rcustomers['postal_code'];
$direccion = strval ($calle . ", " . $municipio . ", " . $estado . ". " . $pais . ". " . $cp);
$stotal = str_replace(",", '', $row['stotal']);

$de= $row['descu'];
if($de!=NULL){
    $descuento = number_format(floatval(str_replace(",", '', $row['descu'])),2);
}else{
    $descuento=0;
}
$total = str_replace(",", '', $row['total']);
$tipoDeComprobante =  str_replace(" ", "", $row['tipo_comp']);
$iva =  str_replace(",", '', $row['iva']);
$uso = $row['uso'];
$total1=$stotal-$descuento+$iva;
$ti=str_replace(",", '', $total1);

$sumador_total = 0;

$qc_p = mysqli_query($con, "select p.note,p.clave_sat,p.product_name,s.qty cantidad,s.unit_price precioUnitario,cl.ClaveUnidad claveU,cl.nombre Clave from sale_product s
inner join products p on s.product_id=p.product_id
inner join c_claveunidad cl on cl.idClaveUnidad = p.presentation

where s.sale_id='" . $row['ticket_id'] . "';");

$rc_pn = mysqli_num_rows($qc_p);

$json = array(
   
    "Comprobante" => array(
        // 'Version' =>"$version",
        "Serie" => "$serie",
        "Folio" => "$folio",
        "Fecha" => "$f",
        "FormaPago" => "$formaPago",
        "NoCertificado" => "30001000000400002434",
        // "CondicionesDePago" => "NA",
        "SubTotal" =>  "$stotal",
        "Descuento" => "$descuento",
        "Moneda" => "$moneda",
        "TipoCambio" => "$tipoCambio",
        "Total" => "$ti",
        "TipoDeComprobante" => "$tipoDeComprobante",
        "Exportacion" => "$exportacion",// FALTA TABLA
        "MetodoPago" => "$metodoPago",
        "LugarExpedicion" => "$cp",
        // 'Confirmacion' => "",
        // 'InformacionGlobal' => array(
        //     'Periodicidad' => "",
        //     'Meses' => "",
        //     'Año' => ""
        // ),

        // 'CfdiRelacionados' => array(
        //     'TipoRelacion' => "",
        //     'CfdiRelacionado' => ["UUID-1", "UUID-2", "UUID-N"]
        // ),
        "Emisor" => array(
            "Rfc" => "PAS2105125T1",//RFC DEL DUEÑO 
            "Nombre" => "PYJ AMORTIGUADORES SUSPENSION Y DIRECCION", //"$nombre_r",
            "RegimenFiscal" => "001",
            // 'FacAtrAdquirente' => ""
        ),

        "Receptor" => array(
            "Rfc" => "$rfc_cliente",//AGREGAR RFC DEL CLIENTE  GENERAL XAXX010101000
            "Nombre" => "$nombreCliente",
            "DomicilioFiscalReceptor" => "$cp",
            // "ResidenciaFiscal" => "",
            // "NumRegIdTrib" => "",
            "RegimenFiscalReceptor" => "616", //"$regimenFiscal", Descrito en los medios indica que debe mandar 616
            "UsoCFDI" =>"P01", //$uso Descrito en los medios indica que debe mandar S01
        ),
        "Conceptos" => array(),
        "Impuestos" => array()

    ),
    "CamposPDF" => array(
        "tipoComprobante" => "Factura",
        "Comentario" => "Ninguno"
    ),
    

);

$cont = 1;
while ($cont <= $rc_pn and $rc_p =mysqli_fetch_array($qc_p)) {
   
        $clave_sat = intval($rc_p['clave_sat']);
        $claveUnidad = $rc_p['claveU'];
        $claveNombre = strtoupper($rc_p['Clave']);
        $unit_price = $rc_p['precioUnitario'];
        $d = str_replace(",", ' ', $rc_p['note']);
        $de= str_replace("/", ' ', $d);
        $descripcion = str_replace("\*", ' ', $de);
    
    
        $qty = $rc_p['cantidad'];
        $product_name = $rc_p['product_name'];
        $precio_total = $unit_price * $qty;
        $precio_total = number_format($precio_total, $currency_format['precision_currency'], '.', ''); //Precio total formateado
        $sumador_total += $precio_total; //Sumador
        $totalconcepto = number_format($precio_total, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']);
 
    $productos = $cont;

    if ($descuento < 1) {
        $descuentoConcepto = 0;
        $importeConcepto =floatval($totalconcepto);
    } else {
       $descuentoConcepto = $totalconcepto*$pDescuento;
       $descuentoConcepto=str_replace(",", '',$descuentoConcepto);
       $importeConcepto =floatval($totalconcepto - $descuentoConcepto);
    }
    // BASE ... PRECIOuNITARIO * CANTIDAD ... TOTALCONCEPTOS
// IMPUESTO->IMPORTE ES EL IVA DE BASE  $importe = 0.16
$baseIm =floatval($importeConcepto*$importe);
$baseIm= str_replace(",","",number_format($baseIm,2));
// $importeConcepto =floatval($totalconcepto-$baseIm);
$importeConcepto= str_replace(",","",number_format(floatval($importeConcepto),2));

    $Conceptos = array(
        "ClaveProdServ" => "$clave_sat",
        "NoIdentificacion" =>"$folio", //"$clave_sat", VA descrito lan este campo se debe registrar el número de folio o de operación de los comprobantes de operación con el público en general. Puede conformarse desde 1 hasta 100 caracteres alfanuméricos.
        "Cantidad" => "$qty",
        "ClaveUnidad" => "$claveUnidad",
        "Unidad" => "$claveNombre",
        "Descripcion" => "$descripcion",
        "ValorUnitario" => "$unit_price",
        "Importe" => "$totalconcepto",
        "Descuento" => "$descuentoConcepto",
        // "ObjetoImp" => "$objetoIm",
        "Impuestos" => array(
            "Traslados" => array(array(
                "Base" => "$importeConcepto",
                "Impuesto" => "$impuesto",
                "TipoFactor" => "$TipoFactor",
                "TasaOCuota" => "$tasa0",
                "Importe" => "$baseIm",
            ))
        )


    );
    array_push($json["Comprobante"]["Conceptos"], $Conceptos);
    $cont++;
}

$Impuestos=array(
    "TotalImpuestosTrasladados" => "$iva",
    "Traslados" => array(
        "Base" => "$stotal",
        "Impuesto" => "$impuesto",
        "TipoFactor" => "$TipoFactor",
        "TasaOCuota" => "$tasa0",
        "Importe" => "$iva",
    )
);

array_push($json["Comprobante"]["Impuestos"], $Impuestos);
$l = json_encode($json);
// print_r($json);