<?php

/* Connect To Database*/
include("../config/db.php");
include("../config/conexion.php");
/* ?>
<header>
	<script src="https://code.jquery.com/jquery-latest.js"></script>
</header>
<?php */
//Ontengo variables pasadas por GET	
/*Datos de la empresa*/
$id_ticket = $_GET['ticket_id'];
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

// get the HTML
ob_start();
include('../pdf/documentos/html/factura_pdftim.php');
$content = ob_get_clean();
require_once('../pdf/html2pdf.class.php');
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
	$html2pdf->Output("./storage/factura/$id_ticket.pdf");
	//la linea de abajao abre el pdf en una ventana aparte ayuda para visualizar el pdf e irlo modificando
	if($_GET['op'] == '5'){
		define($pdf_auxiliar, $html2pdf->Output('./storage/factura/$id_ticket.pdf', 'S'));
	}else{
		$html2pdf->Output("$id_ticket.pdf");
	}
} catch (HTML2PDF_exception $e) {
	echo $e;
	exit;
}
