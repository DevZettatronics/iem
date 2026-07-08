<?php
$inscription = InscriptionData::getById($_GET["id"]);
$alumn = PersonData::getById($inscription->alumn_id);
$asignations = AsignationData::getAllByTP($inscription->team_id, $inscription->period_id);
$con = Database::getCon();

?>
<div class="row">
	<div class="col-md-12">

		<div class="small-box bg-maroon">
			<div class="inner">
				<h4 align="left"><i class='fa fa-tasks'></i> <strong>Datos del Estudiante</strong></h4>
				<h5 align="left">Matrícula: <strong><?php echo $alumn->code; ?></strong></h5>
				<h5 align="left">Nombre(s): <strong><?php echo $alumn->name; ?></strong></h5>
				<h5 align="left">Apellidos: <strong><?php echo $alumn->lastname; ?></strong></h5>

			</div>
			<div class="icon">
				<i class="fa fa-list"></i>
			</div>
		</div>

		<!-- <h3>Ciclos Escolares Cursados</h3>
		<h5>La información mostrada en este espacio corresponde a las asignaturas cursadas durante el ciclo escolar.| Para visualizar el desglose de calificaciones, presiona la calificación obtenida en cada asignatura. </h5> -->
		<a href="./?view=alumnhistory&id=<?php echo $alumn->id; ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>

		<br><br>
		<?php

		if (count($asignations) > 0) {
			// si hay usuarios
		?>
			<div class="box box-primary">
				<div class="box-body">
					<table class="table table-bordered datatable table-hover">
						<thead>
							<th>Asignatura</th>
<!-- 							<th>Promedio Por Parcial</th> -->
							<th>Calificación</th>
							<th>Estado</th>

						</thead>
						<?php foreach ($asignations as $asig) {
							$blocks = BlockData::getParentsByAsignationId($asig->id);
							$totalBlocks = count($blocks);
						?>
							<tr>
								<td align="left"><?php echo $asig->getAsignature()->name; ?></td>
								<?php
								$suma = 0;
								foreach ($blocks as $b) {
									$subs = BlockData::getAllByBlockId($b->id);
									$totalhijos = count($subs);

									$sql = "SELECT SUM(Calificacion) as Calificacion FROM v_calificaciones where idalumno = $alumn->id and  Id_Materia = $asig->id and IdBloquePapa = $b->id";
									$query = mysqli_query($con, $sql);
									while ($row = mysqli_fetch_array($query)) {
										$calificacionSQL = $row['Calificacion'];
									}
									$promedio = bcdiv($calificacionSQL / $totalhijos, '1', 1);
								?>

									<?php
									$ppe = 0;
									foreach ($subs as $sb) { ?>
									<?php
										$exist = CalificationData::getExist($alumn->id, $sb->id);
									}
									$ppe += $promedio;
									$suma += $promedio;
									$opeacionPromedioFinal = $suma / $totalBlocks;
									$promedioFinal = round($opeacionPromedioFinal);
									?>

								<?php } ?>
								<td class="text-center"><?php echo $promedioFinal ?></td>

								<td>
									<?php
									if ($promedioFinal >= 6) {
										echo "<span class='label label-success'>Aprobado</span>";
									} elseif ($promedioFinal < 6) {
										echo "<span class='label label-danger'>Reprobado</span>";
									} ?>
								</td>
							</tr>
					<?php
						}
						echo "</table></div></div>";
					} else {
						echo "<p class='alert alert-danger'>No hay Inscripciones</p>";
					}
					?>

				</div>
			</div>