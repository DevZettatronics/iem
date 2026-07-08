<?php
$con = Database::getCon();
if (isset($_GET["code"])) {
	$code = intval($_GET["code"]);
	$alumn = PersonData::getByCodeAlumn($code);
	$query = mysqli_query($con, "SELECT * FROM notificaciones WHERE id_receptor = '$code'");
	$num = mysqli_num_rows($query);
?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

	<h1>Notificaciones</h1>
      <br>
	<?php
	if ($num > 0) {
	?>

		<section class="content">
			<div class="row">
				<div class="col-md-12">

					<div class="box box-primary">
						<div class="box-body">
							<table class="table table-bordered datatable table-hover">
								<thead>
									<th>Mensaje</th>
									<th>Observacion</th>
									<th class="text-center">Fecha y Hora de carga</th>
								</thead>
								<?php
								while ($rw = mysqli_fetch_array($query)) {	
								?>
									<tr>
										<td><?php echo $rw['mensaje']; ?></td>
										<td><?php echo $rw['file']; ?></td>
										<td class="text-center"><?php echo $rw['fecha']; ?></td>
									</tr>
								<?php } ?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</section>


<?php
	} else {
		echo "<p class='alert alert-danger'>No hay Notificaciones</p>";
	}
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
	function eliminar(id) {
		//https://craftpip.github.io/jquery-confirm/ documentacion
		$.confirm({
			title: 'Mensaje del sistema',
			content: 'Esta acción  eliminará de forma permanente el Documento \n\n Desea continuar?',
			buttons: {
				somethingElse: {
					text: 'Aceptar',
					btnClass: 'btn-red',
					action: function() {
						var parametros = {
							"id": id
						};
						$.ajax({
							type: "GET",
							url: 'index.php?action=alumns&opt=deldocument&id=' + id,
							data: parametros,
							success: function(data) {
								location.reload();
							}

						})
					}
				},
				cancelar: function() {}
			}
		});
	}
</script>