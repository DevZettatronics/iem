<?php

if (isset($_GET['idAlumn']) && isset($_GET['idAsignation']) && isset($_GET['idInscription'])) {
    $idAlumno = $_GET['idAlumn'];
    $idAsignation = $_GET['idAsignation'];
    $idInscription = $_GET['idInscription'];

    $asignation = AsignationData::getById($_GET['idAsignation']);
    $period = PeriodData::getById($asignation->period_id);
    $blocks = BlockData::getParentsByAsignationId($idAsignation);
    $totalBlocks = count($blocks);
    $con = Database::getCon();

    if ($totalBlocks > 0) {
?>
        <div class="row">

            <div class="col-md-12">

                <div class="small-box bg-navy">
                    <div class="inner">
                        <h4 align="left"><i class='fa fa-tasks'></i> <strong>Desglose de Calificaciones</strong></h4>
                        <h5 align="left">Asignatura: <?php echo $asignation->getAsignature()->name; ?></strong></h5>

                    </div>
                    <div class="icon">
                        <i class="fa fa-list"></i>
                    </div>
                </div>

                <p class="text-left"> A continuación se muestra el desglose de tus calificaciones obtenidas en cada evaluación. Tus calificaciones se actualizarán conforme el docente las asigne.</p>

                <span><img src="../assets/images/giro.png" width="320px" height="91px"></span>
                <br><br>
                <a href="./?view=viewinscription&id=<?php echo $idInscription ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
                <br><br>
                <?php

                // si hay usuarios
                ?>
                <div class="box box-primary">
                    <div class="box-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <?php foreach ($blocks as $b) {
                                    echo "<th>" .  $b->name . "</th>";
                                } ?>
                                <th>Promedio Final</th>
                            </thead>

                            <tr>

                                <?php
                                $cals = []; // creo array vacio
                                foreach ($blocks as $b) {
                                    $subs = BlockData::getAllByBlockId($b->id);
                                    $byIdFatherBlocks = CalificationData::getAllByIdFather($idAlumno, $b->id);
                                    $totalhijos = count($byIdFatherBlocks);

                                    foreach ($byIdFatherBlocks as $b) {
                                        array_push($cals, $b->val); //METER CALIFICACIONES AL ARRAY -> CALS
                                    }
                                    if (count(array_diff($cals, ['AC'])) > 0) {
                                        $promedio = 'Reprobado';
                                    } else {
                                        $promedio = 'Aprobado';
                                    }
                                ?>
                                    <td>
                                        <?php
                                        foreach ($subs as $sb) { ?>
                                            <?php
                                            $exist = CalificationData::getExist($idAlumno, $sb->id);
                                            if ($exist != null) {
                                                $calificacion = $exist->val;
                                            } else {
                                                $calificacion = null;
                                            }

                                            ?>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><?php echo $sb->name; ?></span>
                                                <input placeholder="Calificacion" readonly data-type="currency" type="text" class="form-control calificacion" pattern="[A]C|[N]P|[N]A|[S]D" name="val-<?php echo $alumn->id; ?>-<?php echo $sb->id; ?>" value="<?php echo $calificacion ?>">
                                            </div>
                                        <?php }

                                        if ($totalhijos > 0) { ?>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1">Promedio</span>
                                                <input type="text" class="form-control" readonly value="<?php echo $promedio ?>" placeholder="Promedio">
                                            </div>
                                        <?php } ?>
                                    </td>
                                <?php } ?>
                                <td>
                                    <input class="form-control text-center" type="text" readonly id="promedioFinal" value="<?php echo $promedio ?>">
                                </td>
                            </tr>


                        </table>


                    </div>
                </div>

            </div>
        </div>
<?php } else {
        echo "<p class='alert alert-danger'>No hay Bloques de Calificaciones Asignados</p>";
    }
} else {
    echo "<p class='alert alert-danger'>Sin Acceso</p>";
} ?>