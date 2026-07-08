<?php
$con = Database::getCon();

if (isset($_GET["opt"]) && $_GET["opt"] == "check") {
	$id_course = $_GET["id"];
	$id_person = $_GET["user"];

	$resultado = mysqli_query($con, "SELECT count(*) AS filas FROM reg_courses WHERE id_course = $id_course AND id_person = $id_person ");
	$rw = mysqli_fetch_assoc($resultado);
	$filas = $rw['filas'];

	if ($filas == 1) {
		Core::alert("Ya te encuentras registrado en este curso");
		Core::redir("./?view=courses");
	} else {

		$query_new = mysqli_query($con, "INSERT INTO reg_courses (id_course,id_person) VALUES('$id_course','$id_person');");
		Core::alert("Inscrito con exito");
		Core::redir("./?view=courses");
	}
}
