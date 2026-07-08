<?php

/* Connect To Database*/
require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
require_once("../libraries/inventory.php"); //Contiene funcion que conecta a la base de datos
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
	// escaping, additionally removing everything that could be (html/javascript-) code
	if (isset($_REQUEST['id_vinculacion'])) {	
		$id_vinculacion = mysqli_real_escape_string($con, $_REQUEST['id_vinculacion']);

		$per_page = 5; //how much records you want to show	
		$sql = "SELECT * FROM conceptos WHERE centro_id = '$id_vinculacion'";
		$query_count = "SELECT count(*) AS numrows FROM conceptos WHERE centro_id = '$id_vinculacion'";
		$count_query = mysqli_query($con, $query_count);
		$row = mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		if($numrows >= 1){
			$total_pages = ceil($numrows / $per_page);
			$reload = './index.php';
		}else{
			$numrows = 0;
			$total_pages = ceil($numrows / $per_page);
			$reload = './index.php';
		}
		$query = mysqli_query($con, $sql);
	} else {
		$q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$category_id = mysqli_real_escape_string($con, (strip_tags($_REQUEST["categoria"], ENT_QUOTES)));
		// echo $category_id;
		$aColumns = array('nombre', 'monto'); //Columnas de busqueda
		$sTable = "conceptos";
		$sWhere = "";

		$sWhere = " WHERE status = 1";

		if (!empty($category_id)) {
			$sWhere .= " AND category_id = " . $category_id;
		}

		if (!empty($q)) {
			$sWhere .= " AND (nombre LIKE '%" . $q . "%' OR monto LIKE '%" . $q . "%')";
		}
		
		$sWhere .= " ORDER BY id DESC";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
		$per_page = 5; //how much records you want to show
		$adjacents = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable $sWhere");
		$row = mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows / $per_page);
		$reload = './index.php';
		//main query to fetch the data
		//$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$sql = "SELECT * FROM  $sTable $sWhere";
		$query = mysqli_query($con, $sql);
		
	}

	//loop through fetched data
	if ($numrows > 0) {

		/*Datos de la empresa*/
		$sql_empresa = mysqli_query($con, "SELECT * FROM  business_profile, currencies WHERE business_profile.currency_id=currencies.id AND business_profile.id=1");
		$rw_empresa = mysqli_fetch_array($sql_empresa);
		$moneda = $rw_empresa["symbol"];
		/*Fin datos empresa*/
		while ($row = mysqli_fetch_array($query)) {
			$id_producto = $row['id'];
			$id_plan = 0;
			// $product_code = $row['product_code'];
			$product_name = $row['product_name'];
			$descripcion = "Vinculación";
			$image_path = $row['image_path'];
			// $note = $row['note'];
			$category_id = $row['category_id'];
			// echo $category_id;
			$fecha_inicio = date('d-m-Y');
			$sql_marca = mysqli_query($con, "SELECT name FROM categories WHERE id='$category_id'");
			$rw_marca = mysqli_fetch_array($sql_marca);
			// $nombre_marca = $rw_marca['name'];
			$selling_price = $row["monto"];
			$selling_price = number_format($selling_price, $currency_format['precision_currency'], '.', '');
			?>
			<div class="col-lg-4 col-xs-4 col-sm-4 box Oil">
				<!-- <div class="widget-panel widget-style-2 "> -->
				<center>
				<img src="<?php echo $image_path; ?>" onclick="agregar('<?php echo $id_producto; ?>', '<?php echo $id_plan; ?>')" height="70px" width="70px" alt="">
				</center>
				<div class="text-muted m-t-5 text-center" style="height: 40px"><span class="name">
						
						<?php echo $product_name; ?> <br>
						<?php echo $descripcion; ?> <br>
						<?php echo $fecha_inicio; ?> <br>
						<!-- <?php //echo $id_plan ?> -->
						<input type="hidden" value="<?php echo $fecha_inicio; ?>" id="fecha_<?php echo $id_producto; ?>" name="">
					</span> <br>
					<input type="hidden" value="1" id="cantidad_<?php echo $id_producto; ?>" name="">
					<input type="hidden" value="1" id="vinculacion" name="">
					<!-- <span class="sku"><?php //echo $note; ?></span> -->
				</div>
				<h4 class="text-success text-center">
					<input type="hidden" value="<?php echo $selling_price; ?>" id="precio_venta_<?php echo $id_producto; ?>"
						name="">
					<b data-plugin="counterup">
						<?php echo $moneda; ?>
						<?php echo $selling_price; ?>
					</b>
				</h4>
				<!-- </div> -->
			</div>
			<?php
		}
	?>
	<?php
	}else{
		?>
		<div class="col-lg-4 col-xs-4 col-sm-4 box Oil">
				<!-- <div class="widget-panel widget-style-2 "> -->
				<p>No hay conceptos disponibles en vinculación</p>
				<!-- </div> -->
			</div>
		<?php
	}
}
?>