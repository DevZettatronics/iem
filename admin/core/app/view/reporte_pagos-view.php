<?php
$con = Database::getCon();
// get the HTML
$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$tipo_reporte = $_GET["tipo_reporte"];
$alumno_id = $_GET["alumno_id"];

// 🔥 TIPO DE REPORTE
if (!empty($alumno_id)) {

    $queryN = mysqli_query($con, "SELECT code, name, lastname FROM person WHERE id = $alumno_id");
    if ($queryN && mysqli_num_rows($queryN) > 0) {
        $dataN = mysqli_fetch_array($queryN);

        $nombreN = $dataN['name'] . ' ' . $dataN['lastname'];
    }
    $tipo = "Alumno: " . $nombreN;
} else {
    $tipo = "General";
}


require_once('pdf/html2pdf.class.php');
ob_start();
include('j/welcome_letter_pagos.php');
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
