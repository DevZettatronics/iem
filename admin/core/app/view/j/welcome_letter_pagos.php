<style type="text/css">

/* ====== GENERAL ====== */
body {
    margin: 0;
    padding: 0;
    font-family: helvetica;
    font-size: 12px;
}

.uni {
    color: #002976;
    font-family: Times, serif;
    margin: 5px 0;
}

.title {
    margin-top: -30px;
    text-align: center;
}

/* ====== HEADER IMÁGENES ====== */
.image {
    position: absolute;
    top: 0;
    right: 15px;
    width: 20%;
    height: 110%;
}

.image1 {
    position: absolute;
    top: 55px;
    left: 5px;
    width: 20%;
    height: 125%;
}

/* ====== TABLA ADEUDOS ====== */
.conte-calificaciones {
    width: 100%;
    font-size: 8px;
    border-collapse: separate;
    table-layout: fixed;
    position: absolute;
    top: 100px;
    padding-bottom: 200px;
}

.conte-calificaciones th,
.conte-calificaciones td {
    padding: 3px 4px;
    vertical-align: top;
    word-wrap: break-word;
}

.conte-calificaciones th {
    font-weight: bold;
    text-align: center;
    color: #002976;
}

/* Evita saltos en montos y status */
.nowrap {
    white-space: nowrap;
}

/* ====== FOOTER ====== */
.footer {
    position: fixed;
    border-top: solid 1px #000;
}


.total-alumno {
    background: #eaf1ff;
}

.total-general {
    background: #002976;
    color: #fff;
}

.separador td {
    height: 8px;
}
</style>




<!-- NA y NP se deberan quitar -->





<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm" style="font-size: 12px; font-family: helvetica ;" backimg="">

    <!-- <page_footer pageset="old" class="footer">

        <div style="margin-bottom:20px;border-top: solid 1px #000;text-align: center">

            <p style="font-size: 8px;">Documento de indole informativo, sin validez oficial.</p>

            <p style="font-size: 9px; margin:0px; padding:0px;">Herschel 143, Col. Nueva Anzures, Alc. Miguel Hidalgo, Ciudad de México CP 11590.</p>

            <p style="font-size: 9px;">Línea Gestalt (55)5203 2008&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CAMPUS POLANCO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;www.ugestalt.edu.mx</p>

        </div>

    </page_footer> -->


    <!-- General -->

    <div class="test">

        <div class="image1">

            <!-- <img style="width: 98%; height: 100%;" src="https://viserion.gestalt.education/admin/core/app/view/j/img/gesdos.png"> -->

        </div>

        <div class="title">

            <h3 class="uni"></h3>

            <h4 class="uni"></h4>

            <h4 class="uni" style="font-size: 14px">REPORTE DETALLADO DE PAGOS CON FECHA DE <?php echo $start_date; ?> AL <?php echo $end_date; ?></h4>
            <h4 class="uni" style="font-size: 14px"><?php echo $tipo; ?> </h4>
        </div>

        <div class="image">

            <!-- <img style="width: 100%; height: 100%;" class="img1" src="https://viserion.gestalt.education/admin/core/app/view/j/img/gesuno.jpg"> -->

        </div>

    </div>

    <table align="center" style="position: relative; margin-left: 15px; margin-top: 8px;">

        

    </table>



    <!-- Calificacion -->

    <table class="conte-calificaciones" style="width: 100%; top:100px; position:absolute;" align='center'>

        <thead>
            <tr>
                <th style="width: 10%;">Id Pago</th>
                <th style="width: 20%;">Alumno / Matrícula</th>
                <th style="width: 20%;">Concepto</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 20%;">Datos de pago</th>
                <th style="width: 20%;">Monto Total</th>
            </tr>
        </thead>

        <tbody>
        <?php

        // 🔹 filtros
        $filtro_alumno = "";
        if (!empty($alumno_id)) {
            $filtro_alumno = " AND per.id = " . intval($alumno_id);
        }


        $query = mysqli_query($con, "
            SELECT 
                s.*,
                per.id AS idalumno,
                per.code AS matricula,
                per.name,
                per.lastname,

                sap.product_id,
                sap.qty,
                p.product_name

            FROM sales s

            INNER JOIN person per 
                ON per.id = s.person_id 

            INNER JOIN sale_product sap
                ON s.sale_id = sap.sale_id

            LEFT JOIN products p
                ON p.product_id = CAST(TRIM(sap.product_id) AS UNSIGNED)

            WHERE s.sale_date >= '$start_date 00:00:00'
            AND s.sale_date < DATE_ADD('$end_date', INTERVAL 1 DAY)
            $filtro_alumno

            ORDER BY per.code, s.sale_id
        ");

        if ($query && mysqli_num_rows($query) > 0) {

            $ventas = [];

            while ($row = mysqli_fetch_assoc($query)) {

                $sale_id = $row['sale_id'];

                if (!isset($ventas[$sale_id])) {
                    $ventas[$sale_id] = [
                        'id_pago' => $row['sale_id'],
                        'alumno' => $row['name'] . ' ' . $row['lastname'],
                        'matricula' => $row['matricula'],
                        'status' => $row['status'],
                        'fecha_pago' => $row['sale_date'],
                        'subtotal' => $row['subtotal'],
                        'discount_value' => $row['discount_value'],
                        'recargo' => $row['recargo'],
                        'total' => $row['total'],
                        'productos' => []
                    ];
                }

                $ventas[$sale_id]['productos'][] = [
                    'product_name' => $row['product_name'],
                    'cantidad' => $row['qty']
                ];
            }

            $current_alumno = null;
            $total_alumno = 0;
            $total_general = 0;

            foreach ($ventas as $venta) {

                // 🔹 ALUMNO
                if ($current_alumno !== $venta['matricula']) {

                    if ($current_alumno !== null) {
                        echo "<tr class='total-alumno'>
                                <td colspan='5' style='text-align:right;'>Total alumno:</td>
                                <td>$" . number_format($total_alumno, 2) . "</td>
                            </tr>";

                        echo "<tr class='separador'><td colspan='6'></td></tr>";
                    }

                    $total_alumno = 0;
                    $current_alumno = $venta['matricula'];
                }

                $rowspan = count($venta['productos']);
                $first = true;

                foreach ($venta['productos'] as $prod) {

                    echo "<tr>";

                    if ($first) {
                        echo "<td style='text-align:center;' rowspan='$rowspan'>{$venta['id_pago']}</td>";

                        echo "<td style='text-align:center;' rowspan='$rowspan'>
                                {$venta['matricula']}<br>
                                {$venta['alumno']}
                            </td>";

                        $total_alumno += floatval($venta['total']);
                        $total_general += floatval($venta['total']);
                    }

                    echo "<td style='text-align:center;'>{$prod['product_name']}</td>";

                    if ($first) {
                        switch ($venta['status']) {
                            case 1:
                                $status_texto = 'Activo';
                                break;
                            case 7:
                                $status_texto = 'Cancelado';
                                break;
                            default:
                                $status_texto = 'Desconocido';
                                break;
                        }

                        echo "<td style='text-align:center;' rowspan='$rowspan'>{$status_texto}</td>";
                    }

                    echo "<td style='text-align:center;'>
                                Subtotal: $" . number_format($venta['subtotal'], 2) . "<br>
                                Descuento: $" . number_format($venta['discount_value'], 2);

                                // 🔥 SOLO SI ES DIFERENTE DE 0
                                if (floatval($venta['recargo']) != 0) {
                                    echo "<br>Recargo: $" . number_format($venta['recargo'], 2);
                                }

                        echo "</td>";

                    echo "<td style='text-align:center;'>
                            $" . number_format($venta['total'], 2) . "<br>
                            " . date("d/m/Y", strtotime($venta['fecha_pago'])) . "
                        </td>";

                    echo "</tr>";

                    $first = false;
                }
            }

            // último alumno
            echo "<tr class='total-alumno'>
                    <td colspan='5' style='text-align:right;'>Total alumno:</td>
                    <td>$" . number_format($total_alumno, 2) . "</td>
                </tr>";

            // total general
            echo "<tr class='total-general'>
                    <td colspan='5' style='text-align:right;'>TOTAL GENERAL</td>
                    <td>$" . number_format($total_general, 2) . "</td>
                </tr>";

        } else {
            echo "<tr><td colspan='6' style='text-align:center;'>No hay registros</td></tr>";
        }

        ?>
        </tbody>

    </table>
</page>