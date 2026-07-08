<?php

if(!empty($_POST)){
	$found = AssistanceData::getByATD($_POST["alumn_id"],$_POST["asignation_id"],$_POST["date_at"]);
	if($found==null && $_POST["kind_id"]!=""){
	$assis = new AssistanceData();
	$assis->alumn_id = $_POST["alumn_id"];
	$assis->asignation_id = $_POST["asignation_id"];
	$assis->kind_id = $_POST["kind_id"];
	$assis->date_at = $_POST["date_at"];
	$assis->add();
if($_POST["kind_id"]==2){
	$alumn = PersonData::getById($_POST["alumn_id"]);
	$parent = PersonData::getById($alumn->parent_id);
	$asignation = AsignationData::getById($_POST["asignation_id"]);
	$asignature = AsignatureData::getById($asignation->asignature_id);
	$teacher = PersonData::getById($asignation->teacher_id);
//	echo "nuevo";
//	print_r($parent);
 $message = "<html>
<body>
<h1>El alumno no ha asistido a la escuela</h1>
<p>Se envia este mensaje debido a que el alumno ha registrado una inasistencia con los siguientes datos:</p>
<p>Alumno: ".$alumn->name." ".$alumn->lastname."</p>
<p>Fecha: ".$_POST['date_at']."</p>
<p>Asignatura: ".$asignature->name."</p>
<p>Profesor: ".$teacher->name." ".$teacher->lastname."</p>
</body>
</html>";

$to = $parent->email;
$adminemail = "admin@admin.com";
$subject = 'El alumno tiene una inasistencia';

$headers = "From: " . strip_tags($adminemail) . "\r\n";
$headers .= "Reply-To: ". strip_tags($adminemail) . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

mail($to, $subject, $message, $headers);
}
	}else if($found=!null&&$_POST["kind_id"]!=""){
	$found = AssistanceData::getByATD($_POST["alumn_id"],$_POST["asignation_id"],$_POST["date_at"]);
	
	$found->kind_id = $_POST["kind_id"];
	$found->update();

if($_POST["kind_id"]==2){
	$alumn = PersonData::getById($_POST["alumn_id"]);
	$parent = PersonData::getById($alumn->parent_id);
	$asignation = AsignationData::getById($_POST["asignation_id"]);
	$asignature = AsignatureData::getById($asignation->asignature_id);
	$teacher = PersonData::getById($asignation->teacher_id);
//	echo "nuevo";
//	print_r($parent);
 $message = "<html>
<body>
<h1>El alumno no ha asistido a la escuela</h1>
<p>Se envia este mensaje debido a que el alumno ha registrado una inasistencia con los siguientes datos:</p>
<p>Alumno: ".$alumn->name." ".$alumn->lastname."</p>
<p>Fecha: ".$_POST['date_at']."</p>
<p>Asignatura: ".$asignature->name."</p>
<p>Profesor: ".$teacher->name." ".$teacher->lastname."</p>
</body>
</html>";

$to = $parent->email;
$adminemail = "admin@admin.com";
$subject = 'El alumno tiene una inasistencia';

$headers = "From: " . strip_tags($adminemail) . "\r\n";
$headers .= "Reply-To: ". strip_tags($adminemail) . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

mail($to, $subject, $message, $headers);
}

//	echo "actualizar";

	}else if($_POST["kind_id"]==""){
	$found = AssistanceData::getByATD($_POST["alumn_id"],$_POST["asignation_id"],$_POST["date_at"]);
		$found->del();
//	echo "eliminar";

	}
}

?>