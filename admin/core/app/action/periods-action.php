<?php

if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	$a = new PeriodData();
	$a->name = $_POST["name"];
	$a->periodo = $_POST["periodo"];
	$a->start_at = $_POST["start_at"];
	$a->finish_at = $_POST["finish_at"];
	$a->add();
	Core::redir("./?view=periods&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
	$a = PeriodData::getById($_POST["id"]);
	$a->name = $_POST["name"];
	$a->periodo = $_POST["periodo"];
	$a->start_at = $_POST["start_at"];
	$a->finish_at = $_POST["finish_at"];
	$a->update();
	Core::redir("./?view=periods&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$a = PeriodData::getById($_GET["id"]);
	$a->del();
	Core::redir("./?view=periods&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="setstarted"){
	$a = PeriodData::getById($_GET["id"]);
	$a->set_started();
	Core::redir("./?view=periods&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="setfinished"){
	$a = PeriodData::getById($_GET["id"]);
	$a->set_finished();
	Core::redir("./?view=periods&opt=all");
}
?>