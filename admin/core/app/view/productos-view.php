<?php if (isset($_GET["opt"]) && $_GET["opt"] == "all") { ?>
	<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @function em($pixels) {
	@if not (unit($pixels) == 'px') {
		@error 'Value #{$pixels} must have `px` unit.';
	}
	
	@return $pixels / 10px * 1em;
	}

	.toggle-container {
	--inactive-color: #c73535;
	position: relative;
	aspect-ratio: 1;
	height: em(1px);
	
	&:nth-child(1) {
		--active-color: #35c759;
	} 
	}

	.toggle-input {
	appearance: none;
	margin: 0;
	position: absolute;
	z-index: 1;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	cursor: pointer;
	}
	.toggle-background {
	fill: var(--inactive-color);
	transition: fill .4s;
	
	.toggle-input:checked + .toggle & {
		fill: var(--active-color);
	}
	}

	.toggle-circle-center {
	transform-origin: center;
	transition: transform .6s;

	.toggle-input:checked + .toggle & {
		transform: translateX(150px);
	}
	}

	.toggle-circle {
	transform-origin: center;
	backface-visibility: hidden;
	transition: transform .45s;
	
	&.left {
		transform: scale(1);
		
		.toggle-input:checked + .toggle & {
		transform: scale(0);
		}
	}
	
	&.right {
		transform: scale(0);
		
		.toggle-input:checked + .toggle & {
		transform: scale(1);
		}
	}
	}

	.toggle-icon {
	transition: fill .4s;

	&.on {
		fill: var(--inactive-color);

		.toggle-input:checked + .toggle & {
		fill: #fff;
		}
	}

	&.off {
		fill: #eaeaec;

		.toggle-input:checked + .toggle & {
		fill: var(--active-color);
		}
	}
	}
    </style>
</head>
	<div class="row">
		<div class="col-md-12">
			<h1>Listado de Conceptos</h1>
			<a href="./?view=productos&opt=new" class="btn btn-success"><i class='fa fa-asterisk'></i> Nuevo Concepto</a>
			

			<br>
			<br>
			<?php

			$products = ProductsData::getAllAll();

			if (count($products) > 0) {
				// si hay usuarios
		
				?>
				<div class="box box-primary">
					<div class="box-body">
						<table class="table table-bordered datatable table-hover">
							<thead class="bg-primary font-weight-bold p-3 text-left">
								<tr>
								    <th>Categoría</th>
									<th>Código</th>
									<th>Imagen</th>
									<th>Producto</th>
									
									<th>Precio</th>
									<th>Estado</th>
									<th>Estado</th>
									<th>Acciones</th>
								</tr>
							</thead>

							<?php

							foreach ($products as $product) {
								$product->status;
								if ($product->status == 1) {
									$product->lbl_status = "Activo";
									$product->lbl_class = 'label label-success';
									$checked = 'checked';
								} else {
									$product->lbl_status = "Inactivo";
									$product->lbl_class = 'label label-danger';
									$checked = '';
								}

								$pro = $product->getPro();
								?>

								<tr>
								    <td>
										<?php echo $pro->name; ?>
									</td>
									<td>
										<?php echo $product->product_code; ?>
									</td>
									<td>
									    <img src="<?php echo $product->image_path; ?>" alt="Product Image" class='img-rounded'
											width="60" height="60">
									</td>
									<td>
										<?php echo $product->product_name; ?>
										<br>
										<p><strong>Descripción: </strong>
										<?php echo $product->note; ?>
										<br>
										<strong>Código SAT: </strong>
										<?php echo (isset($product->clave_sat) && ($product->clave_sat) != "") ? ($product->clave_sat) : '<strong>No asignado</strong>'; ?>
										</p>
									</td>

	

									<td>
										<?php 
										$selling_price = $product->selling_price;

										// Formatear el número con dos decimales y separador de miles
										$formatted_price = number_format($selling_price, 2, '.', ',');
										
										// Imprimir el precio formateado
										echo $formatted_price;
										?>
									</td>

									<td>
										<span class="<?php echo $product->lbl_class; ?>"><?php echo $product->lbl_status; ?></span>
									</td>

									<td>
									<form class="form-vertical" method="post" id="addcategory" action="./?action=products&opt=updateStatus">
									<div class="toggle-container">
										<input class="toggle-input" type="checkbox" name="product_status" data-product-id="<?php echo $product->product_id; ?>" <?php echo $checked; ?>>
										<svg class="toggle" viewBox="0 0 292 142" xmlns="http://www.w3.org/2000/svg">
											<path class="toggle-background" d="M71 142C31.7878 142 0 110.212 0 71C0 31.7878 31.7878 0 71 0C110.212 0 119 30 146 30C173 30 182 0 221 0C260 0 292 31.7878 292 71C292 110.212 260.212 142 221 142C181.788 142 173 112 146 112C119 112 110.212 142 71 142Z" />
											<rect class="toggle-icon on" x="64" y="39" width="12" height="64" rx="6" />
											<path class="toggle-icon off" fill-rule="evenodd" d="M221 91C232.046 91 241 82.0457 241 71C241 59.9543 232.046 51 221 51C209.954 51 201 59.9543 201 71C201 82.0457 209.954 91 221 91ZM221 103C238.673 103 253 88.6731 253 71C253 53.3269 238.673 39 221 39C203.327 39 189 53.3269 189 71C189 88.6731 203.327 103 221 103Z" />
											<g filter="url('#goo')">
											<rect class="toggle-circle-center" x="13" y="42" width="116" height="58" rx="29" fill="#fff"/>
											<rect class="toggle-circle left" x="14" y="14" width="114" height="114" rx="58" fill="#fff" />
											<rect class="toggle-circle right" x="164" y="14" width="114" height="114" rx="58" fill="#fff" />
											</g>
											<filter id="goo">
											<feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10" />
											<feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="goo" />
											</filter>
										</svg>
									</div>	
									</form>
									</td>
									<td>
										<a href="index.php?view=productos&opt=edit&product_id=<?php echo $product->product_id; ?>"
											class="btn btn-warning btn-xs" style="width:80px">Editar</a>
										<a href="index.php?action=products&opt=del&product_id=<?php echo $product->product_id; ?>"
											class="btn btn-danger btn-xs" style="width:80px">Eliminar</a>
									</td>
								</tr>
								<?php
							}

							echo "</table></div></div>";
			} else {
				echo "<p class='alert alert-danger'>No hay Conceptos</p>";
			}

			?>
				</div>
			</div>

			<script>
			$(document).ready(function() {
				$('.toggle-input').change(function() {
					var productId = $(this).data('product-id');
					var status = $(this).prop('checked') ? '1' : '0'; // '1' para activado, '0' para desactivado

					// Envía los datos al servidor usando AJAX
					$.ajax({
						type: 'POST',
						url: './?action=products&opt=updateStatus',
						data: {
							opt: 'updateStatus',
							product_id: productId,
							status: status
						},
						success: function(response) {
							// Maneja la respuesta del servidor si es necesario
							console.log(response); // Puedes mostrar un mensaje de éxito o realizar otras acciones
							if (response === 'Actualización exitosa') {
                        var statusCell = $('.toggle-input[data-product-id=' + productId + ']').closest('tr').find('td:eq(5)');

                        if (status === '1') {
                            statusCell.html('<span class="label label-success">Activo</span>');
                        } else {
                            statusCell.html('<span class="label label-danger">Inactivo</span>');
                        }
                    }
						},
						error: function() {
							console.error('Error al enviar los datos al servidor');
						}
					});
				});
			});
			</script>

		<?php } elseif (isset($_GET["opt"]) && $_GET["opt"] == "new") { ?>
			<?php
			$con = Database::getCon();
			?>
			<div class="row">
				<div class="col-md-12">

					<!-- NOTA : en la base de datos en el campo DATE_ADDED se le agrego atributo "predeterminado"  CURRENT_TIMES-->
					<h1>Agregar nuevo concepto</h1>
					<br>

					<div class="col-md-3" style="height:500px">
						<div class="box box-primary">
							<div class="box-body box-profile">
								<div id="load_img">
									<img class=" img-responsive" src="img/productos/product.png"
										alt="Bussines profile picture">
								</div>
								<h3 class="profile-username text-center"></h3>
								<p class="text-muted text-center mail-text"></p>
							</div>
						</div>
					</div>
					<div class="tab-content">
						<form class="form-vertical" method="post" id="addcategory" action="./?action=products&opt=add"
							role="form">
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-1 control-label">Categoría</label>
								<div class="col-md-3">
									<select class="form-control" name="category_id" required>
										<option value="">-- SELECCIONE --</option>
										<?php foreach (CategoriesData::getAll() as $parent): ?>
											<option value="<?php echo $parent->id; ?>"><?php echo $parent->name; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<!--  -->
							<?php
							$target_dir = "img/productos/product.png";
							$_SESSION['img_tmp'] = $target_dir;
							$product_id = time();
							?>
							<!--  -->
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-1 control-label">Código</label>
								<div class="col-md-2">
									<input type="text" name="product_code" required class="form-control" id="product_code"
										placeholder="Código">
								</div>
							</div>

							<div class="form-group">
								<label for="name" class="col-lg-4 control-label">Concepto*</label>
								<div class="col-md-6">
									<input type="text" name="product_name" required class="form-control" id="product_name"
										placeholder="Nombre">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-4 control-label">Descripción*</label>
								<div class="col-md-6">
									<input type="text" name="note" required class="form-control" id="note"
										placeholder="Descripción">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-4 control-label">Precio de venta*</label>
								<div class="col-md-6">
									<input type="duble" name="selling_price" required class="form-control"
										id="selling_price" placeholder="Precio de venta">
								</div>
							</div>
							<div class="form-group">
								<label for="tipo_concepto" class="col-lg-4 control-label">Selecciona el tipo del
									producto</label>
								<div class="col-md-6">
									<select class="form-control" data-live-search="true" name="tipo_concepto"
										id="tipo_concepto">
										<option value="">Seleccionar</option>
										<?php
										$tipo_c = mysqli_query($con, "SELECT * FROM tipo_concepto");
										while ($rwt = mysqli_fetch_array($tipo_c)) {
											?>
											<option value="<?php echo $rwt['id']; ?>"><?php echo ucwords($rwt['tipo']); ?>
											</option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="division" class="col-lg-4 control-label">Selecciona la división del
									producto</label>
								<div class="col-md-6">
									<select class="form-control" data-live-search="true" name="division" id="division">
										<option value=""></option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="grupo" class="col-lg-4 control-label">Selecciona el grupo del producto</label>
								<div class="col-md-6">
									<select class="form-control" data-live-search="true" name="grupo" id="grupo">
										<option value=""></option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="clase" class="col-lg-4 control-label">Selecciona la clase del producto</label>
								<div class="col-md-6">
									<select class="form-control" data-live-search="true" name="clase" id="clase">
										<option value=""></option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="clave" class="col-lg-4 control-label">Selecciona la clave del producto</label>
								<div class="col-md-6">
									<select class="form-control " name="clave" id="clave">
										<option value=""></option>
									</select>
								</div>
							</div>
							<div class="form-group hidden">
								<label for="inputEmail1" class="col-lg-4 control-label">Estado*</label>
								<div class="col-md-6">
									<input type="text" name="status" required class="form-control" id="status" value="1">
								</div>
							</div>
							<div class="form-group">
								<label for="ClaveUnidad" class="col-lg-offset-3 col-lg-4 control-label">Clave Unidad*</label>
								<div class="col-lg-offset-3 col-lg-6">
									<select class="form-control" data-live-search="true" name="ClaveUnidad"
											id="ClaveUnidad">
											<option value="">Seleccionar</option>
											<?php
											$tipo_cu = mysqli_query($con, "SELECT * FROM c_claveunidad WHERE idClaveUnidad=678");
											while ($rwu = mysqli_fetch_array($tipo_cu)) {
												$clave_tabla = $rwu['Nombre'];
												$clave_tablaU = $rwu['ClaveUnidad'];
												?>
												<option value="<?php echo $id_clave = $rwu['idClaveUnidad']; ?>"><?php echo $clave_tablaU ." - ". $clave_tabla  ?>
												</option>
											<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-offset-3 col-lg-12">
									<br>
									<button type="submit" class="btn btn-success">Guardar datos</button>
									<a href="javascript:history.back()" onclick="ConceptoCancelar()" class="btn btn-primary">Cancelar</a>
									<script>
										function ConceptoCancelar(){
											alert("El concepto fue cancelado.")
										}
									</script>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-------------------edicion---------------------------->
		<?php } elseif (isset($_GET["opt"]) && ($_GET["opt"] == "edit")) {
	$a = ProductsData::getCambio($_GET["product_id"]);
	$con = Database::getCon();
	if (isset($a)) {
		?>
				<div class="row">
					<div class="col-md-12">
						<h1>Edición</h1>
						<br>
						<form class="form-horizontal" method="post" id="addcategory" action="./?action=products&opt=update"
							role="form">
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-4 control-label">Categoría</label>
								<?php
								$query_categoria = mysqli_query($con, "SELECT * FROM categories WHERE id = '" . $a->category_id . "' ");
								$row_categoria = mysqli_fetch_array($query_categoria);
								$id_categoria = $row_categoria['id'];
								$name_categoria = $row_categoria['name'];
								?>
								<div class="col-md-3">
									<select class="form-control" name="category_id" id="catgory_id">
										<option value="<?php echo $a->category_id ?>" selected> <?php echo $name_categoria ?>
										</option>
										<?php foreach (CategoriesData::getAll() as $parent): ?>
											<option value="<?php echo $parent->id; ?>"><?php echo $parent->name; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<!-------------------------------------------------->
								<input type="hidden" name="product_id" id="product_id" value="<?php echo $a->product_id; ?>">
								<!-- actualiza los datos por ID -->
								<!-------------------------------------------------->
								<label for="inputEmail1" class="col-lg-1 control-label">Código</label>
								<div class="col-md-2">
									<input type="text" name="product_code" required class="form-control" id="product_code"
										value="<?php echo $a->product_code; ?>">
								</div>
							</div>

							<div class="form-group">
								<label for="name" class="col-lg-4 control-label">Nombre*</label>
								<div class="col-md-6">
									<input type="text" name="product_name" required class="form-control" id="product_name"
										value="<?php echo $a->product_name; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-4 control-label">Descripción*</label>
								<div class="col-md-6">
									<input type="text" name="note" required class="form-control" id="note"
										value="<?php echo $a->note; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-4 control-label">Precio de venta*</label>
								<div class="col-md-6">
									<input type="text" name="selling_price" required class="form-control" id="selling_price"
										value="<?php echo $a->selling_price; ?>">
								</div>
							</div>
							<div class="form-group hidden">
								<label for="inputEmail1" class="col-lg-4 control-label">Estado*</label>
								<div class="col-md-6">
									<input type="text" name="status" required class="form-control" id="status"
										value="<?php echo $a->selling_price; ?>">
								</div>
							</div>
							<div class="form-group hidden">
								<label for="inputEmail1" class="col-lg-4 control-label">Stock inicial*</label>
								<div class="col-md-6">
									<input type="text" name="stock" required class="form-control" id="stock" required
										pattern="\d{1,11}" value="10000" maxlength="11" value="<?php echo $a->stock; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="tipo_concepto" class="col-lg-4 control-label">Clave del producto actual</label>
								<div class="col-md-6">
									<input type="text" readonly id="clave_anterior" value="<?php echo (isset($a->clave_sat) && ($a->clave_sat) != "") ? ($a->clave_sat) : 'No asignado'; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="tipo_concepto" class="col-lg-4 control-label">Selecciona el tipo del
									producto</label>
								<div class="col-md-6">
									<select class="form-control" data-live-search="true" name="tipo_concepto"
										id="tipo_concepto">
										<option value="">Seleccionar</option>
										<?php
										$tipo_c = mysqli_query($con, "SELECT * FROM tipo_concepto");
										while ($rwt = mysqli_fetch_array($tipo_c)) {
											?>
											<option value="<?php echo $rwt['id']; ?>"><?php echo ucwords($rwt['tipo']); ?>
											</option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="division" class="col-lg-4 control-label">Selecciona la división del
									producto</label>
								<div class="col-md-6">
									<select class="form-control" data-live-search="true" name="division" id="division">
										<option value=""></option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="grupo" class="col-lg-4 control-label">Selecciona el grupo del producto</label>
								<div class="col-md-6">
									<select class="form-control" data-live-search="true" name="grupo" id="grupo">
										<option value=""></option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="clase" class="col-lg-4 control-label">Selecciona la clase del producto</label>
								<div class="col-md-6">
									<select class="form-control" data-live-search="true" name="clase" id="clase">
										<option value=""></option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="clave" class="col-lg-4 control-label">Selecciona la clave del producto</label>
								<div class="col-md-6">
									<select class="form-control " name="clave" id="clave">
										<option value=""></option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-offset-8 col-lg-10">
									<button type="submit" class="btn btn-success">Actualizar</button>
									<a href="javascript:history.back()" onclick="EdicionCancelar()" class="btn btn-primary">Cancelar</a>
									<script>
										function EdicionCancelar(){
											alert("La edición se cancelo.")
										}
									</script>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php
	} else {
		Core::alert("El producto fue eliminado");
		Core::redir("./?view=categorias&opt=all");
	}
} ?>

<script>
	// Productos o servicio ... llenado de campos.
	$(document).ready(function () {
		$('#tipo_concepto').on('change', function () {
			if ($('#tipo_concepto').val() == "") {
				$('#division').empty();
				$('<option value = "">Seleccionar</option>').appendTo('#division');
				$('#division').attr('disabled', 'disabled');
			} else {
				$('#division').removeAttr('disabled', 'disabled');
				//<!-- /NewGestalt/admin/?view=productos&opt=new -->
				//./?action=products&opt=update
				var parametros = { "division": $('#tipo_concepto').val() };
				$.ajax({
					url: './core/app/action/listar_tipoP_S-action.php',
					data: parametros,
					success: function (data) {
						$('#division').html(data);
					},
					error: function (response) {
						console.log(response)
					}
				})
			}
		});
	});
	$(document).ready(function () {
		$('#division').on('change', function () {
			if ($('#division').val() == "") {
				$('#grupo').empty();
				$('<option value = "">Seleccionar</option>').appendTo('#grupo');
				$('#grupo').attr('disabled', 'disabled');
			} else {
				$('#grupo').removeAttr('disabled', 'disabled');
				var parametros = { "grupo": $('#division').val() };
				$.ajax({
					url: './core/app/action/listar_tipoGrupo-action.php',
					data: parametros,
					success: function (data) {
						$('#grupo').html(data);
					},
					error: function (response) {
						console.log(response)
					}
				})
			}
		});
	});
	$(document).ready(function () {
		$('#grupo').on('change', function () {
			if ($('#grupo').val() == "") {
				$('#clase').empty();
				$('<option value = "">Seleccionar</option>').appendTo('#clase');
				$('#clase').attr('disabled', 'disabled');
			} else {
				$('#clase').removeAttr('disabled', 'disabled');
				var parametros = { "grupo": $('#grupo').val() };
				$.ajax({
					url: './core/app/action/listar_tipoClase-action.php',
					data: parametros,
					success: function (data) {
						$('#clase').html(data);
					},
					error: function (response) {
						console.log(response)
					}
				})
			}
		});
	});
	$(document).ready(function () {
		$('#clase').on('change', function () {
			if ($('#clase').val() == "") {
				$('#clave').empty();
				$('<option value = "">Seleccionar</option>').appendTo('#clave');
				$('#clave').attr('disabled', 'disabled');
			} else {
				$('#clave').removeAttr('disabled', 'disabled');
				/* $('#clave').load('./ajax/listar_tipoClave.php?clave=' + $('#clase').val()); */
				var parametros = { "clave": $('#clase').val() };
				$.ajax({
					url: './core/app/action/listar_tipoClaveaction.php',
					data: parametros,
					success: function (data) {
						$('#clave').html(data);
					},
					error: function (response) {
						console.log(response)
					}
				})
			}
		});
	});
	$(document).ready(function () {
		$('#clase').on('change', function () {
			if ($('#clase').val() == "") {
				$('#clave_num').empty();
				$('<option value = "">Seleccionar</option>').appendTo('#clave_num');
				$('#clave_num').attr('disabled', 'disabled');
			} else {
				$('#clave_num').removeAttr('disabled', 'disabled');
				$('#clave_num').load('./ajax/listar_tipoClave.php?clave=' + $('#clase').val());
			}
		});
	});
</script>