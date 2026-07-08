<?php

$con = Database::getCon();

$tablename = 'inscription';

$alumn_id = $_POST["alumn_id"];
$period_id = $_POST["period_id"];
$team_id = $_POST["team_id"];

foreach ($alumn_id as $alumn_count) {

	$query = mysqli_query($con, "SELECT count(*) AS filas FROM $tablename WHERE alumn_id=$alumn_count AND period_id=$period_id AND team_id=$team_id ");
	$rw = mysqli_fetch_assoc($query);
	$filas = $rw['filas'];
}

if ($filas >= 1) {

	Core::alert("El/Los alumno(s) ya esta(n) inscrito(s) en el grupo y periodo seleccionado.");

	Core::redir("./?view=inscriptions");
} else {

	foreach ($alumn_id as $alumnos) {


		$sql = "INSERT INTO $tablename (alumn_id,period_id,team_id,created_at) 
				VALUES						   ('$alumnos','$period_id','$team_id',NOW())";
		$query_new = mysqli_query($con, $sql);
		// if has been added successfully
		if ($query_new) {
			Core::alert("El/Los alumno(s) se ha(n) inscrito exitosamente.");
			Core::redir("./?view=inscriptions");
		} else {
			Core::alert("Lo sentimos, el registro falló. Por favor, regrese y vuelva a intentarlo.");
			Core::redir("./?view=inscriptions");
		}
	}
}
