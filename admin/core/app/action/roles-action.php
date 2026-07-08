<?php
// Leer el cuerpo de la petición como JSON
$data = json_decode(file_get_contents("php://input"), true);

// Verificar si se recibió nameRol
if (isset($data['nameRol'])) {
    $nameRol = $data['nameRol'];

    // Llamamos a la función y obtenemos la respuesta
    $resultado = Permisos::insertRol($nameRol);
   
    // Devolvemos el resultado como JSON
    echo json_encode($resultado);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Falta el nombre del rol"
    ]);
}
?>