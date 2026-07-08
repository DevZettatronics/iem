<?php if (isset($_GET["opt"]) && $_GET["opt"] == "byperiod") {
	$period = PeriodData::getById($_GET["id"]);
?>
	<div class="row">
		<div class="col-md-12">
			<h3>Grupos del Periodo: <?php echo $period->name; ?></h3>
			<br>
			<?php
			$teams = TeamData::getAll();
			if (count($teams) > 0) {
				// si hay usuarios
			?>
				<div class="box box-primary">
					<div class="box-body">
						<table class="table table-bordered datatable table-hover">
							<thead>
								<th>Semestre</th>
								<th>Grupo</th>
								<th>Estudiantes</th>
								<th>Asignaturas</th>
								<th></th>
							</thead>
							<?php
							foreach ($teams as $team) {
							?>
								<tr>
									<td><?php echo $team->grade; ?></td>
									<td><?php echo $team->letter; ?></td>
									<td>
										<?php echo count(InscriptionData::getAllByTP($team->id, $period->id)); ?>
									</td>
									<td>
										<?php echo count(AsignationData::getAllByTP($team->id, $period->id)); ?>
									</td>
									<td>
										<a href="index.php?view=teams&opt=general1&id=<?php echo $team->id; ?>&period_id=<?php echo $period->id; ?>" class="btn btn-default btn-small"><i class="fa fa-th-list"></i> Ver Reporte de Calificaciones </a>
									
											<a href="index.php?view=teamasignatures&opt=all&id=<?php echo $team->id; ?>&period_id=<?php echo $period->id; ?>" class="btn btn-default btn-small"><i class="fa fa-th-list"></i> Ver Asignaturas </a>
									</td>
								</tr>
						<?php

							}
							echo "</table></div></div>";
						} else {
							echo "<p class='alert alert-danger'>No hay Grupos</p>";
						}


						?>


					</div>
				</div>



			<?php } elseif (isset($_GET["opt"]) && $_GET["opt"] == "general1") {
			$team = TeamData::getById($_GET["id"]);
			$period = PeriodData::getById($_GET["period_id"]);
			$alumns = InscriptionData::getAllByTP($_GET["id"], $_GET["period_id"]);
			$teacher = PersonData::getById($_GET["id"]); /* para el docente */
			?>

				<div class="row">
					<div class="col-md-12">
						<!--<div class="btn-group">
  								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Modificar Conducta <span class="caret"></span></button>
  								<ul class="dropdown-menu">
								  <?php foreach (AsignationData::getAllByTP($team->id, $period->id) as $asi) : ?>
    									<li><a href="./?view=teams&opt=behavior&asignation_id=<?php echo $asi->id; ?>"><?php echo $asi->getAsignature()->name; ?></a></li>
									<?php endforeach; ?>
  								</ul>
							</div>-->

						<h4><strong>Reporte de Calificaciones</strong> <br><?php echo $team->grade . " - Grupo: " . $team->letter; ?> <br> Ciclo Escolar:<?php echo $period->name; ?></h4>
						<a href="./?view=teams&opt=byperiod&id=<?php echo $period->id; ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>

						<?php
						if (Core::$user->kind == 1 or Core::$user->id == 5) : ?>
							<!--Limite por uso de grupo -->

							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Tomar Asistencia <span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<?php foreach (AsignationData::getAllByTP($team->id, $period->id) as $asi) { ?>
										<li><a href="./?view=teams&opt=assistance&asignation_id=<?php echo $asi->id; ?>"><?php echo $asi->getAsignature()->name; ?></a></li>
									<?php } ?>
								</ul>
							</div>
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Reporte de Asistencia <span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<?php foreach (AsignationData::getAllByTP($team->id, $period->id) as $asi) { ?>
										<li><a href="./?view=teams&opt=assistancereport&asignation_id=<?php echo $asi->id; ?>"><?php echo $asi->getAsignature()->name; ?></a></li>
									<?php } ?>
								</ul>
							</div>

							<div class="btn-group">
								<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Modificar Calificaciones <span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<?php foreach (AsignationData::getAllByTP($team->id, $period->id) as $asi) {
										$url = $asi->asignature_type == 'NUM' ? './?view=editcalifications' : './?view=editcalificationsL';
									?>
										<li><a href="<?php echo $url ?>&id=<?php echo $asi->id; ?>"><?php echo $asi->getAsignature()->name; ?></a></li>
									<?php } ?>
								</ul>
							</div>

						<?php endif; ?>
						<!--FIn del limite por uso de grupo  -->

						<!--- boton de descargar -->
						<!--<a href="report/alumns-word.php?id=<?php echo $team->id; ?>&period_id=<?php echo $period->id; ?>" class="btn btn-default"><i class="fa fa-download"></i> Descargar </a><br><br>--><br><br>
					</div>
				</div>


				<div class="row">
					<div class="col-md-12">

						<?php
						$asignations = AsignationData::getAllByTP($team->id, $period->id);
						if (count($alumns) > 0) {
							// si hay usuarios
						?>
							<div class="box box-primary">
								<div class="box-body">
								<div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
									<table class="table datatable table-bordered table-hover">
										<thead>
											<th>Matrícula</th>
											<th>Nombre</th>
											<?php foreach ($asignations as $a) { ?>
												<th>
													<?php echo $a->getAsignature()->name; ?> <br>
													<div style="color: blue;">
														Docente: <?php echo $a->getTeacher()->name . " " . $a->getTeacher()->lastname; ?>
													</div>
												</th>
											<?php } ?>
										</thead>

										<?php
										foreach ($alumns as $alumnx) {
											$alumn = $alumnx->getAlumn(); ?>
											<tr>
												<td><?php echo $alumn->code; ?></td>
												<td><?php echo $alumn->name . " " . $alumn->lastname; ?></td>

										<?php foreach ($asignations as $a) {
												$pF = CalificationFinalData::promedioFinal($alumn->id, $a->id);
												$calificacion = $pF != NULL ? $pF->calificacion : 'Sin Calificacion';

												echo '<td>' . $calificacion . '</td>';
											}
											echo '</tr>';
										}

										echo "</table></div></div></div>";
									} else {
										echo "<p class='alert alert-danger'>No hay Alumnos</p>";
									}
										?>
								</div>
							</div>


						<?php } elseif (isset($_GET["opt"]) && $_GET["opt"] == "assistance") {
						?>
							<?php
							$asignation = AsignationData::getById($_GET["asignation_id"]);
							$team = TeamData::getById($asignation->team_id);
							$period = PeriodData::getById($asignation->period_id);

							$alumns = InscriptionData::getAllByTP($asignation->team_id, $asignation->period_id);
							?>

							<div class="row">
								<div class="col-md-12">
									<h1>Lista de Asistencia [<?php echo $team->grade . " - " . $team->letter; ?>] [<?php echo $period->name; ?>]</h1>
									<a href="./?view=teams&opt=general1&id=<?php echo $team->id; ?>&period_id=<?php echo $period->id; ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
									<div class="btn-group">
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Tomar Asistencia <span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
											<?php foreach (AsignationData::getAllByTP($team->id, $period->id) as $asi) : ?>
												<li><a href="./?view=teams&opt=assistance&asignation_id=<?php echo $asi->id; ?>"><?php echo $asi->getAsignature()->name; ?></a></li>
											<?php endforeach; ?>
										</ul>
									</div>

									<div class="btn-group">
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Reporte de Asistencia <span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
											<?php foreach (AsignationData::getAllByTP($team->id, $period->id) as $asi) : ?>
												<li><a href="./?view=teams&opt=assistancereport&asignation_id=<?php echo $asi->id; ?>"><?php echo $asi->getAsignature()->name; ?></a></li>
											<?php endforeach; ?>
										</ul>
									</div>

									<!--		<a href="../report/alumns-word.php?id=<?php echo $team->id; ?>&period_id=<?php echo $period->id; ?>" class="btn btn-default"><i class="fa fa-download"></i> Descargar </a><br><br> -->
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<!--	<a href="index.php?view=list&team_id=<?php echo $_GET["team_id"]; ?>" class="btn btn-default"><i class='fa fa-check'></i> Asistencia</a> -->
									<form class="form-horizontal" id="loadlist" role="form">
										<div class="form-group">
											<label for="inputEmail1" class="col-lg-2 control-label">Seleccionar Fecha:</label>
											<div class="col-lg-7">
												<input type="date" name="date_at" value="<?php echo date("Y-m-d"); ?>" required class="form-control">
											</div>
											<div class="col-lg-offset-3">
												<input type="hidden" name="team_id" value="<?php echo $team->id; ?>">
												<input type="hidden" name="period_id" value="<?php echo $period->id; ?>">
												<input type="hidden" name="asignation_id" value="<?php echo $asignation->id; ?>">
												<button type="submit" class="btn btn-primary">Buscar</button>
											</div>

										</div>
									</form>

									<div id="data">
										<p class="alert alert-warning">No hay datos, por favor selecciona una fecha.</p>
									</div>

								</div>
							</div>

							<script>
								$("#loadlist").submit(function(e) {
									e.preventDefault();
									var d = $("#loadlist").serialize();
									$.get("./?action=loadassistance", d, function(data) {
										console.log(data);
										$("#data").html(data);

									});
								});
							</script>


						<?php } elseif (isset($_GET["opt"]) && $_GET["opt"] == "assistancereport") {
						?>
							<?php
							$asignation = AsignationData::getById($_GET["asignation_id"]);
							$team = TeamData::getById($asignation->team_id);
							$period = PeriodData::getById($asignation->period_id);

							$alumns = InscriptionData::getAllByTP($asignation->team_id, $asignation->period_id);
							?>

							<div class="row">
								<div class="col-md-12">
									<h1>Reporte de Asistencia [<?php echo $team->grade . " - " . $team->letter; ?>] [<?php echo $period->name; ?>]</h1>
									<a href="./?view=teams&opt=general1&id=<?php echo $team->id; ?>&period_id=<?php echo $period->id; ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
									<div class="btn-group">
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Tomar Asistencia <span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
											<?php foreach (AsignationData::getAllByTP($team->id, $period->id) as $asi) : ?>
												<li><a href="./?view=teams&opt=assistance&asignation_id=<?php echo $asi->id; ?>"><?php echo $asi->getAsignature()->name; ?></a></li>
											<?php endforeach; ?>
										</ul>
									</div>

									<div class="btn-group">
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Reporte de Asistencia <span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
											<?php foreach (AsignationData::getAllByTP($team->id, $period->id) as $asi) : ?>
												<li><a href="./?view=teams&opt=assistancereport&asignation_id=<?php echo $asi->id; ?>"><?php echo $asi->getAsignature()->name; ?></a></li>
											<?php endforeach; ?>
										</ul>
									</div>

									<!--		<a href="../report/alumns-word.php?id=<?php echo $team->id; ?>&period_id=<?php echo $period->id; ?>" class="btn btn-default"><i class="fa fa-download"></i> Descargar </a><br><br> -->
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-12">
									<!--	<a href="index.php?view=list&team_id=<?php echo $_GET["team_id"]; ?>" class="btn btn-default"><i class='fa fa-check'></i> Asistencia</a> -->
									<form class="form-horizontal" id="loadlist" role="form">
										<div class="form-group">
											<label for="inputEmail1" class="col-lg-2 control-label">Inicio:</label>
											<div class="col-lg-3">
												<input type="date" name="start_at" value="<?php echo date("Y-m-d"); ?>" required class="form-control">
											</div>
											<label for="inputEmail1" class="col-lg-2 control-label">Fin:</label>
											<div class="col-lg-3">
												<input type="date" name="finish_at" value="<?php echo date("Y-m-d"); ?>" required class="form-control">
											</div>
											<div class="col-lg-offset-3">
												<input type="hidden" name="team_id" value="<?php echo $team->id; ?>">
												<input type="hidden" name="period_id" value="<?php echo $period->id; ?>">
												<input type="hidden" name="asignation_id" value="<?php echo $asignation->id; ?>">
												<button type="submit" class="btn btn-primary">Buscar</button>
											</div>

										</div>
									</form>

									<div id="data">
										<p class="alert alert-warning">No hay datos, por favor selecciona una fecha.</p>
									</div>

								</div>
							</div>

							<script>
								$("#loadlist").submit(function(e) {
									e.preventDefault();
									var d = $("#loadlist").serialize();
									$.get("./?action=loadlist", d, function(data) {
										console.log(data);
										$("#data").html(data);

									});
								});
							</script>



						<?php } elseif (isset($_GET["opt"]) && $_GET["opt"] == "behaviorreport") {
						?>
							<?php
							$asignation = AsignationData::getById($_GET["asignation_id"]);
							$team = TeamData::getById($asignation->team_id);
							$period = PeriodData::getById($asignation->period_id);

							$alumns = InscriptionData::getAllByTP($asignation->team_id, $asignation->period_id);
							?>

							<div class="row">
								<div class="col-md-12">
									<h1>Reporte de Conducta [<?php echo $team->grade . " - " . $team->letter; ?>] [<?php echo $period->name; ?>]</h1>
									<a href="./?view=teams&opt=general1&id=<?php echo $team->id; ?>&period_id=<?php echo $period->id; ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
									<div class="btn-group">
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Modificar Conducta <span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
											<?php foreach (AsignationData::getAllByTP($team->id, $period->id) as $asi) : ?>
												<li><a href="./?view=teams&opt=assistance&asignation_id=<?php echo $asi->id; ?>"><?php echo $asi->getAsignature()->name; ?></a></li>
											<?php endforeach; ?>
										</ul>
									</div>

									<div class="btn-group">
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Reporte de Conducta <span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
											<?php foreach (AsignationData::getAllByTP($team->id, $period->id) as $asi) : ?>
												<li><a href="./?view=teams&opt=behaviorreport&asignation_id=<?php echo $asi->id; ?>"><?php echo $asi->getAsignature()->name; ?></a></li>
											<?php endforeach; ?>
										</ul>
									</div>

									<!--		<a href="../report/alumns-word.php?id=<?php echo $team->id; ?>&period_id=<?php echo $period->id; ?>" class="btn btn-default"><i class="fa fa-download"></i> Descargar </a><br><br> -->
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-12">
									<!--	<a href="index.php?view=list&team_id=<?php echo $_GET["team_id"]; ?>" class="btn btn-default"><i class='fa fa-check'></i> Asistencia</a> -->
									<form class="form-horizontal" id="loadlist" role="form">
										<div class="form-group">
											<label for="inputEmail1" class="col-lg-2 control-label">Inicio:</label>
											<div class="col-lg-3">
												<input type="date" name="start_at" value="<?php echo date("Y-m-d"); ?>" required class="form-control">
											</div>
											<label for="inputEmail1" class="col-lg-2 control-label">Fin:</label>
											<div class="col-lg-3">
												<input type="date" name="finish_at" value="<?php echo date("Y-m-d"); ?>" required class="form-control">
											</div>
											<div class="col-lg-offset-3">
												<input type="hidden" name="team_id" value="<?php echo $team->id; ?>">
												<input type="hidden" name="period_id" value="<?php echo $period->id; ?>">
												<input type="hidden" name="asignation_id" value="<?php echo $asignation->id; ?>">
												<button type="submit" class="btn btn-primary">Buscar</button>
											</div>

										</div>
									</form>

									<div id="data">
										<p class="alert alert-warning">No hay datos, por favor selecciona una fecha.</p>
									</div>

								</div>
							</div>

							<script>
								$("#loadlist").submit(function(e) {
									e.preventDefault();
									var d = $("#loadlist").serialize();
									$.get("./?action=loadlistbehavior", d, function(data) {
										console.log(data);
										$("#data").html(data);

									});
								});
							</script>

						<?php } elseif (isset($_GET["opt"]) && $_GET["opt"] == "behavior") {
						?>
							<?php
							$asignation = AsignationData::getById($_GET["asignation_id"]);
							$team = TeamData::getById($asignation->team_id);
							$period = PeriodData::getById($asignation->period_id);

							$alumns = InscriptionData::getAllByTP($asignation->team_id, $asignation->period_id);
							?>

							<div class="row">
								<div class="col-md-12">
									<h1>Lista de Conducta [<?php echo $team->grade . " - " . $team->letter; ?>] [<?php echo $period->name; ?>]</h1>
									<a href="./?view=teams&opt=general1&id=<?php echo $team->id; ?>&period_id=<?php echo $period->id; ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
									<div class="btn-group">
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Modificar Conducta <span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
											<?php foreach (AsignationData::getAllByTP($team->id, $period->id) as $asi) : ?>
												<li><a href="./?view=teams&opt=hehavior&asignation_id=<?php echo $asi->id; ?>"><?php echo $asi->getAsignature()->name; ?></a></li>
											<?php endforeach; ?>
										</ul>
									</div>

									<div class="btn-group">
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Reporte de Conducta <span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
											<?php foreach (AsignationData::getAllByTP($team->id, $period->id) as $asi) : ?>
												<li><a href="./?view=teams&opt=behaviorreport&asignation_id=<?php echo $asi->id; ?>"><?php echo $asi->getAsignature()->name; ?></a></li>
											<?php endforeach; ?>
										</ul>
									</div>

									<!--		<a href="../report/alumns-word.php?id=<?php echo $team->id; ?>&period_id=<?php echo $period->id; ?>" class="btn btn-default"><i class="fa fa-download"></i> Descargar </a><br><br> -->
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<!--	<a href="index.php?view=list&team_id=<?php echo $_GET["team_id"]; ?>" class="btn btn-default"><i class='fa fa-check'></i> Asistencia</a> -->
									<form class="form-horizontal" id="loadlist" role="form">
										<div class="form-group">
											<label for="inputEmail1" class="col-lg-2 control-label">Seleccionar Fecha:</label>
											<div class="col-lg-7">
												<input type="date" name="date_at" value="<?php echo date("Y-m-d"); ?>" required class="form-control">
											</div>
											<div class="col-lg-offset-3">
												<input type="hidden" name="team_id" value="<?php echo $team->id; ?>">
												<input type="hidden" name="period_id" value="<?php echo $period->id; ?>">
												<input type="hidden" name="asignation_id" value="<?php echo $asignation->id; ?>">
												<button type="submit" class="btn btn-primary">Buscar</button>
											</div>

										</div>
									</form>

									<div id="data">
										<p class="alert alert-warning">No hay datos, por favor selecciona una fecha.</p>
									</div>

								</div>
							</div>

							<script>
								$("#loadlist").submit(function(e) {
									e.preventDefault();
									var d = $("#loadlist").serialize();
									$.get("./?action=loadbehavior", d, function(data) {
										console.log(data);
										$("#data").html(data);

									});
								});
							</script>

						<?php } elseif (isset($_GET["opt"]) && $_GET["opt"] == "all") {
						?>

							<div class="row">
								<div class="col-md-12">
									<h1>Grupos</h1>
									<a href="index.php?view=newteam" class="btn btn-default"><i class='fa fa-th-list'></i> Nuevo Grupo</a>
									<br>
									<br>
									<?php
									$teams = TeamData::getAll();
									if (count($teams) > 0) {
										// si hay usuarios
									?>
										<div class="box box-primary">
											<div class="box-body">
											<div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
												<table class="table table-bordered datatable table-hover">
													<thead>
														<th class="text-center">Programa y Grupo</th>
														<th>Primero</th>
														<th>Segundo</th>
														<th>Tercero</th>
														<th>Cuarto</th>
														<th>Quinto</th>
														<th>Sexto</th>
														<th>Septimo</th>
														<th>Octavo</th>
														<th>Noveno</th>
														<th>Décimo</th>
														<th>Onceavo</th>
														<th>Doceavo</th>
														<th>Editar</th>
														<th>Borrar</th>
													</thead>
													<?php
													foreach ($teams as $team) {

													?>
														<tr>

															<td><?php echo  $team->grade . "--" . $team->letter; ?></td>
															<td><?php if ($team->semestre == 1) { ?><center><i class="fa fa-check" style="color:#14A1D9;"></i><span class="label label-primary"> Activo</span></center><?php } else { ?><span class="label label-warning"> Inactivo</span><?php } ?></td>
															<td><?php if ($team->semestre == 2) { ?><center><i class="fa fa-check" style="color:#14A1D9;"></i><span class="label label-primary"> Activo</span></center><?php } else { ?><span class="label label-warning"> Inactivo</span><?php } ?></td>
															<td><?php if ($team->semestre == 3) { ?><center><i class="fa fa-check" style="color:#14A1D9;"></i><span class="label label-primary"> Activo</span></center><?php } else { ?><span class="label label-warning"> Inactivo</span><?php } ?></td>
															<td><?php if ($team->semestre == 4) { ?><center><i class="fa fa-check" style="color:#14A1D9;"></i><span class="label label-primary"> Activo</span></center><?php } else { ?><span class="label label-warning"> Inactivo</span><?php } ?></td>
															<td><?php if ($team->semestre == 5) { ?><center><i class="fa fa-check" style="color:#14A1D9;"></i><span class="label label-primary"> Activo</span></center><?php } else { ?><span class="label label-warning"> Inactivo</span><?php } ?></td>
															<td><?php if ($team->semestre == 6) { ?><center><i class="fa fa-check" style="color:#14A1D9;"></i><span class="label label-primary"> Activo</span></center><?php } else { ?><span class="label label-warning"> Inactivo</span><?php } ?></td>
															<td><?php if ($team->semestre == 7) { ?><center><i class="fa fa-check" style="color:#14A1D9;"></i><span class="label label-primary"> Activo</span></center><?php } else { ?><span class="label label-warning"> Inactivo</span><?php } ?></td>
															<td><?php if ($team->semestre == 8) { ?><center><i class="fa fa-check" style="color:#14A1D9;"></i><span class="label label-primary"> Activo</span></center><?php } else { ?><span class="label label-warning"> Inactivo</span><?php } ?></td>
															<td><?php if ($team->semestre == 9) { ?><center><i class="fa fa-check" style="color:#14A1D9;"></i><span class="label label-primary"> Activo</span></center><?php } else { ?><span class="label label-warning"> Inactivo</span><?php } ?></td>
															<td><?php if ($team->semestre == 10) { ?><center><i class="fa fa-check" style="color:#14A1D9;"></i><span class="label label-primary"> Activo</span></center><?php } else { ?><span class="label label-warning"> Inactivo</span><?php } ?></td>
															<td><?php if ($team->semestre == 11) { ?><center><i class="fa fa-check" style="color:#14A1D9;"></i><span class="label label-primary"> Activo</span></center><?php } else { ?><span class="label label-warning"> Inactivo</span><?php } ?></td>
															<td><?php if ($team->semestre == 12) { ?><center><i class="fa fa-check" style="color:#14A1D9;"></i><span class="label label-primary"> Activo</span></center><?php } else { ?><span class="label label-warning"> Inactivo</span><?php } ?></td>

															<td>
																<div class="btn-group">
																	<a href="index.php?view=editteam&id=<?php echo $team->id; ?>"><button type="button" class="btn btn-primary "><i class="fa fa-edit"></i></button><i>Editar</i></a>
																</div>
															</td>
															<td>
																<div class="btn-group">
																	<a href="index.php?action=delteam&id=<?php echo $team->id; ?>"><button type="button" class="btn btn-danger "><i class="fa fa-trash"></i></button><i style="color:#ff0000;">Borrar</i></a>
																</div>
															</td>

														</tr>
												<?php

													}
													echo "</table></div></div></div>";
												} else {
													echo "<p class='alert alert-danger'>No hay Grupos</p>";
												}


												?>


											</div>
										</div>
									<?php } ?>