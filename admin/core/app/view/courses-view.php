<?php if (isset($_GET["opt"]) && $_GET["opt"] == "all") { ?>
	<div class="row">
		<div class="col-md-12">
			<div class="btn-group pull-right">
				<a href="./?view=courses&opt=new" class="btn btn-default"><i class='fa fa-th-list'></i> Nuevo Curso</a>
			</div>
			<h1>Cursos</h1>
			<br>
			<?php

			$courses = CoursesData::getAll();
			if (count($courses) > 0) {
				// si hay usuarios
			?>
				<div class="box box-primary">
					<div class="box-body">

						<table class="table table-bordered datatable table-hover">
							<thead>
								<th>Nombre</th>
								<th>URL</th>
								<th>Estatus</th>
								<th>Perfil</th>
								<th>Fecha</th>
								<th>Horario</th>
								<th></th>
							</thead>
							<?php
							foreach ($courses as $course) {
								if ($course->is_active == "1") {
									$lbl_status = "Activo";
									$lbl_class = 'label bg-green';
								} else {
									$lbl_status = "Finalizado";
									$lbl_class = 'label label-danger';
								}

								if ($course->kind == "1") {
									$kind = "PROFESORES";
								} elseif ($course->kind == "2") {
									$kind = "PADRES";
								} elseif ($course->kind == "3") {
									$kind = "ESTUDIANTES";
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
									<td><i class='fa fa-link'></i> <a href="<?php echo $course->url; ?>" target="_blank"><?php echo $course->url; ?></a><br></td>
									<td>
										<span class="<?php echo $lbl_class; ?>"><?php echo $lbl_status; ?></span>
									</td>
									<td><?php echo $kind ?></td>
									<td><?php echo  $fecha ?></td>
									<td><?php echo  $star_hour . " - " . $end_hour  ?></td>

									<td class="col-md-2">
										<div class="btn-group pull-center">
											<a href="index.php?view=courses&opt=view&id=<?php echo $course->id ?>"><button type="button" class="btn bg-primary"><i class="fa fa-eye"></i></button></a>
										</div><!-- /btn-group -->
										<?php if ($course->is_active == 1) { ?>
											<div class="btn-group pull-center">
												<a href="index.php?view=courses&opt=edit&id=<?php echo $course->id ?>"><button type="button" class="btn bg-orange"><i class="fa fa-edit"></i></button></a>
											</div><!-- /btn-group -->
											<div class="btn-group pull-center">
												<a href="index.php?action=courses&opt=del&id=<?php echo $course->id ?>"><button type="button" class="btn bg-red"><i class="fa fa-trash"></i></button></a>
											</div><!-- /btn-group -->

											<div class="btn-group pull-center">
												<a href="index.php?action=courses&opt=check&id=<?php echo $course->id ?>"><button type="button" class="btn bg-purple"><i class="fa fa-check"></i></button></a>

											</div><!-- /btn-group -->
										<?php	} ?>
									</td>
								</tr>
						<?php
							}
							echo "</table></div></div>";
						} else {
							echo "<p class='alert alert-danger'>No hay cursos</p>";
						}
						?>
					</div>
				</div>

			<?php } elseif (isset($_GET["opt"]) && $_GET["opt"] == "new") { ?>
				<div class="row">
					<div class="col-md-12">
						<h1>Nuevo Curso</h1>
						<br>
						<form class="form-horizontal" method="post" id="addcourse" action="./?action=courses&opt=add" role="form">
							<div class="form-group">
								<label for="name" class="col-lg-2 control-label">Nombre*</label>
								<div class="col-md-6">
									<input type="text" name="name" required class="form-control" id="name" placeholder="Nombre">
								</div>
							</div>
							<div class="form-group">
								<label for="url" class="col-lg-2 control-label">URL*</label>
								<div class="col-md-6">
									<input type="text" name="url" required class="form-control" id="url" placeholder="URL">
								</div>
							</div>
							<div class="form-group">
								<label for="kind" class="col-lg-2 control-label">Perfil*</label>
								<div class="col-md-3">
									<select name="kind" id="kind" class="form-control">
										<option value="1" selected>Profesores</option>
										<option value="3">Estudiantes</option>
										<option value="2">Padres</option>
									</select>
								</div>
								<label for="date" class="control-label">*Fecha</label>
								<div class="col-md-3">
									<input type="date" name="date" id="date" class="form-control text-center" required>
								</div>
							</div>

							<div class="form-group">

							</div>

							<div class="form-group">
								<label for="date" class="col-lg-2 control-label">Inicio*</label>
								<div class="col-md-3">
									<input type="time" name="star" id="star" class="form-control text-center" required>
								</div>
								<label for="date" class="control-label">*Fin</label>
								<div class="col-md-3">
									<input type="time" name="end" id="end" class="form-control text-center" required>
								</div>
							</div>

							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
									<button type="submit" class="btn btn-primary">Agregar Curso</button>
								</div>
							</div>
						</form>
					</div>
				</div>



			<?php } elseif (isset($_GET["opt"]) && $_GET["opt"] == "edit") {
			$a = CoursesData::getById($_GET["id"]);
			if ($a->kind == "1") {
				$kind = "Profesores";
			} elseif ($a->kind == "2") {
				$kind = "Padres";
			} elseif ($a->kind == "3") {
				$kind = "Estudiantes";
			}

			list($time_star) = explode(" ", $a->star_time);
			list($hora, $minutos, $segundos) = explode(":", $time_star);
			$inicio = $hora . ":" . $minutos;

			list($time_end) = explode(" ", $a->end_time);
			list($hora_e, $minutos_e, $segundos_e) = explode(":", $time_end);
			$fin = $hora_e . ":" . $minutos_e;


			?>
				<div class="row">
					<div class="col-md-12">
						<h1>Editar Curso</h1>
						<br>
						<form class="form-horizontal" method="post" id="updatecourse" action="./?action=courses&opt=update" role="form">
							<div class="form-group">
								<label for="name" class="col-lg-2 control-label">Nombre*</label>
								<div class="col-md-6">
									<input type="text" name="name" required class="form-control" id="name" placeholder="Nombre" value="<?php echo $a->name ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="url" class="col-lg-2 control-label">URL*</label>
								<div class="col-md-6">
									<input type="text" name="url" required class="form-control" id="url" placeholder="URL" value="<?php echo $a->url ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="kind" class="col-lg-2 control-label">Perfil*</label>
								<div class="col-md-3">
									<select name="kind" id="kind" class="form-control">
										<option value="<?php echo $a->kind ?>" selected> <?php echo $kind ?></option>
										<option value="1">Profesores</option>
										<option value="3">Estudiantes</option>
										<option value="2">Padres</option>
									</select>
								</div>
								<label for="date" class="control-label">*Fecha</label>
								<div class="col-md-3">
									<input type="date" name="date" id="date" class="form-control text-center" value="<?php echo $a->date ?>" required>
								</div>
							</div>



							<div class="form-group">
								<label for="date" class="col-lg-2 control-label">Inicio*</label>
								<div class="col-md-3">
									<input type="time" name="star" id="star" class="form-control text-center" value="<?php echo $inicio ?>" required>
								</div>
								<label for="date" class="control-label">*Fin</label>
								<div class="col-md-3">
									<input type="time" name="end" id="end" class="form-control text-center" value="<?php echo $fin ?>" required>
								</div>
							</div>

							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
									<input type="hidden" name="id" value="<?php echo $a->id ?>">
									<button type="submit" class="btn btn-success">Actualizar Curso</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			<?php

		} elseif (isset($_GET["opt"]) && $_GET["opt"] == "view") { ?>
				<div class="btn-group pull-right">
					<a href="./?view=courses&opt=all" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
				</div>
				<?php
				$id_course = intval($_GET['id']);
				$courses = CoursesData::getById($id_course);
				$courses_info = RegCourses::getAllByCourseId($id_course);
				if (count($courses_info) > 0) {

					if ($courses->is_active == "1") {
						$lbl_status = "Activo";
						$lbl_class = 'label bg-green';
					} else {
						$lbl_status = "Finalizado";
						$lbl_class = 'label label-danger';
					}

					if ($courses->kind == "1") {
						$kind = "Profesores";
					} elseif ($courses->kind == "2") {
						$kind = "Padres";
					} elseif ($courses->kind == "3") {
						$kind = "Estudiantes";
					}

					list($date) = explode(" ", $courses->date);
					list($Y, $m, $d) = explode("-", $date);
					$fecha = $d . "-" . $m . "-" . $Y;

					list($time_star) = explode(" ", $courses->star_time);
					list($hora, $minutos, $segundos) = explode(":", $time_star);
					$inicio = $hora . ":" . $minutos;

					list($time_end) = explode(" ", $courses->end_time);
					list($hora_e, $minutos_e, $segundos_e) = explode(":", $time_end);
					$fin = $hora_e . ":" . $minutos_e;
				?>
					<div class="row">
						<div class="col-md-12">
							<h1>Curso: <b><?php echo $courses->name ?></b></h1>
							<h4><span class="<?php echo $lbl_class; ?>"><?php echo $lbl_status; ?></span></h4>
							<h4>Fecha: <b><?php echo $fecha . " ~ " . $inicio . " - " . $fin ?></b></h4>
							<h4>Perfil: <b><?php echo $kind  ?></b></h4>
							<br>
							<div class="box box-primary">
								<div class="box-body">

									<table class="table table-bordered datatable table-hover">
										<thead>
											<th>Nombre</th>
											<th>Matricula</th>
											<th></th>
										</thead>
										<?php

										foreach ($courses_info as $c_i) {
											$person = PersonData::getById($c_i->id_person);
										?>
											<tr>
												<td><?php echo $person->name . " " . $person->lastname ?></td>
												<td><?php echo $person->code ?></td>
												<td class="col-md-2">
													<?php if ($courses->is_active == 1) {
													?>
														<div class="btn-group pull-center">
															<a href="index.php?action=courses&opt=delperson&id_person=<?php echo $c_i->id_person ?>&id_course=<?php echo $id_course ?>"><button type="button" class="btn bg-red"><i class="fa fa-trash"></i></button></a>
														</div><!-- /btn-group -->
													<?php  }
													?>
												</td>
											</tr>
									<?php
										}
										echo "</table></div></div>";
									} else {
										echo "<br><br><br><p class='alert alert-danger'>No hay personas registradas para este curso</p>";
									}
									?>
								</div>
							</div>

						<?php }
