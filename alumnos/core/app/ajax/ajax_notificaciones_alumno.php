<?php
/* Connect To Database*/
session_start();
include "../../controller/Database.php";
$con = Database::getCon();

$user = $_SESSION["code"];

if (isset($_POST['view'])) {


	if ($_POST["view"] != '') {
		$update_query = "UPDATE notificaciones SET estado = 1 WHERE estado =0";
		mysqli_query($con, $update_query);
	}
	$query = "SELECT * FROM notificaciones WHERE id_receptor = $user ORDER BY id DESC LIMIT 3 ";
	$result = mysqli_query($con, $query);
	$output = '';
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_array($result)) {
			$fechaOriginal = $row["fecha"];
			$fechaFormateada = date("d-m-Y H:i", strtotime($fechaOriginal));
			$output .= '
	   <li>
		  <a href="#">
			<strong class="text-bold text-black">' . $row["mensaje"] . '</strong><br />
			<small><em class="text-bold text-black">' . $fechaFormateada. ' hrs' . '</em></small>
		  </a>
	   </li>
	   ';
		}
		$output .= '
		 <li><a href="./?view=notificaciones&code= ' . $_SESSION["code"] . ' " class="text-bold text-black">Ver todas las notificaciones</a></li>';
	} else {
		$output .= '
		 <li><a href="#" class="text-bold text-black">No tienes notificaciones nuevas</a></li>';
	}

//codigo para alert inicial"   // WHERE estado=0 AND id_receptor = $user 

	$status_query = "SELECT * FROM notificaciones WHERE estado=0 AND id_receptor = $user ";
	$result_query = mysqli_query($con, $status_query);
	$count = mysqli_num_rows($result_query);
	$data = array(
		'notification' => $output,
		'unseen_notification'  => $count
	);

	echo json_encode($data);
}
