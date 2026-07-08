<?php if (isset($_GET["opt"]) && $_GET["opt"] == "all") : ?>
	<div class="row">
		<div class="col-md-12">
			<h1>Programas Educativos</h1>
			<a href="./?view=educationalprogram&opt=new" class="btn btn-default"><i class='fa fa-th-list'></i> Nuevo Programa</a>
			<br>
			<br>
			<?php

			$teams = EducationalProgramData::getAll();
			if (count($teams) > 0) {
				// si hay usuarios
			?>
				<div class="box box-primary">
					<div class="box-body">
						<table class="table table-bordered datatable table-hover">
							<thead>
								<th>Id</th>
								<th>Programa</th>
								<th>Nivel</th>
								<th>Tipo</th>
								<th>RVOE</th>
								<th>Periodo Académico </th>
								<th></th>
							</thead>
							<?php
							foreach ($teams as $team) {
							?>
								<tr>
									<td><?php echo $team->id; ?></td>
									<td><?php echo $team->name; ?></td>
									<td><?php echo $team->grade; ?></td>
									<td><?php echo $team->type; ?></td>
									<td><?php echo $team->no_rvoe . "/" . $team->frvoe; ?></td>
									<td><?php echo $team->periodo_academico; ?></td>
									<td style="width:130px;"><a href="index.php?view=educationalprogram&opt=edit&id=<?php echo $team->id; ?>" class="btn btn-warning btn-xs">Editar</a>
										<a href="index.php?action=educationalprogram&opt=del&id=<?php echo $team->id; ?>" class="btn btn-danger btn-xs">Eliminar</a>
									</td>
								</tr>
						<?php
							}
							echo "</table></div></div>";
						} else {
							echo "<p class='alert alert-danger'>No hay Programas Educativos</p>";
						}
						?>
					</div>
				</div>
				<!-- 	</div>
	</div> -->
				<!--Nuevo Program -->
			<?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "new") :
			$acade = AcademicDegree::getA();
			?>
				<div class="row">
					<div class="col-md-12">
						<h1>Nuevo Programa</h1>
						<br>
						<form class="form-horizontal" method="post" id="addcategory" action="./?action=educationalprogram&opt=add" role="form">

							<div class="form-group">
								<label for="name" class="col-lg-2 control-label">Nombre Programa*</label>
								<div class="col-md-3">
									<input type="text" name="name" required class="form-control" id="name" placeholder="Nombre">
								</div>
								<label for="nc" class="col-lg-2 control-label">Nomenclatura*</label>
								<div class="col-md-3">
									<input type="text" name="nc" required class="form-control" id="nc" placeholder="Nomenclatura del Programa">
								</div>
							</div>

							<div class="form-group">
								<label for="inputEmail1" class="col-lg-2 control-label">Clave Programa*</label>
								<div class="col-md-3">
									<input type="text" name="clavep" id="clavep" required class="form-control" placeholder="Clave programa" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
									<!-- disabled="true" -->
								</div>
								<label for="grado" class="col-lg-2 control-label">Nivel*</label>
								<div class="col-md-3">
									<div id="grado" class="element">
										<select id="grado" name="grado" required class="form-control" aria-describedby="sizing-addon1" style="width: auto">
											<option value="" selected>Selecciona </option>
											<?php foreach (AcademicDegree::getA() as $n) { ?>
												<option value="<?php echo $n->degree; ?>"><?php echo $n->degree; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

							</div>

							<div class="form-group">
								<label for="tipo" class="col-lg-2 control-label">Tipo*</label>
								<div class="col-md-3">
									<div id="tipo" class="element">
										<select id="tipo" name="tipo" required class="form-control" aria-describedby="sizing-addon1" style="width: auto">
											<option value="" selected>Tipo Programa Educativo</option>
											<option value="Escolarizado">Escolarizado</option>
											<option value="No Escolarizado">No Escolarizado</option>
											<!-- <option value="Ejecutiva">Ejecutiva</option>
											<option value="En Linea">En Linea</option> -->

										</select>
									</div>
								</div>
								<label for="periodo_academico" class="col-lg-2 control-label">Periodo Académico*</label>
								<div class="col-md-3">
									<select id="periodo_academico" name="periodo_academico" required class="form-control" aria-describedby="sizing-addon1" style="width: auto">
										<option value="" selected>Selecciona</option>
										<?php foreach (PeriodTypeData::getAll() as $pt) { ?>
											<option value="<?php echo $pt->id; ?>"><?php echo $pt->tipo; ?></option>
										<?php } ?>
									</select>
									<select name="p_name" id="p_name" class="form-control select" style="display: none">
										<option value=""></option>
									</select>
									<select name="id_p" id="id_p" class="form-control select" style="display: none">
										<option value=""></option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="no_rvoe" class="col-lg-2 control-label">Numero de RVOE*</label>
								<div class="col-md-3">
									<input type="text" name="no_rvoe" required class="form-control" id="no_rvoe" placeholder="No RVOE">
								</div>
								<label for="frvoe" class="col-lg-2 control-label">Fecha de RVOE*</label>
								<div class="col-md-3">
									<input type="date" name="frvoe" required class="form-control" id="frvoe" placeholder="Fecha RVOE">
								</div>
							</div>

							<div class="form-group">
								<label for="clave_plan" class="col-lg-2 control-label">Clave Plan*</label>
								<div class="col-md-3">
									<input type="text" name="clave_plan" required class="form-control" id="clave_plan" placeholder="Clave Plan">
								</div>
							</div>
							<div class="form-group">
								<label for="clave_plan" class="col-lg-2 control-label">Cal Minima*</label>
								<div class="col-md-1">
									<input type="text" name="calmin" required class="form-control" id="calmin" placeholder="">
								</div>
								<label for="clave_plan" class="col-lg-2 control-label">Cal Maxima*</label>
								<div class="col-md-1">
									<input type="text" name="calmax" required class="form-control" id="calmax" placeholder="">
								</div>
								<label for="clave_plan" class="col-lg-2 control-label">Minimo Aprobatorio*</label>
								<div class="col-md-1">
									<input type="text" name="calap" required class="form-control" id="calap" placeholder="">
								</div>
							</div>
					</div>

					<div class="form-group">
						<div class="col-lg-offset-2 col-lg-10">
							<button type="submit" class="btn btn-primary">Agregar Programa</button>
						</div>
					</div>
					</form>
				</div>
				<script>
					$(document).ready(function() {
						$('#periodo_academico').on('change', function() {
							if ($('#periodo_academico').val() == "") {
								$('#id_p').empty();
								$('<option value = "">Nomenclatura</option>').appendTo('#id_p');
								$('#id_p').attr('disabled', 'disabled');
							} else {
								$('#id_p').removeAttr('disabled', 'disabled');
								$('#id_p').load('core/app/action/listar_grado.php?periodo_academico=' + $('#periodo_academico').val());
							}
						});
					});
					// para que no se abra el select
					$('#id_p').on('mousedown', function(e) {
						e.preventDefault();
						this.blur();
						window.focus();
					});

					$(document).ready(function() {
						$('#periodo_academico').on('change', function() {
							if ($('#periodo_academico').val() == "") {
								$('#p_name').empty();
								$('<option value = "">Nomenclatura</option>').appendTo('#p_name');
								$('#p_name').attr('disabled', 'disabled');
							} else {
								$('#p_name').removeAttr('disabled', 'disabled');
								$('#p_name').load('core/app/action/listar_pname.php?periodo_academico=' + $('#periodo_academico').val());
							}
						});
					});
					// para que no se abra el select
					$('#p_name').on('mousedown', function(e) {
						e.preventDefault();
						this.blur();
						window.focus();
					});
				</script>
				<!--Actualizar Programa -->
			<?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "edit") :
			$a = EducationalProgramData::getById($_GET["id"]);
			?>
				<div class="row">
					<div class="col-md-12">
						<h1>Editar Programa Educacional</h1>
						<br>
						<form class="form-horizontal" method="post" id="addcategory" action="./?action=educationalprogram&opt=update" role="form">

							<div class="form-group">
								<label for="name" class="col-lg-2 control-label">Nombre Programa*</label>
								<div class="col-md-3">
									<input type="text" name="name" required class="form-control" id="name" placeholder="Nombre" value="<?php echo $a->name; ?>">
								</div>
								<label for="nc" class="col-lg-2 control-label">Nomenclatura*</label>
								<div class="col-md-3">
									<input type="text" name="nc" required class="form-control" id="nc" placeholder="Nomenclatura del Programa" value="<?php echo $a->nc; ?>">
								</div>
							</div>

							<div class="form-group">
								<label for="inputEmail1" class="col-lg-2 control-label">Clave Programa*</label>
								<div class="col-md-3">
									<input type="text" name="clavep" id="clavep" required class="form-control" placeholder="Clave programa" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="<?php echo $a->clavep; ?>">
									<!-- disabled="true" -->
								</div>
								<label for="grado" class="col-lg-2 control-label">Nivel*</label>
								<div class="col-md-3">
									<div id="grado" class="element">
										<select id="grado" name="grado" required class="form-control" aria-describedby="sizing-addon1" style="width: auto">
											<option value="<?php echo $a->grade; ?>" selected><?php echo $a->grade; ?> </option>
											<?php foreach (AcademicDegree::getA() as $n) { ?>
												<option value="<?php echo $n->degree; ?>"><?php echo $n->degree; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

							</div>

							<div class="form-group">
								<label for="tipo" class="col-lg-2 control-label">Tipo*</label>
								<div class="col-md-3">
									<div id="tipo" class="element">
										<select id="tipo" name="tipo" required class="form-control" aria-describedby="sizing-addon1" style="width: auto">
											<option value="" <?php echo empty($a->type) ? 'selected' : ''; ?>>Tipo Programa Educativo</option>
											<option value="Escolarizado" <?php echo ($a->type == 'Escolarizado') ? 'selected' : ''; ?>>Escolarizado</option>
											<option value="No Escolarizado" <?php echo ($a->type == 'No Escolarizado') ? 'selected' : ''; ?>>No Escolarizado</option>
											<!-- <option value="Ejecutiva" <?php //echo ($a->type == 'Ejecutiva') ? 'selected' : ''; ?>>Ejecutiva</option> -->
											<!-- <option value="En Linea" <?php //echo ($a->type == 'En Linea') ? 'selected' : ''; ?>>En Linea</option> -->

										</select>
									</div>
								</div>
								<label for="periodo_academico" class="col-lg-2 control-label">Periodo Académico*</label>
								<div class="col-md-3">
									<select id="periodo_academico" name="periodo_academico" required class="form-control" aria-describedby="sizing-addon1" style="width: auto">
										<option value="" selected><?php echo $a->periodo_academico ?></option>
										<?php foreach (PeriodTypeData::getAll() as $pt) { ?>
											<option value="<?php echo $pt->id; ?>"><?php echo $pt->tipo; ?></option>
										<?php } ?>
									</select>
									<select name="p_name" id="p_name" class="form-control select" style="display: none">
										<option value="<?php echo $a->periodo_academico; ?>"><?php echo $a->periodo_academico; ?></option>
									</select>
									<select name="id_p" id="id_p" class="form-control select" style="display: none">
										<option value="<?php echo $a->id_p; ?>"><?php echo $a->id_p; ?></option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="no_rvoe" class="col-lg-2 control-label">Numero de RVOE*</label>
								<div class="col-md-3">
									<input type="text" name="no_rvoe" required class="form-control" id="no_rvoe" placeholder="No RVOE" value="<?php echo $a->no_rvoe; ?>">
								</div>
								<label for="frvoe" class="col-lg-2 control-label">Fecha de RVOE*</label>
								<div class="col-md-3">
									<input type="date" name="frvoe" required class="form-control" id="frvoe" placeholder="Fecha RVOE" value="<?php echo $a->frvoe; ?>">
								</div>
							</div>

							<div class="form-group">
								<label for="clave_plan" class="col-lg-2 control-label">Clave Plan*</label>
								<div class="col-md-3">
									<input type="text" name="clave_plan" required class="form-control" id="clave_plan" placeholder="Clave Plan" value="<?php echo $a->clave_plan; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="clave_plan" class="col-lg-2 control-label">Cal Minima*</label>
								<div class="col-md-1">
									<input type="text" name="calmin" required class="form-control" id="calmin" placeholder="" value="<?php echo $a->calmin; ?>">
								</div>
								<label for="clave_plan" class="col-lg-2 control-label">Cal Maxima*</label>
								<div class="col-md-1">
									<input type="text" name="calmax" required class="form-control" id="calmax" placeholder="" value="<?php echo $a->calmax; ?>">
								</div>
								<label for="clave_plan" class="col-lg-2 control-label">Minimo Aprobatorio*</label>
								<div class="col-md-1">
									<input type="text" name="calap" required class="form-control" id="calap" placeholder="" value="<?php echo $a->calap; ?>">
								</div>
							</div>
					</div>
					<div class="form-group">
						<div class="col-lg-offset-2 col-lg-10">
							<input type="hidden" name="id" value="<?php echo $a->id; ?>">
							<button type="submit" class="btn btn-success">Actualizar Programa</button>
						</div>
					</div>
					</form>
				</div>
				<script>
					$(document).ready(function() {
						$('#periodo_academico').on('change', function() {
							if ($('#periodo_academico').val() == "") {
								$('#id_p').empty();
								$('<option value = "">Nomenclatura</option>').appendTo('#id_p');
								$('#id_p').attr('disabled', 'disabled');
							} else {
								$('#id_p').removeAttr('disabled', 'disabled');
								$('#id_p').load('core/app/action/listar_grado.php?periodo_academico=' + $('#periodo_academico').val());
							}
						});
					});
					// para que no se abra el select
					$('#id_p').on('mousedown', function(e) {
						e.preventDefault();
						this.blur();
						window.focus();
					});

					$(document).ready(function() {
						$('#periodo_academico').on('change', function() {
							if ($('#periodo_academico').val() == "") {
								$('#p_name').empty();
								$('<option value = "">Nomenclatura</option>').appendTo('#p_name');
								$('#p_name').attr('disabled', 'disabled');
							} else {
								$('#p_name').removeAttr('disabled', 'disabled');
								$('#p_name').load('core/app/action/listar_pname.php?periodo_academico=' + $('#periodo_academico').val());
							}
						});
					});
					// para que no se abra el select
					$('#p_name').on('mousedown', function(e) {
						e.preventDefault();
						this.blur();
						window.focus();
					});
				</script>

			<?php endif; ?>