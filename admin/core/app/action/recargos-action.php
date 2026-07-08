<?php
$con = Database::getCon();
if (isset($_GET["opt"]) && $_GET["opt"] == "add") { 
    // Leer JSON del body
    $data = json_decode(file_get_contents("php://input"), true);

    $nombre = $data['nombre'] ?? '';
    $descripcion = $data['descripcion'] ?? '';
    $fecha_inicio = $data['fecha_inicio'] ?? '';
    $fecha_fin = $data['fecha_fin'] ?? '';

    $intervalos = 0;
    if (!empty($fecha_inicio) && !empty($fecha_fin)) {
        $inicio = new DateTime($fecha_inicio);
        $fin = new DateTime($fecha_fin);

        $intervalo = $inicio->diff($fin); // Si no inclui mos fehca fin 
        // $intervalo = $inicio->diff($fin)->days + 1; // Si incluimos fehca inicio y fin 

        $intervalos = $intervalo->days; // Número total de días
        // echo "El intervalo es de $dias días";
    } else {
        echo "Fechas inválidas";
    }


    if (empty($nombre) || empty($descripcion) || empty($fecha_inicio) || empty($fecha_fin)) {
        echo json_encode([
            "success" => false,
            "message" => "Todos los campos son requeridos."
        ]);
        exit;
    }

    $r = new Recargos;
    $r->nombre = $nombre;
    $r->descripcion = $descripcion;
    $r->fecha_inicio = $fecha_inicio;
    $r->intervalos = $intervalos;
    $r->fecha_fin = $fecha_fin;

    header('Content-Type: application/json');

    if ($r->add()) {
        echo json_encode([
            "success" => true,
            "message" => "Recargo agregado correctamente."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Error al agregar el registro."
        ]);
    }
    exit;
}

if (isset($_GET["opt"]) && $_GET["opt"] == "getById" && isset($_GET["id"])) {
    $id = $_GET["id"];
    $r = Recargos::getById($id); // crea este método si no lo tienes
    echo json_encode($r);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['opt']) && $_GET['opt'] === 'upd') {
            
    $id = $_POST['edit_id'] ?? '';
    $nombre = $_POST['edit_name'] ?? '';
    $descripcion = $_POST['edit_descripcion'] ?? '';
    $fecha_inicio = $_POST['fecha_inicioEdit'] ?? '';
    $fecha_fin = $_POST['fecha_finEdit'] ?? '';
    
    $intervalos = 0;
    if (!empty($fecha_inicio) && !empty($fecha_fin)) {
        $inicio = new DateTime($fecha_inicio);
        $fin = new DateTime($fecha_fin);

        $intervalo = $inicio->diff($fin); // Si no inclui mos fehca fin 
        // $intervalo = $inicio->diff($fin)->days + 1; // Si incluimos fehca inicio y fin 

        $intervalos = $intervalo->days; // Número total de días
        // echo "El intervalo es de $dias días";
    } else {
        echo "Fechas inválidas";
    }

    if (empty($nombre) || empty($descripcion) || empty($fecha_inicio) || empty($fecha_fin)) {
        echo json_encode([
            "success" => false,
            "message" => "Todos los campos son requeridos."
        ]);
        exit;
    }

    $r = new Recargos();
    $r->id = $id;
    $r->nombre = $nombre;
    $r->descripcion = $descripcion;
    $r->fecha_inicio = $fecha_inicio;
    $r->fecha_fin = $fecha_fin;
    $r->intervalos = $intervalos;

    // $v->update();
    // echo "Registro actualizado correctamente.";
    header('Content-Type: application/json');

    if ($r->update()) {
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

    Recargos::delete($id);

    // echo "Registro eliminado correctamente.";
    // print "<script>window.location='index.php?view=centroVinculacion&opt=all';</script>"; 
    header('Content-Type: application/json');
    echo json_encode([
        "success" => true,
        "message" => "Registro eliminado correctamente.",
        "redirect" => "index.php?view=recargos&opt=all"
    ]);
    exit;
}