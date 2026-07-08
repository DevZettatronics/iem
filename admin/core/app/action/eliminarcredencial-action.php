<?php
// =============================================================================
// ACTION: eliminarcredencial
// Acceso: index.php?action=eliminarcredencial (POST)
// Permisos: requiere modulo 'credenciales_revocar'
// Body: alumno_id, motivo, confirmacion="ELIMINAR", redirect (opcional)
// =============================================================================

if (empty($_SESSION["user_id"])) {
    header('Location: ./');
    exit;
}

if (!Permisos::usuarioTieneModulo(Core::$user->kind, 'credenciales_revocar')) {
    header('Location: ./?view=credenciales_lista&err=permiso_denegado');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ./?view=credenciales_lista');
    exit;
}

$alumno_id    = isset($_POST['alumno_id']) ? intval($_POST['alumno_id']) : 0;
$motivo       = trim($_POST['motivo'] ?? '');
$confirmacion = trim($_POST['confirmacion'] ?? '');
$redirect     = $_POST['redirect'] ?? 'credenciales_lista';

// Doble check: el usuario tiene que escribir literalmente "ELIMINAR"
if (strtoupper($confirmacion) !== 'ELIMINAR') {
    header("Location: ./?view=credenciales_lista&err=falta_confirmacion");
    exit;
}

if ($alumno_id <= 0) {
    header('Location: ./?view=credenciales_lista&err=alumno_invalido');
    exit;
}

$usuario    = Core::$user;
$nomUsuario = trim(($usuario->name ?? '') . ' ' . ($usuario->lastname ?? ''));

$resultado = CredencialData::eliminarRegistro(
    $alumno_id,
    $motivo,
    intval($_SESSION["user_id"]),
    $nomUsuario
);

if (is_array($resultado)) {
    $msg = 'eliminado';
} elseif ($resultado === 'sin_registros') {
    $msg = 'sin_registros';
} else {
    $msg = 'error_eliminar';
}

if ($redirect === 'credencial_detalle') {
    header("Location: ./?view=credencial_detalle&id=$alumno_id&msg=$msg");
} else {
    header("Location: ./?view=credenciales_lista&msg=$msg");
}
exit;
