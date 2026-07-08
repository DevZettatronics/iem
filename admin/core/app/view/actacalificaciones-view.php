<?php
$asignation = AsignationData::getById($_GET["id"]);
$period = PeriodData::getById($asignation->period_id);
$team = TeamData::getById($asignation->team_id);
$alumns = InscriptionData::getAllByTP($asignation->team_id, $asignation->period_id);
$blocks = BlockData::getParentsByAsignationId($_GET["id"]);
?>
<div class="row">
	<div class="col-md-12">
		<img src="../assets/images/IEMcorreos.png" width="200" height="52" alt="" />
		<h4>Acta Definitiva de Calificaciones <br></h4>
		<h5><b>Asignatura:</b>
			<?php echo $asignation->getAsignature()->name; ?> <br>
			<b>Grupo:</b>
			<?php echo $team->grade . " - " . $team->letter; ?>
			<b>Ciclo Escolar:</b>
			<?php echo $period->name; ?>
		</h5>
		<?php if (count($alumns) > 0): ?>
		<?php endif; ?>
		<?php
		if (count($alumns) > 0) {
			// si hay usuarios
			?>
			<div class="box box-primary">
				<div class="box-body">
					<!--<form method="post" action="./?action=saveteamcalifications">-->
					<input type="hidden" name="asignation_id" value="<?php echo $asignation->id; ?>">
					<table class="table table-bordered table-hover">
						<thead>
							<th>No.</th>
							<th>Matrícula</th>
							<th>Nombre del Estudiante</th>
							<?php foreach ($blocks as $b): ?>
								<th>
									<?php echo $b->name; ?>
								</th>
							<?php endforeach; ?>
							<th>Promedio</th>
						</thead>
						<?php
						foreach ($alumns as $alumnx) {
							$alumn = $alumnx->getAlumn();
							?>
							<tr>
								<td style="font-size: 11px">
									<?php echo $alumn->id_into_group; ?>
								</td>
								<td style="font-size: 11px">
									<?php echo $alumn->code; ?>
								</td>
								<td style="font-size: 11px">
									<?php echo $alumn->name . " " . $alumn->lastname; ?>
								</td>
								<?php
								$cnt = 0;
								$sum = 0;
								foreach ($blocks as $b) {
									$subs = BlockData::getAllByBlockId($b->id);
									?>
									<td align="center">
										<?php
										$pp = 0;
										$cc = 0;
										foreach ($subs as $sb): ?>
											<?php
											$exist = CalificationData::getExist($alumn->id, $sb->id);
											if ($exist != null) {
												$cnt++;
												$sum += $exist->val;
												$cc++;
												$pp += $exist->val;
											}
											?>
											<!-- 	<div class="input-group">
												<span class="input-group-addon" id="basic-addon1"><?php echo $sb->name; ?></span>
												<input type="text" class="form-control" name="val-<?php echo $alumn->id; ?>-<?php echo $sb->id; ?>" value="<?php if ($exist != null) {
														  echo $exist->val;
													  } ?>" placeholder="<?php echo $sb->name; ?>">
											</div> -->
										<?php endforeach; ?>
										<?php if (count($subs) > 0): ?>
											<div class="input-group">
												<!--<span class="input-group-addon" id="basic-addon1">Promedio</span>-->
												<!--       		 <input type="fname" class="form-control" readonly value="<?php if ($pp > 0 && $cc > 0) {
													echo $pp / $cc;
												} ?>" placeholder="Promedio">-->
												<!--Etiqueta que asigna la calificacion de promedio 2020-->
												<label>
													<?php if ($pp > 0 && $cc > 0) {
														echo $pp / $cc;
													} elseif ($exist->val == 'AC') {
														echo $exist->val;
													} elseif ($exist->val == 'NA') {
														echo $exist->val;
													} elseif ($exist->val == 'NP') {
														echo $exist->val;
													} else {
														echo "Error";
													} ?>
												</label>
											</div>
										<?php endif; ?>
									</td>
								<?php } ?>
								<td>
									<b>
										<center>
											<?php if ($cnt > 0 && $sum > 0) {
												echo round($sum / $cnt);
											} elseif ($exist->val == 'AC') {
												echo 10;
											} elseif ($exist->val == 'NP') {
												echo 'No Presento';
											} elseif ($exist->val == 'NA') {
												echo 5;
											} else {
												echo 'Error';
											}
											; ?>
										</center>
									</b>
								</td>
							</tr>
							<?php
						}
						echo "</table>"; ?>
						<table>
							<tr>
								<td colspan="4" align="center">Se expide la presente acta en la Ciudad de México con fecha
									del
									<?php $arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
									$arrayDias = array('Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado');
									echo $arrayDias[date('w')] . ", " . date('d') . " de " . $arrayMeses[date('m') - 1] . " de " . date('Y');
									?>
								</td>
							</tr>
							<tr>
								<td></td>
								<td align="center" style="padding-top: 50px">__________________________</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td align="center" style="padding-bottom: 40px">
									<?php if (isset($_SESSION["teacher_id"])) {
										echo PersonData::getById($_SESSION["teacher_id"])->name;
									} ?>
									<?php if (isset($_SESSION["teacher_id"])) {
										echo PersonData::getById($_SESSION["teacher_id"])->lastname;
									} ?> <br> Firma del Docente
								</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td align="center" colspan="4"><button class="btn btn-default" onclick="window.print()"><i
											class="fa fa-download"></i> Imprimir o Guardar <i
											class="fa fa-print"></i></button></td>
							</tr>
						</table>
						<?php
						echo "</div></div>";
		} else {
			echo "<p class='alert alert-danger'>No hay Alumnos</p>";
		}
		?>
			</div>
		</div>