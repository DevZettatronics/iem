<?php

/* Connect To Database*/
// include("config/db.php");
// include("config/conexion.php");
//Ontengo variables pasadas por GET
include("crearFactura.php");
session_start();
// get the HTML
ob_start();

/*Datos de la empresa*/
$sql_empresa = mysqli_query($con, "SELECT business_profile.number_id, business_profile.name, business_profile.tax, business_profile.address,  currencies.symbol, business_profile.city, business_profile.state, business_profile.postal_code, business_profile.phone, business_profile.email, business_profile.logo_url FROM  business_profile, currencies where business_profile.currency_id=currencies.id and business_profile.id=1");
$rw_empresa = mysqli_fetch_array($sql_empresa);
$moneda = $rw_empresa["symbol"];
//$tax=$rw_empresa["tax"];
$bussines_name = $rw_empresa["name"];
$address = $rw_empresa["address"];
$city = $rw_empresa["city"];
$state = $rw_empresa["state"];
$postal_code = $rw_empresa["postal_code"];
$phone = $rw_empresa["phone"];
$email = $rw_empresa["email"];
$logo_url = $rw_empresa["logo_url"];
$number_id = $rw_empresa["number_id"];
/*Fin datos empresa*/

require_once('pdf/html2pdf.class.php');
include('pdf/documentos/html/factura_pdf2.php');
$content = ob_get_clean();


$XML = $_POST['XML'];
$UUID = $_POST['UUID'];
$NoCertificado = $_POST['NoCertificado'];
$NoCertificadoSAT = $_POST['NoCertificadoSAT'];
$CadenaOriginal = $_POST['CadenaOriginal'];
$CadenaOriginalSAT = $_POST['CadenaOriginalSAT'];
$Sello = $_POST['Sello'];
$SelloSAT = $_POST['SelloSAT'];
$CodigoQR = $_POST['CodigoQR'];


try {

	$html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));

	// display the full page
	$html2pdf->pdf->SetDisplayMode('default');
	// convert
	$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
	// send the PDF
	$content = ob_get_clean();
	// VARIABLE $id_ticket viene del archivo fac_add_ajax.php 
	//la linea de abajo guarda el pdf 
	$html2pdf->Output("storage/factura/$ticket.pdf","f");
	//la linea de abajao abre el pdf en una ventana aparte ayuda para visualizar el pdf e irlo modificando
	// $html2pdf->Output("FacturaNo_$id_ticket.pdf");
} catch (HTML2PDF_exception $e) {
	echo $e;
	exit;
}
