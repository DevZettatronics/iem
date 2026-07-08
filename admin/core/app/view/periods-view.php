<?php if (isset($_GET["opt"]) && $_GET["opt"] == "all") : ?>

	<div class="row">

		<div class="col-md-12">

			<div class="btn-group pull-right">

				<a href="./?view=periods&opt=new" class="btn btn-default"><i class='fa fa-th-list'></i> Nuevo Periodo</a>

			</div>

			<h1>Periodos</h1>

			<br>

			<?php



			$teams = PeriodData::getAll();

			if (count($teams) > 0) {

				// si hay usuarios

				$yetstarted = false;

				foreach ($teams as $t) {

					if ($t->is_started && !$t->is_finished) {

						$yetstarted = true;

					}

					break;

				}

			?>

				<div class="box box-primary">

					<div class="box-body">

						<table class="table table-bordered datatable table-hover">

							<thead>

								<th>Nombre</th>

								<th>Periodo</th>

								<th>Terminado</th>

								<th></th>

							</thead>

							<?php

							foreach ($teams as $team) {



								$p = $team->periodo;

								$b1 = PeriodTypeData::getById($p);

							?>

								<tr>

									<td><?php echo $team->name; ?></td>



									<td><?php if ($b1 != null) {

											echo $b1->tipo;

										} ?></td><!-- cuando el campo esta basio -->

									<td>

										<?php if ($team->is_finished) : ?>

											<i class="fa fa-check"></i>

										<?php endif; ?>

									</td>

									<td style="width:300px;">

										<?php if (!$team->is_finished) : ?>

											<a href="./?action=periods&opt=setfinished&id=<?php echo $team->id; ?>" class="btn btn-default btn-xs">Finalizar periodo</a>

										<?php endif; ?>

										<a href="index.php?view=periods&opt=edit&id=<?php echo $team->id; ?>" class="btn btn-warning btn-xs">Editar</a> 
										<a href="index.php?action=periods&opt=del&id=<?php echo $team->id; ?>" class="btn btn-danger btn-xs">Eliminar</a>

									</td>

								</tr>

						<?php

							}

							echo "</table></div></div>";

						} else {

							echo "<p class='alert alert-danger'>No hay Periodos</p>";

						}

						?>

					</div>

				</div>

			<?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "new") : ?>

				<div class="row">

					<div class="col-md-12">

						<h1>Nuevo Periodo</h1>

						<br>

						<form class="form-horizontal" method="post" id="addcategory" action="./?action=periods&opt=add" role="form">



							<div class="form-group">

								<label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>

								<div class="col-md-8">

									<input type="text" name="name" required class="form-control" id="name" placeholder="Nombre">

								</div>

							</div>

							<!-- Periodo -->

							<div class="form-group">

								<label for="inputEmail1" class="col-lg-2 control-label">Periodo*</label>

								<div class="col-md-8">

									<select class="form-control" name="periodo" id="periodo">

										<option value="NULL">-- SELECCIONE --</option>

										<?php foreach (PeriodTypeData::getAll() as $periodos) : ?>

											<option value="<?php echo $periodos->id_type; ?>"><?php echo $periodos->tipo; ?></option>

										<?php endforeach; ?>

									</select>

								</div>

							</div>



							<div class="form-group">

								<label for="inputEmail1" class="col-lg-2 control-label">Inicio*</label>

								<div class="col-md-3">

									<input type="date" name="start_at" class="form-control" id="name" placeholder="Inicio">

								</div>

								<label for="inputEmail1" class="col-lg-2 control-label">Fin*</label>

								<div class="col-md-3">

									<input type="date" name="finish_at" class="form-control" id="name" placeholder="Fin">

								</div>

							</div>



							<div class="form-group">

								<div class="col-lg-offset-2 col-lg-10">

									<button type="submit" class="btn btn-primary">Agregar Periodo</button>

								</div>

							</div>

						</form>

					</div>

				</div>

			<?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "edit") :

			$a = PeriodData::getById($_GET["id"]);

			?>

				<div class="row">

					<div class="col-md-12">

						<h1>Editar Periodo</h1>

						<br>

						<form class="form-horizontal" method="post" id="addcategory" action="./?action=periods&opt=update" role="form">

							<div class="form-group">

								<label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>

								<div class="col-md-6">

									<input type="text" name="name" value="<?php echo $a->name; ?>" required class="form-control" id="name" placeholder="Nombre">

								</div>

							</div>

							<div class="form-group">

								<label for="inputEmail1" class="col-lg-2 control-label">Periodo</label>

								<?php

								$con = Database::getCon();

								$sql_po = "SELECT * FROM period_type WHERE id_type = '" . $a->periodo . "'";

								$query_po = mysqli_query($con, $sql_po);

								$pi = mysqli_fetch_array($query_po);

								$id_po = $pi['id_type'];

								$nom_po = $pi['tipo'];

								?>

								<div class="col-md-6">

									<select class="form-control" name="periodo" id="periodo">

										<option value="<?php echo $a->periodo ?>" selected> <?php echo  $nom_po ?></option>

										<?php foreach (PeriodTypeData::getALL() as $p_i) : ?>

											<option value="<?php echo $p_i->id_type; ?>"><?php echo $p_i->tipo; ?></option>

										<?php endforeach; ?>

									</select>

								</div>

							</div>

							<div class="form-group">

								<label for="inputEmail1" class="col-lg-2 control-label">Inicio*</label>

								<div class="col-md-3">

									<input type="date" name="start_at" value="<?php echo $a->start_at; ?>" class="form-control" id="name" placeholder="Inicio">

								</div>

								<label for="inputEmail1" class="col-lg-2 control-label">Fin*</label>

								<div class="col-md-3">

									<input type="date" name="finish_at" value="<?php echo $a->finish_at; ?>" class="form-control" id="name" placeholder="Fin">

								</div>

							</div>



							<div class="form-group">

								<div class="col-lg-offset-2 col-lg-10">

									<input type="hidden" name="id" value="<?php echo $a->id; ?>">

									<button type="submit" class="btn btn-success">Actualizar Periodo</button>

								</div>

							</div>

						</form>

					</div>

				</div>

			<?php endif; ?>