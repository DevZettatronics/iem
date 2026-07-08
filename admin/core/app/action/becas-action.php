<?php
if (isset($_GET["opt"]) && $_GET["opt"] == "add") {
	$a = new BecasData();
	$a->name = $_POST["name"];
	$a->porcentaje = $_POST["porcentaje"];
	$a->descripcion = $_POST["descripcion"];
	$a->tipo = $_POST["tipo"];
	$a->state = $_POST["state"];
	$a->add();
	Core::redir("./?view=becas&opt=all");
}
if (isset($_GET["opt"]) && $_GET["opt"] == "adds") {
	$a = new BecasData();
	$a->name = $_POST["name"];
	$a->porcentaje = $_POST["porcentaje"];
	$a->descripcion = $_POST["descripcion"];
	$a->tipo = $_POST["tipo"];
	$a->state = $_POST["state"];
	$a->add();
	Core::redir("./?view=promociones&opt=all");
} else if (isset($_GET["opt"]) && $_GET["opt"] == "update") {
	$a = BecasData::getById($_POST["id"]);
	$a->name = $_POST["name"];
	$a->porcentaje = $_POST["porcentaje"];
	$a->descripcion = $_POST["descripcion"];
	$a->state = $_POST["state"];
	$a->update();
	Core::redir("./?view=becas&opt=all");
}
if (isset($_GET["opt"]) && $_GET["opt"] == "updates") {
	$a = BecasData::getById($_POST["id"]);
	$a->name = $_POST["name"];
	$a->porcentaje = $_POST["porcentaje"];
	$a->descripcion = $_POST["descripcion"];
	$a->state = $_POST["state"];
	$a->update();
	Core::redir("./?view=promociones&opt=all");
} else if (isset($_GET["opt"]) && $_GET["opt"] == "del") {
	$a = BecasData::getById($_GET["id"]);
	$a->del();
	Core::redir("./?view=becas&opt=all");
} else if (isset($_GET["opt"]) && $_GET["opt"] == "dele") {
	$a = BecasData::getById($_GET["id"]);
	$a->del();
	Core::redir("./?view=promociones&opt=all");

}