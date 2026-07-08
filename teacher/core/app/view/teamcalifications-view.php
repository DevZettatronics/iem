<?php
$asignation = AsignationData::getById($_GET["id"]);
$period = PeriodData::getById($asignation->period_id);
$team = TeamData::getById($asignation->team_id);
$alumns = InscriptionData::getAllByTP($asignation->team_id, $asignation->period_id);
$blocks = BlockData::getParentsByAsignationId($_GET["id"]);
$totalBlocks = count($blocks);
$con = Database::getCon();

if ($totalBlocks > 0) {
?>
<html lang="es">
	<div class="row">
		<div class="col-md-12">
			<h4><strong>Asignar Calificaciones</strong> <br>Asignatura: <?php echo $asignation->getAsignature()->name; ?> <br>Grupo: <?php echo $team->grade . " - " . $team->letter; ?> <br> Ciclo Escolar: <?php echo $period->name; ?></h4>
			<a href="./?view=teamalumns&id=<?php echo $asignation->id; ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
			<br><br>
			<?php if (count($alumns) > 0) : ?>
			<?php endif; ?>
			<?php

			if (count($alumns) > 0) {
				// si hay usuarios
			?>
				<div class="box box-primary">
					<div class="box-body">
						<form method="post" action="./?action=saveteamcalifications">
							<input type="hidden" name="asignation_id" value="<?php echo $asignation->id; ?>">
							<table class="table table-bordered table-hover">
								<thead>
									<th>Matrícula</th>
									<th>Nombre</th>
									<?php foreach ($blocks as $b) {
										echo "<th>" .  $b->name . "</th>";
									} ?>
									<th>Promedio</th>
								</thead>
								<?php foreach ($alumns as $alumnx) {
									$alumn = $alumnx->getAlumn(); ?>
									<tr>
										<td><?php echo $alumn->code; ?></td>
										<td><?php echo $alumn->name . " " . $alumn->lastname; ?></td>

										<?php
										$suma = 0;
										foreach ($blocks as $b) {
											$subs = BlockData::getAllByBlockId($b->id);
											$byIdFatherBlocks = CalificationData::getAllByIdFather($alumn->id, $b->id);
											$byIdFather = CalificationData::getAllByIdFatherSumado($alumn->id, $b->id);
											$totalhijos = count($byIdFatherBlocks);

											foreach ($byIdFather as $b) {
												$calificacionSQL = $b->Calificacion;
											}
											if (!empty($calificacionSQL)) {

												$promedio = bcdiv($calificacionSQL / $totalhijos, '1', 1);
											} else {
												$promedio = 'Aun no hay calificaciones';
											}
										?>
											<td>
												<?php
												$ppe = 0;
												foreach ($subs as $sb) { ?>
													<?php
													$exist = CalificationData::getExist($alumn->id, $sb->id);

													?>
													<div class="input-group">
														<span class="input-group-addon" id="basic-addon1"><?php echo $sb->name; ?></span>
														<input placeholder="Calificacion" data-type="currency" type="text" id="calificacion" class="form-control calificacion" pattern="[N]A|[N]P|[/^([0-9]+\.?[0-9{0,2})$/]|[1]0" name="val-<?php echo $alumn->id; ?>-<?php echo $sb->id; ?>" value="<?php if ($exist != null) {
																																																														echo $exist->val;
																																																													} ?>">
													</div>
												<?php }

												if ($totalhijos > 0) { ?>
													<div class="input-group">
														<span class="input-group-addon" id="basic-addon1">Promedio</span>
														<input type="text" class="form-control" readonly value="<?php echo $promedio ?>" placeholder="Promedio">
													</div>
												<?php }
												if ($exist != null) {
													$ppe += $promedio;
													$suma += $promedio;
													$opeacionPromedioFinal = $suma / $totalBlocks;
													$promedioFinal = round($opeacionPromedioFinal);
												}
												?>
											</td>
										<?php }
										if ($exist != null) {
										?>
											<td><input class="form-control text-center" type="text" value="<?php echo $promedioFinal ?>" placeholder="Promedio" readonly></td>
									</tr>
							<?php }
									} ?>

							</table>
							<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
							<button type="button" class="btn btn-secondary"><a href="./?view=actacalificaciones&id=<?php echo $asignation->id; ?>"><i class='fa fa-print'></i> Imprimir Acta Definitiva </a> </button>

						</form>
					</div>
				</div>
			<?php } else {
				echo "<p class='alert alert-danger'>No hay Alumnos</p>";
			}
			?>
		</div>
	</div>
<?php } else {
	echo "<p class='alert alert-danger'>No hay Bloques de Calificaciones Asignados</p>";
} ?>
<script>
	// Jquery Dependency

	$(".calificacion").on({
		blur: function(e) {
			formatCurrency($(this));
		},
	});

	function formatNumber(n) {
		return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
	}

	function formatCurrency(input) {

		var input_val = input.val();
		if (input_val === "") {
			return;
		}

		var original_len = input_val.length;
		if ((input_val > 10 || input_val < 0.99) || (input_val > 0.99 && input_val < 5)) {
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: 'No puedes asignar calificaciones menores a 5 o mayores a 10',
			})
			input.val("");

			

		} else if (input_val.indexOf(".") >= 0) {
			var decimal_pos = input_val.indexOf(".");
			var left_side = input_val.substring(0, decimal_pos);
			var right_side = input_val.substring(decimal_pos);
			left_side = formatNumber(left_side);
			right_side = formatNumber(right_side);
			right_side = right_side.substring(0, 1);
			input_val = left_side + "." + right_side;
			input.val(input_val);
		}
	}
</script>