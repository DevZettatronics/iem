<?php
$inscription = InscriptionData::getById($_GET["id"]);
$alumn = PersonData::getById($inscription->alumn_id);
$asignations = AsignationData::getAllByTP($inscription->team_id, $inscription->period_id);

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


		
			  <h4><img src="../storage/posts/libros.png"  width="52px"> <strong>Asignaturas Cursadas</strong></h4>
		<h5>° La información mostrada en este espacio corresponde a las asignaturas cursadas durante el ciclo escolar.
			<br>
			<br>
			° <b>Para visualizar el desglose de calificaciones, presiona la calificación obtenida en cada asignatura.</b>
		</h5>
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
							<th class="text-center">Desglose</th>
							<th style="width: 250px;text-align: center;">Ver Calificación</th>
							<th>Estado</th>

						</thead>
						<?php foreach ($asignations as $asig) {
							$pF = CalificationFinalData::promedioFinal($alumn->id, $asig->id);
							$calificacion = $pF != NULL ? $pF->calificacion : 'SC';
							$url = $asig->asignature_type == 'NUM' ? 'calasignation' : 'calasignationL';
						?>
							<tr>
								<td align="left" style="font-size: 10px;"><?php echo $asig->getAsignature()->name; ?></td> <!-- nombre -->
								<td >
									<!-- promedio -->
									<?php
									$asignation_id = $_GET["id"];
									$con = Database::getCon();
									$validar = "SELECT * FROM `v_calificaciones` WHERE IdAlumno = $alumn->id AND Id_Materia = $asig->id AND idBloquePapa IS NOT NULL";
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
								<td class="text-center"><a title="Pesione para vizualizar las calificacione" class="btn bg-primary" href="index.php?view=<?php echo $url ?>&idAlumn=<?php echo $alumn->id ?>&idAsignation=<?php echo $asig->id ?>&idInscription=<?php echo $_GET["id"] ?>"><?php echo $calificacion ?></a></td>

								<?php if ($pF != NULL) { ?>

									<td>
										<?php
										if ($pF->calificacion >= 6 || $pF->calificacion == 'AC') {
											echo "<span class='label label-success'>Aprobado</span>";
										} else {
											echo "<span class='label label-danger'>Reprobado</span>";
										} ?>
									</td>

								<?php } else { ?>
									<td><span class='label label-warning'>Sin Calificacion Aun</span></td>
								<?php }  ?>

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