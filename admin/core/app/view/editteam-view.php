<?php
$team = TeamData::getById($_GET["id"]);
$program_i = $team->id_program;
if ($program_i == null or $program_i == 0) {
	$program_i = 0;
} else {
	$program_i = $team->id_program;
}


$program = EducationalProgramData::getById($program_i);

if ($program == null) {

	$nom_p = "SELECCIONAR PROGRAMA EDUCATIVO";
	$grade_p = "";
	$type_p = "";
} else {
	$nom_p = $program->name;
	$grade_p = $program->grade;
	$type_p = $program->type;
}

// $edi=new TeamData();
// $edit=$edi->getL($r,$_GET["id"]);
// $nomenclatura= $edit[1][0]['nomenclatura']

?>
<div class="row">
	<div class="col-md-12">
		<h1>Editar Grupo</h1>
		<br>
		<form class="form-horizontal" method="post" id="addcategory" action="index.php?action=updateteam" role="form">
			<!-- EDITACION ACTIVA -->
			<div class="form-group">
				<label for="inputEmail1" class="col-lg-2 control-label">Programa*</label>
				<div class="col-md-3">
					<select name="programa" id="programa" data-live-search="true" class="form-control select" required>
						<option value="<?php echo $program_i; ?>"><?php echo $nom_p; ?></option>
						<?php foreach (EducationalProgramData::getAll() as $al): ?>
							<option value="<?php echo $al->id; ?>"><?php echo $al->name; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-3" hidden>
					<select name="name" id="name" class="form-control select">
						<option value=""></option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail1" class="col-lg-2 control-label">Grado*</label>
				<div class="col-md-6">
					<div class="col-md-6">
						<input type="text" name="grade" required value="<?php echo $team->grade; ?>"
							class="form-control" id="grade" placeholder="Grado" readonly>
					</div>
				</div>
			</div>
			<!-- <div class="form-group">
				<label for="inputEmail1" class="col-lg-2 control-label no-arrow">Nivel*</label>
				<div class="col-md-3">
					<select name="li" id="li" class="form-control select">
						<option value="<?php echo $grade_p; ?>"><?php echo $grade_p; ?></option>
					</select>
				</div>
				<label for="inputEmail1" class="col-lg-2 control-label no-arrow">Tipo*</label>
				<div class="col-md-3">
					<select name="ti" id="ti" class="form-control select">
						<option value="<?php echo $type_p; ?>"><?php echo $grade_p; ?></option>
					</select>
				</div>
			</div> -->
			<div class="form-group">

				<label for="inputEmail1" class="col-lg-2 control-label">Grupo*</label>
				<div class="col-md-3">
					<input type="text" name="letter" required class="form-control" id="letter"
						value="<?php echo $team->letter; ?>" placeholder="Grupo ###">
				</div>

				<label for="modalidadBD" class="col-lg-2 control-label no-arrow">Modalidad*</label>
				<div class="col-md-3">
					<?php
						$con = Database::getCon();
						$modalidadSeleccionada = (int)$team->modalidad;

						$sql = "SELECT id_modalidad, nombre FROM modalidad";
						$query = mysqli_query($con, $sql);
					?>
					<select name="modalidadBD" id="modalidadBD" class="form-control select">
						
						<option value="0" <?php echo ($modalidadSeleccionada === 0) ? 'selected' : ''; ?>>
							Selecciona una modalidad
						</option>

						<?php while ($row = mysqli_fetch_assoc($query)) { ?>
							<option value="<?php echo $row['id_modalidad']; ?>"
								<?php echo ($row['id_modalidad'] == $modalidadSeleccionada) ? 'selected' : ''; ?>>
								<?php echo $row['nombre']; ?>
							</option>
						<?php } ?>

					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail1" class="col-lg-2 control-label">Historial al que sera asignado*</label>
				<div class="col-md-3">
					<?php
					$con = Database::getCon();
					$sql2 = "SELECT * FROM historiales_categoria WHERE id_identificador = '" . $team->id_identifica . "'";
					$query2 = mysqli_query($con, $sql2);
					$row2 = mysqli_fetch_array($query2);
					$name_historial = $row2['name'];
					?>
					<select class="form-control" name="id_identifica" id="id_identifica">
						<option value="<?php echo $team->id_identifica; ?>"><?php echo $name_historial; ?></option>
						<?php
						$sql_3 = "SELECT * FROM historiales_categoria";
						$query_3 = mysqli_query($con, $sql_3);
						while ($row_3 = mysqli_fetch_array($query_3)) {
							?>
							<option value="<?php echo $row_3['id_identificador'] ?>"><?php echo ($row_3['name']) ?></option>
							<?php
						}
						?>
					</select>
				</div>
			</div>
			<!-- EDICION ACTIVA FIN -->
			<?php
			if ($team->semestre == 1) {
				$ck1 = "checked";
			} else {
				$ck1 = "";
			}
			if ($team->semestre == 2) {
				$ck2 = "checked";
			} else {
				$ck2 = "";
			}
			if ($team->semestre == 3) {
				$ck3 = "checked";
			} else {
				$ck3 = "";
			}
			if ($team->semestre == 4) {
				$ck4 = "checked";
			} else {
				$ck4 = "";
			}
			if ($team->semestre == 5) {
				$ck5 = "checked";
			} else {
				$ck5 = "";
			}
			if ($team->semestre == 6) {
				$ck6 = "checked";
			} else {
				$ck6 = "";
			}
			if ($team->semestre == 7) {
				$ck7 = "checked";
			} else {
				$ck7 = "";
			}
			if ($team->semestre == 8) {
				$ck8 = "checked";
			} else {
				$ck8 = "";
			}
			if ($team->semestre == 9) {
				$ck9 = "checked";
			} else {
				$ck9 = "";
			}

			if ($team->semestre == 10) {
				$ck10 = "checked";
			} else {
				$ck10 = "";
			}

			if ($team->semestre == 11) {
				$ck11 = "checked";
			} else {
				$ck11 = "";
			}

			if ($team->semestre == 12) {
				$ck12 = "checked";
			} else {
				$ck12 = "";
			}
			?>


			<label class="col-lg-2 control-label">Activación de Semestre</label>
			<div class="col-sm-6">
				<div class="box box-success">
					<div class="box-body">
						<div class="table-responsive ">
							<table class="table table-condensed table-hover table-striped">

								<th class='text-center'>Semestre </th>
								<th class='text-center'>Seleccione</th>

								<tr>
									<td>Primero</td>
									<td class='text-center'><input type="radio" name="ck" value="1" <?php echo $ck1 ?>>
									</td>
								</tr>
								<tr>
									<td>Segundo</td>
									<td class='text-center'><input type="radio" name="ck" value="2" <?php echo $ck2 ?>>
									</td>
								</tr>
								<tr>
									<td>Tercero</td>
									<td class='text-center'><input type="radio" name="ck" value="3" <?php echo $ck3 ?>>
									</td>
								</tr>
								<tr>
									<td>Cuarto</td>
									<td class='text-center'><input type="radio" name="ck" value="4" <?php echo $ck4 ?>>
									</td>
								</tr>
								<tr>
									<td>Quinto</td>
									<td class='text-center'><input type="radio" name="ck" value="5" <?php echo $ck5 ?>>
									</td>
								</tr>
								<tr>
									<td>Sexto</td>
									<td class='text-center'><input type="radio" name="ck" value="6" <?php echo $ck6 ?>>
									</td>
								</tr>
								<tr>
									<td>Septimo</td>
									<td class='text-center'><input type="radio" name="ck" value="7" <?php echo $ck7 ?>>
									</td>
								</tr>
								<tr>
									<td>Octavo</td>
									<td class='text-center'><input type="radio" name="ck" value="8" <?php echo $ck8 ?>>
									</td>
								</tr>
								<tr>
									<td>Noveno</td>
									<td class='text-center'><input type="radio" name="ck" value="9" <?php echo $ck9 ?>>
									</td>
								</tr>
								<tr>
									<td>Décimo</td>
									<td class='text-center'><input type="radio" name="ck" value="10" <?php echo $ck10 ?>>
									</td>
								</tr>
								<tr>
									<td>Onceavo</td>
									<td class='text-center'><input type="radio" name="ck" value="11" <?php echo $ck11 ?>>
									</td>
								</tr>
								<tr>
									<td>Doceavo</td>
									<td class='text-center'><input type="radio" name="ck" value="12" <?php echo $ck12 ?>>
									</td>
								</tr>

							</table>
						</div>
						<!------>
						<div class="col-md-12">
							<div class="form-group">
								<div class="col-lg-offset-4 ">
									<input type="hidden" name="team_id" value="<?php echo $team->id; ?>">
									<button type="submit" class="btn btn-success">Actualizar Grupo</button>
								</div>
							</div>
						</div>
						<!------>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	$(document).ready(function () {
		$('#programa').on('change', function () {
			if ($('#programa').val() == "") {
				$('#li').empty();
				$('<option value = "">Nivel</option>').appendTo('#li');
				$('#li').attr('disabled', 'disabled');
			} else {
				$('#li').removeAttr('disabled', 'disabled');
				$('#li').load('core/app/action/listar_licenciatura.php?programa=' + $('#programa').val());
			}
		});
	});
	// para que no se abra el select
	$('#li').on('mousedown', function (e) {
		e.preventDefault();
		this.blur();
		window.focus();
	});

	$(document).ready(function () {
		$('#programa').on('change', function () {
			if ($('#programa').val() == "") {
				$('#ti').empty();
				$('<option value = "">Tipo</option>').appendTo('#ti');
				$('#ti').attr('disabled', 'disabled');
			} else {
				$('#ti').removeAttr('disabled', 'disabled');
				$('#ti').load('core/app/action/listar_tipo.php?programa=' + $('#programa').val());
			}
		});
	});
	// para que no se abra el select
	$('#ti').on('mousedown', function (e) {
		e.preventDefault();
		this.blur();
		window.focus();
	});

	$(document).ready(function () {
		$('#programa').on('change', function () {
			if ($('#programa').val() == "") {
				$('#name').empty();
				$('<option value = "">Tipo</option>').appendTo('#name');
				$('#name').attr('disabled', 'disabled');
			} else {
				$('#name').removeAttr('disabled', 'disabled');
				$('#name').load('core/app/action/listar_nombreP.php?programa=' + $('#programa').val());
			}
		});
	});
	// para que no se abra el select
	$('#name').on('mousedown', function (e) {
		e.preventDefault();
		this.blur();
		window.focus();
	});
</script>
<script>
	// $('.select').selectpicker();
	$('[id="programa"]').selectpicker();
</script>