<?php
// =============================================================================
// ACTION: extendervigencia
// Acceso: index.php?action=extendervigencia (POST)
// Permisos: requiere modulo 'credenciales_revocar'
// Body: alumno_id, meses (3|6|12|24), motivo, redirect (opcional)
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
$meses     = isset($_POST['meses']) ? intval($_POST['meses']) : 12;
$motivo    = trim($_POST['motivo'] ?? '');
$redirect  = $_POST['redirect'] ?? 'credenciales_lista';

if ($alumno_id <= 0) {
    header('Location: ./?view=credenciales_lista&err=alumno_invalido');
    exit;
}

// Validar meses permitidos (3, 6, 12, 24)
if (!in_array($meses, [3, 6, 12, 24], true)) {
    $meses = 12;
}

$usuario    = Core::$user;
$nomUsuario = trim(($usuario->name ?? '') . ' ' . ($usuario->lastname ?? ''));

$resultado = CredencialData::extenderVigencia(
    $alumno_id,
    $meses,
    intval($_SESSION["user_id"]),
    $nomUsuario,
    $motivo
);

if (is_array($resultado)) {
    $msg = 'extendida_' . $meses;
} elseif ($resultado === 'meses_invalidos') {
    $msg = 'meses_invalidos';
} else {
    $msg = 'error_extender';
}

if ($redirect === 'credencial_detalle') {
    header("Location: ./?view=credencial_detalle&id=$alumno_id&msg=$msg");
} else {
    header("Location: ./?view=credenciales_lista&msg=$msg");
}
exit;
