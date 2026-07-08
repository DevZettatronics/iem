<?php
$asignation_id = $_GET["id"];
$asignation = AsignationData::getById($asignation_id);
$period = PeriodData::getById($asignation->period_id);
$team = TeamData::getById($asignation->team_id);
$alumns = InscriptionData::getAllByTP($team->id, $period->id);
?>
<div class="row">
  <div class="col-md-12">
    <h1><?php echo $asignation->getAsignature()->name; ?> <small>Calificaciones</small></h1>
    <h4>Grupo: <?php echo $team->grade . " - " . $team->letter; ?></h4>
    <h4>Periodo: <?php echo $period->name; ?></h4>
    <a href="./?view=teamasignatures&opt=all&id=<?php echo $team->id; ?>&period_id=<?php echo $period->id; ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
    <!-- <a href="./?view=actacalificaciones&id=<?php echo $asignation->id; ?>" class="btn btn-info"><i class="fa fa-print"></i> Imprimir Acta Definitiva</a> -->

    <br><br>

    <?php

    if (count($alumns) > 0) {
      // si hay usuarios
    ?>
      <div class="box box-primary">
        <table class="table table-bordered table-hover">
          <thead>
            <th>Matrícula</th>
            <th>Nombre</th>
            <th class="text-center">Calificaciones</th>
            <th class="text-center">Promedio Final</th>
            <th>Estado</th>
          </thead>
          <?php
          foreach ($alumns as $alumnx) {
            $alumn = $alumnx->getAlumn();
            $pF = CalificationFinalData::promedioFinal($alumn->id, $asignation_id);
          ?>
            <tr>
              <td><?php echo $alumn->code; ?></td><!-- matricula -->
              <td><?php echo $alumn->name . " " . $alumn->lastname; ?></td><!-- nombre completo -->
              <td>
                <!-- promedio -->
                <?php
                $con = Database::getCon();
                $validar = "SELECT * FROM `v_calificaciones` WHERE Id_Materia = $asignation_id AND IdAlumno = $alumn->id AND idBloquePapa IS NOT NULL";
                $query = mysqli_query($con, $validar);
                while ($row = mysqli_fetch_array($query)) {

                  $nombre_parcial = $row['Calificacion'];
                  $nombre_bloque = $row['NombreBloque'];

                  if ($nombre_bloque and $nombre_parcial) {
                ?>
                    <span style="background: none;" class="input-group-addon" id="basic-addon1"><?php echo  "$nombre_bloque" . "<br><br>" . "$nombre_parcial"; ?></span>
                  <?php
                  } else { ?>
                    <span style="background: none;" class="input-group-addon" id="basic-addon1"> Sin Calificaciones Aun </span>
                <?php
                  }
                }
                ?>
              </td>
              <!-- promedio final  -->
              <?php if ($pF != NULL) { ?>
                <td class="text-center"><?php echo $pF->calificacion; ?></td>
                <td>
                  <?php
                  if ($pF->calificacion >= 6 || $pF->calificacion == 'AC') {
                    echo "<span class='label label-success'>Aprobado</span>";
                  } else {
                    echo "<span class='label label-danger'>Reprobado</span>";
                  } ?>
                </td>

              <?php } else { ?>
                <td class="text-center">Sin Calificaciones Aun</td>
                <td class="text-center">Sin Calificaciones Aun</td>
              <?php }  ?>

            </tr>
        <?php }
          echo "</table></div>";
        } else {
          echo "<p class='alert alert-danger'>No hay Alumnos</p>";
        }
        ?>
      </div>
  </div>