<?php

include_once("../../config/db.php");
include_once("../../config/conexion.php");
require_once("../../libraries/fuction_xml.php");

if (empty($_POST['rsocial'])) {
	$errors[] = "Razón Social vacío.";
} elseif (empty($_POST['rfc_cli'])) {
	$errors[] = "RFC cliente vacío.";
} elseif (empty($_POST['direccion_cliente'])) {
	$errors[] = "La direccion esta vacía.";
} elseif (empty($_POST['cp_cliente'])) {
	$errors[] = "CP esta vacía.";
} elseif (empty($_POST['tipo_c'])) {
	$errors[] = "Tipo de comprobante vacia.";
} elseif (empty($_POST['serie_f'])) {
	$errors[] = "Serie vacio.";
} elseif (empty($_POST['folio_f'])) {
	$errors[] = "Folio vacio.";
} elseif (empty($_POST['fecha_c'])) {
	$errors[] = "Fecha de emision vacia.";
} elseif (empty($_POST['m_pago'])) {
	$errors[] = "Método de pago vacío.";
} elseif (empty($_POST['f_pago'])) {
	$errors[] = "Forma de pago vacío.";
	// } elseif (empty($_POST['n_cuenta'])) {
	// 	$errors[] = "Número de cuenta vacío.";
} elseif (empty($_POST['t_moneda'])) {
	$errors[] = "Tipo de moneda vacío.";
} elseif (empty($_POST['t_cambio'])) {
	$errors[] = "Tipo de cambio vacío.";
} elseif (empty($_POST['tipo_cfdi'])) {
	$errors[] = "Tipo CFDI vacío."; // en la tabla ira en la parte de uso 
} elseif (empty($_POST['iva']) && $_POST['iva'] != '0' ) {
	$errors[] = "Tipo IVA vacío.";
} elseif (isset($_POST['clave_ps']) && is_int($_POST['clave_ps']) && $_POST['clave_ps'] == 0) {
	$errors[] = "Agregar clave de los productos.";
} elseif (isset($_POST['clave_ps']) && is_int($_POST['clave_ps']) && strlen($_POST['clave_ps']) < 8) {
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
	$customer_id = intval($_POST["customer_id"]);
	$name = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["rsocial"], ENT_QUOTES))));
	$rfc = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["rfc_cli"], ENT_QUOTES))));
	$direccion = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["direccion_cliente"], ENT_QUOTES))));
	$cp_cliente = mysqli_real_escape_string($con, (strip_tags($_POST["cp_cliente"])));

	$tipo_comp = intval($_POST["tipo_c"]);
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
	//isset($_POST["descuento"]) && $_POST["descuento"] != ""  ? $descuento = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["descuento"], ENT_QUOTES)))) : $descuento=0;
	if (isset($_POST["descuento"]) && $_POST["descuento"] != "") {
		// Obtienes el valor del descuento del formulario y eliminas la coma
		$descuento_with_comma = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["descuento"], ENT_QUOTES))));
		$descuento = floatval(str_replace(",", "", $descuento_with_comma));
	} else {
		// Si no se envió el descuento o está vacío, estableces el valor de descuento en 0
		$descuento = 0;
	}
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
	$sql_empresa = mysqli_query($con, "SELECT * FROM  business_profile ");
	$rw_r = mysqli_fetch_array($sql_empresa);
	$rfc_empresa = $rw_r['rfc'];
	$status = 1;
	$id_ticket = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["id_ticket"], ENT_QUOTES))));
	$sql_tmp = mysqli_query($con, "SELECT * FROM tmp_fac where ticket_id=$id_ticket");
	$rnf = mysqli_num_rows($sql_tmp);
	$sql_fa = mysqli_query($con, "SELECT * FROM factura where ticket_id=$id_ticket");
	$rnfa = mysqli_num_rows($sql_fa);
	$obj_impuesto = "02";
	if ($rnf === 0 and $rnfa === 0) {//La factura no existe en la base de datos y se necesitan guardar los datos para poder generarla
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
			$messages[] = "El registro de la factura ha sido creado con éxito.";
			$sql_tmpfa = mysqli_query($con, "SELECT * FROM tmp_fac where ticket_id=$id_ticket");
			$rwtmpfac = mysqli_fetch_array($sql_tmpfa);
			$idtmfac = $rwtmpfac['id'];
?>
			<script>
				// alert(<?php //echo $idtmfac; ?>);
				window.location.replace('?view=timbrar&tmpfac=<?php echo $idtmfac; ?>&ticket=<?php echo $id_ticket; ?>');
				//setTimeout(pdf('<?php echo $id_ticket; ?>'), 2000); //POSIBLE PARA MANNDARLO AL JS
			</script>
		<?php
		} else {
			$errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
			if ($rnf === 0) {
				$messages[] = "No se encontraron registros en tmp_fac para el ticket con id $id_ticket $descuento.";
			} 
			if ($rnfa === 0) {
				$messages[] = "No se encontraron registros en la tabla factura para el ticket con id $id_ticket.";
			} 
		}
	} elseif ($rnf == 1) {//La factura sí existe en la base de datos y es necesario obtener toda la información de la factura
		$sql_tmpfa = mysqli_query($con, "SELECT * FROM tmp_fac where ticket_id=$id_ticket");
		$rwtmpfac = mysqli_fetch_array($sql_tmpfa);
		$idtmfac = $rwtmpfac['id'];
		?>
		<script>
			window.location.replace('?view=timbrar&tmpfac=<?php echo $idtmfac; ?>&ticket=<?php echo $id_ticket; ?>');
			//setTimeout(pdf('<?php echo $id_ticket; ?>'), 2000); //POSIBLE PARA MANNDARLO AL JS
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
		<strong>¡Bien hecho!</strong>
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