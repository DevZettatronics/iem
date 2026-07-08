<?php
$alumns = PersonData::getTeachers();
?>
<div class="row">
	<div class="col-md-12">
		<h1>Docentes IEM</h1>
		
		<a href="index.php?view=newteacher" class="btn bg-gradient-secondary btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tooltip on bottom" data-container="body" data-animation="true">
        <i class='fa fa-asterisk'></i> Nuevo Usuario
        </a>
		<?php if (count($alumns) > 0) : ?>
		<?php endif; ?>
		<!--	<a href="index.php?view=list&team_id=<?php echo $_GET["id"]; ?>" class="btn btn-default"><i class='fa fa-area-chart'></i> Estadisticas</a> -->
		<br><br>
		<?php

		if (count($alumns) > 0) {
			// si hay usuarios
		?>
			<div class="box box-primary">
				<div class="box-body">
					<table id="tabladatatable" class="table table-bordered table-hover">
						<thead>
							<th>Usuario Sistema</th>
							<th>Nombre</th>
							<!--			<th>Domicilio</th>-->
							<th>Telefono</th>
							<th>Email</th>
							<th></th>
						</thead>
						<?php
						foreach ($alumns as $alumn) {
						?>
							<tr>
								<td><?php echo $alumn->code; ?></td>
								<td><?php echo $alumn->name . " " . $alumn->lastname; ?></td>
								<!--				<td><?php echo $alumn->address; ?></td>-->
								<td><?php echo $alumn->phone; ?></td>
								<td><?php echo $alumn->email; ?></td>
								<td style="width:160px;">
									<!--<a href="index.php?view=openalumn&id=<?php echo $alumn->id; ?>&tid=<?php echo $team->id; ?>" class="btn btn-default btn-xs">Ver</a> -->
									<a href="index.php?view=editteacher&id=<?php echo $alumn->id; ?>" class="btn btn-warning btn-xs">Editar</a>
									<a href="index.php?action=teachers&opt=del&id=<?php echo $alumn->id; ?>" class="btn btn-danger btn-xs">Eliminar</a>
								</td>
							</tr>
					<?php

						}

						echo "</table></div></div>";
					} else {
						echo "<p class='alert alert-danger'>No hay Profesores</p>";
					}


					?>


				</div>
			</div>
			<script>
				
				$(document).ready(function () {

					var table = $('#tabladatatable').DataTable({
						ordering: false,
						pageLength: 10,
						stateSave: true // ✅ guarda búsqueda, página, etc.
					});

					// 🔥 Forzar redraw al cargar estado guardado
					table.draw();

					// 🔄 Redibujar cuando el usuario busca
					$('#tabladatatable_filter input').on('keyup change', function () {
						table.draw();
					});

				});

			</script>