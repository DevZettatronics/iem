<?php

require_once("../../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("../../config/conexion.php"); //Contiene funcion que conecta a la base de datos
require_once("../../libraries/fuction_xml.php");

if (empty($_POST['rsocial'])) {
	$errors[] = "Raz�n Social vac�o.";
} elseif (empty($_POST['rfc_cli'])) {
	$errors[] = "RFC cliente vac�o.";
} elseif (empty($_POST['direccion_cliente'])) {
	$errors[] = "La direccion esta vac�a.";
} elseif (empty($_POST['cp_cliente'])) {
	$errors[] = "CP esta vac�a.";
} elseif (empty($_POST['tipo_c'])) {
	$errors[] = "Tipo de comprobante vacia.";
} elseif (empty($_POST['serie_f'])) {
	$errors[] = "Serie vacio.";
} elseif (empty($_POST['folio_f'])) {
	$errors[] = "Folio vacio.";
} elseif (empty($_POST['fecha_c'])) {
	$errors[] = "Fecha de emision vacia.";
} elseif (empty($_POST['m_pago'])) {
	$errors[] = "M�todo de pago vac�o.";
} elseif (empty($_POST['f_pago'])) {
	$errors[] = "Forma de pago vac�o.";
	// } elseif (empty($_POST['n_cuenta'])) {
	// 	$errors[] = "N�mero de cuenta vac�o.";
} elseif (empty($_POST['t_moneda'])) {
	$errors[] = "Tipo de moneda vac�o.";
} elseif (empty($_POST['t_cambio'])) {
	$errors[] = "Tipo de cambio vac�o.";
} elseif (empty($_POST['tipo_cfdi'])) {
	$errors[] = "Tipo CFDI vac�o."; // en la tabla ira en la parte de uso 
} elseif (empty($_POST['iva'])) {
	$errors[] = "Tipo IVA vac�o.";
} elseif ($_POST['clave_ps'] == 0) {
	$errors[] = "Agregar clave de los productos.";
} elseif (strlen($_POST['clave_ps']) < 8) {
	$errors[] = "La clave de productos debe contener minimo 8 caracteres.";
} elseif (empty($_POST['unidadc'])) {
	$errors[] = "Agregar Unidad de los productos.";
} elseif (
	!empty($_POST['rsocial'])
	&& !empty($_POST['rfc_cli'])
	&& !empty($_POST['direccion_cliente'])
	&& !empty($_POST['cp_cliente'])
	&& !empty($_POST['tipo_c'])
	&& !empty($_POST['serie_f'])
	&& !empty($_POST['folio_f'])
	&& !empty($_POST['fecha_c'])
	&& !empty($_POST['m_pago'])
	&& !empty($_POST['f_pago'])
	// && !empty($_POST['n_cuenta'])
	&& !empty($_POST['t_moneda'])
	&& !empty($_POST['t_cambio'])
	&& !empty($_POST['tipo_cfdi'])
) {
	// $customer_id = intval($_POST["customer_id"]);
	// $name = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["rsocial"], ENT_QUOTES))));
	// $direccion = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["direccion_cliente"], ENT_QUOTES))));
	$rfc = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["rfc_cli"], ENT_QUOTES))));
	$tipo_comp = intval($_POST["tipo_c"]);
	$cp_cliente = mysqli_real_escape_string($con, (strip_tags($_POST["cp_cliente"])));
	$serie = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["serie_f"], ENT_QUOTES))));
	$folio = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["folio_f"], ENT_QUOTES))));
	$fecha = $_POST["fecha_c"];
	$me_pago = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["m_pago"], ENT_QUOTES))));
	$forma_pago = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["f_pago"], ENT_QUOTES))));
	// $n_cuenta = intval($_POST["n_cuenta"], ENT_QUOTES);
	$uso_cfid = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["tipo_cfdi"], ENT_QUOTES))));
	$t_moneda = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["t_moneda"], ENT_QUOTES))));
	/* $objetoImp = intval($_POST["objeto"]); */
	$sql_cfdi = mysqli_query($con, "SELECT * FROM c_usocfdi where idusocfdi = $uso_cfid;");
	$rwuso = mysqli_fetch_array($sql_cfdi);
	$uso = $rwuso['c_UsoCFDI'];

	$sql_tcomp = mysqli_query($con, "SELECT * FROM c_tipodecomprobante where id=$tipo_comp ;");
	$rw_tcomp = mysqli_fetch_array($sql_tcomp);
	$tipo_c = $rw_tcomp['tipoDeComprobante'];

	$sql_f = mysqli_query($con, "SELECT * FROM c_metodopago where id= $me_pago;");
	$rw_f = mysqli_fetch_array($sql_f);
	$m_pago = $rw_f['c_MetodoPago'];

	$sql_m = mysqli_query($con, "SELECT * FROM c_formapago where idformadepago= $forma_pago;");
	$rw_m = mysqli_fetch_array($sql_m);
	$f_pago = $rw_m['c_FormaPago'];

	/* $sql_objeto = mysqli_query($con, "SELECT * FROM c_objetoimp where id_ObjetoImp = $objetoImp;");
	$rwobjeto = mysqli_fetch_array($sql_objeto);
	$objetoImpuesto = $rwobjeto['c_ObjetoImp']; */


	// inicio productos
	$subtotal = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["subtotal"], ENT_QUOTES))));
	$subtotal = str_replace(",", "", $subtotal);
	isset($_POST["descuento"]) && $_POST["descuento"] != ""  ? $descuento = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["descuento"], ENT_QUOTES)))) : $descuento=0;
	$iva = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["iva"], ENT_QUOTES))));
	$total = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["total"], ENT_QUOTES))));
	$total = str_replace(",", "", $total);
	/* if($iva==0){
		$iva= $subtotal * .16;
		$total = $iva + $subtotal - $descuento;  
	} */

	$estado = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["estado"], ENT_QUOTES))));
	//fin productos

	//extraer de la informacion de la empresa falta agregae el campo
	$sql_empresa = mysqli_query($con, "SELECT * FROM  business_profile");
	$rw_r = mysqli_fetch_array($sql_empresa);
	$rfc_empresa = $rw_r['rfc'];
	$status = 1;
	$id_ticket = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["id_ticket"], ENT_QUOTES))));
	$sql_tmp = mysqli_query($con, "SELECT * FROM tmp_fac where ticket_id=$id_ticket");
	$rnf = mysqli_num_rows($sql_tmp);
	$sql_fa = mysqli_query($con, "SELECT * FROM factura where ticket_id=$id_ticket");
	$rnfa = mysqli_num_rows($sql_fa);
	$obj_impuesto = "02";
	if ($rnf <= 0 and $rnfa <= 0) {
		//Write register in to database 
		$sql = "INSERT INTO tmp_fac (ticket_id,rfc_em,rfc_cli,cp,folio,serie,tipo_comp,stotal,iva,total,estado,forma_p,metodo_p,moneda,uso,emision,descu,objeto_impuesto) 
	VALUES ('" . $id_ticket . "','" . $rfc_empresa . "','" . $rfc . "','" . $cp_cliente . "','" . $folio . "','" . $serie . "','" . $tipo_c . "',
			'" . $subtotal . "','" . $iva . "','" . $total . "','" . $estado . "','" . $f_pago . "','" . $m_pago . "',
			'" . $t_moneda . "','" . $uso . "','" . $fecha . "','" . $descuento . "','" . $obj_impuesto . "');";
		/* pegar despues de $descuento
			,'" . $objetoImpuesto . "' */

		// var_dump("INSERT INTO tmp_fac (ticket_id,rfc_em,rfc_cli,cp,folio,serie,tipo_comp,stotal,iva,total,estado,forma_p,metodo_p,moneda,uso,emision,descu) 
		// VALUES ('" . $id_ticket . "','" . $rfc_empresa . "','" . $rfc . "','" . $cp_cliente . "','" . $folio . "','" . $serie . "','" . $tipo_c . "',
		// 		'" . $subtotal . "','" . $iva . "','" . $total . "','" . $estado . "','" . $f_pago . "','" . $m_pago . "',
		// 		'" . $t_moneda . "','" . $uso . "','" . $fecha . "','" . $descuento . "'
		// );");

		$query_new = mysqli_query($con, $sql);

		// if has been added successfully
		if ($query_new) {
			$messages[] = "El registro de la factura ha sido creado con �xito.";
			$sql_tmpfa = mysqli_query($con, "SELECT * FROM tmp_fac where ticket_id=$id_ticket");
			$rwtmpfac = mysqli_fetch_array($sql_tmpfa);
			$idtmfac = $rwtmpfac['id'];
?>
			<script>
				// alert(<?php //echo $idtmfac; ?>);
				window.location.replace('./timbrar4.php?tmpfac=<?php echo $idtmfac; ?>&ticket=<?php echo $id_ticket; ?>');
				setTimeout(pdf('<?php echo $id_ticket; ?>'), 2000); //POSIBLE PARA MANNDARLO AL JS
			</script>
		<?php
		} else {
			$errors[] = "Lo sentimos , el registro fall�. Por favor, regrese y vuelva a intentarlo.";
		}
	} elseif ($rnf == 1) {
		$sql_tmpfa = mysqli_query($con, "UPDATE tmp_fac set rfc_em = '$rfc_empresa' where ticket_id=$id_ticket");
		$sql_tmpfa = mysqli_query($con, "SELECT * FROM tmp_fac where ticket_id=$id_ticket");
		$rwtmpfac = mysqli_fetch_array($sql_tmpfa);
		$idtmfac = $rwtmpfac['id'];
		?>
		<script>
			window.location.replace('./timbrar4.php?tmpfac=<?php echo $idtmfac; ?>&ticket=<?php echo $id_ticket; ?>');
			setTimeout(pdf('<?php echo $id_ticket; ?>'), 2000); //POSIBLE PARA MANNDARLO AL JS
		</script>
	<?php
	} else {
		$errors[] = "La factura que deseas realizar ya se encuentra creada.";
	}
} else {
	$errors[] = "desconocido.";
}

if (isset($errors)) {
	?>
	<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Error!</strong>
		<?php
		foreach ($errors as $error) {
			echo $error;
		}
		?>
	</div>
<?php
}
if (isset($messages)) {
?>
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>�Bien hecho!</strong>
		<?php
		foreach ($messages as $message) {
			echo $message;
		}
		?>
	</div>
<?php
}
?>

<script>
	function pdf(id) {
		VentanaCentrada(
			"factura_pdf.php?ticket_id=" + id,
			"",
			"1024",
			"768",
			"true"
		)
		// $.ajax({
		//   url:'factura_pdf.php?ticket_id=' + id,
		//   type: "GET",
		//   data:parametros,
		// })
	}
</script>