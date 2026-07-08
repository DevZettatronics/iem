<?php if (isset($_GET["opt"]) && $_GET["opt"] == "all") : ?>

	<div class="row">
		<div class="col-md-12">
			<h1>Categorias</h1>
			<a href="./?view=categorias&opt=new" class="btn btn-default"><i class='fa fa-asterisk'></i> Nueva categoria</a>
			<br>
			<br>
			<?php

			$categories = CategoriesData::getAll();


			if (count($categories) > 0) {
				// si hay usuarios
			?>
				<div class="box box-primary">
					<div class="box-body">
						<table class="table table-bordered datatable table-hover">
							<thead>
								<tr>
									<!-- Se ñaden las columnas 24/mayo/2021 -->
									<th>Categoría</th>
									<th class="text-left">Nº de Servicios</th>
									<th>Estado</th>
									<th>Agregado</th>
									<th>Acciones</th>

								</tr>
							</thead>

							<?php

							foreach ($categories as $cate) {
								$date = new DateTime($cate->date_added);	//Objeto para definir la fecha 24/mayo/2021
								$cate->status; // agregado 25/05/2021 para darle sentido y estilo al estado 
								if ($cate->status == 1) {
									$cate->lbl_status = "Activo";
									$cate->lbl_class = 'label label-success';
								} else {
									$cate->lbl_status = "Inactivo";
									$cate->lbl_class = 'label label-danger';
								}
							?>

								<tr>
									<!-- PARA QUE SE MUESTRE TODOS EN MAYUSCULAS  -->
									<td><?php echo strtoupper($cate->name); ?></td>
									<!-- Clase::nombreDeLaFuncion($parametros,$parametros) 
										26/05/2021-->
									<td><?php echo count(ProductsData::getStock($cate->id)); ?> </td>
									<td>
										<!-- agregado 25/05/2021 -->
										<span class="<?php echo $cate->lbl_class; ?>"><?php echo $cate->lbl_status; ?></span>
									</td>
									<td><?php echo $date->format('d-m-Y'); //24/mayo/2021
										?></td>

									<td style="width:130px;">
										<a href="index.php?view=categorias&opt=edit&id=<?php echo $cate->id; ?>" class="btn btn-warning btn-xs">Editar</a>
										<a href="index.php?action=categorias&opt=del&id=<?php echo $cate->id; ?>" class="btn btn-danger btn-xs">Eliminar</a>
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

				<!-- ////////// NO MOVER -->

				<!-- AGREGAR -->
			<?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "new") : ?>
				<div class="row">
					<div class="col-md-12">

						<!-- NOTA : en la base de datos en el campo DATE_ADDED se le agrego atributo "predeterminado"  CURRENT_TIMES-->
						<h1>Nueva Categoria</h1>
						<br>
						<form class="form-horizontal" method="post" id="addcategory" action="./?action=categorias&opt=add" role="form">
							<div class="form-group">
								<label for="name" class="col-lg-2 control-label">Nombre*</label>
								<div class="col-md-6">
									<input type="text" name="name" required class="form-control" id="name" placeholder="Nombre">
								</div>
							</div>
							<div class="form-group">
								<label for="descripcion" class="col-lg-2 control-label">Descripción*</label>
								<div class="col-md-6">
									<input type="text" name="descripcion" required class="form-control" id="descripcion" placeholder="Descripción">
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
									<button type="submit" class="btn btn-primary">Agregar Categoría</button>
								</div>
							</div>
						</form>
					</div>
				</div>



				<!-- EDITAR -->
				<?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "edit") :
				$a = CategoriesData::getById($_GET["id"]);
				if (isset($a)) {
				?>
					<div class="row">
						<div class="col-md-12">
							<h1>Editar Categoría</h1>
							<br>
							<form class="form-horizontal" method="post" id="addcategory" action="./?action=categorias&opt=update" role="form">
								<div class="form-group">
									<label for="name" class="col-lg-2 control-label">Nombre*</label>
									<div class="col-md-6">
										<input type="text" name="name" value="<?php echo $a->name; ?>" required class="form-control" id="name" placeholder="Nombre">
									</div>
								</div>
								<div class="form-group">
									<label for="descripcion" class="col-lg-2 control-label">Descripción*</label>
									<div class="col-md-6">
										<input type="text" name="descripcion" value="<?php echo $a->descripcion; ?>" required class="form-control" id="descripcion" placeholder="Descripción">
									</div>
								</div>

								<div class="form-group">
									<div class="col-lg-offset-2 col-lg-10">
										<input type="hidden" name="id" value="<?php echo $a->id; ?>">
										<button type="submit" class="btn btn-success">Actualizar</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<!-- ////////// NO MOVER -->
			<?php
				} else {
					Core::alert("La categoria fue eliminada");
					Core::redir("./?view=categorias&opt=all");
				}
			endif; ?>