<?php

if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
    
    $con = Database::getCon();
    
	if(count($_POST)>0){
	$a = new EducationalProgramData();  
	$a->name = $_POST["name"];
	$a->grado = $_POST["grado"];
	$a->tipo = $_POST["tipo"];
	$a->nc = $_POST["nc"];
	$a->p_a = $_POST["p_name"];

	//claves
	$a->clavep = $_POST["clavep"];
	$a->clave_plan = $_POST["clave_plan"];

	// rvoe
	$a->no_rvoe = $_POST["no_rvoe"];
	$a->frvoe = $_POST["frvoe"];

	// calificaciones
	$a->calmin = $_POST["calmin"];
	$a->calmax = $_POST["calmax"];
	$a->calap = $_POST["calap"];
	// $a->created_at = 'NOW()';
	$a->id_p = $_POST["id_p"];
	// echo $a->id_p;
	$u = $a->add();
	
	if (mysqli_error($con)) {

        Core::alert("Hubo un error al registrar el progrma, Intentalo de nuevo");

        error_log("Se recuperó el siguiente error: " . mysqli_error($con));
		Core::redir("./?view=educationalprogram&opt=new");
    } else {

        Core::alert("Se ha creado de forma exitosa el nuevo programa!");
		Core::redir("./?view=educationalprogram&opt=all");

    }	
}
}	

/*else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
	if(count($_POST)>0){
	$a = AsignatureData::getById($_POST["id"]);
	$a->name = $_POST["name"];
	$a->program = $_POST["program"];
	$a->update();
	Core::alert("Asignatura Actualizada Exitosamente!");	
	Core::redir("./?view=asignatures&opt=all");
}
}*/


if($_GET["opt"] && $_GET["opt"]=="update"){

	if(count($_POST)>0){
	$a = EducationalProgramData::getById($_POST["id"]);
	$a->name = $_POST["name"];
	$a->grado = $_POST["grado"];
	$a->tipo = $_POST["tipo"];
	$a->nc = $_POST["nc"];
	$a->p_a = $_POST["p_name"];

	//claves
	$a->clavep = $_POST["clavep"];
	$a->clave_plan = $_POST["clave_plan"];

	// rvoe
	$a->no_rvoe = $_POST["no_rvoe"];
	$a->frvoe = $_POST["frvoe"];

	// calificaciones
	$a->calmin = $_POST["calmin"];
	$a->calmax = $_POST["calmax"];
	$a->calap = $_POST["calap"];
	// $a->created_at = 'NOW()';
	$a->id_p = $_POST["id_p"];
		$u = $a->update();
			Core::alert("Programa Actualizado Exitosamente!");
			Core::redir("./?view=educationalprogram&opt=all");
	}
	}
	





else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$a = EducationalProgramData::getById($_GET["id"]);
	$a->del();
	Core::redir("./?view=educationalprogram&opt=all");
}
// else if(isset($_GET["opt"]) && $_GET["opt"]=="deltas"){
// 	$a = AsignationData::getById($_GET["id"]);
// 	$a->del();
// 	Core::redir("./?view=teamasignatures&opt=all&id=$_GET[team_id]&period_id=$_GET[period_id]");
// }else if(isset($_GET["opt"]) && $_GET["opt"]=="delschedule"){
// 	$a = ScheduleData::getById($_GET["id"]);
// 	$a->del();
// 	Core::redir("./?view=teamasignatures&opt=all&id=$_GET[team_id]&period_id=$_GET[period_id]");
// }

?>