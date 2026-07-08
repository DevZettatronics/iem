<?php $user_id = $_SESSION["teacher_id"];
?>
		
<html lang="es">
<div class="row">
	<div class="col-md-12">

		<h1>Mis Cursos <small>IEM y Más...</small></h1>
		<p>Bienvenido al espacio de Cursos IEM, en el siguiente listado se muestran los cursos a los que usted esta inscrito, si desea incribirse a uno nuevo de clic en en el botón <strong>+Inscribirme a Cursos.</strong></p>
		
		
		<a href="./?view=home" class="btn btn-dark" style="color: #62AED2;"><i class="fa fa-arrow-left"></i> Regresar</a>
		<div class="btn-group">
			<a href="./?view=coursesadd&opt=all" class="btn btn-success"><i class='fa fa-plus'></i> Inscribirme a Nuevo Curso</a>
		</div>
		
		<div class="btn-group">
			<a href="index.php?view=misconstancias&id=<?php if (isset($_SESSION["teacher_id"])) {
                                                      echo PersonData::getById($_SESSION["teacher_id"])->id;
                                                    } ?>" class="btn btn-warning"><i class='fa fa-file-text'></i> Mis Constancias</a>
		</div>
		<br><br>
		<?php

		$courses = RegCourses::getAllByUserId($user_id);
		if (count($courses) > 0) {
			// si hay usuarios
		?>
			<div class="box box-primary">
				<div class="box-body">
					<table class="table table-bordered datatable table-hover">
						<thead>
							<th>Nombre de Curso</th>
							<th class="text-center">Enlace para Sesión</th>
							<th>Estatus</th>
							<th>Fecha</th>
							<!--<th>Horario</th>-->
						</thead>
						<?php
						foreach ($courses as $course) {
							$cursos = CoursesData::getById($course->id_course);
							if ($cursos->is_active == 1) {
								$lbl_status = "Inscrito";
								$lbl_class = 'label bg-green';
							} else {
								$lbl_status = "Inscrito";
								$lbl_class = 'label label-success';
							}

							list($date) = explode(" ", $cursos->date);
							list($Y, $m, $d) = explode("-", $date);
							$fecha = $d . "-" . $m . "-" . $Y;

							list($time) = explode(" ", $cursos->star_time);
							list($H, $m) = explode(":", $time);
							$star_hour = $H . ":" . $m;

							list($time_end) = explode(" ", $cursos->end_time);
							list($H, $m) = explode(":", $time_end);
							$end_hour = $H . ":" . $m;

						?>
							<tr>

								<td><?php echo $cursos->name; ?></td>
								<td class="text-center">
									<?php if ($cursos->is_active == 0) { ?>
										<a href="<?php echo $cursos->url; ?>" target="_blank"><i class='fa fa-link'></i></a>
									<?php } ?>
								</td>
								<td>
									<span class="<?php echo $lbl_class; ?>"><?php echo $lbl_status; ?></span>
								</td>
								<td><?php echo  $fecha ?> <br> <strong>Horario: </strong><?php echo  $star_hour . " - " . $end_hour  ?></td>
								
								<!--<td><?php echo  $star_hour . " - " . $end_hour  ?></td>-->


							</tr>
					<?php
						}
						echo "</table></div></div>";
					} else {
						echo "<p class='alert alert-danger'>No tienes cursos</p>";
					}
					?>
				</div>
			</div>