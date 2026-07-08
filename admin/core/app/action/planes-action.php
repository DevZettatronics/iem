<?php

if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	$a = new PlanData();
	$a->name = $_POST["name"];
	$a->add();
	Core::redir("./?view=planes&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
	$a = PlanData::getById($_POST["id"]);
	$a->name = $_POST["name"];
	$a->update();
	Core::redir("./?view=planes&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$a = PlanData::getById($_GET["id"]);
	$a->del();
	Core::redir("./?view=planes&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="addgrade"){
	$a = new PGData();
	$a->plan_id = $_POST["plan_id"];
	$a->grade_id = $_POST["grade_id"];
	$a->add();
	Core::redir("./?view=planes&opt=grades&id=$_POST[plan_id]");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="delgrade"){
	$a = PGData::getById($_GET["id"]);
	$a->del();
	Core::redir("./?view=planes&opt=grades&id=$_GET[plan_id]");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="addasignature"){
	$a = new PGAData();
	$a->plan_id = $_POST["plan_id"];
	$a->asignature_id = $_POST["asignature_id"];
	$a->grade_id = $_POST["grade_id"];
	$a->add();
	Core::redir("./?view=planes&opt=asignatures&id=$_POST[plan_id]");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="delasignature"){
	$a = PGAData::getById($_GET["id"]);
	$a->del();
	Core::redir("./?view=planes&opt=asignatures&id=$_GET[plan_id]");
}

?>