<?php
$con = Database::getCon();
if (isset($_GET["code"])) {
	$code = intval($_GET["code"]);
	$alumn = PersonData::getByCodeAlumn($code);
	$query = mysqli_query($con, "SELECT * FROM repository WHERE code_person = '$code'");
	$num = mysqli_num_rows($query);
?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

	<div class="small-box bg-maroon" style="background: linear-gradient(60deg, #d81b60, #8e0638); box-shadow: 0 12px 20px -10px rgb(0 188 212 / 28%), 0 4px 20px 0px rgb(0 0 0 / 12%), 0 7px 8px -5px rgb(0 188 212 / 20%);">
		<div class="inner">
			<h4 align="left"><i class='fa fa-file'></i> <strong>Repositorio de documentos</strong></h4>
			<h5 align="left">Matrícula: <strong><?php echo $alumn->code; ?></strong></h5>
			<h5 align="left">Nombre: <strong><?php echo $alumn->name . " " . $alumn->lastname ?></strong></h5>
			<h5 align="left">Correo Institucional: <strong><?php echo $alumn->email; ?></strong></h5>
			<h5 align="left">Numero de contacto: <strong><?php echo $alumn->phone; ?></strong></h5>
			<h5 align="left"> <a href="index.php?view=alumns" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar </a>
			</h5>
		</div>
		<div class="icon">
			<i class="fa fa-file"></i>
		</div>
	</div>
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
									<th>Nombre</th>
									<th class="text-center">Fecha y Hora de carga</th>
									<th class="text-center">Estatus</th>
									<th class="text-center">Acciones</th>
								</thead>
								<?php
								while ($rw = mysqli_fetch_array($query)) {
									if ($rw['status'] == "1") {
										$lbl_status = "Sin Validar";
										$lbl_icon = "fa fa-times-circle";
										$lbl_class = 'btn label-danger';
									} elseif ($rw['status'] == "2") {
										$lbl_status = "Validado";
										$lbl_icon = "fa fa-check-circle";
										$lbl_class = 'btn bg-green';
									}
								?>
									<tr>
										<td><?php echo $rw['file']; ?></td>
										<td class="text-center"><?php echo $rw['date_added']; ?></td>
										<td class="text-center">
											<span class="<?php echo $lbl_class ?>"><i class="<?php echo $lbl_icon ?>"> </i> <?php echo $lbl_status ?> </span>
										</td>
										<td class="col-md-2 text-center">
											<div class="btn-group pull-center">
												<a target="_blank" title="Ver Archivo" href="../alumnos/core/app/repository/<?php echo $code . "/" . $rw['file'] ?>"><button type="button" class="btn bg-orange"><i class="fa fa-eye"></i></button></a>
											</div>
											<!-- En este momento el sistema puede eliminar documentos aun validados, descomentar el if si se va a cambiar a no elimanr si estan validados -->
											<?php //if ($rw['status'] == 1) { ?>
												<div class="btn-group">
													<a href="index.php?action=alumns&opt=validate&id=<?php echo $rw['id'] ?>"><button type="button" class="btn bg-purple"><i class="fa fa-check"></i></button></a>
												</div>
												<div class="btn-group">
													<a href="#"><button onclick="eliminar('<?php echo $rw['id']; ?>')" type="button" class="btn bg-red"><i class="fa fa-trash"></i></button></a>
												</div>
											<?php //} ?>
										</td>
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
		echo "<p class='alert alert-danger'>El Alumno No Ha Cargado Documentos</p>";
	}
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
	function eliminar(id) {

	
		//https://craftpip.github.io/jquery-confirm/ documentacion
		$.confirm({
			title: 'Mensaje del sistema',
			content: 'Esta acción eliminará de forma permanente el Documento\n\n ¿Desea continuar?',
			buttons: {
				somethingElse: {
					text: 'Aceptar',
					btnClass: 'btn-red',
					action: function () {
						$.ajax({
							type: "GET",
							url: 'index.php?action=alumns&opt=deldocument&id=' + id,
							dataType: 'json',
							success: function (response) {
								if (response.status === 'ok') {
									$.alert(response.msg);
									setTimeout(() => location.reload(), 1500);
								} else {
									$.alert('Error: ' + response.msg);
								}
							},
							error: function () {
								$.alert('Error de conexión con el servidor.');
							}
						});
					}
				},
				cancelar: function () {}
			}
		});

	}
</script>