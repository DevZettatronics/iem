<?php
if (isset($_GET["opt"]) && $_GET["opt"] == "add") {
	$block = new BlockData();
	$block->name = $_POST["name"];
	$block->asignation_id = $_POST["asignation_id"];
	$query = $block->add();

	if ($query[0] != Null) {
		$block->block_id = $query[1];
		// $block->asignation_id = $_POST["asignation_id"];
		foreach ($_POST["nameBlockChildren"] as $block->name) {
			$block->add_sub();
		}
		Core::alert("Agreado exitosamente!");
		Core::redir("./?view=blocks&opt=all&id=$_POST[asignation_id]");
	} else {
		Core::alert("No se pudieron generar los bloques de calificaciones");
		Core::redir("./?view=blocks&opt=all&id=$_POST[asignation_id]");
	}
}
/* else if(isset($_GET["opt"]) && $_GET["opt"]=="addsub"){
	$block = new BlockData();
	$block->block_id=$_POST["block_id"];
	$block->name=$_POST["name"];
	$block->asignation_id=$_POST["asignation_id"];
	$block->add_sub();
	Core::alert("Agreado exitosamente!");
	Core::redir("./?view=blocks&opt=all&id=$_POST[asignation_id]");
} */ else if (isset($_GET["opt"]) && $_GET["opt"] == "upd") {
	$block = BlockData::getById($_POST["block_id"]);
	$block->name = $_POST["name"];
	$block->update();
	Core::alert("Actualizado exitosamente!");
	Core::redir("./?view=blocks&opt=all&id=$_POST[asignation_id]");
} else if (isset($_GET["opt"]) && $_GET["opt"] == "del") {
	$block = BlockData::getById($_GET["id"]);
	$block->del();
	Core::alert("Eliminado exitosamente!");
	Core::redir("./?view=blocks&opt=all&id=$_GET[asignation_id]");
}
