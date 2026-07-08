<?php

if(isset($_GET["opt"]) && $_GET["opt"]=="finish"){
	$asignation = AsignationData::getById($_GET["id"]);
	$alumns = InscriptionData::getAllByTP($asignation->team_id,$asignation->period_id);
	foreach($alumns as $a){ $a->finish(); }
	$asignation->finish();
	Core::redir("./?view=myasignations&opt=all");

}

?>