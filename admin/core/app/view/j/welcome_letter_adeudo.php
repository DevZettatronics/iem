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

            <h4 class="uni" style="font-size: 14px">REPORTE DETALLADO DE ADEUDOS CON FECHA DE <?php echo $start_date; ?> AL <?php echo $end_date; ?></h4>
            <h4 class="uni" style="font-size: 14px"><?php echo $descripcion; ?> DE TODOS LOS GRUPOS</h4>
        </div>

        <div class="image">

            <!-- <img style="width: 100%; height: 100%;" class="img1" src="https://viserion.gestalt.education/admin/core/app/view/j/img/gesuno.jpg"> -->

        </div>

    </div>

    <table align="center" style="position: relative; margin-left: 15px; margin-top: 8px;">

        

    </table>



    <!-- Calificacion -->

    <table class="conte-calificaciones" style="width: 100%;top:100px;padding-bottom: 20px;position:absolute;padding-bottom:200px" align='center'>

        <thead>

            <tr>

                <th style="width: 6%;">Id plan</th>

                <th style="width: 22%;">Id Alumno/<br>Matricula/ Nombre</th>

                <th style="width: 14%;">Concepto <br> Fecha</th>

                <th style="width: 10%;">Cantidad <br> Programada</th>

                <th style="width: 6%;">Status</th>

                <th style="width: 8%;">Descuentos</th>

                <th style="width: 10%;">Pago real</th>

                <!-- <th style="width: 12%;">Adeudo Real</th> -->
            </tr>

        </thead>

        <tbody>
            <?php
                $query = mysqli_query($con, "
                    SELECT 
                        p.*,

                        -- Datos del alumno
                        per.id AS idalumno,
                        per.code AS matricula,
                        per.name,
                        per.lastname,
                        per.beca,
                        per.promocion,

                        -- Producto
                        pro.product_name,
                        pro.selling_price, 
                        pro.asignacion_bp, 

                        -- Becas (pueden venir NULL)
                        becpro.name AS nameBenca,
                        becpro.porcentaje AS porcentajeBeca,

                        -- promocion (pueden venir NULL)
                        becpro2.name AS namePromo,
                        becpro2.porcentaje AS porcentajePromo,

                        -- Datos de inscription (pueden venir NULL)
                        ins.id AS inscription_id,
                        ins.alumn_id,
                        ins.period_id,
                        ins.team_id,

                        -- Datos del grupo (pueden venir NULL)
                        t.grade,
                        t.letter,

                        -- Datos del estado del alumno
                        stp.estado

                    FROM plan_de_pago p

                    INNER JOIN person per 
                        ON per.id = p.alumno 

                    INNER JOIN products pro
                        ON pro.product_id = p.concepto

                    LEFT JOIN becas becpro
                        ON becpro.id = per.beca

                    LEFT JOIN becas becpro2
                        ON becpro2.id = per.promocion

                    INNER JOIN estatus_alumnos stp
                        ON stp.id = per.status_alumno

                    LEFT JOIN inscription ins
                        ON ins.alumn_id = p.alumno
                    AND ins.period_id = p.periodo

                    LEFT JOIN team t
                        ON t.id = ins.team_id

                    WHERE p.status = 6
                    AND p.fecha_inicio_pago <= '$end_date'
                    AND p.fecha_fin_pago >= '$start_date'
                    AND (
                        ($opcion = 0 AND stp.estado NOT IN (1,2,3,4))
                        OR
                        ($opcion != 0 AND stp.estado = $opcion)
                    )
                    -- AND stp.estado NOT IN (1,2,3,4)  -- Filtro original: excluye alumnos dados de baja
                    
                    ORDER BY
                       (t.letter IS NULL) ASC,  -- 0 = tiene grupo, 1 = no tiene grupo → primero los que sí tienen grupo
                        t.letter ASC,           -- los grupos se ordenan alfabéticamente: A, B, C...
                        ins.team_id DESC,       -- dentro de la misma letra, el grupo más “nuevo” (ID mayor) primero
                        per.id ASC,              -- 🔑 agrupa los registros del mismo alumno
                        p.fecha_fin_pago ASC   -- 🔑 dentro del grupo, orden cronológico por fecha de vencimiento
                       
                ");

                if ($query && mysqli_num_rows($query) > 0) {

                    $letter_actual = null;
                    $totalGrupo = 0;

                    $alumno_actual = null;
                    $alumnosMostradosPorGrupo = [];

                    $totalAlumno = 0;
                    $totalGeneral = 0;

                    while ($row = mysqli_fetch_array($query)) {
                        $estado = $row['estado'];
                        // $claveActual = $row['idalumno'] . '-' . ($row['letter'] ?? 'SIN');
                        // $esNuevoAlumno = ($alumno_actual !== $claveActual);

                        $grupoActual = $row['letter'] ?? 'SIN';
                        $idAlumno    = $row['idalumno'];

                        if (!isset($alumnosMostradosPorGrupo[$grupoActual])) {
                            $alumnosMostradosPorGrupo[$grupoActual] = [];
                        }

                        $mostrarAlumno = !in_array($idAlumno, $alumnosMostradosPorGrupo[$grupoActual]);

                        /* =======================
                        CAMBIO DE ALUMNO
                        ======================= */
                        if ($alumno_actual !== null && $alumno_actual != $idAlumno) {

                            echo '
                            <tr>
                                <td colspan="7" style="background:#d4edda; font-weight:bold; text-align:right;">
                                    TOTAL ALUMNO: $' . number_format($totalAlumno, 2) . '
                                </td>
                            </tr>';

                            $totalAlumno = 0;
                        }

                        /* =======================
                        CÁLCULOS
                        ======================= */
                        $precio = (float)$row['selling_price'];

                        $porcentajeBeca  = ($row['cuenta_beca'] === 'SI') 
                            ? floatval($row['porcentajeBeca'] ?? 0) 
                            : 0;

                        $porcentajePromo = ($row['cuenta_promocion'] === 'SI') 
                            ? floatval($row['porcentajePromo'] ?? 0) 
                            : 0;

                        // Aplicar descuentos acumulativos
                        $asignacion = (int)$row['asignacion_bp'];

                        $totalFinal = $precio;
                        $descuentoAplicado = "No aplica";

                        // 🔹 Caso 0 → No aplica nada
                        if ($asignacion === 0) {
                            // no se hace nada
                        }

                        // 🔹 Caso 1 → Solo promoción
                        elseif ($asignacion === 1) {
                            if ($porcentajePromo > 0) {
                                $descuento = $precio * ($porcentajePromo / 100);
                                $totalFinal = $precio - $descuento;
                                $descuentoAplicado = "Promoción: {$porcentajePromo}%";
                            }
                        }

                        // 🔹 Caso 2 → Solo beca
                        elseif ($asignacion === 2) {
                            if ($porcentajeBeca > 0) {
                                $descuento = $precio * ($porcentajeBeca / 100);
                                $totalFinal = $precio - $descuento;
                                $descuentoAplicado = "Beca: {$porcentajeBeca}%";
                            }
                        }

                        $totalFinal = max(0, $totalFinal);

                        /* =======================
                        CAMBIO DE GRUPO
                        ======================= */
                        if ($letter_actual !== $row['letter']) {

                            // 🔥 imprimir total del alumno SOLO si tiene acumulado
                            if ($alumno_actual !== null && $totalAlumno > 0) {
                                echo '
                                <tr>
                                    <td colspan="7" style="background:#d4edda; font-weight:bold; text-align:right;">
                                        TOTAL ALUMNO: $' . number_format($totalAlumno, 2) . '
                                    </td>
                                </tr>';
                                $totalAlumno = 0;
                            }

                            // TOTAL DEL GRUPO ANTERIOR
                            if ($letter_actual !== null) {
                                echo '
                                <tr>
                                    <td colspan="7" style="background:#9abbfa; font-weight:bold; text-align:right;">
                                        TOTAL POR GRUPO ' . ($letter_actual ?? 'SIN GRUPO') . ': $' . number_format($totalGrupo, 2) . '
                                    </td>
                                </tr>';
                            }

                            // NUEVO GRUPO
                            $letter_actual = $row['letter'];
                            $totalGrupo = 0;

                            echo '
                            <tr>
                                <td colspan="8" style="background:#f0f0f0; font-weight:bold; text-align:left;">
                                    Grupo ' . ($letter_actual ?? 'SIN GRUPO') . '
                                </td>
                            </tr>';

                            $alumno_actual = null;
                        }

                        // SUMA AL TOTAL DEL GRUPO
                        $totalGrupo += $totalFinal;
                        $totalAlumno += $totalFinal;
                        $totalGeneral += $totalFinal; // 🔥 TOTAL GENERAL
                        ?>

                        <tr>
                            <td style="text-align:center;"><?php echo $row['id']; ?></td>

                            <td>
                                <?php if ($mostrarAlumno) { ?>
                                    Id alumno: <?php echo $row['idalumno']; ?><br>
                                    Matrícula: <?php echo $row['matricula']; ?><br>
                                    <?php echo $row['name'].' '.$row['lastname']; ?>
                                <?php } ?>
                            </td>


                            <td style="text-align:center;">
                                <?php echo $row['product_name']; ?><br>
                                <?php echo $row['fecha_fin_pago']; ?>
                            </td>

                            <td class="nowrap" style="text-align:center;">
                                <strong><?php echo number_format($precio, 2); ?></strong>
                            </td>

                           <td class="nowrap" style="text-align:center;">
                                <?php
                                    if ($estado == 1) {
                                        echo 'Baja administrativa';
                                    } elseif ($estado == 2) {
                                        echo 'Baja temporal';
                                    } elseif ($estado == 3) {
                                        echo 'Baja definitiva';
                                    } elseif ($estado == 4) {
                                        echo 'Baja académica';
                                    }  else {
                                        // 0, NULL
                                        echo 'Activo';
                                    }
                                ?>
                            </td>

                            <td style="text-align:center;">
                                <?php
                                    echo $descuentoAplicado;
                                ?>
                            </td>
                            <td style="text-align:center;">
                                <?php echo number_format($totalFinal, 2); ?>
                            </td>

                            <!-- <td style="text-align:center;">
                                <strong><?php  //echo number_format($totalFinal, 2); ?></strong>
                            </td> -->
                        </tr>

                        <?php
                        // $alumno_actual = $claveActual;

                        if ($mostrarAlumno) {
                            $alumnosMostradosPorGrupo[$grupoActual][] = $idAlumno;
                        }
                        $alumno_actual = $idAlumno;
                    }

                    // 🔥 TOTAL DEL ÚLTIMO ALUMNO
                    if ($alumno_actual !== null && $totalAlumno > 0) {
                        echo '
                        <tr>
                            <td colspan="7" style="background:#d4edda; font-weight:bold; text-align:right;">
                                TOTAL ALUMNO: $' . number_format($totalAlumno, 2) . '
                            </td>
                        </tr>';
                    }
                    // TOTAL DEL ÚLTIMO GRUPO
                    echo '
                    <tr>
                        <td colspan="7" style="background:#9abbfa; font-weight:bold; text-align:right;">
                            TOTAL GRUPO ' . ($letter_actual ?? 'SIN GRUPO') . ': $' . number_format($totalGrupo, 2) . '
                        </td>
                    </tr>';

                    echo '
                    <tr>
                        <td colspan="8" style="background:#000; color:#fff; font-weight:bold; text-align:right; font-size:10px;">
                            TOTAL GENERAL: $' . number_format($totalGeneral, 2) . '
                        </td>
                    </tr>';
                } else {
                ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">
                            No se encontraron deudores en el rango de fechas
                        </td>
                    </tr>
                <?php
                }
                ?>

        </tbody>

    </table>
</page>