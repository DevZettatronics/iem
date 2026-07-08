<?php if (isset($_GET["opt"]) && $_GET["opt"] == "all") { ?>
	<div class="row">
		<div class="col-md-12">
			<h1>Tiempo Docentes</h1>
			<br>
			<?php

			$tiempo = TiemposDocenteData::getAll();
			if (count($tiempo) > 0) {
				// si hay usuarios
			?>
				<div class="box box-primary">
					<div class="box-body">

						<table class="table table-bordered datatable table-hover">
							<thead>
							<!-- 	<th>Nombre de Usuario</th> -->
								<th>Nombre</th>
								<th>Tipo</th>
								<th>Fecha</th>
								<th>Horario</th>
							</thead>
							<?php
							foreach ($tiempo as $lista) {

								$id = $lista->id;
								$matricula =	$lista->tarjeta;
								$nombre = $lista->name;
								$apellido = $lista->apellido;
								$tipo = $lista->tipo;

								list($date) = explode(" ", $lista->fecha);
								list($Y, $m, $d) = explode("-", $date);
								$fecha = $d . "-" . $m . "-" . $Y;

								list($time) = explode(" ", $lista->hora);
								list($H, $m, $s) = explode(":", $time);
								$horas = $H . ":" . $m . ":" . $s;

							?>
								<tr>
								<!-- 	<td>?php echo $matricula; ?></td> -->
									<td><?php echo $nombre . " " . $apellido; ?></td>
									<td><?php echo $tipo; ?></td>
									<td><?php echo  $fecha ?></td>
									<td><?php echo  $horas ?></td>

								<!-- 	<td class="col-md-2"> -->
										<!-- <div class="btn-group pull-center">
											<a href="index.php?action=tiempo&opt=del&id=?php echo $lista->id ?>"><button type="button" class="btn bg-red"><i class="fa fa-trash"></i></button></a>
										</div> -->
							<!-- 		</td> -->
								</tr>
						<?php
							}
							echo "</table></div></div>";
						} else {
							echo "<p class='alert alert-danger'>No existe registro de un docente</p>";
						}
						?>
					</div>
				</div>
			<?PHP } ?>