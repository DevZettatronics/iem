<?php
$con = Database::getCon();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['opt']) && $_GET['opt'] === 'add') {
    
    $nombre = trim($_POST['nombre'] ?? '');
    $monto = trim($_POST['monto'] ?? '');
    $centro_id = $_POST['centro_id'] ?? null;

    if (empty($nombre) || !is_numeric($monto) || empty($centro_id)) {
        echo "Todos los campos son requeridos y monto debe ser numérico.";
        exit;
    }

    $v = new Vinculacion();
    $v->nombre = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
    $v->monto = floatval($monto);
    $v->centro_id = intval($centro_id);

    // $v->addConceptos();

    if ($v->addConceptos()) {
        echo "Concepto agregado correctamente.";
    } else {
        echo "Error al actualizar el registro.";
    }

    exit;
}

if (isset($_GET["opt"]) && $_GET["opt"] == "edit" && isset($_GET["id"])) {

    $id = $_GET["id"];
    $v = Vinculacion::getByIdConcepto($id); // crea este método si no lo tienes
    echo json_encode($v);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['opt']) && $_GET['opt'] === 'editUp') {
    $id = $_POST['edit_id'] ?? '';
    $edit_name = $_POST['edit_name'] ?? '';
    $edit_monto = $_POST['edit_monto'] ?? '';


    if (empty($id) || empty($edit_name) || !is_numeric($edit_monto) || $edit_monto < 0) {
        echo "Todos los campos son requeridos y monto debe ser un número válido.";
        exit;
    }


    $v = new Vinculacion();
    $v->id = $id;
    $v->nombre = $edit_name; // Usa 'nombre', no 'name'
    $v->monto = $edit_monto;


    // if ($v->updateConcepto()) {
    //     echo "Concepto actualizado correctamente.";
    // } else {
    //     echo "Error al actualizar el registro.";
    // }

    header('Content-Type: application/json');

    if ($v->updateConcepto()) {
        echo json_encode([
            "success" => true,
            "message" => "Concepto actualizado correctamente."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Error al actualizar el registro."
        ]);
    }

    exit;

}

if (isset($_GET['opt']) && $_GET['opt'] === 'delete' && isset($_GET["id"]) && isset($_GET["id_center"])) {
    $id = intval($_GET["id"]); // sanitizar el ID
    $id_center = intval($_GET["id_center"]); // sanitizar también el ID del centro

    Vinculacion::deleteConceptos($id);

   // Devolver respuesta en JSON
    header('Content-Type: application/json');
    echo json_encode([
        "success" => true,
        "message" => "Concepto eliminado correctamente.",
        "redirect" => "index.php?view=conceptosCV&opt=add&id=$id_center"
    ]);
    
    exit;
}


?>