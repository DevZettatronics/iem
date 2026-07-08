<?php

//$teams = AlumnTeamData::getAllByAlumnId($_GET["id"]);
//foreach ($teams as $t) {
//	$t->del();
//}

$alumn = TeacherData::getById($_GET["id"]);
$alumn->del();

Core::redir("./?view=teachers");
?>