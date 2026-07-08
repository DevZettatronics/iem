<?php
if (count($_POST) > 0) {
	$user = new TeamData();
	// $user->grade = $_POST["programa"];  
	$user->letter = $_POST["letter"];
	// $user->nca = $_POST["nca"];
	$user->grade = $_POST["name"];
	$user->id_program = $_POST["programa"];
	$user->historial_asg = $_POST['historial_asg'];
	// $user->letter= $user->nca."-".$user->let;
	$user->modalidad= $_POST['modalidadBD'];

	if ($_POST["ck"] == 1) {

		$user->semestre = 1;
	} elseif ($_POST["ck"] == 2) {

		$user->semestre = 2;
	} elseif ($_POST["ck"] == 3) {

		$user->semestre = 3;
	} elseif ($_POST["ck"] == 4) {

		$user->semestre = 4;
	} elseif ($_POST["ck"] == 5) {

		$user->semestre = 5;
	} elseif ($_POST["ck"] == 6) {

		$user->semestre = 6;
	} elseif ($_POST["ck"] == 7) {

		$user->semestre = 7;
	} elseif ($_POST["ck"] == 8) {

		$user->semestre = 8;
	} elseif ($_POST["ck"] == 9) {

		$user->semestre = 9;
	}elseif ($_POST["ck"] == 10) {

		$user->semestre = 10;
	}elseif ($_POST["ck"] == 11) {

		$user->semestre = 11;
	}elseif ($_POST["ck"] == 12) {

		$user->semestre = 12;
	}
	$user->add();
	print "<script>window.location='index.php?view=teams&opt=all';</script>";
}
