<?php if (isset($_GET["opt"]) && $_GET["opt"] == "all") : ?>
    <div class="row">
        <div class="col-md-12">
            <h1>Calendario de Pago</h1>
            <?php
            $calen = CalendarData::getAll();
            if (count($calen) > 0) {
                // si hay usuarios
            ?>
                <div class="box box-primary">
                    <div class="box-body">
                        <table class="table table-bordered datatable table-hover">
                            <thead>
                                <th>Matricula</th>
                                <th>Nombre</th>
                                <th>Fecha de Pago</th>
                                <th>Status Fecha</th>
                                <th>Status Pago</th>
                            </thead>
                            <?php
                            foreach ($calen as $cal) {
                                $alumno = $cal->getAlumn();


                                /* evaluacion de la fecha ingresada */
                                $fecha_sistemal = date_create(date('Y-m-d'));    /* FECHA ACTUAL */
                                $start_at = date_create($cal->start_at); /*FECHA DE VENCIMIENTO GUARDADA EN LA BD */
                                $dia = $diff = $fecha_sistemal->diff($start_at); /* LO COMPARA */
                                $dia = $fecha_sistemal->diff($start_at)->format('%r%a');/* SACA LAS CONCLUSIONES*/

                                if ($cal->status == 1) {
                                    $statusP = 'No Pagado';
                                } elseif ($cal->status == 2) {
                                    $statusP = 'Pagado';
                                }


                            ?>
                                <tr>
                                    <td><?php echo $alumno->code; ?></td>
                                    <td><?php echo $alumno->name . " " . $alumno->lastname; ?></td>
                                    <td><?php echo $cal->start_at; ?></td>
                                    <td><?php
                                        // Si la fecha final es igual a la fecha actual o anterior <== MUESTRA MENSAJE SEGUN PROGRAMACION
                                        if ($dia >= "1") {
                                            echo '<span class="label bg-primary">Pendiente</span>';
                                        } elseif ($dia <= "2") {
                                            echo '<span class="label bg-red">Vencido</span>';
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $statusP ?></td>
                                </tr>
                        <?php
                            }
                            echo "</table></div></div>";
                        } else {
                            echo "<p class='alert alert-danger'>No hay Calendario de Pago</p>";
                        }
                        ?>
                        </table>
                    </div>
                </div>
       <!--  </div>
    </div> -->
<?php endif; ?>