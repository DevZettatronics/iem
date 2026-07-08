<?php

if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	$a = new ConceptData();
	$a->name = $_POST["name"];
	$a->price = $_POST["price"];
	$a->add();
	Core::redir("./?view=concepts&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
	$a = ConceptData::getById($_POST["id"]);
	$a->name = $_POST["name"];
	$a->price = $_POST["price"];
	$a->update();
	Core::redir("./?view=concepts&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$a = ConceptData::getById($_GET["id"]);
	$a->del();
	Core::redir("./?view=concepts&opt=all");
}

?>