<?php
$con = Database::getCon();

if (isset($_GET["opt"]) && $_GET["opt"] == "add") {
	$a = new CategoriesData();
	$a->name = $_POST["name"];
	$a->descripcion = $_POST["descripcion"];

	$verificar = $a->name = $_POST["name"]; /* pruebas */

	$sql = "SELECT * FROM categories WHERE name = '" . $verificar . "';"; /*evitar la duplicidad de datos */
	$query_check_curp = mysqli_query($con, $sql);
	$query_curp = mysqli_num_rows($query_check_curp);

	if ($query_curp == 1) {
		Core::alert("EL NOMBRE DE LA CATEGORIA YA EXISTE"); /* alerta del sistema */
	} else {
		$a->add();
		Core::redir("./?view=categorias&opt=all");
	}
	Core::redir("./?view=categorias&opt=all"); /* retorono a pagina principal */
} else if (isset($_GET["opt"]) && $_GET["opt"] == "update") { /* editar */
	$a = CategoriesData::getById($_POST["id"]);
	$a->name = $_POST["name"];
	$a->descripcion = $_POST["descripcion"];
	$a->update();
	Core::redir("./?view=categorias&opt=all");
} else if (isset($_GET["opt"]) && $_GET["opt"] == "del") { /* eliminar datos */
	$a = CategoriesData::getById($_GET["id"]);
	$a->del();
	Core::redir("./?view=categorias&opt=all");
}
