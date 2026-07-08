<?php

/* Connect To Database*/
require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
require_once("../libraries/inventory.php"); //Contiene funcion que conecta a la base de datos
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
	// escaping, additionally removing everything that could be (html/javascript-) code
	if (isset($_REQUEST['id_estudiante'])) {	
		$per_page = 5; //how much records you want to show	
		//$sql = "SELECT * FROM products INNER JOIN plan_de_pago ON plan_de_pago.concepto = products.product_id WHERE plan_de_pago.alumno = '" . $_REQUEST['id_estudiante'] . "' AND products.status = 1";
		$sql = "SELECT * FROM products INNER JOIN plan_de_pago ON plan_de_pago.concepto = products.product_id WHERE plan_de_pago.alumno = '" . $_REQUEST['id_estudiante'] . "' AND products.status = 1 AND (plan_de_pago.status = 1||plan_de_pago.status = 4||plan_de_pago.status = 6)";
		$query_count = "SELECT count(*) AS numrows FROM products INNER JOIN plan_de_pago ON plan_de_pago.concepto = products.product_id WHERE plan_de_pago.alumno = '" . $_REQUEST['id_estudiante'] . "' AND products.status = 1";
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
		$aColumns = array('product_code', 'product_name'); //Columnas de busqueda
		$sTable = "products";
		$sWhere = "";

		$sWhere = " WHERE status = 1";

		if (!empty($category_id)) {
			$sWhere .= " AND category_id = " . $category_id;
		}

		if (!empty($q)) {
			$sWhere .= " AND (product_code LIKE '%" . $q . "%' OR product_name LIKE '%" . $q . "%')";
		}
		// // $sWhere .= " ";
		// if ($_GET['q'] != "") {
		// 	$sWhere .= " WHERE (product_code LIKE '%" . $q . "%' OR product_name LIKE '%" . $q . "%')";
		// }

		// if ($_GET['categoria'] != "") {
		// 	$sWhere .= " WHERE category_id=" . $category_id . "";
		// }
		// $sWhere .= " AND status=1";
		$sWhere .= " ORDER BY products.product_name";
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
			$id_producto = $row['product_id'];
			$id_plan =isset($row ['id']) ? $row['id'] : '0';
			$product_code = $row['product_code'];
			$product_name = $row['product_name'];
			$descripcion = $row['note'];
			$image_path = $row['image_path'];
			$note = $row['note'];
			$category_id = $row['category_id'];
			$fecha_inicio = isset($row['fecha_inicio_pago']) ? date('d-m-Y', strtotime($row['fecha_inicio_pago'])) : '';
			$sql_marca = mysqli_query($con, "SELECT name FROM categories WHERE id='$category_id'");
			$rw_marca = mysqli_fetch_array($sql_marca);
			$nombre_marca = $rw_marca['name'];
			$selling_price = $row["selling_price"];
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
						<!-- <?php echo $id_plan ?> -->
						<input type="hidden" value="<?php echo $fecha_inicio; ?>" id="fecha_<?php echo $id_producto; ?>" name="">
					</span> <br>
					<input type="hidden" value="1" id="cantidad_<?php echo $id_producto; ?>" name="">
					<!-- <span class="sku"><?php //echo $note; ?></span> -->
					 <input type="hidden" value="2" id="vinculacion" name="">
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
				<p>El alumno no tiene plan de pagos cargado</p>
				<!-- </div> -->
			</div>
		<?php
	}
}
?>