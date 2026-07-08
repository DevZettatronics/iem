<?php
$exist = ScheduleData::getExist($_POST["asignation_id"],$_POST["room_id"],$_POST["d"],$_POST["time_start"],$_POST["time_end"]);
if($exist==null){
$schedule = new ScheduleData();
$schedule->room_id=$_POST["room_id"];
$schedule->asignation_id=$_POST["asignation_id"];
$schedule->d=$_POST["d"];
$schedule->time_start=$_POST["time_start"];
$schedule->time_end=$_POST["time_end"];
$schedule->add();
Core::alert("Agregado exitosamente!");
}else{
	Core::alert("Error, elemento repetido!");
}
Core::redir("./?view=teamasignatures&opt=all&id=$_POST[team_id]&period_id=$_POST[period_id]");

?>