<style type="text/css">
	<!--
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
	-->
</style>
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm" style="font-size: 12px; font-family: helvetica" backimg="">
	<?php
	$title_report = '';
	include('page_header_contrato2.php');

	?>
	<br>

	<?php
	if (isset($_GET["id"])) {
		$id = $_GET["id"];
		$user_id = intval($id);
		$sql = mysqli_query($con, "SELECT users.user_id, users.fullname, users.a_p, users.a_m, users.user_email, amigos.patrocinador, amigos.estado, amigos.calle, amigos.n_interior, amigos.n_exterior, amigos.colonia, amigos.delegacion, amigos.cp, amigos.telefono, amigos.curp, amigos.beneficiario, amigos.parentesco, amigos.b_tel FROM users INNER JOIN amigos ON users.user_id = amigos.id AND users.user_id = $user_id AND amigos.id= $user_id ");
		$num = mysqli_num_rows($sql);

		if ($num == 1) {
			$rw = mysqli_fetch_array($sql);
			$id_usuario = $rw['user_id']; //SI JALA
			$fullname = $rw['fullname'];
			$a_p = $rw['a_p'];
			$a_m = $rw['a_m'];
			$user_email = $rw['user_email'];
			$id_estado = $rw['estado'];
			$id_patrocinador = $rw['patrocinador'];
			$calle = $rw['calle'];
			$n_interior = $rw['n_interior'];
			$n_exterior = $rw['n_exterior'];
			$colonia = $rw['colonia'];
			$delegacion = $rw['delegacion'];
			$cp = $rw['cp'];
			$telefono = $rw['telefono'];
			$curp = $rw['curp'];
			$beneficiario = $rw['beneficiario'];
			$parentesco = $rw['parentesco'];
			$b_tel = $rw['b_tel'];
		}
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

		<table cellspacing="0" style="width: 100%;">
			<tr>

				<td style="width: 20%; ">
				</td>
				<td style="width: 60%;text-align:center;font-size:24px;color: 0000; padding:10px; border-radius: 7px ">
					<b>SOLICITUD DE AMIGOS</b>
				</td>


			</tr>
		</table>

		<table cellspacing="0" style="width: 100%;">
			<tr>

				<td style="width: 60%; ">

				</td>
				<td style="width: 20%;color:white;background-color: #0000;padding:5px;text-align:center ">
					<strong style="font-size:14px;">No. del Socio #</strong>
				</td>
				<td style="width: 20%; color:white;background-color: #0000;padding:5px;text-align:center ">
					<strong style="font-size:14px;">FECHA</strong>
				</td>
			</tr>

			<tr>

				<td style="width: 60%; ">

				</td>
				<td style="width: 20%;padding:5px;text-align:center;border:solid 1px #bdc3c7;font-size:15px">
					<?php echo $id_usuario; ?>
				</td>
				<td style="width: 20%;padding:5px;text-align:center;border:solid 1px #bdc3c7;font-size:15px ">
					<?php echo date("d/m/Y"); ?>
				</td>
			</tr>

		</table>


		<br>
		<?php
		$query = mysqli_query($con, "SELECT * FROM amigos WHERE id = $id_patrocinador");
		$rw = mysqli_fetch_array($query);
		$n_patrocinador = $rw['name'];
		$p_patrocinador = $rw['a_p'];
		$m_patrocinador = $rw['a_m'];

		?>
		<table cellspacing="0" style="width: 100%;" class="detalle">

			<tr>
				<td style="width: 16%; ">
					<strong>Patrocinador: </strong>
				</td>
				<td style="width: 55%; " class="border-bottom">
					<?php echo $n_patrocinador . " " . $p_patrocinador . " " . $m_patrocinador; ?>
				</td>

			</tr>
		</table>




		<table cellspacing="0" style="width: 100%;" class="detalle">

			<tr>
				<td style="width: 20%; ">
					<strong>Nombre del socio: </strong>
				</td>
				<td style="width: 55%; " class="border-bottom">
					<?php echo $fullname; ?> <?php echo $a_p; ?> <?php echo $a_m; ?>
				</td>

			</tr>
		</table>


		<table cellspacing="0" style="width: 100%;" class="detalle">

			<tr>
				<td style="width: 15%; ">
					<strong>Calle: </strong>
				</td>

				<td style="width: 20%; " class="border-bottom">
					<?php echo $calle; ?>
				</td>

				<td style="width: 15%; ">
					<strong>N° Exterior: </strong>
				</td>

				<td style="width: 15%; " class="border-bottom">
					<?php echo $n_exterior; ?>
				</td>

				<td style="width: 15%; ">
					<strong>N° Interior:: </strong>
				</td>

				<td style="width: 15%; " class="border-bottom">
					<?php echo $n_interior; ?>
				</td>
			</tr>
		</table>


		<table cellspacing="0" style="width: 100%;" class="detalle">
			<tr>
				<td style="width: 15%; ">
					<strong>Colonia: </strong>
				</td>
				<td style="width: 55%; " class="border-bottom">
					<?php echo $colonia; ?>
				</td>
				<td style="width: 15%; text-align:right">
					<strong>C.P: </strong>
				</td>
				<td style="width: 15%; " class="border-bottom">
					<?php echo $cp; ?>
				</td>
			</tr>
		</table>

		<?php
		$query2 = mysqli_query($con, "SELECT * FROM estados WHERE id = $id_estado");
		$rw2 = mysqli_fetch_array($query2);
		$n_estado = $rw2['name'];

		?>

		<table cellspacing="0" style="width: 100%;" class="detalle">
			<tr>
				<td style="width: 25%; ">
					<strong>Delegación/Municipio: </strong>
				</td>

				<td style="width: 25%; " class="border-bottom">
					<?php echo $delegacion; ?>
				</td>

				<td style="width: 25%; text-align:right">
					<strong>Estado: </strong>
				</td>
				<td style="width: 25%; " class="border-bottom">
					<?php echo $n_estado; ?>
				</td>

			</tr>
		</table>



		<table cellspacing="0" style="width: 100%;" class="detalle">
			<tr>
				<td style="width: 15%; ">
					<strong>E-mail: </strong>
				</td>
				<td style="width: 55%; " class="border-bottom">
					<?php echo $user_email; ?>
				</td>
				<td style="width: 15%; text-align:right">
					<strong>Celular: </strong>
				</td>
				<td style="width: 15%; " class="border-bottom">
					<?php echo $telefono; ?>
				</td>
			</tr>
		</table>



		<table cellspacing="0" style="width: 100%;" class="detalle">
			<tr>
				<td style="width: 10%; ">
					<strong>CURP: </strong>
				</td>
				<td style="width: 55%; " class="border-bottom">
					<?php echo $curp; ?>
				</td>

			</tr>
		</table>

		<br>
		<br>
		<br>
		<br>
		<br>

		<table cellspacing="0" style="width: 100%;">
			<tr>

				<td style="width: 20%; ">
				</td>
				<td style="width: 60%;text-align:center;font-size:24px;color:#0000; padding:10px; border-radius: 7px ">
					<b>BENEFICIARIO</b>
				</td>


			</tr>
		</table>

		<table cellspacing="0" style="width: 100%;" class="detalle">

			<tr>
				<td style="width: 20%; ">
					<strong>Nombre: </strong>
				</td>
				<td style="width: 55%; " class="border-bottom">
					<?php echo $beneficiario; ?>
				</td>

			</tr>
		</table>



		<table cellspacing="0" style="width: 100%;" class="detalle">
			<tr>
				<td style="width: 15%; ">
					<strong>Parentesco: </strong>
				</td>
				<td style="width: 55%; " class="border-bottom">
					<?php echo $parentesco; ?>
				</td>
				<td style="width: 15%; text-align:right">
					<strong>Celular: </strong>
				</td>
				<td style="width: 15%; " class="border-bottom">
					<?php echo $b_tel; ?>
				</td>
			</tr>
		</table>

		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>



		<div style='padding-bottom:-5px;text-align:Left '>
			<p class="qui">Documentos y aviso de privacidad.</p>

		</div>

		<div style='padding-bottom:-5px;text-align:center '>

			<h4>ANEXAR COPIA IFE / INE, COMPROBANTE DE DOMICILIO Y CURP </h4>
		</div>

		<p class="qui">Para dudas o aclaración referente a la utilización de los datos personales aqui solicitados, le pedimos consulte nuestro AVISO DE PRIVACIDAD INTEGRAL, que podra encontrar en nuestra página web:</p>

		<div style='padding-bottom:-5px;text-align:center '>
			<a href="#">
				<p class="qui">www.amigosprosperandoenelmundo.com</p>
			</a>
		</div>

</page>
<?php
	} else {
		header("location: index.php"); //Redirecciona 
		exit;
	}
?>