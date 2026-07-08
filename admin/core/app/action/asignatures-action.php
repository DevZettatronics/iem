<?php

if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	if(count($_POST)>0){
	$a = new AsignatureData();
	$a->name = $_POST["name"];
	$a->program = $_POST["program_a"];
	$a->credito = $_POST["credito"];
	$a->grado = $_POST["grado"];  
	$a->code_asignatura = $_POST["code_asignatura"];
	$a->id_program = $_POST["id_program"];
	$a->add();
	Core::alert("Se ha creado de forma exitosa una nueva asignatura!");	
	Core::redir("./?view=asignatures&opt=all");
	
}
}	
if($_GET["opt"] && $_GET["opt"]=="update"){

if(count($_POST)>0){
	$a = AsignatureData::getById($_POST["id"]);
	$a->name = $_POST["name"];
	$a->program = $_POST["program_a"];
	$a->credito = $_POST["credito"];
	$a->grado = $_POST["grado"];
	$a->code_asignatura = $_POST["code_asignatura"];
	$a->id_program = $_POST["id_program"];
	$u = $a->update();
		Core::alert("Asignatura Actualizada Exitosamente!");
		Core::redir("./?view=asignatures&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$a = AsignatureData::getById($_GET["id"]);
	$a->del();
	Core::redir("./?view=asignatures&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="deltas"){
	$a = AsignationData::getById($_GET["id"]);
	$a->del();
	Core::redir("./?view=teamasignatures&opt=all&id=$_GET[team_id]&period_id=$_GET[period_id]");
}else if(isset($_GET["opt"]) && $_GET["opt"]=="delschedule"){
	$a = ScheduleData::getById($_GET["id"]);
	$a->del();
	Core::redir("./?view=teamasignatures&opt=all&id=$_GET[team_id]&period_id=$_GET[period_id]");
}
