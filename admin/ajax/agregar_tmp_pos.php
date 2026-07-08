<?php
session_start();
$user_id = $_SESSION['user_id'];
if (isset($_POST['id'])) {
	$id = $_POST['id'];
}
if (isset($_POST['id_plan'])) {
	$id_plan = $_POST['id_plan'];
}
if (isset($_POST['cantidad'])) {
	$qty = intval($_POST['cantidad']);
}
if (isset($_POST['precio_venta'])) {
	floatval($unit_price = $_POST['precio_venta']);
}

if (isset($_POST['vinculacion'])) {
	$vinculacion = intval($_POST['vinculacion']);
}


/* Connect To Database*/
require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
require_once("../libraries/inventory.php"); //Contiene funcion que controla stock en el inventario

if (!empty($id) and !empty($qty) and !empty($unit_price)) {
	
	if (validarTablaTemporal($id, $user_id, $id_plan, $vinculacion)) {
		global $con;
		// $sql = mysqli_query($con, "UPDATE  product_tmp  set qty =qty+'" . $qty . "'  WHERE product_id='" . $id . "' and  user_id='" . $user_id . "' ");
	} else {

		add_tmp($id, $qty, $unit_price, $user_id,$id_plan, $vinculacion);
	}
	
}

// Cambio de stock
if (isset($_GET['cantidad'])) {
	$cantidad = intval($_GET['cantidad']);
	$product_id = intval($_GET['idproducto']);
	$vinculacion = intval($_GET['vinculacion']);
	$id_plans = 0;
	//echo var_dump($product_id);
	// echo "vinculacion: " . $vinculacion;
	$stock = get_stock($product_id, $vinculacion);
	//echo var_dump($stock);
	if ($cantidad == 0) {
	?>
		<script>
			alert('Cantidad debe ser mayor a 0');
		</script>
	<?php
		$cantidad = 1;
	}

	if ($stock < $cantidad) {
	?>
		<script>
			alert('No cuenta con suficiente stock para realizar la venta');
		</script>
<?php
	} else {

		if (validarTablaTemporal($product_id, $user_id, $id_plans, $vinculacion)) {
			global $con;
			$sql = mysqli_query($con, "UPDATE  product_tmp  set qty ='" . $cantidad . "'  WHERE product_id='" . $product_id . "' and  user_id='" . $user_id . "' ");
			// $sql = mysqli_query($con, "UPDATE  product_tmp  set qty ='" . $cantidad . "'  WHERE product_id='" . $product_id . "' and  user_id='" . $user_id ."'and id_plan'".$id_plan. "' ");
		}
	}
}
if (isset($_GET['id'])) //codigo elimina un elemento de la DB
{
	$id_tmp = intval($_GET['id']);
	remove_tmp($id_tmp);
	// echo '<script>resetearBandera();</script>';

}

/*Datos de la empresa*/
$sql_empresa = mysqli_query($con, "SELECT * FROM  business_profile, currencies WHERE business_profile.currency_id=currencies.id and business_profile.id=1");
$rw_empresa = mysqli_fetch_array($sql_empresa);
$moneda = $rw_empresa["symbol"];

/*Fin datos empresa*/
$tax = floatval($_REQUEST['tax']);
$descuento = floatval($_REQUEST['descuento']);

$recargo = !empty($_REQUEST['recargo']) ? floatval($_REQUEST['recargo']) : 0;



if ($descuento < 0) {
	echo "<script>alert('Descuento debe ser mayor a 0.')</script>";
	$descuento = 0;
}

// echo var_dump($descuento);
?>



<table class="table" id="cartTable" style="height: 55%;">
    <thead>
        <tr>
            <th>#</th>
            <th>PRODUCTO</th>
            <th>CANT.</th>
            <th>P. UNIT.</th>
            <th>P. TOTAL</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql_taxes = mysqli_query($con, "SELECT * FROM taxes WHERE status=1");
        $sumador_total = 0;
		// Asegúrate de recibir el valor de vinculacion

		$query_tmp = "SELECT * FROM product_tmp WHERE user_id = '$user_id'";
		$sql_tmp = mysqli_query($con, $query_tmp);

        // $query = "SELECT * FROM products, product_tmp WHERE products.product_id=product_tmp.product_id AND product_tmp.user_id='$user_id'";

        // $sql = mysqli_query($con, $query);
        $numsProductos = 1;
		$numsItems = 0;
       	while ($row_tmp = mysqli_fetch_array($sql_tmp)) {
            $product_id = $row_tmp['product_id'];
            $id_tmp = $row_tmp["id_tmp"];
            $qty = $row_tmp['qty'];
			$vinculacion = $row_tmp['vinculacion']; // Aquí tienes el campo para decidir
            
			// Según el valor de vinculacion, haces una consulta para obtener los datos del producto:
			if ((int)$vinculacion === 1) {
				// Buscas en conceptos
				$query_producto = "SELECT * FROM conceptos WHERE id = '$product_id' ";
			} else {
				// Buscas en products
				$query_producto = "SELECT * FROM products WHERE product_id = '$product_id'";
			}

			$sql_producto = mysqli_query($con, $query_producto);
    		$row_producto = mysqli_fetch_array($sql_producto);

			// $product_code = $row_producto ? $row_producto['product_code'] : 0;
			// $id_pp = $row_producto ? $row_producto['id_plan'] : 0;
			$product_code = isset($row_producto['product_code']) ? $row_producto['product_code'] : 0;
			$id_pp = isset($row_producto['id_plan']) ? $row_producto['id_plan'] : 0;


            $product_name = $row_producto['product_name'];
            $unit_price = number_format($row_tmp['unit_price'], $currency_format['precision_currency'], '.', '');
            

            $precio_total = $unit_price * $qty;
            $precio_total = number_format($precio_total, $currency_format['precision_currency'], '.', '');
            $sumador_total += $precio_total;

			// echo "vinculacion: " . $vinculacion;
        ?>
            <tr>
                <td><?php echo $numsProductos; ?></td>
                <td><?php echo $product_name; ?></td>
                <td>
                    <input
                        <?php echo ($vinculacion == 1) ? '' : 'readonly'; ?>
                        type="number"
                        class="form-control input-sm"
                        style="width: 65px;"
                        id="cant_<?php echo $product_id; ?>"
                        oninput="updateCant(this.value, '<?php echo $product_id; ?>')"
                        value="<?php echo $qty; ?>"
                    >
                </td>
                <td>
                    <span class="pull-right">
                        <?php echo number_format($unit_price, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?>
                    </span>
                </td>
                <td>
                    <span class="pull-right">
                        <?php echo number_format($precio_total, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?>
                    </span>
                </td>
                <td>
                    <button class="btn btn-danger btn-xs" onclick="eliminar('<?php echo $id_tmp; ?>')">
                        <i class="fa fa-times"></i>
                    </button>
                </td>
            </tr>
        <?php
            $numsProductos++;
			$numsItems++;
            if ($id_pp > 0) {
                // Aquí podrías cargar promociones, 
            }
        } ?>
    </tbody>
</table>

<?php
$total_parcial = number_format($sumador_total, $currency_format['precision_currency'], '.', '');
$total_neto = $total_parcial;
$total_neto = number_format($total_neto, $currency_format['precision_currency'], '.', '');
$precio_descuento = ($total_neto * $descuento) / 100;

if ($precio_descuento <= 0 && $total_neto <= 0) {
} else {

	if ($precio_descuento >= $total_neto) {
		echo "<script>alert('El descuento no puede ser mayor al precio ');</script>";
		$descuento = 0;
		$precio_descuento = 0;
	}
}


if ($descuento > 0) {
	$precio_descuento = ($total_neto * $descuento) / 100;
	$total_descuento = ($total_neto - $precio_descuento);
	$total_iva = ($total_descuento * $tax) / 100;
	$total_compra = ($total_descuento + $total_iva);
} else {

	$total_iva = ($total_neto * $tax) / 100;
	$total_iva = number_format($total_iva, $currency_format['precision_currency'], '.', '');
	$total_compra = $total_neto + $total_iva;
	$total_compra = number_format($total_compra, $currency_format['precision_currency'], '.', '');
}
?>
<hr>
<div class="m-t-10">
	<div class="row">
		<div class="col-md-4"><label class="control-label">Total Item(s) </label></div>
		<div class="col-md-2">: <span id="total"><label class="control-label"><?php echo $numsItems; ?></label></sapn>
		</div>
		<?php
		$validarDescuento = $total_neto;
		$label = "NETO:";


		// if ($descuento>0) {
		// 		$label = "NETO(incluye descuento)";
		// 		$validarDescuento=$total_descuento;

		// }
		?>
		<div class="col-md-3"> <label class="control-label"><?php echo $label; ?></label> </div>
		<div class="col-md-3">: <span id="price"><label class="control-label"><?php echo number_format($validarDescuento, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></label></span></div>

	</div>
</div>
<?php

$precio_descuento = ($total_neto * $descuento) / 100;

			if ($descuento > 0) {
				$precio_descuento = ($total_neto * $descuento) / 100;
				$total_descuento = ($total_neto - $precio_descuento);
				$total_iva = ($total_descuento * $tax) / 100;
				$total_compra = ($total_descuento + $total_iva);
			} else {

				$total_iva = ($total_neto * $tax) / 100;
				$total_iva = number_format($total_iva, $currency_format['precision_currency'], '.', '');
				$total_compra = $total_neto + $total_iva;
				$total_compra = number_format($total_compra, $currency_format['precision_currency'], '.', '');
			}
			?>
<div class="m-t-10">
	<div class="row">
		<div class="col-md-4"> <label class="control-label">Descuento(%) </label></div>
				<!-- <div class="col-md-2"></div> -->
				<div class="col-md-4"><input class="form-control input-sm" required pattern="\d+(\.\d{2})?" type="number" id="descuento" value="<?php echo $descuento ?>" onblur="descuento(this.value)"></div>
				<!-- <div class="col-md-4"> <input class="form-control input-sm" required pattern="\d+(\.\d{2})?" type="number" id="descuento" value="<?php echo $descuento ?>" onblur="actualizarDescuento(this.value)"></div> -->
				<div class="col-md-3 col-md-offset-1">: <span id="price"> <label class="control-label"><?php echo number_format($precio_descuento, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></label></span></div>
			</div>

	</div>
</div>

<?php
	//Recargo
	$total_compra = $total_compra + $recargo;

?>
<div class="m-t-10">
	<!-- <p style="color: red; font-weight: bold;">Nota: los recargos no afectan el cálculo del IVA ni del descuento. Se agregan al final (Siempre).</p> -->

	<div class="row">
		<div class="col-md-4"> <label class="control-label">Recargos </label></div>
				<!-- <div class="col-md-2"></div> -->
				<div class="col-md-4"><input class="form-control input-sm" required pattern="\d+(\.\d{2})?" type="number" id="recargo" value="<?php echo $recargo ?>" onblur="recargo(this.value)"></div>
				<!-- <div class="col-md-4"> <input class="form-control input-sm" required pattern="\d+(\.\d{2})?" type="number" id="descuento" value="<?php echo $descuento ?>" onblur="actualizarDescuento(this.value)"></div> -->
				<div class="col-md-3 col-md-offset-1">: <span id="price"> <label class="control-label"><?php echo number_format($recargo, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></label></span></div>
			</div>

	</div>
</div>

<div class="m-t-10">
	<div class="row">
		<div class="col-md-4"><label class="control-label">IVA(%)</label> </div>
		<div class="col-md-4">
			<select name="taxes" class="form-control input-sm" id="taxes" onchange="tax_value(this.value)">
				<?php
				foreach ($sql_taxes as $valor) {
					if ($tax == $valor['value']) {
						$selected = "selected";
					} else {
						$selected = "";
					}
					echo '<option value="' . $valor['value'] . '" ' . $selected . '>' . $valor['name'] . " " . $valor['value'] . ' %</option>';
				}
				?>

			</select>
		</div>
		<!-- <div class="col-md-2"></div> -->
		<div class="col-md-3 col-md-offset-1">: <span id="price"><label class="control-label"><?php echo number_format($total_iva, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></label></span></div>
	</div>
</div>

<div class="m-t-10">
	<div class="row">
		<div class="col-md-3 col-md-offset-6">
			<h3> <label class="control-label">TOTAL</label> </h3>
		</div>
		<div class="col-md-3">
			<h3>
				<label class="control-label">
					<?php echo number_format($total_compra, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?>

				</label>
			</h3>
			<!-- <input type="hidden" id="total" name="total"  value="<?php echo number_format($total_compra, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?>">
           		 <?php
					if (isset($_POST['total'])) {

						echo json_encode($total_compra); // number_format($total_compra,$currency_format['precision_currency'],$currency_format['decimal_separator'],$currency_format['thousand_separator']);
					}
					?> -->
		</div>

	</div>
</div>

<!-- <form  method="post" name="save_sale" id="save_sale"> -->
<div class="button-list pull-right">
	<button data-toggle="modal" data-target="#paymentModel" value="<?php echo $total_compra; ?>" onclick="modalPago(this.value);" id="payButton" class="btn btn-danger waves-effect waves-light">
		<span class="btn-label"><i class="fa fa-money"></i></span>Pagar
	</button>
</div>
<hr>