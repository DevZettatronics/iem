<?php

if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	$a = new GradeData();
	$a->name = $_POST["name"];
	$a->add();
	Core::redir("./?view=grades&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
	$a = GradeData::getById($_POST["id"]);
	$a->name = $_POST["name"];
	$a->update();
	Core::redir("./?view=grades&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$a = GradeData::getById($_GET["id"]);
	$a->del();
	Core::redir("./?view=grades&opt=all");
}

?>