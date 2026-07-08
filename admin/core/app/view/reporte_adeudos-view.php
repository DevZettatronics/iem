<?php
$con = Database::getCon();
// get the HTML
$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$opcion = $_GET["opcion"];

switch ($opcion) {
    case "0":
        $descripcion = "ALUMNOS ACTIVOS";
        break;
    case "1":
        $descripcion = "ALUMNOS CON BAJA ADMINISTRATIVA";
        break;
    case "2":
        $descripcion = "ALUMNOS CON BAJA TEMPORAL";
        break;
    case "3":
        $descripcion = "ALUMNOS CON BAJA DEFINITIVA";
        break;
    case "4":
        $descripcion = "ALUMNOS CON BAJA ACADÉMICA";
        break;
    case "6":
        $descripcion = "ALUMNOS EGRESADOS TITULADO";
        break;
    case "7":
        $descripcion = "ALUMNOS EGRESADOS EN VÍA DE TITULACIÓN";
        break;
    default:
        $descripcion = "Opción no válida";
        break;
}

require_once('pdf/html2pdf.class.php');
ob_start();
include('j/welcome_letter_adeudo.php');
$content = ob_get_clean();
try {
    // $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
    $html2pdf = new HTML2PDF(
    'P',
    array(260, 330), // más ancha que A4
    'es',
    true,
    'UTF-8',
    array(5, 5, 5, 5)
);
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
