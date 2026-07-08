<?php
$con = Database::getCon();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['opt']) && $_GET['opt'] === 'add') {
    $name = $_POST['name'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $responsable = $_POST['responsable'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $parcialidades = $_POST['parcialidades'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $email = $_POST['email'] ?? '';

    if (empty($name) || empty($descripcion) || empty($responsable) || empty($direccion) || empty($telefono) || empty($parcialidades) 
        || empty($lastname) || empty($email)) {
        echo "Todos los campos son requeridos.";
        exit;
    }

    $v = new Vinculacion();
    $v->name = $name;
    $v->descripcion = $descripcion;
    $v->responsable = $responsable;
    $v->address = $direccion;
    $v->phone = $telefono;
    $v->parcialidades = $parcialidades;
    $v->lastname = $lastname;
    $v->email = $email;

    $v->add();
    echo "Registro agregado correctamente.";
    exit;
}

if (isset($_GET["opt"]) && $_GET["opt"] == "edit" && isset($_GET["id"])) {

    $id = $_GET["id"];
    $v = Vinculacion::getById($id); // crea este método si no lo tienes
    echo json_encode($v);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['opt']) && $_GET['opt'] === 'editUp') {
    $id = $_POST['edit_id'] ?? '';
    $edit_name = $_POST['edit_name'] ?? '';
    $edit_descripcion = $_POST['edit_descripcion'] ?? '';
    $edit_responsable = $_POST['edit_responsable'] ?? '';
    $edit_direccion = $_POST['edit_direccion'] ?? '';
    $edit_telefono = $_POST['edit_telefono'] ?? '';
    $edit_parcialidades = $_POST['edit_parcialidades'] ?? '';
    $edit_lastname = $_POST['edit_lastname'] ?? '';
    $edit_email = $_POST['edit_email'] ?? '';
 

    if (empty($id) || empty($edit_name) || empty($edit_descripcion) || empty($edit_responsable) || empty($edit_direccion) ||
             empty($edit_telefono) || empty($edit_parcialidades) || empty($edit_lastname) || empty($edit_email)) {
        echo "Todos los campos son requeridos.";
        exit;
    }

    $v = new Vinculacion();
    $v->id = $id;
    $v->name = $edit_name;
    $v->descripcion = $edit_descripcion;
    $v->responsable = $edit_responsable;
    $v->address = $edit_direccion;
    $v->phone = $edit_telefono;
    $v->parcialidades = $edit_parcialidades;
    $v->lastname = $edit_lastname;
    $v->email = $edit_email;

    // $v->update();
    // echo "Registro actualizado correctamente.";
    header('Content-Type: application/json');

    if ($v->update()) {
        echo json_encode([
            "success" => true,
            "message" => "Registro actualizado correctamente."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Error al actualizar el registro."
        ]);
    }
    exit;
}

if (isset($_GET['opt']) && $_GET['opt'] === 'delete' && isset($_GET["id"])) {
    $id = intval($_GET["id"]); // sanitizar el ID

    Vinculacion::delete($id);

    // echo "Registro eliminado correctamente.";
    // print "<script>window.location='index.php?view=centroVinculacion&opt=all';</script>"; 
    header('Content-Type: application/json');
    echo json_encode([
        "success" => true,
        "message" => "Registro eliminado correctamente.",
        "redirect" => "index.php?view=centroVinculacion&opt=all"
    ]);
    exit;
}

?>