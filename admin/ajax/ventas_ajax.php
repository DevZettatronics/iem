<?php
session_start();
/* Connect To Database*/
require_once("../config/db.php");
require_once("../config/conexion.php");
require_once("../libraries/inventory.php"); //Contiene funcion que controla stock en el inventario
//Inicia Control de Permisos
include("../config/permisos.php");
$user_id = $_SESSION['user_id'];
get_cadena($user_id);
$modulo = "Ventas";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
	$query = mysqli_real_escape_string($con, (strip_tags($_REQUEST['query'], ENT_QUOTES)));
	$customer_id = intval($_REQUEST['customer_id']);
	$tables = "sales, users";
	$campos = "*";
	$sWhere = "users.user_id=sales.sale_by";
	$sWhere .= " and sales.sale_number LIKE '%" . $query . "%'";
	$sWhere .= " and sales.total >0";
	if ($customer_id > 0) {
		$sWhere .= " and sales.customer_id = '" . $customer_id . "'";
	}
	$sWhere .= " order by sales.sale_id desc";


	include 'pagination.php'; //include pagination file
	//pagination variables
	$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
	$per_page = intval($_REQUEST['per_page']); //how much records you want to show
	$adjacents  = 4; //gap between pages after number of adjacents
	$offset = ($page - 1) * $per_page;
	//Count the total number of row in your table*/
	$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $tables where $sWhere ");
	if ($row = mysqli_fetch_array($count_query)) {
		$numrows = $row['numrows'];
	} else {
		echo mysqli_error($con);
	}
	$total_pages = ceil($numrows / $per_page);
	$reload = './permisos.php';
	//main query to fetch the data
	$query = mysqli_query($con, "SELECT $campos FROM  $tables where $sWhere LIMIT $offset,$per_page");
	//loop through fetched data



	if ($numrows > 0) {

?>

		<section class="content">
			<div class="row">
				<div class="col-md-12">

					<div class="box box-primary">
						<div class="box-body">
							<table class="table table-bordered datatable table-hover">
								<thead>
									<th class='text-center'>Documento Nº</th>
									<th>Cliente</th>
									<th class="text-center"> Método de pago</th>
									<th class='text-center'>Fecha </th>
									<th>Cajero </th>
									<th class='text-right'>Total</th>

									<th></th>
								</thead>
								<?php
								$finales = 0;
								while ($row = mysqli_fetch_array($query)) {
									$sale_id = $row['sale_id'];
									$sale_number = $row['sale_number'];
									$customer_id = $row['customer_id'];
									$typeDocument = $row['type_document'];
									$paymentMethod = $row['payment_method'];
									$sql_customer = mysqli_query($con, "select name from customers where id='" . $customer_id . "'");
									$rw_customer = mysqli_fetch_array($sql_customer);
									$customer_name = $rw_customer['name'];

									$date_added = $row['sale_date'];
									$user_fullname = $row['fullname'];
									$subtotal = $row['subtotal'];
									$tax = $row['tax'];
									$total = $row['total'];
									list($date, $hora) = explode(" ", $date_added);
									list($Y, $m, $d) = explode("-", $date);
									$fecha = $d . "-" . $m . "-" . $Y;
									$finales++;
									if ($typeDocument == 1) {
										$typeDocumentName = "Factura";
									} else {
										$typeDocumentName = "Ticket";
									}

									if ($paymentMethod == 1) {
										$paymentMethodName = "Efectivo";
									} else if ($paymentMethod == 2) {
										$paymentMethodName = "SPEI";
									} else {
										$paymentMethodName = "Tarjeta";
									}

								?>
									<tr>
										<td class='text-center'><?php echo $sale_number; ?></td>
										<td><?php echo $customer_name; ?></td>
										<td class="text-center"> <?php echo $paymentMethodName; ?> </td>
										<td class='text-center'><?php echo $fecha; ?></td>
										<td><?php echo $user_fullname; ?></td>
										<td class='text-right'><?php echo number_format($total, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></td>


										<td>
											<div class="btn-group pull-right">
												<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
												<ul class="dropdown-menu">
													<?php if ($permisos_editar == 1) { ?>
														<!-- <li><a href="edit_pos.php?id=<?php echo $sale_id; ?>"><i class='fa fa-edit'></i> Editar</a></li> -->
													<?php }
													if ($permisos_ver == 1) {
													?>
														<!-- <li><a href="#" onclick="view_pdf('<?php echo $sale_id; ?>', '<?php echo $typeDocument; ?>');"><i class='fa fa-file-pdf-o'></i> Ver PDF</a></li> -->
													<?php
													}
													if ($permisos_eliminar == 1) {
													?>
														<li><a href="#" onclick="eliminar('<?php echo $sale_id; ?>')"><i class='fa fa-trash'></i> Borrar</a></li>
													<?php } ?>
												</ul>
											</div><!-- /btn-group -->
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