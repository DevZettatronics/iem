<?php


	require_once(dirname(__FILE__).'/../../html2pdf.class.php');
   // require_once("../../html2pdf.class.php");

    // get the HTML
    ob_start();
    require_once 'Reporte_Cotizacion.php';
    $content = ob_get_clean();

        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
    
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');

        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        // send the PDF
        $html2pdf->Output('Cotizacion.pdf');