<?php
$con = Database::getCon();
header('Content-Type: application/json');

$opt = $_POST['opt'] ?? '';

if ($opt == 'add') {

    // Validar obligatorios
    if (
        !isset($_POST['id']) ||
        !isset($_POST['estado']) ||
        !isset($_POST['id_usuario'])
    ) {
        echo json_encode([
            "status" => "error",
            "message" => "Faltan datos obligatorios"
        ]);
        exit;
    }

    $id         = intval($_POST['id']);
    $estado     = intval($_POST['estado']);
    $comentario = mysqli_real_escape_string($con, $_POST['comentario'] ?? "");

    // Fecha puede venir vacía → guardamos NULL
    $fecha = ($_POST['fecha'] === "" ? NULL : $_POST['fecha']);

    $id_usuario = intval($_POST['id_usuario']);

    mysqli_begin_transaction($con);

    try {

        // -----------------------------------------
        // 1) OBTENER NOMBRE Y APELLIDO DEL USUARIO
        // -----------------------------------------

        $consulta1 = mysqli_prepare($con,"SELECT name, lastname FROM user WHERE id = ?");
        if (!$consulta1) {
            throw new Exception("Error al preparar consulta1: " . mysqli_error($con));
        }

        mysqli_stmt_bind_param($consulta1, "i", $id_usuario);

        mysqli_stmt_execute($consulta1);

        mysqli_stmt_bind_result($consulta1, $name_db, $lastname_db);
        mysqli_stmt_fetch($consulta1);

        mysqli_stmt_close($consulta1);

        // Si no existe usuario → nombre por defecto
        $nombre_usuario = trim(($name_db ?? "Desconocido") . " " . ($lastname_db ?? ""));

        // -----------------------------------------
        // 2) INSERTAR REGISTRO
        // -----------------------------------------

        $consulta = mysqli_prepare(
            $con,
            "INSERT INTO estatus_alumnos 
                (id_alumno, estado, mensaje, id_usuario, nombre_usuario, fecha_manual)
             VALUES (?,?,?,?,?,?)"
        );

        if (!$consulta) {
            throw new Exception("Error al preparar insert: " . mysqli_error($con));
        }

        mysqli_stmt_bind_param(
            $consulta,
            'iisiss',
            $id,
            $estado,
            $comentario,
            $id_usuario,
            $nombre_usuario,
            $fecha
        );

        if (!mysqli_stmt_execute($consulta)) {
            throw new Exception("Error al ejecutar insert: " . mysqli_stmt_error($consulta));
        }

        // Obtener ID autoincremental
        $id_insercion = mysqli_insert_id($con);

        //Insertamos el estatus actual del alumno 
        $consulta2 = mysqli_prepare($con,"UPDATE person SET status_alumno = ? WHERE id = ?");
        if (!$consulta2) {
            throw new Exception("Error al preparar la consulta person: ". mysqli_error($con));
        }

        mysqli_stmt_bind_param($consulta2,"ii",$id_insercion,$id);
        if (!mysqli_stmt_execute($consulta2)) {
            throw new Exception("Error al ejecutar insert2: " . mysqli_stmt_error($consulta2));
        }

        mysqli_stmt_close($consulta);
        mysqli_stmt_close($consulta2);
        
        mysqli_commit($con);

        echo json_encode([
            "status" => "ok",
            "message" => "Estatus agregado correctamente"
        ]);

    } catch (Exception $e) {

        mysqli_rollback($con);

        echo json_encode([
            "status" => "error",
            "message" => "Ocurrió un error y se revertieron los cambios",
            "error" => $e->getMessage()
        ]);
    }

    exit;
} else if ($opt == 'getAll') {

    $id = intval($_POST['id']); // ← ID de ultima actualizacion 
    $ida = intval($_POST['ida']); // ← ID del alumno 

    // Consulta para obtener los datos reales del alumno
    $querySsA = mysqli_query($con,
        "SELECT id,estado, mensaje, nombre_usuario, fecha_manual
            FROM estatus_alumnos 
            WHERE id_alumno  = $ida 
            ORDER BY id DESC"
    );

    if ($querySsA && mysqli_num_rows($querySsA) > 0) {

        $estadosTexto = [   
            1 => "Bajas administrativa",
            2 => "Baja temporal",
            3 => "Baja definitiva",
            4 => "Baja académica",
            5 => "Activo",
            6 => "Egresados titulado",
            7 => "Egresados en vía de titulación"
        ];

        $registros = [];

        while ($row = mysqli_fetch_assoc($querySsA)) {

            $registros[] = [
                "id" => $row['id'] ?? "",
                "estado"  => $estadosTexto[$row['estado']] ?? "Desconocido",
                "mensaje" => $row['mensaje'] ?? "",
                "usuario" => $row['nombre_usuario'] ?? "",
                "fecha"   => $row['fecha_manual'] ?? ""
            ];
        }

        echo json_encode([
            "status" => "success",
            "data"   => $registros
        ]);
        exit;
    }
    else {
        echo json_encode([
            "status" => "error",
            "message" => "No se encontraron registros del alumno"
        ]);
        exit;
    }
}

?>
