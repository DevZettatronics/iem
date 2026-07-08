<?php
session_start();
if (isset($_REQUEST['id'])) {
	/* Connect To Database*/
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");


	$id = $_REQUEST["id"];
	$id = intval($id);

		if ($delete = mysqli_query($con, "DELETE FROM tmp_fac WHERE ticket_id='$id'")) {
			$messages[] = "<b> eliminados satisfactoriamente.";

		} else {
			$errors[] = "Error al eliminar los datos " . mysqli_error($con);
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
			<script>
					window.location.replace('./?view=payments&opt=all');
					</script>
		</div>
<?php
	}
}
?>