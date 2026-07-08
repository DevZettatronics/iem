<?php
session_start();
$sale_id = $_SESSION['sale_id'];
if (isset($_POST['id'])) {
	$id = $_POST['id'];
}
if (isset($_POST['cantidad'])) {
	$qty = intval($_POST['cantidad']);
}
if (isset($_POST['precio_venta'])) {
	floatval($unit_price = $_POST['precio_venta']);
}
/* Connect To Database*/
require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
require_once("../libraries/inventory.php"); //Contiene funcion que controla stock en el inventario

if (!empty($id) and !empty($qty) and !empty($unit_price)) {
	$stock = get_stock($id);
	if ($stock < $qty) {
?>
		<script>
			alert('No cuenta con suficiente stock para realizar la venta');
		</script>
<?php
	} else {
		$insert = mysqli_query($con, "INSERT INTO sale_product (sale_id,product_id,qty,unit_price) VALUES ('$sale_id','$id','$qty','$unit_price')");
		remove_inventory($id, $qty); //Disminuye la cantidad en el inventario;
	}
}
if (isset($_POST['key'])) {
	$key = intval($_POST['key']);
	if ($key == 1) {
		$person_id = intval($_POST['value']);
		$str = "person_id='$person_id'";
	} else if ($key == 2) {
		$tax_value = floatval($_POST['value']);
		$str = "tax_value='$tax_value'";
	}
	$update_sale = mysqli_query($con, "update sales set $str where sale_id='$sale_id'");

}

//codigo elimina un elemento de la DB
if (isset($_GET['id'])) {
	$sale_product_id = intval($_GET['id']);
	$sql_sale = mysqli_query($con, "select product_id, qty from  sale_product where sale_product_id='" . $sale_product_id . "'");
	$rw_sale = mysqli_fetch_array($sql_sale);
	$product_id_remove = $rw_sale['product_id'];
	$qty_remove = $rw_sale['qty'];
	$delete = mysqli_query($con, "DELETE FROM sale_product WHERE sale_product_id='" . $sale_product_id . "'");
	add_inventory($product_id_remove, $qty_remove); //Agrego producto al inventario
}
/*Datos de la empresa*/
$sql_empresa = mysqli_query($con, "SELECT * FROM  business_profile, currencies where business_profile.currency_id=currencies.id and business_profile.id=1");
$rw_empresa = mysqli_fetch_array($sql_empresa);
$moneda = $rw_empresa["symbol"];

/*Fin datos empresa*/
$tax = get_id("sales", "tax_value", "sale_id", $sale_id);
?>

<!-- vista tabla -->
<div class="table-responsive">
	<table class="table">
		<tr>
			<th>CODIGO</th>
			<th class='text-center'>CANT.</th>
			<th>DESCRIPCION</th>
			<th><span class="pull-right">PRECIO UNIT.</span></th>
			<th><span class="pull-right">PRECIO TOTAL</span></th>
			<th></th>
		</tr>
		<?php
		$sql_taxes = mysqli_query($con, "select * from taxes where status=1");
		$sumador_total = 0;
		$sql = mysqli_query($con, "select * from products, sale_product where products.product_id=sale_product.product_id and sale_product.sale_id='$sale_id'");
		while ($row = mysqli_fetch_array($sql)) {
			$product_id = $row['product_id'];
			$sale_product_id = $row["sale_product_id"];
			$product_code = $row['product_code'];
			$qty = $row['qty'];
			$product_name = $row['product_name'];
			$unit_price = number_format($row['unit_price'], $currency_format['precision_currency'], '.', '');

			$precio_total = $unit_price * $qty;
			$precio_total = number_format($precio_total, $currency_format['precision_currency'], '.', ''); //Precio total formateado
			$sumador_total += $precio_total; //Sumador

		?>
			<tr>
				<td><?php echo $product_code; ?></td>
				<td class='text-center'><?php echo $qty; ?></td>
				<td><?php echo $product_name; ?></td>
				<td><span class="pull-right"><?php echo number_format($unit_price, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></span></td>
				<td><span class="pull-right"><?php echo number_format($precio_total, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></span></td>
				<td><span class="pull-right"><a href="#" onclick="eliminar('<?php echo $sale_product_id ?>')"><i class="glyphicon glyphicon-trash"></i></a></span></td>
			</tr>
		<?php

		}
		$total_parcial = number_format($sumador_total, $currency_format['precision_currency'], '.', '');
		$total_neto = $total_parcial;
		$total_neto = number_format($total_neto, $currency_format['precision_currency'], '.', '');
		$total_iva = ($total_neto * $tax) / 100;
		$total_iva = number_format($total_iva, $currency_format['precision_currency'], '.', '');
		$total_compra = $total_neto + $total_iva;
		$total_compra = number_format($total_compra, $currency_format['precision_currency'], '.', '');
		$update = mysqli_query($con, "update sales set subtotal='$total_neto', tax='$total_iva', total='$total_compra' where sale_id='$sale_id'");
		?>


		<tr>
			<td colspan=4><span class="pull-right">NETO <?php echo $moneda; ?></span></td>
			<td><span class="pull-right"><?php echo number_format($total_neto, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></span></td>
			<td></td>
		</tr>
		<tr>
			<td colspan=4 class='text-right'>
				<select name="taxes" id="taxes" onchange="update_sale(2,this.value);">
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
			</td>
			<td><span class="pull-right"><?php echo number_format($total_iva, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></span></td>
			<td></td>
		</tr>
		<tr>
			<td colspan=4><span class="pull-right">TOTAL <?php echo $moneda; ?></span></td>
			<td><span class="pull-right"><?php echo number_format($total_compra, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></span></td>
			<td></td>
		</tr>
	</table>
</div>
<!-- fin de vista tabla -->