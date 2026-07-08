<?php
$logo_url = "img/logo/LOGOINSTITUTO.jpg"; // Reemplaza "ruta/al/logo.jpg" con la ruta real de la imagen del logo
?>
    <page_header>
        <table class="page_footer">
            <tr style='vertical-align:top'>
                <td style="width: 70%; text-align: left">
                    <img src="<?php echo $logo_url; ?>" style="width: 800px;">
                </td>
            </tr>
        </table>
    </page_header>



    <page_footer>
        <table class="page_footer">
            <tr>

                <td style="width: 25%; text-align: left">
                    P&aacute;gina [[page_cu]]/[[page_nb]]
                </td>
                <td style="width: 75%; text-align: right"> 
                     &copy; <?php echo $bussines_name; ?>
                    | Fecha de Impresión: <?php echo $anio = date('d-m-Y'); ?>
                </td>

            </tr>
        </table>
    </page_footer>