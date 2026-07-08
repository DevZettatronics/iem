<?php
/* Connect To Database*/
require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
require_once("../libraries/inventory.php"); //Contiene funcion que conecta a la base de datos
if (isset($_REQUEST['id_alumno']) && isset($_REQUEST['id_producto'])) {
	$sql = "SELECT * FROM `plan_de_pago` WHERE `alumno` = '" . $_REQUEST['id_alumno'] . "' && `concepto` = '" . $_REQUEST['id_producto'] . "'";
	$result = mysqli_query($con, $sql);
	$row_s_n = mysqli_fetch_array($result);	
	$beca_temp = ($row_s_n['cuenta_beca'] == null || $row_s_n['cuenta_beca'] == " " || $row_s_n['cuenta_beca'] == "" || !isset($row_s_n['cuenta_beca']) || $row_s_n['cuenta_beca'] == "MO") ? 'NO' : $row_s_n['cuenta_beca'];
	$promo_temp = ($row_s_n['cuenta_promocion'] == null || $row_s_n['cuenta_promocion'] == " " || $row_s_n['cuenta_promocion'] == "" || !isset($row_s_n['cuenta_promocion']) || $row_s_n['cuenta_promocion'] == "NO") ? 'NO' : $row_s_n['cuenta_promocion'];
	$beca = ($row_s_n['cuenta_beca'] == null || $row_s_n['cuenta_beca'] == " " || $row_s_n['cuenta_beca'] == "" || !isset($row_s_n['cuenta_beca']) || $row_s_n['cuenta_beca'] == "MO") ? 'NO' : $row_s_n['cuenta_beca'];
	$promo = ($row_s_n['cuenta_promocion'] == null || $row_s_n['cuenta_promocion'] == " " || $row_s_n['cuenta_promocion'] == "" || !isset($row_s_n['cuenta_promocion']) || $row_s_n['cuenta_promocion'] == "NO") ? 'NO' : $row_s_n['cuenta_promocion'];
	//--------------------------------------------------------------------------//
	$sql = "SELECT * FROM `person` WHERE `ID` = '" . $_REQUEST['id_alumno'] . "'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);
	$code = $row['code'];	
	if ($beca == "NO") {
		//--------------------------------------------------------------------------//
		$beca = 0;		
	} else {
		$sql = "SELECT * FROM `alumns_bec_prom` WHERE `code` = '" . $code . "' ORDER BY `alumns_bec_prom`.`created_at` DESC";
		$result = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($result);
		$beca = $row['beca'];
		$sql = "SELECT * FROM `becas` WHERE `id` = '" . $beca . "' AND tipo = '1'";
		$result = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($result);
		$beca = $row['porcentaje'];
	}
	if ($promo == "NO") {
		//--------------------------------------------------------------------------//
		$promo = 0;
	} else {
		$sql = "SELECT * FROM `alumns_bec_prom` WHERE `code` = '" . $code . "' ORDER BY `alumns_bec_prom`.`created_at` DESC";
		$result = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($result);
		$promo = $row['promocion'];
		$sql = "SELECT * FROM `becas` WHERE `id` = '" . $promo . "' AND tipo = '2'";
		$result = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($result);
		$promo = $row['porcentaje'];
	}
	$sql = "SELECT * FROM `alumns_bec_prom` WHERE `code` = '" . $code . "' ORDER BY `alumns_bec_prom`.`created_at` DESC";
	$sql2 = "SELECT * FROM `plan_de_pago` WHERE `alumno` = '" . $_REQUEST['id_alumno'] . "' && `concepto` = '" . $_REQUEST['id_producto'] . "'";
	echo json_encode(array("beca" => $beca, "promo" => $promo, "sql" => $sql, "sql2" => $sql2 , "extra" => $beca_temp . " " . $promo_temp));
}
?>