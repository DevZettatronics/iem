<?php

//$teams = AlumnTeamData::getAllByAlumnId($_GET["id"]);
//foreach ($teams as $t) {
//	$t->del();
//}

$alumn = InscriptionData::getById($_GET["id"]);
//$asig = AsignationData::getByPAT($alumn->period_id,$alumn->team_id);
//print_r($alumn);
$alumn->del();

Core::redir("./?view=inscriptions");
?>