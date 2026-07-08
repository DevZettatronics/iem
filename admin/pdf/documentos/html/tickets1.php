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
	/* 	$title_report = ''; */
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
			<b>RECIBO DE OPERACIÓN</b>
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
			<td style="width:100%; text-align:center"><?php // echo $branch_office_name;
														?></td>
		</tr>
		<tr>
			<td style="width:100%; text-align:center"><?php // echo $branch_office_address;
														?></td>
		</tr>
	</table>

	<!-- <table border=0 style="width:100%;margin:5mm 0px" cellspacing=0>

		<tr>
			<td style="width:100%;" class='top'><?php //echo $sale_date; 
												?></td>
		</tr>
		<?php
			//if($vinculacion === 1){
				
		?>
			<tr>
				<td style="width:100%;" class='bottom'><b>VINCULACION</b> <?php //echo ''; ?><br></td>
			</tr>
			<tr>
				<td style="width:100%;" class='bottom'><b>NOMBRE:</b> <?php //echo mb_strtoupper($union_nombre, 'UTF-8'); ?><br></td>
			</tr>
		<?php
			//}else{
		?>
			<tr>
				<td style="width:100%;" class='bottom'><b>MATRICULA:</b> <?php //echo $person_code; ?><br></td>
			</tr>
			<tr>
				<td style="width:100%;" class='bottom'><b>ESTUDIANTE:</b> <?php //echo $union_nombre; ?><br></td>
			</tr>
		<?php
			//}
		?>
		 <tr>
			<td style="width:100%;" class='bottom'><b>MATRICULA:</b> <?php //echo $person_code; ?><br></td>
		</tr>
		 <tr>
			<td style="width:100%;" class='bottom'><b>ESTUDIANTE:</b> <?php //echo $union_nombre; ?><br></td>
		</tr> 

	</table> -->

	
	<table border=0 style="width:100%;margin:5mm 0px" cellspacing=0>
			
			<?php
				if($vinculacion === 1){	
			?>
				<tr>
					<td style="width:59.5%;text-align:left;"class='bottom top'><b>VINCULACION</b></td>
						<td style="width:40%;text-align:center;"class='bottom top'>
							<?php if (!empty($fecha_formateada) && $fecha_formateada !== null): ?>
								Fecha de pago correspondiente: <b><?php echo $fecha_formateada; ?></b>
							<?php endif; ?>
						</td>
					
				</tr>
				<tr>
					<td style="width:59.5%;text-align:left;"class='bottom'><b>NOMBRE:</b> <?php echo mb_strtoupper($union_nombre, 'UTF-8'); ?><br></td>
					<td style="width:40%;text-align:center;"class='bottom'>Fecha de pago:<b><?php echo $sale_date;  ?></b></td>
				</tr>
			<?php
				}else{
			?>
				<tr>
					<td style="width:59.5%;text-align:left;"class=''><b>MATRICULA:</b> <?php echo $person_code; ?><br></td>
					
						<td style="width:40%;text-align:center;"class=''>
							<?php if (!empty($fecha_formateada) && $fecha_formateada !== null): ?>
								Fecha de pago correspondiente: <b><?php echo $fecha_formateada; ?></b>
							<?php endif; ?>
						</td>
					
				</tr>
				<tr>
					<td style="width:40%;text-align:left;" class=''><b>ESTUDIANTE:</b> <?php echo $union_nombre; ?><br></td>
					<td style="width:40%;text-align:center;"class=''>Fecha de pago:<b><?php echo $sale_date;  ?></b></td>
				</tr>
				<?php if ($namePeriodo !== 0): ?>
					<tr>
						<td style="width:40%;text-align:left;"><b>CUATRIMESTRE:</b> <?php echo $namePeriodo; ?></td>
					</tr>
				<?php endif; ?>

				<?php if ($nameProgram !== 0): ?>
					<tr>
						<td style="width:50%;text-align:left;"><b>CARRERA:</b> <?php echo $nameProgram; ?></td>
					</tr>
				<?php endif; ?>

				<?php if ($nameProgram !== 0): ?>
					<tr>
						<td style="width:40%;text-align:left;"><b>MODALIDAD:</b> <?php echo $typeProgram; ?></td>
					</tr>
				<?php endif; ?>

			<?php
				}

				if ($payment_method === 1) {
					$operacion = 'Efectivo';
					
				}else if($payment_method === 2) {
					$operacion = 'Deposito';
					
				}else if ($payment_method === 3) {
					$operacion = 'Tarjeta';
				}else{
					$operacion = 'No asignado';
				}
			?>
				<tr>
					<td style="width:40%;text-align:left;"><b>OPERACIÓN:</b> <?php echo $operacion; ?></td>
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
		foreach($productos as $row){
			$product_code = $row['product_id'];
			$product_name = $row['product_name'];
			$idplanp = $row['id_plan'];
			$qty = $row['qty'];
			$fecha_inicio = empty($row['fecha_inicio_pago']) ? date("d-m-Y") : $row['fecha_inicio_pago'];
			$fecha_inicio_formateada = date("d-m-Y", strtotime($fecha_inicio));
			$unit_price = (float)$row['unit_price'];
			$precio_total = $unit_price * $qty;

			$unit_price_format = number_format($unit_price, $currency_format['precision_currency'], '.', '');
			$precio_total_format = number_format($precio_total, $currency_format['precision_currency'], '.', '');

			$sumador_total += $precio_total;
		?>
			<tr>
				<td style="width:80mm;text-align:left;"><?php echo $product_name; ?></td>
				<td style="width:20mm;text-align:center;"><?php echo $fecha_inicio_formateada; ?></td>
				<td style="width:20mm;text-align:center;"><?php echo $qty; ?></td>
				<td style="width:40mm;text-align:right;"><?php echo number_format($unit_price, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></td>
				<td style="width:40mm;text-align:right;"><?php echo number_format($precio_total, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></td>
			</tr>
		<?php
		}
		// Cálculos de los totales
		$total_parcial = number_format($sumador_total, $currency_format['precision_currency'], '.', '');
		$total_neto = $total_parcial;

		$total_iva = ($total_neto * $tax_value) / 100;
		$total_iva = number_format($total_iva, $currency_format['precision_currency'], '.', '');

		if ($descuento > 0) {
			// Si hay descuento
			$precio_descuento = ($total_neto * $descuento) / 100;
			$total_descuento = ($total_neto - $precio_descuento);
			$total_iva = ($total_descuento * $tax_value) / 100;
			$total_compra = $total_descuento + $total_iva;
		} else {
			// Si no hay descuento
			$total_compra = $total_neto + $total_iva;
		}

		$total_compra = $total_compra + $recargo;
		$total_compra = number_format($total_compra, $currency_format['precision_currency'], '.', '');
		$total_neto = number_format($total_neto, $currency_format['precision_currency'], '.', '');
		$precio_descuento = number_format($precio_descuento ?? 0, $currency_format['precision_currency'], '.', ''); // Si no hay descuento, será 0
		$total_descuento = number_format($total_descuento ?? 0, $currency_format['precision_currency'], '.', ''); // Si no hay descuento, será 0
		
		?>
		<!--
		<tr>
			<td colspan="4" class='top'></td>
		</tr>
		<tr>
			<td style='text-align:left' colspan="3" ><b>VALOR VENTA <?php /* echo $simbolo_moneda; */ ?></b> </td>
			<td style='text-align:left' ><b><?php /* echo number_format($total_neto, $precision_moneda, $sepador_decimal_moneda, $sepador_millar_moneda); */ ?></b> </td>
		</tr>
		<tr>
			<td style='text-align:left' colspan="3" ><b>IGV <?php /* echo $simbolo_moneda; */ ?></b></td>
			<td style='text-align:left' ><b> <?php /* echo number_format($total_iva, $precision_moneda, $sepador_decimal_moneda, $sepador_millar_moneda); */ ?></b></td>
		</tr>
		!-->
		
		<tr>
			<td style='text-align:right' colspan="4">Subtotal <?php echo $moneda; ?></td>
			<td style='text-align:right'><?php echo number_format($total_neto, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></td>
		</tr>

		<?php if ($descuento > 0): ?>
			<tr>
				<td style='text-align:right' colspan="4">Descuento <?php echo $descuento; ?>% <?php echo $moneda; ?></td>
				<td style='text-align:right'><?php echo number_format($precio_descuento, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></td>
			</tr>
		<?php endif; ?>

		<?php if ($recargo > 0): ?>
			<tr>
				<td style='text-align:right' colspan="4">Recargos <?php echo $moneda; ?></td>
				<td style='text-align:right'><?php echo number_format($recargo, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></td>
			</tr>
		<?php endif; ?>

		<tr>
			<td style='text-align:right' colspan="4"><?php echo $tax_txt; ?> <?php echo $tax_value; ?>% <?php echo $moneda; ?></td>
			<td style='text-align:right'><?php echo number_format($total_iva, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></td>
		</tr>

		<tr>
			<td style='text-align:right' colspan="4"><b>Total <?php echo $moneda; ?></b></td>
			<td style='text-align:right'><b><?php echo number_format($total_compra, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?></b></td>
		</tr>

		<!-- <tr>
			<td style='text-align:right' colspan="4"><b>Fecha de pago:</b></td>
			<td style='text-align:right'><b><?php echo $sale_date; ?></b></td>
		</tr> -->
	</table>

	<!-- <br><br> -->
	<?php //if($namePeriodo !== 0): ?>
	<!-- <table border=.2 style="width:100%;margin:2mm 0px;font-size:10px" cellspacing=0>
		
		<tr>
			<td style="width:67mm;text-align:center;" class=''><b>Cuatrimestre</b></td>
			<td style="width:69mm;text-align:center;" class=''><b>Carrerra</b></td>
			<td style="width:67mm;text-align:center;" class=''><b>Modalidad</b></td>
		</tr>
		
		<?php //if ($namePeriodo !== 0): ?>
		<tr>
			
			<td style="text-align:center;"><?php //echo $namePeriodo; ?></td>
			
			<?php //endif; ?>
			<?php //if ($id_program !== 0): ?>
				
			
			<td style="text-align:center;"><?php //echo $nameProgram; ?></td>
			
		<?php //endif; ?>
		<?php //if ($nameProgram !== 0): ?>
			
			
			<td style="text-align:center;"><?php //echo $typeProgram; ?></td>
		</tr>
		<?php //endif; ?>
	</table>
	 -->
	<?php //endif; ?>
	<table border=0 style="width:100%;" cellspacing=0>


	</table>
	<br><br>

</page>