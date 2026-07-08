<?php
$asignation = AsignationData::getById($_GET["id"]);
$period = PeriodData::getById($asignation->period_id);
$team = TeamData::getById($asignation->team_id);
$alumns = InscriptionData::getAllByTP($asignation->team_id, $asignation->period_id);
$blocks = BlockData::getParentsByAsignationId($_GET["id"]);
$totalBlocks = count($blocks);
$con = Database::getCon();

if ($totalBlocks > 0) {
?>
    <div class="row">
        <div class="col-md-12">
            <h4><strong>Asignar Calificaciones</strong> <br>Asignatura: <?php echo $asignation->getAsignature()->name; ?> <br>Grupo: <?php echo $team->grade . " - " . $team->letter; ?> <br> Ciclo Escolar: <?php echo $period->name; ?></h4>
            <a href="./?view=teamalumns&id=<?php echo $asignation->id; ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
            <br><br>
            <?php

            if (count($alumns) > 0) {
                // si hay usuarios
            ?>
                <div class="box box-primary">
                    <div class="box-body">
                        <form method="post" action="./?action=saveteamcalificationsL">
                            <input type="hidden" name="asignation_id" value="<?php echo $asignation->id; ?>">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <th>Matrícula</th>
                                    <th>Nombre</th>
                                    <?php foreach ($blocks as $b) {
                                        echo "<th>" .  $b->name . "</th>";
                                    } ?>
                                    <th>Calificacion Final</th>
                                </thead>

                                <?php
                                foreach ($alumns as $alumnx) {
                                    $cals = []; // creo array vacio
                                    $alumn = $alumnx->getAlumn(); ?>
                                    <tr>
                                        <td><?php echo $alumn->code; ?></td>
                                        <td><?php echo $alumn->name . " " . $alumn->lastname; ?></td>

                                        <?php
                                        foreach ($blocks as $b) {
                                            $subs = BlockData::getAllByBlockId($b->id);
                                            $byIdFatherBlocks = CalificationData::getAllByIdFather($alumn->id, $b->id);
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
                                                    $exist = CalificationData::getExist($alumn->id, $sb->id);
                                                    if ($exist != null) {
                                                        $calificacion = $exist->val;
                                                    } else {
                                                        $calificacion = null;
                                                    }

                                                    ?>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1"><?php echo $sb->name; ?></span>
                                                        <input placeholder="Calificacion" data-type="currency" type="text" class="form-control calificacion"  pattern="[A]C|[N]P|[N]A|[S]D"  name="val-<?php echo $alumn->id; ?>-<?php echo $sb->id; ?>" value="<?php echo $calificacion ?>">
                                                    </div>
                                                <?php }

                                                if ($totalhijos > 0) { ?>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1">Promedio</span>
                                                        <input type="text" class="form-control" readonly value="<?php echo $promedio ?>" placeholder="Promedio">
                                                    </div>
                                                <?php }

                                                ?>
                                            </td>
                                        <?php } ?>
                                        <td>
                                            <input class="form-control text-center" type="text" readonly id="promedioFinal" value="<?php echo $promedio ?>">
                                        </td>
                                    </tr>
                                <?php } ?>

                            </table>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
                            <button type="button" class="btn btn-secondary"><a href="./?view=actacalificaciones&id=<?php echo $asignation->id; ?>"><i class='fa fa-print'></i> Imprimir Acta Definitiva </a> </button>

                        </form>
                    </div>
                </div>
            <?php } else {
                echo "<p class='alert alert-danger'>No hay Alumnos</p>";
            }
            ?>
        </div>
    </div>
<?php } else {
    echo "<p class='alert alert-danger'>No hay Bloques de Calificaciones Asignados</p>";
} ?>