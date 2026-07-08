<?php
// =============================================================================
// ACTION: revocarcredencial
// Acceso: index.php?action=revocarcredencial (POST)
// Permisos: requiere modulo 'credenciales_revocar'
// Body: alumno_id, motivo, redirect (opcional)
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

$alumno_id = isset($_POST['alumno_id']) ? intval($_POST['alumno_id']) : 0;
$motivo    = trim($_POST['motivo'] ?? '');
$redirect  = $_POST['redirect'] ?? 'credenciales_lista';

if ($alumno_id <= 0) {
    header('Location: ./?view=credenciales_lista&err=alumno_invalido');
    exit;
}

// Datos del usuario que ejecuta la acción (para snapshot en auditoría)
$usuario   = Core::$user;
$nomUsuario= trim(($usuario->name ?? '') . ' ' . ($usuario->lastname ?? ''));

$resultado = CredencialData::revocar($alumno_id, $motivo, intval($_SESSION["user_id"]), $nomUsuario);

if ($resultado === true) {
    $msg = 'revocada';
} elseif ($resultado === 'already_revoked') {
    $msg = 'ya_revocada';
} else {
    $msg = 'sin_credencial';
}

// Volver a donde se invocó (lista o detalle)
if ($redirect === 'credencial_detalle') {
    header("Location: ./?view=credencial_detalle&id=$alumno_id&msg=$msg");
} else {
    header("Location: ./?view=credenciales_lista&msg=$msg");
}
exit;
