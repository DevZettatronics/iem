<?php

if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	$a = new NotificacionesData();
	$a->mensaje = $_POST["mensaje"];
	$a->fecha = $_POST["fecha"];
		

	$a->id_receptor = $_POST["id_receptor"];
	$a->kind_pub = 1;
	$a->user_id = $_SESSION["user_id"];
	$a->add();
	Core::redir("./?view=notificaciones&opt=all");

	$a->kind = $_POST["kind"];
	$a->kind_pub = 1;
	$a->user_id = $_SESSION["user_id"];
	$a->add();
	Core::redir("./?view=notificaciones&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
	$a = NotificacionesData::getById($_POST["id"]);
	$a->id_receptor = $_POST["id_receptor"];
	$a->mensaje = $_POST["mensaje"];
		

	$a->id_receptor = $_POST["id_receptor"];
	$a->update();
	Core::redir("./?view=notificaciones&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$a = NotificacionesData::getById($_GET["id"]);
	$a->del();
	Core::redir("./?view=notificaciones&opt=all");
}
?>