<style type="text/css">
	div.zone {
		border: solid 0.5mm red;
		border-radius: 2mm;
		padding: 1mm;
		background-color: #FFF;
		color: #440000;
	}

	div.zone_over {
		width: 30mm;
		height: 20mm;

	}

	.bordeado {
		border: solid 0.5mm #eee;
		border-radius: 1mm;
		padding: 0mm;
		font-size: 12px;
	}

	.table {
		border-spacing: 0;
		border-collapse: collapse;
	}

	.table-bordered td,
	.table-bordered th {
		padding: 3px;
		text-align: left;
		vertical-align: top;
	}

	.table-bordered {
		border: 0px solid #eee;
		border-collapse: separate;

		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		border-radius: 4px;
	}

	.left {
		border-left: 1px solid #eee;

	}

	.top {
		border-top: 1px solid #eee;
	}

	.bottom {
		border-bottom: 1px solid #eee;
	}

	.qui {
		font-size: 15px;
	}

	.hr {
		height: 2px;
		width: 50%;
		background-color: black;
	}

	.centrado {
		text-align: center;
	}

	table {
		vertical-align: top;
	}

	tr {
		vertical-align: top;
	}

	td {
		vertical-align: top;
	}

	.text-center {
		text-align: center
	}

	.text-right {
		text-align: right
	}

	table th,
	td {
		font-size: 13px
	}

	.detalle td {
		padding: 7px;
	}

	.border-bottom {
		border-bottom: solic 1px #bdc3c7;
	}

	a {
		text-decoration: none;
		color: black;
	}




	table.page_footer {
		width: 100%;
		border: none;
		background-color: white;
		padding: 2mm;
		border-collapse: collapse;
		border: none;
	}
</style>



<page backtop="0mm" backbottom="0mm" backleft="4mm" backright="4mm" style="font-size: 11px; font-family: helvetica" backimg="">
	<?php

	include('page_header_footer.php');
	?>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>

	<table border=0 style="width:100%;margin:5mm 0px" cellspacing=0>

		<td style="width: 160%;text-align:center;font-size:24px;color: 0000; padding:10px; border-radius: 7px ">
			<b>RECIBO DE PAGO</b>
		</td>

	</table>
	<br>
	<br>
	<br>


	<table border=0 style="width:100%;margin:5mm 0px" cellspacing=0>

		<tr>
			<td style="width:100%; text-align:center"><?php //echo $address . " " . $city; 
														?></td>
		</tr>

		<tr>
			<td style="width:100%; text-align:center"><?php //echo " NRC: "//.$number_id;
														?></td>
		</tr>
		<tr>
			<td style="width:100%; text-align:;font-size:13pt">R.H: <?php echo $email; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Núm.º de folio: <?php echo $sale_number; ?></td>
			<?php $GLOBALS['ticket_id'] = $sale_number;?>
		</tr>

		<tr>
			<td style="width:100%;" class='bottom'><b>MATRICULA:</b> <?php echo $person_code; ?><br></td>
		</tr>
		<tr>
			<td style="width:100%;" class='bottom'><b>ESTUDIANTE:</b> <?php echo $union_nombre; ?><br></td>
		</tr>

	</table>



	<table border=.2 style="width:100%;margin:2mm 0px;font-size:10px" cellspacing=0>
		<tr>
			<td style="width:20mm;text-align:left;" class=''>Descripción</td>
			<td style="width:5mm;text-align:center;" class=''>F_inicio.</td>
			<td style="width:5mm;text-align:center;" class=''>Cant.</td>
			<td style="width:5mm;text-align:center;" class=''>P.U</td>
			<td style="width:5mm;text-align:right;" class=''>TOTAL</td>
		</tr>

		<?php
		$sumador_total = 0;
		$sql = mysqli_query($con, "select * from products, sale_product, sales  where sale_product.sale_id=sales.sale_id  and products.product_id=sale_product.product_id and sale_product.sale_id='$sale_id'");

		while ($row = mysqli_fetch_array($sql)) {
			$product_code = $row['product_id'];
			$product_name = $row['product_name'];
			$idplanp = $row['id_plan'];
			$qty = $row['qty'];
			$sale_date = $row['sale_date'];
			$fecha_pago = date("d-m-Y", strtotime($sale_date));
			$unit_price = number_format($row['unit_price'], $currency_format['precision_currency'], '.', '');
			$precio_total = $unit_price * $qty;
			$precio_total = number_format($precio_total, $currency_format['precision_currency'], '.', ''); //Precio total formateado
			$sumador_total += $precio_total; //Sumador

		?>
			<tr>
				<td style="width:80mm;text-align:left;"><?php echo $product_name; ?></td>
				<td style="width:20mm;text-align:center;"><?php echo $fecha_pago; ?></td>
				<td style="width:20mm;text-align:center;"><?php echo $qty; ?></td>
				<td style="width:40mm;text-align:right;"><?php echo number_format($unit_price, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></td>
				<td style="width:40mm;text-align:right;"><?php echo number_format($precio_total, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></td>
			</tr>
		<?php
		}
		$sql1 = mysqli_query($con, "SELECT * FROM sales where sale_id = $sale_id ");
		while ($row1 = mysqli_fetch_array($sql1)) {
			$descuento = $row1['discount_value'];
			$tax = $row1['tax_value'];
		}
		$total_parcial = number_format($sumador_total, $currency_format['precision_currency'], '.', '');
		$total_neto = $total_parcial;
		$total_neto = number_format($total_neto, $currency_format['precision_currency'], '.', '');
		$total_iva = ($total_neto * $tax) / 100;
		$total_iva = number_format($total_iva, $currency_format['precision_currency'], '.', '');
		$total_compra = $total_neto + $total_iva;
		$total_compra = number_format($total_compra, $currency_format['precision_currency'], '.', '');
		$precio_descuento = ($total_neto * $descuento) / 100;
		if ($descuento > 0) {
			$precio_descuento = ($total_neto * $descuento) / 100;
			$total_descuento = ($total_neto - $precio_descuento);
			$total_iva = ($total_descuento * $tax) / 100;
			$total_compra = ($total_descuento + $total_iva);
		
		}

		?>		
		<tr>
			<td style='text-align:right' class='' colspan="4">Subtotal <?php echo $moneda; ?></td>
			<td style='text-align:right' class=''><?php echo number_format($total_neto, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></td>

		</tr>
		<?php
		if ($descuento > 0) {
		?>
			<tr>
				<td style='text-align:right' class='' colspan="4">Descuento <?php echo $descuento; ?>% <?php echo $moneda; ?></td>
				<td style='text-align:right' class=''><?php echo number_format($precio_descuento, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></td>

			</tr>
		<?php
		}
		?>
		<tr>
			<td style='text-align:right' class='' colspan="4"><?php echo $tax_txt; ?> <?php echo $tax; ?>% <?php echo $moneda; ?></td>
			<td style='text-align:right' class=''><?php echo number_format($total_iva, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></td>

		</tr>

		<tr>
			<td style='text-align:right' class='' colspan="4"><b>Total <?php echo $moneda; ?></b></td>
			<td style='text-align:right' class=''> <b><?php echo number_format($total_compra, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?> </b></td>

		</tr>
		<tr>
			<td style='text-align:right' class='' colspan="4">Fecha de pago: </td>
			<td style='text-align:right' class=''> <?php echo  $fecha_pago ?></td>

		</tr>
	

	<br><br>
	
	</table>
	</page>

