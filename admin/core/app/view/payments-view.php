<?php if (isset($_GET["opt"]) && $_GET["opt"] == "all") : 
 	include "modals/modal_reporte_pdp.php";  
	$h_pagos = PaymentData::getAllJoin();
	if (count($h_pagos) > 0) {
?>
	<div class="row">
        <div class="col-md-12">
            <div class="btn-group pull-right">
                <div class="btn-group pull-right">
					<button class="btn btn-primary btn-img" id="btn_reporte_excel">
						<img src="https://download.logo.wine/logo/Microsoft_Excel/Microsoft_Excel-Logo.wine.png" alt="Imagen" height="40px">
						Generar Reporte
					</button>
            	</div>
            </div>
			
            <h1>Historial de Pagos</h1>
            <a href="./?view=home" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a> 
            <div class="box box-primary">
                <div class="box-body">
					<!-- Le quitamos el data table por defecto para que la cinsulta se tomara de forma desc asi trae los datos y el id ayuda a implementar el datatable y desactivar
					  el acomodo automatico -->
					<table id="datatable_hpagos" class="table table-bordered  table-hover" data-page-length="100">
                        <thead>
                            <th>ID</th>
                            <th>Datos</th>
                            <th>Concepto</th>
                            <th>Tipo de Pago</th>
                            <th class="text-center">Fecha Pago</th>
                            <th>Estatus</th>
                             <?php if (Core::$user->kind == 1 or Core::$user->kind == 12 or Core::$user->kind == 11) : ?>
                            <th>Acciones</th>
                               <?php endif; ?>
                        </thead>
                        <?php foreach ($h_pagos as $hp) { ?>
                            <tr>
                                <!-- ID Pago -->
                                <td>
                                    <?php echo $hp->id_pago; ?>
                                </td>
                              	<?php if($hp->vinculacion === '1') { 
									$dataV = PaymentData::getDatainculacionID($hp->idPerson);
								?>
									<td>
										<?php if ($dataV) { ?>
											<strong>Vinculación:</strong> <?php echo $dataV->name . ' ' . $dataV->lastname; ?>
										<?php } else { ?>
											<strong>Vinculación:</strong> <?php echo 'No se encontro al responsable'; ?>
										<?php } ?>
										<br>
									</td>
								<?php } else { ?>
									<td>
										<strong>Matrícula:</strong> <?php echo $hp->matricula; ?> <br>
										<strong>Estudiante:</strong> <?php echo $hp->name_person; ?>
									</td>
								<?php } ?>
								<!-- Concepto Pago -->
								<td>

									<?php
										if ($hp->multisale == 1) {
											// Verifica que la cadena de multiplanes no sea vacía
											if (!empty($hp->multiplanes)) {
												// Suponiendo que $hp->multiplanes es un string como "15,1,23,7"
												$multiplanesStr = $hp->multiplanes;
												
                                                if ($multiplanesStr === 'SN') {

													//Verificamos si viene de vinculacion
													if ($hp->vinculacion === '1') {
														$conceptoName2 = PaymentData::getProductVinculacion($hp->idPerson,$hp->description);
														
													}else{

														//Buscamos ahora si hay pagos del mismo recibo sin plan de pago
														$sinPlan = 0;
														// echo $sinPlan;
														// echo " " . $hp->order_id;
														$conceptoName2 = PaymentData::getNameConceptos2($sinPlan,$hp->order_id);
														// echo $conceptoName2;
														// echo $conceptoName2;
													}
                                                    if (is_array($conceptoName2) && count($conceptoName2) > 0) {
                                                        foreach ($conceptoName2 as $c) {
                                        ?>
														<strong><span style="color:rgb(133, 122, 31);">Pago Único:</span></strong>
      													<small> <?php echo $c->product_name . "<br>"; ?></small>
										<?php
                                                        // echo "Pago Único: " . $conceptoName2[0]->product_name . "<br>";
                                                        }
                                                    }
                                                }else{

                                                
                                                    // Separamos la cadena en un array usando la coma como separador.
                                                    $multiplanesArr = explode(',', $multiplanesStr);
                                                    
                                                    // Recorremos el array de números
                                                    foreach ($multiplanesArr as $plan) {
                                                        $plan = trim($plan); // Quita espacios en blanco
                                        
                                                        // Realizamos la consulta para obtener el nombre del concepto de cada pago
                                                        // Dependiendo de la implementación de PaymentData::getNameConceptos,
                                                        // asegúrate de que retorne el objeto esperado.
                                                        $conceptoName = PaymentData::getNameConceptos($plan);
                                                        // Si getNameConceptos retorna un array, puedes hacer algo como:
                                                        if (is_array($conceptoName) && count($conceptoName) > 0) {
                                        ?>
                                                            <strong><span style="color:rgb(34, 129, 61);">Pago Planificado:</span></strong><small> <?php echo $conceptoName[0]->product_name . "<br>"; ?> </small>
                                        <?php
                                                            // echo "Pago Planificado: " . $conceptoName[0]->product_name . "<br>";
                                                        }
                                                    }
                                                    //Buscamos ahora si hay pagos del mismo recibo sin plan de pago

													//Verificamos si viene de vinculacion
													if ($hp->vinculacion === '1') {
														$conceptoName2 = PaymentData::getProductVinculacion($hp->idPerson,$hp->description);
														
													}else{

														$sinPlan = 0;
														// echo $sinPlan;
														// echo " " . $hp->order_id;
														$conceptoName2 = PaymentData::getNameConceptos2($sinPlan,$hp->order_id);
														// echo $conceptoName2;
														// echo $conceptoName2;
													}
                                                  
                                        ?>
													<?php
														if (is_array($conceptoName2) && count($conceptoName2) > 0) {
                                                        	foreach ($conceptoName2 as $c) {
													?>
																<strong><span style="color:rgb(133, 122, 31);">Pago Único:</span></strong>
																<small> <?php echo $c->product_name . "<br>"; ?></small>
													<?php
															}
														}else{
													?>
																<!-- <strong><span style="color:rgb(133, 122, 31);">Pago Único:</span></strong><small> <?php echo $c-> product_name . "<br>"; ?></small> -->
													<?php
														}
													?>
													
										<?php
                                                        // echo "Pago Único: " . $conceptoName2[0]->product_name . "<br>";
                                                     
                                                }
											} else {
												
												echo "No hay planes registrados";
											}
										} else {
                                            if($hp->id_plan == 0){
												if ($hp->vinculacion === '1') {
														$conceptoName2 = PaymentData::getProductVinculacion($hp->idPerson,$hp->description);
														 
														if (is_array($conceptoName2) && count($conceptoName2) > 0) {
                                                        	foreach ($conceptoName2 as $c) {
												?>
																<strong><span style="color:rgb(133, 122, 31);">Pago Único:</span></strong>
      															<small> <?php echo $c->product_name . "<br>"; ?></small>
												<?php
															}
														}else{
												?>
																<strong><span style="color:rgb(133, 122, 31);">Pago Único:</span></strong><small> <?php echo $hp-> product_name . "<br>"; ?></small>
												<?php
														}
													}else{
												?>
																<strong><span style="color:rgb(133, 122, 31);">Pago Único:</span></strong><small> <?php echo $hp-> product_name . "<br>"; ?></small>
												<?php
													}
												?>

												<?php
                                            }else{
												?>
														<strong><span style="color: #1A9E40;">Pago Planificado:</span></strong><small> <?php echo $hp->product_name . "<br>"; ?> </small>
												<?php
                                            }
									
									
											// echo $hp->product_name . "<br>" . $hp->note;
										}
									?>
                                   
                                </td>
                                <!-- TIPO DE PAGO -->
                                <td>
                                    <strong><span>ID Venta:</span></strong>
                                    <?php echo ($hp->order_id != null) ? $hp->order_id : 'Sin información'; ?>
                                    <br>
									<?php
										if ($hp->vinculacion === '1') {
											$dataV = PaymentData::getDatainculacionID($hp->idPerson);
									?>
											<strong><span style="color: #1A9E40;">Por:</span></strong><small> <?php echo $dataV->name . ' ' . $dataV->lastname; ?> </small>
									<?php
										}else{
									?>
											<strong><span style="color: #1A9E40;">Tarjetahabiente:</span></strong><small> <?php echo $hp->name_person; ?> </small>
									<?php } ?>
                                    <br>
                                    <strong><span style="color: #0D709E;">Método:</span></strong>
                                    <?php echo ($hp->tipo_pago != null) ? $hp->tipo_pago : 'Sin tipo de pago'; ?>
                                    <br>
                                    <strong><span style="color: #090C6A;">Tarjeta:</span></strong>
                                    <?php echo ($hp->number_card != null) ? $hp->number_card : 'Sin núm. de tarjeta'; ?>
                                    <br>
                                    <strong><span style="color: #B2B2B2;">Importe Pagado:</span></strong>
                                    <strong><i class="fa fa-dollar"></i> <?php echo $hp->total; ?></strong>
                                </td>
                                <!-- Fecha -->
                                <td class="text-center"><?php echo $hp->date_created; ?></td>
                                <!-- Estatus -->
                                <td>
                                    <?php if ($hp->status == 1) {
                                        echo "<span class='label label-success'>Pagado</span><br>";
                                    } else if($hp->status == 7){
                                        echo "<span class='label label-danger'>Cancelado</span><br>";
                                    } ?>
                                    <?php
                                        $Nofacturado = PaymentData::noFacturados($hp->id_pago);
                                        // if ($Nofacturado == 1) {
                                        //     echo "<span class='label label-warning'>Facturado</span>";
                                        // }

                                        // if ($Nofacturado == 0) {
                                        //     echo "<span class='label label-danger'>No facturado</span>";
                                        // }
                                    ?>
                                </td>
                                <!-- Acciones -->
                                <?php if (in_array(Core::$user->kind, [1, 12, 11])) { ?>
									<?php if($hp->status !== '7') {?>
										<td style="width:130px;">
											<!-- <a href="index.php?action=payments&opt=del&id=<?php echo $hp->id_pago; ?>" class="btn btn-danger btn-xs">Eliminar</a> -->
											<center>
												<!-- <a href="?view=fact4&opt=all&id=<?php ?>" class="btn btn-primary btn-ms">Facturar</a> -->
											</center>
											<!-- Download ticket if available -->
											<?php
											if (file_exists('./storage/tickets/' . $hp->order_id . '-1.pdf') || file_exists('./storage/tickets/' . $hp->order_id . '-2.pdf')) { //Se comprueba que la carpeta exista                
												if (file_exists('./storage/tickets/' . $hp->order_id . '-1.pdf')) {
													$url = './storage/tickets/' . $hp->order_id . '-1.pdf';
												} elseif (file_exists('./storage/tickets/' . $hp->order_id . '-2.pdf')) {
													$url = './storage/tickets/' . $hp->order_id . '-2.pdf';
												}
											?>
												<a href="<?php echo $url; ?>" download onclick="delete_ticket('<?php echo $hp->order_id ?>')" title="Descargar ticket en PDF"><button style="background-color:teal; width:111px; height:22px"><i style="color:white" class="fa" aria-hidden="true">Ticket</i></button></a>
											<?php
											} else { ?>
												<br>
												<div class="d-flex justify-content-center">
													<a href="" onclick="DatosRec('<?php echo $hp->idPerson ?>', '<?php echo $hp->order_id ?>', 
														'<?php echo $hp->vinculacion ?>', '<?php echo $hp->payment_date ?>')" title="Recibo">
														<center>
															<button class="btn btn-success" style="width: 60px; height: 20px; border-radius: 3px; border: none; padding: 0;">
																Recibo
															</button>
														</center>
													</a>
												</div>
											<?php } ?>
											<?php
                                                if (Permisos::puede(Core::$user->kind, 'historial_pagos', 'eliminar')):
                                                    if($Nofacturado != 1) {
                                                        $nombreCancelacion = $_SESSION["user_id"];
                                                        // echo $nombreCancelacion;
                                            ?>
                                                        <div class="d-flex justify-content-center">
                                                            <center>
                                                                <button  onclick="DatosCancelar('<?php echo $hp->id_pago ?>', '<?php echo $hp->order_id ?>', <?php echo $nombreCancelacion; ?>)"
                                                                        class="btn btn-danger" style="width: 60px; height: 20px; border-radius: 3px; border: none; padding: 0;">
                                                                    Cancelar
                                                                </button>
                                                            </center>
                                                        </div>
                                            <?php
                                                    }
                                                endif;
                                            ?>
										</td>
									<?php }else{ ?>
									<td></td>
									<?php } ?>
                                <?php } ?>
                            </tr>
                        <?php
                        } # FIn del foreach
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
	<?php } else {
		echo "<p class='alert alert-danger'>No hay Pagos</p>";
		}
	?>
			<?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "new") : ?>
				<div class="row">
					<div class="col-md-12">
						<h1>Nuevo Pago Directo</h1>
						<br>
						<form class="form-horizontal" method="post" id="addcategory" action="./?action=payments&opt=add" role="form">
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-2 control-label">Concepto*</label>
								<div class="col-md-6">
									<select name="concept_id" required class="form-control">
										<option value="">-- SELECCIONE --</option>
										<?php foreach (ConceptData::getAll() as $c) : ?>
											<option value="<?php echo $c->id; ?>"><?php echo $c->name . " - $ " . $c->price; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-2 control-label">Alumno*</label>
								<div class="col-md-6">
									<select name="alumn_id" required class="form-control">
										<option value="">-- SELECCIONE --</option>
										<?php foreach (AlumnData::getAll() as $c) : ?>
											<option value="<?php echo $c->id; ?>"><?php echo $c->code . " - " . $c->name . " " . $c->lastname; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-2 control-label">Fecha Limite*</label>
								<div class="col-md-6">
									<input type="date" name="limit_at" required class="form-control" id="name" placeholder="Fecha Limite">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-2 control-label">Comentario*</label>
								<div class="col-md-6">
									<textarea name="comment_before" required class="form-control" id="name" placeholder="Comentario"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-2 control-label">Estado*</label>
								<div class="col-md-6">
									<select name="status" required class="form-control">
										<option value="0">Pendiente</option>
										<option value="1">Pagado</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
									<button type="submit" class="btn btn-primary">Agregar Pago</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			<?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "newconcept") : ?>
				<div class="row">
					<div class="col-md-12">
						<h1>Nuevo Concepto</h1>
						<br>
						<form class="form-horizontal" method="post" id="addcategory" action="./?action=payments&opt=addconcept" role="form">
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
								<div class="col-md-6">
									<input type="text" name="name" required class="form-control" id="name" placeholder="Nombre">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-2 control-label">Precio*</label>
								<div class="col-md-6">
									<input type="text" name="price" required class="form-control" id="name" placeholder="Precio">
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
									<button type="submit" class="btn btn-primary">Agregar Concepto</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			<?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "edit") :
			$a = PaymentData::getById($_GET["id"]);
			?>
				<div class="row">
					<div class="col-md-12">
						<h1>Editar Salon de clases</h1>
						<br>
						<form class="form-horizontal" method="post" id="addcategory" action="./?action=payments&opt=update" role="form">
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
								<div class="col-md-6">
									<input type="text" name="name" value="<?php echo $a->name; ?>" required class="form-control" id="name" placeholder="Nombre">
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
									<input type="hidden" name="id" value="<?php echo $a->id; ?>">
									<button type="submit" class="btn btn-success">Actualizar Salon de clases</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			<?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "editconcept") :
			$a = ConceptData::getById($_GET["id"]);
			?>
				<div class="row">
					<div class="col-md-12">
						<h1>Editar Salon de clases</h1>
						<br>
						<form class="form-horizontal" method="post" id="addcategory" action="./?action=payments&opt=updateconcept" role="form">
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
								<div class="col-md-6">
									<input type="text" name="name" value="<?php echo $a->name; ?>" required class="form-control" id="name" placeholder="Nombre">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-2 control-label">Precio*</label>
								<div class="col-md-6">
									<input type="text" name="price" value="<?php echo $a->price; ?>" required class="form-control" id="name" placeholder="Precio">
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
									<input type="hidden" name="id" value="<?php echo $a->id; ?>">
									<button type="submit" class="btn btn-success">Actualizar Concepto</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			<?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "concepts") : ?>
				<div class="row">
					<div class="col-md-12">
						<div class="btn-group pull-right">
							<a href="./?view=payments&opt=newconcept" class="btn btn-default"><i class='fa fa-th-list'></i> Nuevo Concepto</a>
						</div>
						<h1>Conceptos de pago</h1>
						<br>
						<?php
						$teams = ConceptData::getAll();
						if (count($teams) > 0) {
							// si hay usuarios
						?>
							<div class="box box-primary">
								<div class="box-body">
									<table class="table table-bordered datatable table-hover">
										<thead>
											<th>Nombre</th>
											<th>Precio</th>
											<th></th>
										</thead>
										<?php
										foreach ($teams as $team) {
										?>
											<tr>
												<td><?php echo $team->name; ?></td>
												<td>$ <?php echo $team->price; ?></td>
												<td style="width:130px;"><a href="index.php?view=payments&opt=editconcept&id=<?php echo $team->id; ?>" class="btn btn-warning btn-xs">Editar</a> <a href="index.php?action=payments&opt=delconcept&id=<?php echo $team->id; ?>" class="btn btn-danger btn-xs">Eliminar</a></td>
											</tr>
									<?php
										}
										echo "</table></div></div>";
									} else {
										echo "<p class='alert alert-danger'>No hay Conceptos de pago</p>";
									}
									?>
								</div>
							</div>
						<?php endif; ?>

<script src="./dist/js/VentanaCentrada.js"></script>
<script>
	function tareaDespuesDescarga(id){
		var parametros = {id:id};
		$.ajax({
			url: "ajax/delete_ticket_downloaded.php",
			type: "POST",
			data: parametros,
			cache: false,
			beforeSend: function(){},
			success: function (response) {
				console.log(response)
				switch(response){
					case '0':
						alert('Ticket descargado. Ya no está disponible para su descarga')
						break;
					case '1':
						alert('Ticket descargado. Sólo se podrá descargar una vez más')
						break;
					case '2':
						alert('Ticket descargado. Sólo se podrá descargar dos veces más')
						break;
				}
				location.reload()
			},
			error: function(){
				alert('Ha habido un error, intente más tarde')
			},
		});
	}
	function delete_ticket(id){
		setTimeout(function(){tareaDespuesDescarga(id)}, 100);
	}

	function DatosRec(id, order, vinculacion, payment_date) {
    var idPerson = id;
    var order = order;
    var vinculacion = vinculacion;
    var payment_date = payment_date;
	// console.log(payment_date);
	
	// return
    // var Cuatrimestre = Cuatrimestre;
    // var carrera = carrera;

    // VentanaCentrada('new-sale-ticket-pdf-per.php?idPerson=' + idPerson + '&order=' + order, 'Nueva factura', '', '1024', '768', 'true');
	VentanaCentrada(
    'new-sale-ticket-pdf-per.php?idPerson=' + idPerson +
    '&order=' + order +
    '&payment_date=' + payment_date +
    '&vinculacion=' + vinculacion ,
    // '&Cuatrimestre=' + Cuatrimestre +
    // '&carrera=' + carrera,
    'Nueva factura',
    '',
    '1024',
    '768',
    'true'
);
  }

	// $(document).ready(function() {
	// 	$('#datatable_hpagos').DataTable({
	// 		ordering: false,
	// 		pageLength: 100
	// 	});
	// });

	//Guardar busqueda al recargar y ir a otros lados y regresar
	$(document).ready(function () {

		var table = $('#datatable_hpagos').DataTable({
			ordering: false,
			pageLength: 10,
			stateSave: true // ✅ guarda búsqueda, página, filtros
		});

		// 🔥 Forzar redraw al cargar estado guardado
		table.draw();

		// 🔄 Redibujar cuando el usuario busca
		$('#datatable_hpagos_filter input').on('keyup change', function () {
			table.draw();
		});

	});
</script>
<script>
    $(document).on("click", "#btn_reporte_excel", function(e) {
		$('#modal_reporte_pdp').modal('show');
	});
    $(document).on("click", "#generar_reporte_hvexcel", function(e) {
		var start_date = $("#start_date").val();
		var end_date = $("#end_date").val();
		// console.log(start_date);
		// console.log(end_date);
		
		if (start_date.length === 0 || end_date.length === 0) {
			$("#errorMessage").html("Debes colocar una fecha de inicio y fin para generar el reporte");
			setTimeout(function() {
				$("#errorMessage").empty(); // Vaciar el contenido del elemento
			}, 5000); // 5000 milisegundos = 5 segundos
		} else {
			window.open("index.php?action=planpago&opt=reporte_excel_pagos&start_date=" + start_date + "&end_date=" + end_date);
			setTimeout(function() {
				$("#start_date").val("");
				$("#end_date").val("");
				$('#modal_reporte_pdp').modal('hide');
			}, 1500);
		}

	});
</script>

<script>
	const DatosCancelar = async (id_pago, order, nombreCancelacion) => {
		try {
			// 1. Preguntar al usuario con SweetAlert2
			const { isConfirmed } = await Swal.fire({
				title: "⚠️ ¿Seguro que quieres cancelar este pago?",
				text: "Esta acción no se puede deshacer.",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d33",
				cancelButtonColor: "#3085d6",
				confirmButtonText: "Sí, cancelar",
				cancelButtonText: "Cancelar"
			});

			if (!isConfirmed) return; // si presiona "Cancelar", no hacemos nada

			// 2. Llamar al backend
			const response = await fetch(
				`index.php?action=cancelacionPago&opt=cancelar&id_pago=${id_pago}&order=${order}&nombreCancelacion=${nombreCancelacion}`
			);

			if (!response.ok) {
				throw new Error("Error en la petición: " + response.status);
			}

			const data = await response.json();
			// console.log("Respuesta del servidor:", data);

			// 3. Mostrar alerta según el resultado
			if (data.success) {
				await Swal.fire({
					icon: "success",
					title: "¡Pago cancelado!",
					text: "El pago se canceló correctamente.",
					showConfirmButton: false,
					timer: 3000
				});

				// 4. Redirigir si el backend envía redirect
				if (data.redirect) {
					window.location.href = data.redirect;
				}
			} else {
				Swal.fire({
					icon: "error",
					title: "Error",
					text: data.error || "No se pudo cancelar el pago",
					confirmButtonText: "Aceptar"
				});
			}

		} catch (error) {
			console.error("Error en DatosCancelar:", error);
			Swal.fire({
				icon: "error",
				title: "Error",
				text: "Ocurrió un error al cancelar el pago",
				confirmButtonText: "Aceptar"
			});
		}
	};

</script>