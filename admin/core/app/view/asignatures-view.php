<?php if (isset($_GET["opt"]) && $_GET["opt"] == "all") : ?>
	<div class="row">
		<div class="col-md-12">
			<h1>Asignaturas</h1>
			<a href="./?view=asignatures&opt=new" class="btn btn-default"><i class='fa fa-th-list'></i> Nueva Asignatura</a>
			<br>
			<br>
			<?php  

			$teams = AsignatureData::getAll();
			if (count($teams) > 0) {
				// si hay usuarios
			?>
				<div class="box box-primary">
					<div class="box-body">
						<table class="table table-bordered datatable table-hover">
							<thead>
								<th>ID</th>
								<th>Nombre</th>
								<th>Programa</th>
								<th>Creditos</th>
								<th>Periodo Académico</th>
								<th></th>
							</thead>
							<?php
							foreach ($teams as $team) {
							?>
								<tr>
									<?php

									?>
									<td><?php echo $team->code;
										?></td>
									<td><?php echo $team->name; ?></td>
									<td><?php echo $team->program; ?></td>
									<td style="text-align: center;"><?php echo $team->credito; ?></td>
									<td style="text-align: center;"><?php echo $team->grado . "°"; ?></td>
									<td style="width:130px;"><a href="index.php?view=asignatures&opt=edit&id=<?php echo $team->id; ?>" class="btn btn-warning btn-xs">Editar</a> <a href="index.php?action=asignatures&opt=del&id=<?php echo $team->id; ?>" class="btn btn-danger btn-xs">Eliminar</a></td>
								</tr>
						<?php
							}
							echo "</table></div></div>";
						} else {
							echo "<p class='alert alert-danger'>No hay Asignaturas</p>";
						}
						?>
					</div>
				</div>
				<!--Nueva Asignatura -->

			<?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "new") :

			?>
				<div class="row">
					<div class="col-md-12">
						<h1>Nueva Asignatura</h1>
						<br>
						<form class="form-horizontal" method="post" id="addcategory" action="./?action=asignatures&opt=add" role="form">
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-2 control-label">Programa*</label>
								<div class="col-md-6">
									
										<select id="program" name="program" required class="form-control" aria-describedby="sizing-addon1" style="width: auto">
											<option value="" selected>Selecciona el Programa Educativo</option>
											<?php
											foreach (EducationalProgramData::getGrade() as $edu) { ?>
												<optgroup label="<?php echo $edu->grade ?>">
													<?php
													foreach (EducationalProgramData::getName($edu->grade) as $n) {
													?>
														<option value="<?php echo $n->id; ?>"><?php echo $n->name; ?></option>

												<?php
													}
												}
												?>
										</select>
									
								</div>
								<!-- style="display: none" -->
							<select name="program_a" id="program_a" class="form-control select" style="display: none">
								<option value=""></option>
							</select>
							<select name="id_program" id="id_program" class="form-control select" style="display: none">
								<option value=""></option>
							</select>
							</div>
							
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
								<div class="col-md-6">
									<input type="text" name="name" required class="form-control" id="name" placeholder="Nombre Asignatura">
								</div>
							</div>
							<div class="form-group">
								<label for="credito" class="col-lg-2 control-label">ID asignatura*</label>
								<div class="col-md-3	">
									<input type="text" name="code_asignatura" required class="form-control" id="code_asignatura" placeholder="ID asignatura" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
								</div>

							</div>
							<div class="form-group">
								<label for="credito" class="col-lg-2 control-label">Credito*</label>
								<div class="col-md-3	">
									<input type="text" name="credito" required class="form-control" id="credito" placeholder="Credito de asignatura" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
								</div>
							</div>
							<div class="form-group">
								<label for="grado" class="col-lg-2 control-label">Grado*</label>
								<div class="col-md-3">
									<select name="grado" required class="form-control" id="grado">
										<option value="1">1º grado</option>
										<option value="2">2º grado</option>
										<option value="3">3º grado</option>
										<option value="4">4º grado</option>
										<option value="5">5º grado</option>
										<option value="6">6º grado</option>
										<option value="7">7º grado</option>
										<option value="8">8º grado</option>
										<option value="9">9º grado</option>
										<option value="10">10º grado</option>
										<option value="11">11º grado</option>
										<option value="12">12º grado</option>
									</select>
								</div>
							</div>
					</div>

					<div class="form-group">
						<div class="col-lg-offset-2 col-lg-10">
							<button type="submit" class="btn btn-primary">Agregar Asignatura</button>
						</div>
					</div>
					</form>
				</div>
				<script>
		$(document).ready(function() {
			$('#program').on('change', function() {
				if ($('#program').val() == "") {
					$('#program_a').empty();
					$('<option value = "">Nomenclatura</option>').appendTo('#program_a');
					$('#program_a').attr('disabled', 'disabled');
				} else {
					$('#program_a').removeAttr('disabled', 'disabled');
					$('#program_a').load('core/app/action/listar_programas.php?program_a=' + $('#program').val());
				}
			});
		});
		$(document).ready(function() {
			$('#program').on('change', function() {
				if ($('#program').val() == "") {
					$('#id_program').empty();
					$('<option value = "">Nomenclatura</option>').appendTo('#id_program');
					$('#id_program').attr('disabled', 'disabled');
				} else {
					$('#id_program').removeAttr('disabled', 'disabled');
					$('#id_program').load('core/app/action/listar_programas_id.php?program_a=' + $('#program').val());
				}
			});
		});
	

	</script>
		</div>

		<!--Actualizar Asignatura -->
	<?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "edit") :
			$a = AsignatureData::getById($_GET["id"]);
	?>
		<div class="row">
			<div class="col-md-12">
				<h1>Editar Asignatura</h1>
				<br>
				<form class="form-horizontal" method="post" id="addcategory" action="./?action=asignatures&opt=update" role="form">

					<div class="form-group">
						<label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
						<div class="col-md-6">
							<input type="text" name="name" value="<?php echo $a->name; ?>" required class="form-control" id="name" placeholder="Nombre">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail1" class="col-lg-2 control-label">Programa</label>
						<div class="col-md-6">
							<div class="element">
								<select id="program" name="program" required class="form-control" aria-describedby="sizing-addon1" style="width: auto">
									<option value="<?php echo $a->program; ?>" selected><?php echo $a->program; ?></option>
									<?php
									foreach (EducationalProgramData::getGrade() as $edu) { ?>
										<optgroup label="<?php echo $edu->grade ?>">
											<?php
											foreach (EducationalProgramData::getName($edu->grade) as $n) {
											?>
												<option value="<?php echo $n->id; ?>"><?php echo $n->name; ?></option>

										<?php
											}
										}
										?>
								</select>
							</div>
						</div>
						<!-- style="display: none" -->
							<select name="program_a" id="program_a"  class="form-control select" style="display: none">
								<option value="<?php echo $a->program; ?>"><?php echo $a->program; ?></option>
							</select>
							<select name="id_program" id="id_program"  class="form-control select" style="display: none">
								<option value="<?php echo $a->id_program; ?>"><?php echo $a->id_program; ?></option>
							</select>
					</div>

					<div class="form-group">
						<label for="credito" class="col-lg-2 control-label">ID asignatura*</label>
						<div class="col-md-3	">
							<input type="text" name="code_asignatura" required class="form-control" id="code_asignatura" value="<?php echo $a->code ?>" placeholder="ID asignatura" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
						</div>

					</div>
					<div class="form-group">
						<label for="credito" class="col-lg-2 control-label">Credito*</label>
						<div class="col-md-3	">
							<input type="text" name="credito" required class="form-control" id="credito" value="<?php echo $a->credito ?>" placeholder="Credito de asignatura" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
						</div>
					</div>
					<div class="form-group">
						<label for="grado" class="col-lg-2 control-label">Grado</label>
						<div class="col-md-3">
							<select name="grado" required class="form-control" id="grado">
								<option value="1" <?php if ($a->grado == "1") {
														echo "selected";
													} ?>>1º grado</option>
								<option value="2" <?php if ($a->grado == "2") {
														echo "selected";
													} ?>>2º grado</option>
								<option value="3" <?php if ($a->grado == "3") {
														echo "selected";
													} ?>>3º grado</option>
								<option value="4" <?php if ($a->grado == "4") {
														echo "selected";
													} ?>>4º grado</option>
								<option value="5" <?php if ($a->grado == "5") {
														echo "selected";
													} ?>>5º grado</option>
								<option value="6" <?php if ($a->grado == "6") {
														echo "selected";
													} ?>>6º grado</option>
								<option value="7" <?php if ($a->grado == "7") {
														echo "selected";
													} ?>>7º grado</option>
								<option value="8" <?php if ($a->grado == "8") {
														echo "selected";
													} ?>>8º grado</option>
								<option value="9" <?php if ($a->grado == "9") {
														echo "selected";
													} ?>>9º grado</option>
								<option value="10" <?php if ($a->grado == "10") {
														echo "selected";
													} ?>>10º grado</option>
								<option value="11" <?php if ($a->grado == "11") {
														echo "selected";
													} ?>>11º grado</option>
								<option value="12" <?php if ($a->grado == "12") {
														echo "selected";
													} ?>>12º grado</option>
							</select>
						</div>
					</div>
					<!-- <div class="form-group">
						<label for="credito" class="col-lg-2 control-label ">Cambio*</label>
						<div class="col-md-6">
							<input type="text" name="credito" required class="form-control" id="credito" placeholder="Credito de asignatura" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
						</div>
					</div> -->
					<div class="form-group">
						<div class="col-lg-offset-2 col-lg-10">
							<input type="hidden" name="id" value="<?php echo $a->id; ?>">
							<button type="submit" class="btn btn-success">Actualizar Asignatura</button>
						</div>
					</div>
				</form>
			</div>
			<script>
		$(document).ready(function() {
			$('#program').on('change', function() {
				if ($('#program').val() == "") {
					$('#program_a').empty();
					$('<option value="<?php echo $a->program; ?>">Nomenclatura</option>').appendTo('#program_a');
					$('#program_a').attr('disabled', 'disabled');
				} else {
					$('#program_a').removeAttr('disabled', 'disabled');
					$('#program_a').load('core/app/action/listar_programas.php?program_a=' + $('#program').val());
				}
			});
		});
		$(document).ready(function() {
			$('#program').on('change', function() {
				if ($('#program').val() == "") {
					$('#id_program').empty();
					$('<option value="">ID</option>').appendTo('#id_program');
					$('#id_program').attr('disabled', 'disabled');
				} else {
					$('#id_program').removeAttr('disabled', 'disabled');
					$('#id_program').load('core/app/action/listar_programas_id.php?program_a=' + $('#program').val());
				}
			});
		});
	

	</script>
		</div>
	<?php endif; ?>



	<!-- ESTO ES COMO SE TENIA ANTES DE LOS CAMBIOS 

class="small-box bg-navy"  ESTILO PARA PODER DIFERENCIAR LOS CAMBIOS


	<select id="program" name="program" required class="form-control" aria-describedby="sizing-addon1" style="width: auto">
									<option value="<?php echo $a->program; ?>" selected>Selecciona el Programa Educativo</option>
									<optgroup label="Bachillerato">
										<option value="Bachillerato General">Bachillerato General</option>
									</optgroup>
									<optgroup label="Licenciatura">
										<option value="Licenciatura en Psicología E - 128">Psicología Es 128</option>
										<option value="Licenciatura en Psicología No E - 129">Psicología No Es 129</option>
										<option value="Licenciatura en Pedagogía">Pedagogía</option>
										<option value="Licenciatura en Relaciones Internacionales">Relaciones Internacionales</option>
										<option value="Licenciatura en Derecho">Derecho</option>
										<option value="Licenciatura en Contaduría">Contaduría</option>
										<option value="Licenciatura en Mercadotecnia">Mercadotecnia</option>
										<option value="Licenciatura en Administración">Administración</option>
									</optgroup>
									<optgroup label="Especialidad">
										<option value="Especialidad en Pareja y Familia">Pareja y Familia</option>
										<option value="Especialidad en Niños y Adolescentes">Niños y Adolescentes</option>
									</optgroup>
									<optgroup label="Maestría">
										<option value="Maestría en Educación">Educacion</option>
										<option value="Maestría en Psicoterapia Gestalt 2 Años">Psicoterapia Gestalt 2 Años</option>
										<option value="Maestría en Psicoterapia Gestalt 3 Años">Psicoterapia Gestalt 3 Años</option>
									</optgroup>
									<optgroup label="Doctorado">
										<option value="Doctorado en Psicoterapia Gestalt">Psicoterapia Gestalt</option>
										<option value="Doctorado en Filosofía Gestalt">Filosofía Gestalt</option>
										<option value="Doctorado en Innovación y Administración Educativa">Innovación y Administración Educativa</option>
									</optgroup>
								</select> -->