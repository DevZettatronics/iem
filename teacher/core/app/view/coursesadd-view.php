<?php
$user_id = $_SESSION["teacher_id"];
if (isset($_GET["opt"]) && $_GET["opt"] == "all") { ?>
	<div class="row">
		<div class="col-md-12">
			<h1>Listado de Cursos</h1>
			<br>
			<?php

			$courses = CoursesData::getAllTeacher();
			if (count($courses) > 0) {
				// si hay usuarios
			?>
				<div class="box box-primary">
					<div class="box-body">

						<table class="table table-bordered datatable table-hover">
							<thead>
								<th>Nombre</th>
								<th>Estatus</th>
								<th>Fecha</th>
								<!--<th>Horario</th>-->
								<th></th>
							</thead>
							<?php
							foreach ($courses as $course) {
								if ($course->is_active == "1") {
									$lbl_status = "Disponible";
									$lbl_class = 'label bg-green';
								} else {
									$lbl_status = "Finalizado";
									$lbl_class = 'label label-danger';
								}

								list($date) = explode(" ", $course->date);
								list($Y, $m, $d) = explode("-", $date);
								$fecha = $d . "-" . $m . "-" . $Y;

								list($time) = explode(" ", $course->star_time);
								list($H, $m) = explode(":", $time);
								$star_hour = $H . ":" . $m;

								list($time_end) = explode(" ", $course->end_time);
								list($H, $m) = explode(":", $time_end);
								$end_hour = $H . ":" . $m;

							?>
								<tr>
									<td><?php echo $course->name; ?></td>
									<td>
										<span class="<?php echo $lbl_class; ?>"><?php echo $lbl_status; ?></span>
									</td>
									<td><?php echo  $fecha ?><br><strong>Horario: </strong> <?php echo  $star_hour . " - " . $end_hour  ?></td>
									<!--<td><?php echo  $star_hour . " - " . $end_hour  ?></td>-->

									<td class="col-md-2">
										<div class="btn-group pull-center">
											<a href="index.php?action=courses&opt=check&id=<?php echo $course->id ?>&user=<?php echo $user_id ?>"><button type="button" class="btn bg-purple"><i class="fa fa-plus"></i></button></a>
										</div><!-- /btn-group -->
									</td>

								</tr>
						<?php
							}
							echo "</table></div></div>";
						} else {
							echo "<p class='alert alert-danger'>No hay cursos disponibles</p>";
						}
						?>
					</div>
				</div>

			<?php }
