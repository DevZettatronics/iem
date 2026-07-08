<?php
if (isset($_POST['rol_id'])) {
    $rol_id = $_POST['rol_id'];
    $rol_nombre = $_POST['rol_nombre'];

    // Array de permisos que vienen del formulario (solo los marcados)
    $permisos_form = isset($_POST['permisos']) ? $_POST['permisos'] : [];

    // Obtenemos todos los permisos asignados al rol desde la BD
    $permisos_rol = Permisos::allpermisos($rol_id);

    if (empty($permisos_rol)) {
        Core::alert("No se encontraron permisos para este rol.");
        Core::redir("./?view=editpermisos&id=" . $rol_id . "&name=" . $rol_nombre);
        exit;
    }

    foreach ($permisos_rol as $permiso) {
        $id_permiso = $permiso->id_permiso;

        if (isset($permisos_form[$id_permiso])) {
            $acciones = $permisos_form[$id_permiso];
            $puede_ver = isset($acciones['puede_ver']) ? 1 : 0;
            $puede_crear = isset($acciones['puede_crear']) ? 1 : 0;
            $puede_editar = isset($acciones['puede_editar']) ? 1 : 0;
            $puede_eliminar = isset($acciones['puede_eliminar']) ? 1 : 0;
        } else {
            // No llegó nada para ese permiso, todos en 0 (desmarcado)
            $puede_ver = 0;
            $puede_crear = 0;
            $puede_editar = 0;
            $puede_eliminar = 0;
        }

        Permisos::updateOrInsertPermiso($rol_id, $id_permiso, $puede_ver, $puede_crear, $puede_editar, $puede_eliminar);
    }

    Core::alert("Permisos actualizados correctamente.");
    Core::redir("./?view=editpermisos&id=" . $rol_id . "&name=" . $rol_nombre);
} else {
    Core::alert("No se recibió ningún permiso.");
    Core::redir("./?view=editpermisos&id=" . $rol_id . "&name=" . $rol_nombre);
}
?>
