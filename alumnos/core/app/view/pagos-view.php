<?php
require_once('../keys_conekta/conekta.php');

if (isset($_GET["code"])) {
	$code = intval($_GET["code"]);
	$alumn = PersonData::getByCodeAlumn($code);
	$pagos = PagosData::GetPagoByIdPerson($alumn->id);
	// if (!empty($alumn->beca)) {
	// 	$beca = BecasData::getById($alumn->beca);
	// 	$porcentajeBeca = $beca->porcentaje;
	// } else {
	// 	$porcentajeBeca = '0';
	// }
	// if (!empty($alumn->promocion)) {
	// 	$beca = BecasData::getById($alumn->promocion);
	// 	$porcentajePromocion = $beca->porcentaje;
	// } else {
	// 	$porcentajePromocion = '0';
	// }
	$planPago = PlandepagoData::getPlanPagoByAlumno($alumn->id);
	$con = Database::getCon();

?>
	<!-- Inicio de tabla   -->

	
	<h4><img src="../storage/posts/tarjeta.png"  width="52px"> <strong>Sistema de Pagos</strong></h4>
	En este espacio podrás realizar tus pagos con <strong>tarjeta de crédito y/o débito.</strong> Cualquier duda comunícate al (713) 133 52 38.<br>
		

        <img src="../storage/posts/visa.png"  width="32px">
        <img src="../storage/posts/mastercard.png"  width="32px">
        <img src="../storage/posts/american-express.png"  width="32px">

    <br><br>
     <a href="./?view=home" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a> 
    
	<!-- Button trigger modal -->

	<!--Fin Button trigger modal -->   
    
    <!--
    <section class="content-header">

    <small><Strong>Detalle de Estatus en Estado de Cuenta</Strong></small><br>
    <small>El Comité de Becas de la Universidad Gestalt informa:</small><br>
    
    Estudiante:     <strong><?php if (isset($_SESSION["alumn_id"])) {
                    echo PersonData::getById($_SESSION["alumn_id"])->name . ' ' .PersonData::getById($_SESSION["alumn_id"])->lastname;
                    $id = $_SESSION["alumn_id"];
                    $con = Database::getCon();
                    $query = mysqli_query($con,"SELECT * FROM person, becas WHERE person.beca=becas.id AND person.id=$id");
                    $data = mysqli_fetch_array($query);
                    $name = $data['name'];
                    $query = mysqli_query($con,"SELECT * FROM person, becas WHERE person.promocion=becas.id AND person.id=$id");
                    $data = mysqli_fetch_array($query);
                    $namepromo = $data['name'];
                
                    } ?></storng>
    

                <br>
                

                <small>Promocion inscripción | reinscripción: <?php echo $namepromo; ?> </small><br>
                <small>Beca otorgada: <Strong><?php echo $name; ?></Strong></small><br><br>
                
    </section>-->


<section class="content-header">
    <div class="container">
        <div class="card">
            <div class="card-header text-white" style="background-color: #34495E;">
                <h3 class="mb-0">Datos del Estudiante</h3>
            </div>
            <div class="card-body">

                <dl class="row">
                    <dd class="col-sm-3">Estudiante:</dd>
                    <dd class="col-sm-9">
                        <strong>
                            <?php
                            if (isset($_SESSION["alumn_id"])) {
                                echo PersonData::getById($_SESSION["alumn_id"])->name . ' ' . PersonData::getById($_SESSION["alumn_id"])->lastname;
                                $id = $_SESSION["alumn_id"];
                                $con = Database::getCon();
                                $query = mysqli_query($con, "SELECT * FROM person, becas WHERE person.beca=becas.id AND person.id=$id");
                                $data = mysqli_fetch_array($query);
                                $name = $data['name'];
                                $query = mysqli_query($con, "SELECT * FROM person, becas WHERE person.promocion=becas.id AND person.id=$id");
                                $data = mysqli_fetch_array($query);
                                $namepromo = $data['name'];
                            }
                            ?>
                        </strong></dd>
                    <dd class="col-sm-3">Inscripción | reinscripción:</dd>
                    <dt class="col-sm-9"><small><?php echo $namepromo; ?></small></dt>
                    <dd class="col-sm-3">Beca otorgada:</dd>
                    <dt class="col-sm-9"><small><?php echo $name; ?></small></dt>
                </dl>

            </div>
        </div>
    </div>
</section>



<section class="content-header">
    <div class="container">
        <div class="card">
            <div class="card-header text-blue" style="background-color: #FFEA7F;">
                <h3 class="mb-0">Detalle de Pagos Pendientes - Estado de Cuenta IEM</h3>
            </div>
            <div class="card-body">
                <p class="card-text">
                  <h5>La información mostrada en este espacio corresponde al <strong>Plan de Pagos</strong> asignado por el Área de Ingresos y autorizado por el Comité de Becas. <br>
                 <strong style="color: red;">Las Becas y/o descuentos se mostrarán al momento de realizar el pago correspondiente.</strong></h5>
                </p>
                
                <dl class="row">
                    <?php setlocale(LC_TIME, 'es_ES.UTF-8'); ?>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Fecha</th>
                                <th>Concepto</th>
                                <th class="text-center">Costo Base</th>
                                <th class="text-center">Costo Final</th>
                                <th class="text-center">Beca Asignada</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($planPago as $pl): ?>
                                <tr>
                                    <td><?php echo ucfirst(strftime('%B - %y', strtotime($pl->fecha_inicio_pago))); ?></td>
                                    <td><strong><?php echo ProductsData::getCambio($pl->concepto)->product_name; ?></strong> <br> 
                                    <small><?php echo ProductsData::getCambio($pl->concepto)->note; ?></small>
                                    </td>
                                   	<td class="text-center" style="font-size: 16px; font-weight: bold;"><?php echo '$' . number_format(ProductsData::getCambio($pl->concepto)->selling_price, 0, '.', ','); ?></td>
								   <?php 
									   // Obtener el precio de venta basado en el concepto (%)
										$total_becaV = ProductsData::getCambio($pl->concepto)->selling_price;

								   		//Verificamos que tenga beca
										if ($pl->cuenta_beca == 'NO') {
									?>
											<td class="text-center" style="font-size: 16px; font-weight: bold;">
												<?= '$' . number_format($total_becaV, 2, '.', ','); ?>
											</td>
											<td class="text-center" style="font-size: 16px; font-weight: bold;">
												No cuenta con beca
											</td>
									<?php
										}else{

											// Obtener el porcentaje y nombre de la beca
											$becaData = ProductsData::getTotal($alumn->beca);
											$porcentajeBeca = $becaData['porcentaje'];
											$nombreBeca = $becaData['name'];
	
											// Calcular el descuento y el total con descuento
											$operacion_tb = ($total_becaV * $porcentajeBeca) / 100;
											$resultadoTotal = $total_becaV - $operacion_tb;
											
											// Mostrar el total con descuento formateado
											// echo '$' . number_format($resultadoTotal, 2, '.', ',');
											// echo '$' . number_format($porcentajeBeca, 2, '.', ',');
									?>
											<td class="text-center" style="font-size: 16px; font-weight: bold;">
												<?= '$' . number_format($resultadoTotal, 2, '.', ','); ?>
											</td>
		
											<td class="text-center" style="font-size: 16px; font-weight: bold;">
												<?= $nombreBeca ?>
											</td>
									<?php	
										}	
									?>  

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </dl>
                
                <dl class="row">
                  	&nbsp;&nbsp;&nbsp;&nbsp;
                	<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#exampleModal"><i class="glyphicon glyphicon-usd"></i>
                		Realizar Pago con Tarjeta
                	</button>  
                </div>
            </div>
        </div>
    </div>
</section>

	
	
	<br>
	<?php
	if (count($pagos) > 0) {
	?>
		<section class="content">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-primary">
						<div class="box-body">
							<table class="table table-bordered datatable table-hover">
								<thead>
								 
									<th>Datos de Operación</th>
									
									
									
									<th>Total</th>
									<th>Fecha y Hora</th>
			
								</thead>
								<?php
								foreach ($pagos as $rw) {
									// $descripcion = $rw->description;
									$tipo_pago = $rw->tipo_pago;
									// $multisale = $rw->multisale;
									// $multiplanes = $rw->multiplanes;
									// $id = $rw->id;
									// $vinculacion = $rw->vinculacion;
									// $idPerson = $rw->idPerson;
									// $produ = ProductsData::getCambio($descripcion);
									// $id_produ = $produ->product_id;
									// $name_produ = $produ->product_name;


								?>
									<tr>
										<!-- campo orden -->
										<td align="left">
				                            <?php if ($rw->number_card != null) { ?>
									        <strong>
											    <?php echo 'Operación: '?> 
											</strong>
											<small>
											    <?php echo $rw->order_id; ?>
											</small>
											
									    	<?php } 
									    	
									    	else { ?>
										    <small>
										        <strong>
											       <?php echo 'Folio:' . " " . $rw->order_id; ?>
											     </strong>
											 </small>
										<?php } ?>
										
										<!-- CONCEPTO -->
										<br>
                                        <!-- CONCEPTO -->
										<br>
                                        <small>
											<?php
												if ($rw->multisale == 1) {
													// Verifica que la cadena de multiplanes no sea vacía
													if (!empty($rw->multiplanes)) {
														// Suponiendo que $hp->multiplanes es un string como "15,1,23,7"
														$multiplanesStr = $rw->multiplanes;
														
														if ($multiplanesStr === 'SN') {

															//Verificamos si viene de vinculacion
															if ($rw->vinculacion === '1') {
																$conceptoName2 = PaymentData::getProductVinculacion($rw->idPerson,$rw->description);
																
															}else{

																//Buscamos ahora si hay pagos del mismo recibo sin plan de pago
																$sinPlan = 0;
																// echo $sinPlan;
																// echo " " . $rw->order_id;
																$conceptoName2 = PaymentData::getNameConceptos2($sinPlan,$rw->order_id);
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
															if ($rw->vinculacion === '1') {
																$conceptoName2 = PaymentData::getProductVinculacion($rw->idPerson,$rw->description);
																
															}else{

																$sinPlan = 0;
																// echo $sinPlan;
																// echo " " . $rw->order_id;
																$conceptoName2 = PaymentData::getNameConceptos2($sinPlan,$rw->order_id);
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
													if($rw->id_plan == 0){
														if ($rw->vinculacion === '1') {
																$conceptoName2 = PaymentData::getProductVinculacion($rw->idPerson,$rw->description);
																
																if (is_array($conceptoName2) && count($conceptoName2) > 0) {
																	foreach ($conceptoName2 as $c) {
														?>
																		<strong><span style="color:rgb(133, 122, 31);">Pago Único:</span></strong>
																		<small> <?php echo $c->product_name . "<br>"; ?></small>
														<?php
																	}
																}else{
														?>
																		<strong><span style="color:rgb(133, 122, 31);">Pago Único:</span></strong><small> <?php echo $rw-> product_name . "<br>"; ?></small>
														<?php
																}
															}else{
														?>
																		<strong><span style="color:rgb(133, 122, 31);">Pago Único:</span></strong><small> <?php echo $rw-> product_name . "<br>"; ?></small>
														<?php
															}
														?>

														<?php
													}else{
														?>
																<strong><span style="color: #1A9E40;">Pago Planificado:</span></strong><small> <?php echo $rw->product_name . "<br>"; ?> </small>
														<?php
													}
											
											
													// echo $rw->product_name . "<br>" . $rw->note;
												}
											?>
                                        </small>
                                      <br><br>
										
										
										<small>Método de Pago:  
										<!-- TIPO DE PAGO  -->
										<?php if ($tipo_pago != null) {
												echo $tipo_pago;
											} else {
												echo 'Sin tipo de pago';
											}
											?>
											<!-- TARJETA -->
											<?php if ($rw->number_card != null) { ?>
										</small>
                                            <br>
										    <i class="fa fa-credit-card"></i> Terminación:  <?php echo $rw->number_card; ?>
									        <?php } else { ?>
										<br>
										<small>Terminación: 
										<strong><?php echo 'Sin núm. de tarjeta' ?></strong>
										</small> 
										</td>
									<?php } ?>
									
									
									<!-- fin del campo tarjeta  -->
									<td style="text-align: center; vertical-align: middle;  font-size: 18px;">
									    <i class="fa fa-dollar"></i> <?php echo $rw->total; ?>
									    <br>
									    <br>
									    <?php
										$query = "SELECT * FROM sales WHERE id_plan = '$rw->id_plan'";
										$result = mysqli_query($con, $query);
										$row = mysqli_fetch_assoc($result);
										$idPlan = $row['sale_number'];
										// $filename = '../admin/storage/tickets/'. $rw->order_id .'-3.pdf'; // Ruta del archivo PDF
										if (file_exists('../admin/storage/tickets/'. $idPlan .'-1.pdf') || (file_exists('../admin/storage/tickets/'. $idPlan .'-2.pdf'))){
											if(file_exists('../admin/storage/tickets/'. $idPlan .'-1.pdf')){
												$url = '../admin/storage/tickets/'. $idPlan .'-1.pdf';
											}elseif(file_exists('../admin/storage/tickets/' .$idPlan . '-2.pdf')){
												$url = '../admin/storage/tickets/' . $idPlan . '-2.pdf';
											}?>
											<br><a href="<?php echo $url; ?>" download onclick="delete_ticket('<?php echo $rw->order_id ?>')" 
											title="Descargar ticket en PDF"><button style="background-color:teal; width:111px; height:22px"><i style="color:white" class="fa" aria-hidden="true">Ticket</i></button></a>
									<?php
											} else { ?>
												<?php if($rw->status === '1') {?>
													<a href="" onclick="DatosRec('<?php echo $alumn->id ?>','<?php echo $rw->order_id ?>')" title="Genera recibo">
														<button class="btn btn-success btn-ms" style=" width: 80px; height: 30px; border-radius: 5px; border: none; padding: 0;">
															<i class="fa fa-receipt"></i></i> Recibo
															<!-- <a style="color:white" class="fa fa-file-alt" aria-hidden="true">Recibo</a> -->
														</button>
													</a>
												<?php }else{
														
														echo '<span style="color: red; font-weight: bold; font-size: 16px;">Cancelado</span>';
													} 
												?>
									<?php } ?>
									    
									</td>
									
									<td style="text-align: center; vertical-align: middle;">
									    <?php echo $rw->date_created; ?>
									</td>

									</tr>
								<?php } ?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- fin de tabla -->
	<?php
	} else { ?>
		<br>
<?php
		echo "<p class='alert alert-danger'>No hay pago</p>";
	}
}
?>

<script src="../../js/VentanaCentrada.js"></script>

<script>
  function DatosRec(id, order) {
    var idPerson = id;
    var order = order;
    VentanaCentrada('new-sale-ticket-pdf.php?idPerson=' + idPerson + '&order=' + order, 'Nueva factura', '', '1024', '768', 'true');
  }
</script>

<script>
	function tareaDespuesDescarga(id){
		var parametros = {id:id};
		$.ajax({
			url: "../admin/ajax/delete_ticket_downloaded.php",
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
</script>

<!-- Inicio de modal   -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="card-form" method="post" >
				<input type="hidden" name="conektaTokenId" id="conektaTokenId" value="">
				<input type="hidden" name="idAlumno" id="idAlumno" value="<?php echo $alumn->id; ?>">
				<input type="hidden" name="matricula" id="matricula" value="<?php echo $alumn->code; ?>">
				<input type="hidden" id="payment" value="2">
				<input type="hidden" id="taxes" value="0">
				<input type="hidden" id="typeDocument" value="5">
				<input type="hidden" name="descuento" id="descuento" onmousedown="return false;">
				<?php
    			$sql = mysqli_query($con, "select sale_number from sales order by sale_id desc limit 0,1");
    			$rw = mysqli_fetch_array($sql);
    			$sale_number = $rw['sale_number'];
    			$nex_sale_number = $sale_number + 1;
			?>
				<input type="hidden" name="sale_number" id="sale_number" value="<?php echo $nex_sale_number ?>">				
				<!-- <input type="hidden" name="becas" id="becas" value="<?php echo $porcentajeBeca; ?>">
				<input type="hidden" name="promocion" id="promocion" value="<?php echo $porcentajePromocion; ?>"> -->
				<div class="modal-header">
				    <h4 class="modal-title" id="exampleModalLabel">
				    <img src="../storage/posts/tarjeta-de-credito.png"  width="32px">
					Pago en Linea</h4>
					
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					
				</div>
				<div class="modal-body">
				    
					<div class="row">
					    
						<div class="col-md-6">
							<label>Nombre del titular </label>
							<input value="" data-conekta="card[name]" class="form-control" name="name" id="name" placeholder="Nombre en Tarjeta" type="text">
						</div>
						<div class="col-md-6">
							<label><span>Email</span></label>
							<input class="form-control" type="email" name="email" id="email" maxlength="200" placeholder="Correo electronico" value="">
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-4 text-center">
							<label>Número de tarjeta</label>
							<input value="" name="card" id="card" data-conekta="card[number]" class="form-control text-center" type="text" maxlength="16" placeholder="16 dígitos">
						</div>

						<div class="col-md-5 text-center">
							<label>Vigencia (MM/AA) </label>
							<div>
								<input style="width:50px; display:inline-block" value="" data-conekta="card[exp_month]" class="form-control text-center" type="text" maxlength="2" placeholder="Mes">
								<input style="width:50px; display:inline-block" value="" data-conekta="card[exp_year]" class="form-control text-center" type="text" maxlength="2" placeholder="Año">
							</div>
						</div>
						
						<div class="col-md-3 text-center">
							<label>CVC </label>
							<input value="" data-conekta="card[cvc]" class="form-control text-center" type="text" maxlength="4" placeholder="CVC">
						</div>						
					</div>
                    <br>
					<div class="row">
						<div class="col-md-4">
							<label>Concepto a pagar: </label>
							<select class="form-control" type="text" name="description" id="description" maxlength="100" data-live-search="true" value="">
								<option value="">-- SELECCIONE --</option>
								<?php foreach ($planPago as $pl) {
									setlocale(LC_TIME, 'es_ES.UTF-8');
									$product = ProductsData::getCambio($pl->concepto);
									// $fecha = date('d-m-Y', strtotime($pl->fecha_inicio_pago));
									// echo "<option value='$pl->id'> $fecha, $product->product_name</option>";
									// Obtener el nombre del mes y los últimos dos dígitos del año
									$fecha = ucfirst(strftime('%B - %y', strtotime($pl->fecha_inicio_pago)));
        							echo "<option value='$pl->id'> $fecha, $product->product_name</option>";
								} ?>
							</select>
							
						</div>
						</div>
						<br>
						<div class="row">
						<div class="col-md-3">
							<label>Costo Base</label>
							<input class="form-control" placeholder="Costo Base" type="hidden" name="monto" id="monto" onmousedown="return false;">
							<input class="form-control" placeholder="Costo Base" type="text" name="montoview" id="montoview" onmousedown="return false;">
						</div>

						<div class="col-md-5">
							<label>Costo con descuento de beca</label>
							<input class="form-control" placeholder="Con descuento aplicado" type="hidden" name="total" id="total" value="" onmousedown="return false;">
							<input class="form-control" placeholder="Con descuento aplicado" type="text" name="totalview" id="totalview" value="" onmousedown="return false;">
						</div>
					</div>
					<h6>Por tu seguridad, nuestro sistema no guardará tu información.</h6>
				</div>
				
				<div class="modal-footer">
				    
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					<button class="btn btn-success btn-lg" type="submit" id="btn-pago">Pagar </button>
				</div>	 
			</form>
		</div>
	</div>
</div>

<!-- Fin de modal   -->

<script src="./js/VentanaCentrada.js"></script>

<script>
	$(document).ready(function() {
		$('#description').on('change', function() {
			if ($('#description').val() == "") {
				$('#monto').val("");
				$('#total').val("");
			} else {
				$.ajax({
					url: './core/app/ajax/description_planpago.php',
					type: 'GET',
					data: {
						idProducto: $('#description').val(),
						// porcentajeBeca: $('#becas').val(),
						// porcentajePromocion: $('#promocion').val()
					},
					success: function(data) {
						try {
							var json = JSON.parse(data);
							$('#monto').val(json.precioLista);
							$('#total').val(json.precioFinal);
							$('#descuento').val(json.descuento);
							$('#montoview').val(formatNumber(json.precioLista));
                            $('#totalview').val(formatNumber(json.precioFinal));
							
						} catch (e) {
							console.log(e);
						}
					}
				});
			}
		});
		
	});
	function formatNumber(number) {
    // Formatea el número en estilo $0,000.00
		return '$' + parseFloat(number).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
	}
</script>
<!-- Conekta JQ  -->
<script>
	Conekta.setPublicKey('<?php echo key_publica_conekta; ?>');
	var conektaSuccessResponseHandler = function(token) {

		// Obtiene el valor del campo de texto
		var totalValue = $("#total").val();

		// Formatea el valor a dos decimales
		totalValue = parseFloat(totalValue).toFixed(2);

		// Actualiza el valor del campo con el valor formateado
		$("#total").val(totalValue);

		$("#conektaTokenId").val(token.id);
		jsPay();
	};

	// var conektaErrorResponseHandler = function(response) {
	// 	var $form = $("#card-form");
	// 	Swal.fire({
	// 		icon: 'error',
	// 		title: 'Oops...',
	// 		text: response.message_to_purchaser
	// 	});
	// }

	// Traducciones de errores
	var conektaErrorMessagesES = {
		// Solo los que no traen message_to_purchaser o vienen siempre en inglés
		"The card was declined": "La tarjeta fue rechazada.",
		"Your card has insufficient funds.": "Tu tarjeta no tiene fondos suficientes.",
		"Your code could not be processed, please try again later": "No se pudo procesar tu pago, por favor intenta más tarde.",
		// Los demás solo si los necesitas forzados en español
	};

	var conektaErrorResponseHandler = function(response) {
		$("#btn-pago").attr("disabled", false).text("Pagar");

		// Buscamos en los lugares posibles
		var mensajeOriginal = response.message_to_purchaser;
		var mensajeTraducido = conektaErrorMessagesES[mensajeOriginal] || mensajeOriginal;
		console.log(mensajeOriginal);
		
		Swal.fire({
			icon: 'error',
			title: 'Revisa tu Información.',
			text: mensajeTraducido
		});
	}

	//Aqui comienza conekta y cuando se preciona el boton pagar
	$(document).ready(function() {

		$("#card-form").submit(function(e) {
			e.preventDefault();

			// Bloquea el botón de pago para evitar múltiples clics
			$("#btn-pago").attr("disabled", true).text("Procesando...");

			var $form = $("#card-form");
			Conekta.Token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);
		})

	})

	function jsPay() {
		let params = $("#card-form").serialize();
		let url = "pay.php";

		$.ajax({
			type: "POST",
			url: url,
			data: params,
			beforeSend: function() {
				$("#btn-pago").attr("disabled", true);
				// Evitar que el modal se cierre al hacer clic fuera
				$("#miModal").modal({ backdrop: "static", keyboard: false });
				Swal.fire({
					icon: 'info',
					title: 'Espere un momento',
					text: 'Estamos procesando su pago',
					showConfirmButton: false,
					allowOutsideClick: false,
					allowEscapeKey: false,
					allowEnterKey: false,
					onOpen: () => {
						Swal.showLoading();
					}
				});
			},
			success: function(data) {
				// console.log(data);
				
				$("#btn-pago").attr("disabled", true);
				let json = JSON.parse(data);
				if (json.code == "200") {
					CambiarStatus();
				} else {
				    // Mostramos la alerta que no se cierra automáticamente
					swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: json.message,
						showCancelButton: false, // No mostrar el botón de "Cancelar"
						confirmButtonText: 'Aceptar', // Texto del botón
						allowOutsideClick: false, // No permitir cerrar haciendo clic fuera
						allowEscapeKey: false, // No permitir cerrar con la tecla Esc
						willClose: () => {
							// Aquí puedes agregar lógica adicional si lo necesitas
							
							location.reload(); // Recargamos la página después de cerrar la alerta
							$("#btn-pago").attr("disabled", false);
						}
					});
				}
			}
		});

	}

	function CambiarStatus() {
		let idAlumno = $("#idAlumno").val();
		let url = "./core/app/ajax/description_planpago.php";
		$.ajax({
			type: "POST",
			url: url,
			data: {
				idPlanDePago: $("#description").val(),
				idAlumno: idAlumno
			},
			success: function(data) {
				let json = JSON.parse(data);
				console.log(json);
				if (json.code == "200") {
					swal.fire({
						icon: 'success',
						title: 'Exito!!',
						// text: json.message,
						html: `
							<div style="font-size: 16px;">${json.message}</div>
							<div id="loading-message" style="font-size: 18px; font-weight: bold; margin-top: 10px;">
								${json.message2} <span id="loading-dots">...</span>
							</div>
						`,
						showConfirmButton: false,
						timer: 5000,
						allowOutsideClick: false,  // Evita que se cierre al hacer clic fuera
						allowEscapeKey: false,     // Evita que se cierre con la tecla Esc
						allowEnterKey: false       // Evita que se cierre con la tecla Enter
					});
						// Animación de carga
						let dots = 0;
						let loadingInterval = setInterval(function() {
							dots = (dots + 1) % 4;  // Restaura a 0 cuando llega a 3 puntos
							document.getElementById("loading-dots").textContent = ".".repeat(dots);
						}, 500);
					setTimeout(function() {
						var person_id = $("#idAlumno").val();
						var sale_number = $("#sale_number").val();
						var taxes = $("#taxes").val();
						var descuento = $("#descuento").val();
						var monto = $("#monto").val();
						var payid = $("#description").val();
						var pago = $("#total").val();

						add_sale1(person_id, sale_number, taxes, descuento, monto, payid, pago);
							// window.location.href = "./?view=pagos&code=<?php echo $alumn->code; ?>";
         				//VentanaCentrada('new-sale-ticket-pdf-dep.php?person_id=' + person_id + '&sale_number=' + sale_number + '&tax=' + taxes + '&descuento=' + descuento + '&payment_method=' + typeDocument + '&payablePrice=' + total + '&payid=' + payid + '&payment=' + pago, 'Nueva factura', '', '1024', '768', 'true');
					}, 5000);
				} else {
					swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: json.message
					});
				}
			}
		});

	}

	//$person_id,$sale_number, $tax, $descuento, $payment_method, $payablePrice, $payid, $payment
	function add_sale1(person_id, sale_number, tax, descuento, payablePrice, payid, pago) {
		// console.log('person_id: ' + person_id);
		// console.log('sale_number: ' + sale_number);
		// console.log('tax: ' + tax);
		// console.log('descuento: ' + descuento);
		// console.log('payablePrice: ' + payablePrice);
		// console.log('payid: ' + payid);
		// console.log('pago: ' + pago);
		
		
		$.ajax({
			type: "POST",
			url: "./core/app/ajax/add_sale1.php",
			data: {
				person_id: person_id,
				sale_number: sale_number,
				tax: tax,
				descuento: descuento,
				payablePrice: payablePrice,
				payid: payid,
				pago: pago
			},
			success: function(response) {
				// console.log('response: ' + response);
				const res = JSON.parse(response);

				if(res.status == 'success'){
					swal.fire({
						icon: 'success',
						title: 'Listo',
						text: res.message,
						timer: 4000, // O puedes cambiarlo si deseas
						willClose: () => {
							location.reload();  // Recarga la página cuando el temporizador termine
						}
					}).then((result) => {
						// Recarga la página si el usuario hace clic en el botón "OK"
						if (result.isConfirmed) {
							location.reload();
						}
					});
				// Aquí puedes redireccionar, limpiar, etc
				} else {
					swal.fire({
						icon: 'error',
						title: 'Error',
						text: res.message
					});
				}

			},
			error: function(xhr, status, error) {
				console.log(xhr.responseText);
				swal.fire({
					icon: 'error',
					title: 'Error en el proceso',
					text: 'Hubo un problema al registrar la venta.'
				});
			}
		});

	}

</script>




<!-- Fin Conekta JQ  -->