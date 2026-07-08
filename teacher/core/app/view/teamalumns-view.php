<?php
$asignation_id = $_GET["id"];
$asignation = AsignationData::getById($asignation_id);
$period = PeriodData::getById($asignation->period_id);
$team = TeamData::getById($asignation->team_id);
$alumns = InscriptionData::getAllByTP($asignation->team_id, $asignation->period_id);
$url = $asignation->asignature_type == 'NUM' ? './?view=teamcalifications' : './?view=teamcalificationsL';
?>

<html lang="es">
<div class="row">
	<div class="col-md-12">
		<h3><?php echo $asignation->getAsignature()->name; ?> <small>Calificaciones</small></h3>
		<h5>Grupo: <?php echo $team->grade . " - " . $team->letter; ?> | Periodo: <?php echo $period->name; ?></h5>
		
		<div class="btn-group" style="margin-right: 10px;">
			<!--<button type="button" class="btn btn-lg bg-gradient-secondary btn-tooltip" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='fa fa-tasks'></i>
				Calificaciones <span class="caret"></span>
			</button>-->
			
		    <a href="<?php echo $url ?>&id=<?php echo $asignation->id; ?>" class="btn bg-gradient-secondary btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tooltip on bottom" data-container="body" data-animation="true">
                <i class='fa fa-pencil-square-o'></i> Asignar Calificaciones
            </a>
        </div>
        <div class="btn-group" style="margin-right: 10px;">
            <a href="./?view=actacalificaciones&id=<?php echo $asignation->id; ?>" class="btn bg-gradient-primary btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tooltip on bottom" data-container="body" data-animation="true">
                <i class='fa fa-download'></i> Descarga Acta Definitiva
            </a>
		</div>
        

		<div class="btn-group" style="margin-right: 10px;">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='fa fa-check'></i>
				Asistencia <span class="caret"></span>
			</button>

			<ul class="dropdown-menu">
				<li><a href="./?view=teams&opt=assistance&asignation_id=<?php echo $asignation->id; ?>">
						<i class='fa fa-pencil-square'></i>Tomar Asistencia</a>
				</li>
				<li><a href="./?view=teams&opt=assistancereport&asignation_id=<?php echo $asignation->id; ?>"><i class='fa fa-file-text'></i>Reporte de Asistencia</a>
				</li>

			</ul>

		</div>


		<!--<a href="./?view=teams&opt=behavior&asignation_id=<?php echo $asignation->id; ?>" class="btn btn-default">Modificar Conducta</a>-->

		<!--<a class="btn btn-default" href="http://cals.ugestalt.edu.mx/viserion/grupos/AnwesenheitsundKontrolllisten.php" target="_blank"><i class='fa fa-download'></i>Descargar Lista Grupal</a>
		-->

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
						<th>Calificaciones</th>
						<th class="text-center">Promedio Final</th>
						<th>Estado</th>
					</thead>
					<?php
					foreach ($alumns as $alumnx) {
						$alumn = $alumnx->getAlumn();
						$pF = CalificationFinalData::promedioFinal($alumn->id, $asignation_id);
					?>
						<tr>
							<td><?php echo $alumn->code; ?></td>
							<td><?php echo $alumn->name . " " . $alumn->lastname; ?></td>
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