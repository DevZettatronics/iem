<style type="text/css">
	<!--
	div.zone {
		border: solid 0mm red;
		border-radius: 0mm;
		padding: mm;
		background-color: #FFF;
		color: #440000;
	}

	div.zone_over {
		width: 0mm;
		height: 0mm;

	}

	.bordeado {
		border: solid 0mm #eee;
		border-radius: 0mm;
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
		border-left: 0px solid #eee;

	}

	.top {
		border-top: 0px solid #eee;
	}

	.bottom {
		border-bottom: 0px solid #eee;
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

	table.page_footer {
		width: 100%;
		border: none;
		background-color: white;
		padding: 2mm;
		border-collapse: collapse;
		border: none;
	}
	-->
</style>
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm" style="font-size: 12px; font-family: helvetica" backimg="">

	<br>






	<br>
	<br>
	<br>
	<br>



	<table cellspacing="0" style="width: 1%;">
		<tr>
			<td style="width: 20%; ">
			</td>
			<td style="width: 9900%;color:black;background-color: #F9F9F9;padding:5px;text-align:left;border:solid 2px #0000 ">
				<table cellspacing="0" style="width: 100%;">
					<tr>
						<td style="width: 20%; ">
						</td>
						<td style="width: 60%;text-align:center;font-size:14px;color: 0000; padding:10px; border-radius: 7px ">
							<b>SOLDEVI</b>
						</td>
					</tr>
				</table>

				<table cellspacing="0" style="width: 100%;">
					<tr>
						<td style="width: 20%; ">
						</td>
						<td style="width: 60%;text-align:center;font-size:14px;color: 0000; padding:10px; border-radius: 7px ">
							<b>LIQUIDACION DE AUSPICIOS</b>
						</td>
					</tr>
				</table>

				<table cellspacing="0" style="width: 100%;">
					<tr>
						<td style="width: 20%; ">
						</td>
						<td style="width: 60%;text-align:center;font-size:14px;color: 0000; padding:10px; border-radius: 7px ">
							<b><?php echo $fecha ?></b>
						</td>
					</tr>
				</table>

				<br>
				<br>
				<table cellspacing="0" style="width: 1%;">
					<tr>

						<td style="width: 20%; ">

						</td>
						<td style="width: 3300%;color:white;background-color: #0000;padding:5px;text-align:left ">
							<strong style="font-size:14px;">NOMBRE</strong>
						</td>
						<td style="width: 1000%; color:white;background-color: #0000;padding:5px;text-align:center ">
							<strong style="font-size:14px;">REG</strong>
						</td>
					</tr>

					<tr>

						<td style="width: 60%; ">

						</td>
						<td style="width: 3300%;padding:5px;text-align:left;border:solid 1px #0000 ;font-size:left ">
							<?php echo $paterno_sponsor . " " . $materno_sponsor . " " . $nombre_sponsor ?>
						</td>
						<td style="width: 20%;padding:5px;text-align:center;border:solid 1px #0000 ;font-size:15px ">
							<?php echo "#" . $id_sponsor; ?>
						</td>
					</tr>

				</table>

				<br>
				<br>



			</td>
		</tr>
		<tr>
			<td style="width: 60%; ">
			</td>
		</tr>
	</table>
	<table cellspacing="0" style="width: 1%;">
		<tr>

			<td style="width: 20%; ">

			</td>
			<td style="width: 3300%;color:white;background-color: #0000;padding:5px;text-align:center ">
				<strong style="font-size:14px;">DIRECTOS DEL PERIODO</strong>
			</td>
			<td style="width: 1000%; color:white;background-color: #0000;padding:5px;text-align:center ">
				<strong style="font-size:14px;">ID</strong>
			</td>
			<td style="width: 2000%;color:white;background-color: #0000;padding:5px;text-align:center ">
				<strong style="font-size:14px;">CONCEPTO</strong>
			</td>
			<td style="width: 20%; color:white;background-color: #0000;padding:5px;text-align:center ">
				<strong style="font-size:14px;">IMPORTE</strong>
			</td>
			<td style="width: 1000%;color:white;background-color: #0000;padding:5px;text-align:center ">
				<strong style="font-size:14px;">TAX</strong>
			</td>
			<td style="width: 1400%; color:white;background-color: #0000;padding:5px;text-align:center;border:solid 1px #0000 ; ">
				<strong style="font-size:14px;">NETO</strong>
			</td>
		</tr>

		<tr>

			<td style="width: 60%; ">

			</td>
			<td style="width: 3300%;padding:5px;text-align:center;;border:solid 1px #0000 ;font-size:15px">
				<?php echo $a_p_s . " " . $a_m_s . " " . $name_s ?>
			</td>
			<td style="width: 1000%;padding:5px;text-align:center;;border:solid 1px #0000 ;font-size:15px ">
				<?php echo "#" . $id_new_socio ?>
			</td>
			<td style="width: 2000%;padding:5px;text-align:center;;border:solid 1px #0000 ;font-size:15px">
				<strong style="font-size:10px;">BONUS SPONSOR</strong>
			</td>
			<td style="width: 20%;padding:5px;text-align:center;;border:solid 1px #0000 ;font-size:15px ">
				<strong style="font-size:14px;">$150.00</strong>
			</td>
			<td style="width: 1000%;padding:5px;text-align:center;;border:solid 1px #0000 ;font-size:15px">

			</td>
			<td style="width: 1400%;padding:5px;text-align:center;;border:solid 1px #0000 ;font-size:15px;border:solid 1px #0000 ; ">
				<strong style="font-size:14px;">$150.00</strong>
			</td>
		</tr>

	</table>

	<table cellspacing="0" style="width: 1%;">
		<tr>

			<td style="width: 20%; ">

			</td>
			<td style="width: 3300%;color:white;background-color: #0000;padding:5px;border:solid 1px #0000 ;text-align:left ">
				<strong style="font-size:14px;">NETO PAGADO</strong>
			</td>
			<td style="width: 1000%;padding:5px;text-align:center;border:solid 1px #0000 ;font-size:15px ">
				<strong style="font-size:14px;"></strong>
			</td>
			<td style="width: 2000%;padding:5px;text-align:center;border:solid 1px #0000 ;font-size:15px">
				<strong style="font-size:14px;"></strong>
			</td>
			<td style="width: 20%;padding:5px;text-align:center;border:solid 1px #0000 ;font-size:15px ">
				<strong style="font-size:14px;"></strong>
			</td>
			<td style="width: 1000%;padding:5px;text-align:center;border:solid 1px #0000 ;font-size:15px">
				<strong style="font-size:10px;">MX 00/100</strong>
			</td>
			<td style="width: 1400%;padding:5px;text-align:center;border:solid 1px #0000 ;font-size:15px ">
				<strong style="font-size:14px;">$150.00</strong>
			</td>
		</tr>

		<tr>

			<td style="width: 60%; ">

			</td>
			<td style="width: 3300%;color:white;background-color: #0000;padding:5px;text-align:center ">

			</td>
			<td style="width: 1000%; color:white;background-color: #0000;padding:5px;text-align:center ">

			</td>
			<td style="width: 2000%;color:white;background-color: #0000;padding:5px;text-align:center ">

			</td>
			<td style="width: 1210%; color:white;background-color: #0000;padding:5px;text-align:center ">

			</td>
			<td style="width: 1000%;color:white;background-color: #0000;padding:5px;text-align:center ">

			</td>
			<td style="width: 1400%; color:white;background-color: #0000;padding:5px;text-align:center ">

			</td>
		</tr>

	</table>

	<table cellspacing="0" style="width: 1%;">
		<tr>
			<td style="width: 20%; ">
			</td>
			<td style="width: 9900%;color:black;background-color: #DAF6B2;padding:5px;text-align:left;border:solid 2px #0000 ">
				<br>
				<strong style="font-size:14px;">Esta liquidación esta de acuerdo al sistema soldevi y se a efectuado la transferencia correspondiente</strong>
				<strong style="font-size:14px;">a la cuenta bancaria proporcionada por el afiliado.</strong>
				<br>
				<br>
				<strong style="font-size:14px;">Cualquier inconformidad deberá ser por escrito al WhatsApp 55 3829 5859 dentro de los siguientes</strong>
				<strong style="font-size:14px;">7 días naturales a la fecha de la transferencia.</strong>
				<br>
				<br>
				<strong style="font-size:14px;">De no ser así entenderemos su conformidad plena al referente citado.</strong>
				<br>
			</td>
		</tr>
		<tr>
			<td style="width: 60%; ">
			</td>
		</tr>
	</table>




	<br>

</page>