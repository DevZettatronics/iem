<?php

if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	$a = new RoomData();
	$a->name = $_POST["name"];
	$a->add();
	Core::redir("./?view=rooms&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
	$a = RoomData::getById($_POST["id"]);
	$a->name = $_POST["name"];
	$a->update();
	Core::redir("./?view=rooms&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$a = RoomData::getById($_GET["id"]);
	$a->del();
	Core::redir("./?view=rooms&opt=all");
}

?>