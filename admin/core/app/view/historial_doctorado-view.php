<?php
$con = Database::getCon();
// get the HTML
$id = intval($_GET["id"]);
$code = intval($_GET["code"]);
$name = ($_GET["name"]);
$lastname = ($_GET["lastname"]);
require_once('pdf/html2pdf.class.php');
ob_start();
include('j/welcome_letter_doctorado.php');
$content = ob_get_clean();
try {
    $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
    // display the full page
    $html2pdf->pdf->SetDisplayMode('default');
    // convert
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    // send the PDF
    $content = ob_get_clean();
    $html2pdf->Output('historialAcademico.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
// require_once('dompdf/autoload.inc.php');
// use DomPDF\Dompdf;
// $dompdf=new DOMPDF();
// $dompd->load_html(ob_get_clean());
// $dompd->render();
// $pdf=$dompd->output();
// $filename="historial.pdf";
// file_put_contents($filename,$pdf);
// $dompd->stream($filename);
