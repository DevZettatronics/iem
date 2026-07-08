<?php

if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	$a = new LetterData();
	$a->name = $_POST["name"];
	$a->add();
	Core::redir("./?view=letters&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
	$a = LetterData::getById($_POST["id"]);
	$a->name = $_POST["name"];
	$a->update();
	Core::redir("./?view=letters&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$a = LetterData::getById($_GET["id"]);
	$a->del();
	Core::redir("./?view=letters&opt=all");
}

?>