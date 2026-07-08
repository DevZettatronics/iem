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
                                $suma = 0;
                                foreach ($blocks as $b) {
                                    $subs = BlockData::getAllByBlockId($b->id);
                                    $totalhijos = count($subs);

                                    $sql = "SELECT SUM(Calificacion) as Calificacion FROM v_calificaciones where idalumno = $idAlumno and  Id_Materia = $asignation->id and IdBloquePapa = $b->id";
                                    $query = mysqli_query($con, $sql);
                                    while ($row = mysqli_fetch_array($query)) {
                                        $calificacionSQL = $row['Calificacion'];
                                    }
                                    $promedio = bcdiv($calificacionSQL / $totalhijos, '1', 1);
                                ?>
                                    <td>
                                        <?php
                                        $ppe = 0;
                                        foreach ($subs as $sb) { ?>
                                            <?php
                                            $exist = CalificationData::getExist($idAlumno, $sb->id);

                                            ?>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><?php echo $sb->name; ?></span>
                                                <input disabled placeholder="Calificacion" data-type="currency" type="text" id="calificacion" class="form-control calificacion" pattern="[N]A|[N]P|[/^([0-9]+\.?[0-9{0,2})$/]|[1]0" name="val-<?php echo $alumn->id; ?>-<?php echo $sb->id; ?>" value="<?php if ($exist != null) {
                                                                                                                                                                                                                                                        echo $exist->val;
                                                                                                                                                                                                                                                    } ?>">
                                            </div>
                                        <?php }

                                        if ($totalhijos > 0) { ?>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><b>Promedio</b></span>
                                                <input type="text" class="form-control" disabled value="<?php echo $promedio ?>" placeholder="Promedio">
                                            </div>
                                        <?php }
                                        $ppe += $promedio;
                                        $suma += $promedio;
                                        $opeacionPromedioFinal = $suma / $totalBlocks;
                                        $promedioFinal = round($opeacionPromedioFinal);
                                        ?>
                                    </td>
                                <?php } ?>
                                <td><input class="form-control text-center" type="text" name="promedioFinal" id="promedioFinal" value="<?php echo $promedioFinal
                                                                                                                                        ?>" placeholder="Promedio" disabled></td>
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