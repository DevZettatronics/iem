<?php
// =============================================================================
// VISTA: credencial_detalle
// Acceso: index.php?view=credencial_detalle&id=ALUMNO_ID
// Permisos: requiere modulo 'credenciales_lista' (mismo nivel que ver listado)
// =============================================================================
if (!Permisos::usuarioTieneModulo(Core::$user->kind, 'credenciales_lista')) {
    Core::redir("./");
    exit;
}

$alumno_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($alumno_id <= 0) Core::redir('./?view=credenciales_lista');

$d         = CredencialData::getDetalleAlumno($alumno_id);
if (!$d) Core::redir('./?view=credenciales_lista');

$vigencia  = CredencialData::getVigenciaActivaByAlumno($alumno_id);
$historial = CredencialData::getHistorialByAlumno($alumno_id);

$puedeRevocar = Permisos::usuarioTieneModulo(Core::$user->kind, 'credenciales_revocar');

// Construir nombre completo
$nombre = trim(($d->name ?? '') . ' ' . ($d->lastname ?? ''));

// Foto: la lógica del sistema /credencial/ guarda como /credencial/uploads/fotos/{matricula}.jpg
$rutaFotoPublica = '/credencial/uploads/fotos/' . preg_replace('/[^A-Z0-9]/i', '', $d->code) . '.jpg';
$rutaFotoCheck   = $_SERVER['DOCUMENT_ROOT'] . $rutaFotoPublica;
$tieneFoto       = is_file($rutaFotoCheck);

// Estado actual de la credencial
$revocacionActual = $vigencia ? CredencialData::getRevocacionByVigencia($vigencia->id) : null;
if (!$vigencia) {
    $estadoTxt   = 'Sin emitir';
    $estadoClass = 'badge-sin-emitir';
} elseif ($revocacionActual) {
    $estadoTxt   = 'Revocada';
    $estadoClass = 'badge-revocada';
} elseif (strtotime($vigencia->fecha_vencimiento) < strtotime(date('Y-m-d'))) {
    $estadoTxt   = 'Vencida';
    $estadoClass = 'badge-vencida';
} else {
    $estadoTxt   = 'Vigente';
    $estadoClass = 'badge-vigente';
}
?>

<style>
    .badge-estado {
        display: inline-block; padding: 6px 14px; border-radius: 999px;
        font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px;
    }
    .badge-vigente   { background: #dcedc8; color: #1b5e20; }
    .badge-vencida   { background: #fdd; color: #b71c1c; }
    .badge-revocada  { background: #555; color: #fff; }
    .badge-sin-emitir{ background: #f0f0f0; color: #555; }
    .foto-detalle    { width: 160px; height: 200px; object-fit: cover;
                       border-radius: 8px; border: 3px solid #d4a437; }
    .info-row        { padding: 8px 0; border-bottom: 1px dashed #eee; }
    .info-row strong { color: #0b2545; }
</style>

<div class="row">
    <div class="col-md-12">
        <h3><i class="fa fa-id-card"></i> <strong>Detalle de Credencial</strong></h3>
        <a href="./?view=credenciales_lista" class="btn btn-default">
            <i class="fa fa-arrow-left"></i> Regresar al Listado
        </a>
        <a href="./?view=editalumn&id=<?php echo $alumno_id; ?>" class="btn btn-info">
            <i class="fa fa-user"></i> Ver expediente del estudiante
        </a>
        <br><br>
    </div>
</div>

<div class="row">
    <!-- ============== Foto + datos ============== -->
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-user"></i> Estudiante</h3>
            </div>
            <div class="box-body text-center">
                <?php if ($tieneFoto): ?>
                    <img src="<?php echo $rutaFotoPublica; ?>?v=<?php echo @filemtime($rutaFotoCheck); ?>"
                         class="foto-detalle" alt="Foto">
                <?php else: ?>
                    <div class="foto-detalle"
                         style="display:flex;align-items:center;justify-content:center;
                                background:#e9ecf3;color:#888;font-size:12px;">
                        Sin foto
                    </div>
                <?php endif; ?>

                <h4 style="margin-top:14px"><?php echo htmlspecialchars($nombre); ?></h4>
                <p>
                    <span class="badge-estado <?php echo $estadoClass; ?>"><?php echo $estadoTxt; ?></span>
                </p>

                <div style="text-align:left; margin-top: 16px;">
                    <div class="info-row">
                        <strong>Matrícula:</strong> <?php echo htmlspecialchars($d->code); ?>
                    </div>
                    <div class="info-row">
                        <strong>CURP:</strong> <?php echo htmlspecialchars($d->curp ?: '—'); ?>
                    </div>
                    <div class="info-row">
                        <strong>Fecha de nac.:</strong>
                        <?php echo $d->f_nacimiento && $d->f_nacimiento !== '0000-00-00'
                                ? date('d/m/Y', strtotime($d->f_nacimiento)) : '—'; ?>
                    </div>
                    <div class="info-row">
                        <strong>Email:</strong> <small><?php echo htmlspecialchars($d->email ?: '—'); ?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============== Credencial actual + acciones ============== -->
    <div class="col-md-8">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-id-card-o"></i> Credencial vigente</h3>
            </div>
            <div class="box-body">

                <?php if (!$vigencia): ?>
                    <div class="alert alert-info">
                        Este estudiante <strong>todavía no emite</strong> su credencial digital.
                        Cuando ingrese al sistema en
                        <code>aula.iemueem.edu.mx/credencial/</code> se generará automáticamente.
                    </div>
                <?php else: ?>
                    <div class="row">
                        <div class="col-md-6 info-row">
                            <strong>Programa:</strong><br>
                            <?php echo htmlspecialchars($d->carrera ?: '—'); ?>
                            <?php if ($d->grado): ?> <small>(<?php echo htmlspecialchars($d->grado); ?>)</small><?php endif; ?>
                        </div>
                        <div class="col-md-6 info-row">
                            <strong>Modalidad:</strong> <?php echo htmlspecialchars($d->modalidad ?: '—'); ?>
                        </div>
                        <div class="col-md-6 info-row">
                            <strong>Ciclo:</strong> <?php echo htmlspecialchars($d->ciclo ?: '—'); ?>
                        </div>
                        <div class="col-md-6 info-row">
                            <strong>Semestre:</strong> <?php echo htmlspecialchars($d->semestre ?: '—'); ?>
                        </div>
                        <div class="col-md-6 info-row">
                            <strong>Emitida:</strong>
                            <?php echo date('d/m/Y', strtotime($vigencia->fecha_emision)); ?>
                        </div>
                        <div class="col-md-6 info-row">
                            <strong>Vence:</strong>
                            <?php echo date('d/m/Y', strtotime($vigencia->fecha_vencimiento)); ?>
                        </div>
                        <div class="col-md-6 info-row">
                            <strong>Renovaciones:</strong> <?php echo intval($vigencia->num_renovacion); ?>
                        </div>
                        <div class="col-md-6 info-row">
                            <strong>ID de vigencia:</strong> <?php echo intval($vigencia->id); ?>
                        </div>
                    </div>

                    <?php if ($revocacionActual): ?>
                        <hr>
                        <div class="alert alert-danger">
                            <h4><i class="fa fa-ban"></i> Credencial revocada</h4>
                            <p><strong>Fecha:</strong>
                                <?php echo date('d/m/Y H:i', strtotime($revocacionActual->fecha_registro)); ?></p>
                            <p><strong>Motivo:</strong>
                                <?php echo htmlspecialchars($revocacionActual->motivo ?: '(no especificado)'); ?></p>
                            <p><strong>Por:</strong>
                                <?php echo htmlspecialchars($revocacionActual->nombre_usuario ?: 'Usuario ID '.$revocacionActual->usuario_id); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if ($puedeRevocar && in_array($estadoTxt, ['Vigente', 'Vencida']) && !$revocacionActual): ?>
                        <hr>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#modalExtender">
                            <i class="fa fa-clock-o"></i> Extender vigencia
                        </button>
                        <?php if ($estadoTxt === 'Vigente'): ?>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#modalRevocar">
                                <i class="fa fa-ban"></i> Revocar esta credencial
                            </button>
                        <?php endif; ?>
                        <button class="btn btn-default" style="color:#7a0000;border-color:#a44;"
                                data-toggle="modal" data-target="#modalEliminar">
                            <i class="fa fa-trash"></i> Eliminar registro
                        </button>
                    <?php elseif ($puedeRevocar && $vigencia): ?>
                        <hr>
                        <button class="btn btn-default" style="color:#7a0000;border-color:#a44;"
                                data-toggle="modal" data-target="#modalEliminar">
                            <i class="fa fa-trash"></i> Eliminar registro
                        </button>
                    <?php endif; ?>

                <?php endif; ?>

            </div>
        </div>

        <!-- ============== Historial completo ============== -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-history"></i> Historial completo
                    (<?php echo count($historial); ?>)
                </h3>
            </div>
            <div class="box-body">
                <?php if (count($historial) === 0): ?>
                    <p class="text-muted">No hay registros de credencial.</p>
                <?php else: ?>
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tipo</th>
                                <th>Emisión</th>
                                <th>Vencimiento</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($historial as $h):
                            $rev = CredencialData::getRevocacionByVigencia($h->id);
                            if ($rev) {
                                $stTxt = 'Revocada'; $stClass = 'badge-revocada';
                            } elseif ($h->activa == 0) {
                                $stTxt = 'Reemplazada'; $stClass = 'badge-sin-emitir';
                            } elseif (strtotime($h->fecha_vencimiento) < strtotime(date('Y-m-d'))) {
                                $stTxt = 'Vencida'; $stClass = 'badge-vencida';
                            } else {
                                $stTxt = 'Vigente'; $stClass = 'badge-vigente';
                            }
                            $tipo = $h->num_renovacion == 0 ? 'Original' : 'Renovación #'.$h->num_renovacion;
                        ?>
                            <tr>
                                <td><?php echo $h->id; ?></td>
                                <td><?php echo $tipo; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($h->fecha_emision)); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($h->fecha_vencimiento)); ?></td>
                                <td><span class="badge-estado <?php echo $stClass; ?>" style="font-size:11px;padding:3px 8px;"><?php echo $stTxt; ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- ============== Modal de revocación ============== -->
<div class="modal fade" id="modalRevocar" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="index.php?action=revocarcredencial">
      <div class="modal-header" style="background:#c0392b; color:#fff;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-ban"></i> Revocar credencial</h4>
      </div>
      <div class="modal-body">
        <p>Estás a punto de revocar la credencial vigente de:</p>
        <p><strong><?php echo htmlspecialchars($nombre); ?></strong> ·
           Matrícula <?php echo htmlspecialchars($d->code); ?></p>
        <p>El estudiante no podrá usar su credencial actual. La verificación
           pública del QR mostrará "Credencial revocada".</p>
        <hr>
        <input type="hidden" name="alumno_id" value="<?php echo $alumno_id; ?>">
        <input type="hidden" name="redirect"  value="credencial_detalle">
        <div class="form-group">
            <label>Motivo (opcional)</label>
            <textarea name="motivo" class="form-control" rows="3"
                      placeholder="Ej. Reporte de extravío, baja académica, etc."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-danger">
            <i class="fa fa-ban"></i> Confirmar revocación
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ============== Modal de extensión de vigencia ============== -->
<div class="modal fade" id="modalExtender" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="index.php?action=extendervigencia">
      <div class="modal-header" style="background:#f39c12; color:#fff;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-clock-o"></i> Extender vigencia</h4>
      </div>
      <div class="modal-body">
        <p>Vas a extender la vigencia de:</p>
        <p><strong><?php echo htmlspecialchars($nombre); ?></strong> ·
           Matrícula <?php echo htmlspecialchars($d->code); ?></p>
        <?php if ($vigencia): ?>
            <p>Vencimiento actual:
                <strong><?php echo date('d/m/Y', strtotime($vigencia->fecha_vencimiento)); ?></strong>
            </p>
        <?php endif; ?>
        <hr>
        <input type="hidden" name="alumno_id" value="<?php echo $alumno_id; ?>">
        <input type="hidden" name="redirect"  value="credencial_detalle">

        <div class="form-group">
            <label>¿Cuánto tiempo extender?</label>
            <div class="btn-group btn-group-justified" data-toggle="buttons">
                <label class="btn btn-default">
                    <input type="radio" name="meses" value="3"> 3 meses
                </label>
                <label class="btn btn-default">
                    <input type="radio" name="meses" value="6"> 6 meses
                </label>
                <label class="btn btn-default active">
                    <input type="radio" name="meses" value="12" checked> 1 año
                </label>
                <label class="btn btn-default">
                    <input type="radio" name="meses" value="24"> 2 años
                </label>
            </div>
            <small class="text-muted">
                Si la credencial está vigente, se suma desde el vencimiento actual.
                Si está vencida, se suma desde hoy.
            </small>
        </div>

        <div class="form-group">
            <label>Motivo (opcional)</label>
            <textarea name="motivo" class="form-control" rows="2"
                      placeholder="Ej. Solicitud de Servicios Escolares..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-warning">
            <i class="fa fa-clock-o"></i> Extender vigencia
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ============== Modal de eliminación de registro ============== -->
<div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="index.php?action=eliminarcredencial">
      <div class="modal-header" style="background:#7a0000; color:#fff;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-trash"></i> Eliminar registro de credencial</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-triangle"></i>
            <strong>Esta acción es permanente.</strong> Borra toda la historia de
            credenciales del alumno: vigencias, renovaciones y revocaciones.
            Solo úsala si el registro está corrupto o se creó por error.
        </div>
        <p>Vas a eliminar TODOS los registros de credencial de:</p>
        <p>
            <strong><?php echo htmlspecialchars($nombre); ?></strong><br>
            Matrícula: <code><?php echo htmlspecialchars($d->code); ?></code>
        </p>
        <p class="muted">El alumno podrá generar credencial nueva al entrar al
           sistema /credencial/ otra vez.</p>
        <hr>
        <input type="hidden" name="alumno_id" value="<?php echo $alumno_id; ?>">
        <input type="hidden" name="redirect"  value="credencial_detalle">

        <div class="form-group">
            <label>Motivo (recomendado)</label>
            <textarea name="motivo" class="form-control" rows="2"
                      placeholder="Ej. Datos corruptos, registro duplicado..."></textarea>
        </div>

        <div class="form-group">
            <label>Para confirmar, escribe <strong>ELIMINAR</strong> en mayúsculas:</label>
            <input type="text" name="confirmacion" class="form-control"
                   placeholder="ELIMINAR" autocomplete="off" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-danger">
            <i class="fa fa-trash"></i> Eliminar registro
        </button>
      </div>
    </form>
  </div>
</div>