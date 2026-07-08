<?php
// =============================================================================
// VISTA: credenciales_lista
// Acceso: index.php?view=credenciales_lista[&carrera_id=X][&status=Y][&q=...]
// Permisos: requiere modulo 'credenciales_lista'
// =============================================================================
if (!Permisos::usuarioTieneModulo(Core::$user->kind, 'credenciales_lista')) {
    Core::redir("./");
    exit;
}

$filtros = [
    'carrera_id' => isset($_GET['carrera_id']) ? intval($_GET['carrera_id']) : 0,
    'status'     => $_GET['status'] ?? 'todos',
    'q'          => $_GET['q'] ?? '',
];

$lista     = CredencialData::getListadoEstudiantes($filtros);
$carreras  = CredencialData::getCarreras();
$puedeRevocar = Permisos::puede(Core::$user->kind, 'credenciales_revocar', 'eliminar')
             || Permisos::usuarioTieneModulo(Core::$user->kind, 'credenciales_revocar');

// Mensajes flash desde la URL
$flashMsg = $_GET['msg'] ?? '';
$flashErr = $_GET['err'] ?? '';
?>
<?php if ($flashMsg || $flashErr): ?>
<style>.flash-alert { margin-top:10px; }</style>
<div class="row flash-alert"><div class="col-md-12">
    <?php
    $mapMsg = [
        'revocada'        => ['success', '✓ Credencial revocada correctamente.'],
        'eliminado'       => ['success', '✓ Registro de credencial eliminado.'],
        'extendida_3'     => ['success', '✓ Vigencia extendida 3 meses.'],
        'extendida_6'     => ['success', '✓ Vigencia extendida 6 meses.'],
        'extendida_12'    => ['success', '✓ Vigencia extendida 1 año.'],
        'extendida_24'    => ['success', '✓ Vigencia extendida 2 años.'],
        'ya_revocada'     => ['warning', '⚠ Esta credencial ya estaba revocada.'],
        'sin_credencial'  => ['warning', '⚠ El alumno no tiene credencial vigente.'],
        'sin_registros'   => ['warning', '⚠ No hay registros de credencial para borrar.'],
    ];
    $mapErr = [
        'permiso_denegado'  => 'No tienes permisos para esta acción.',
        'falta_confirmacion'=> 'Necesitas confirmar escribiendo ELIMINAR.',
        'alumno_invalido'   => 'Alumno inválido.',
        'meses_invalidos'   => 'Cantidad de meses inválida.',
        'error_eliminar'    => 'No pudimos eliminar el registro.',
        'error_extender'    => 'No pudimos extender la vigencia.',
    ];
    if ($flashMsg && isset($mapMsg[$flashMsg])): ?>
        <div class="alert alert-<?php echo $mapMsg[$flashMsg][0]; ?>"><?php echo $mapMsg[$flashMsg][1]; ?></div>
    <?php endif; ?>
    <?php if ($flashErr && isset($mapErr[$flashErr])): ?>
        <div class="alert alert-danger">⚠ <?php echo $mapErr[$flashErr]; ?></div>
    <?php endif; ?>
</div></div>
<?php endif; ?>

<style>
    .badge-estado {
        display: inline-block; padding: 4px 9px; border-radius: 999px;
        font-size: 11px; font-weight: 600; text-transform: uppercase;
        letter-spacing: .5px; white-space: nowrap;
    }
    .badge-vigente   { background: #dcedc8; color: #1b5e20; }
    .badge-vencida   { background: #fdd; color: #b71c1c; }
    .badge-revocada  { background: #555; color: #fff; }
    .badge-sin-emitir{ background: #f0f0f0; color: #555; }
    .filtros-row .form-group { margin-bottom: 0; }
    .tbl-credenciales tbody tr td { vertical-align: middle; }
</style>

<div class="row">
    <div class="col-md-12">
        <h3><i class="fa fa-list"></i> <strong>Listado de Estudiantes — Credenciales</strong></h3>
        <h5>Estado de credencial digital de todos los estudiantes activos del IEM.</h5>
        <a href="./?view=credenciales_dashboard" class="btn btn-default">
            <i class="fa fa-arrow-left"></i> Regresar al Dashboard
        </a>
        <button id="btnExportExcel" class="btn btn-success">
            <i class="fa fa-file-excel-o"></i> Exportar a Excel
        </button>
        <br><br>
    </div>
</div>

<!-- ============== FILTROS ============== -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-filter"></i> Filtros</h3>
    </div>
    <div class="box-body filtros-row">
        <form method="get" action="./" class="form-inline">
            <input type="hidden" name="view" value="credenciales_lista">

            <div class="form-group" style="margin-right:12px;">
                <label>Buscar:&nbsp;</label>
                <input type="text" name="q" class="form-control" placeholder="Matrícula, nombre, CURP..."
                       value="<?php echo htmlspecialchars($filtros['q']); ?>">
            </div>

            <div class="form-group" style="margin-right:12px;">
                <label>Carrera:&nbsp;</label>
                <select name="carrera_id" class="form-control selectpicker" data-live-search="true">
                    <option value="0">Todas las carreras</option>
                    <?php foreach ($carreras as $c): ?>
                        <option value="<?php echo $c->id; ?>"
                            <?php if ($filtros['carrera_id'] === intval($c->id)) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($c->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group" style="margin-right:12px;">
                <label>Estado:&nbsp;</label>
                <select name="status" class="form-control">
                    <option value="todos"     <?php if ($filtros['status']==='todos')     echo 'selected'; ?>>Todos</option>
                    <option value="vigente"   <?php if ($filtros['status']==='vigente')   echo 'selected'; ?>>Vigente</option>
                    <option value="sin_emitir"<?php if ($filtros['status']==='sin_emitir')echo 'selected'; ?>>Sin emitir</option>
                    <option value="vencida"   <?php if ($filtros['status']==='vencida')   echo 'selected'; ?>>Vencida</option>
                    <option value="revocada"  <?php if ($filtros['status']==='revocada')  echo 'selected'; ?>>Revocada</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Filtrar</button>
            <a href="./?view=credenciales_lista" class="btn btn-default"><i class="fa fa-eraser"></i> Limpiar</a>
        </form>
    </div>
</div>

<!-- ============== TABLA ============== -->
<div class="box box-default">
    <div class="box-body">
        <p>
            <strong><?php echo count($lista); ?></strong> estudiante(s) encontrado(s).
        </p>

        <table id="tablaCredenciales" class="table table-bordered table-hover tbl-credenciales">
            <thead class="bg-primary">
                <tr>
                    <th>Matrícula</th>
                    <th>Nombre</th>
                    <th>Carrera</th>
                    <th>Estado credencial</th>
                    <th>Vigencia</th>
                    <th>Renovaciones</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php if (count($lista) === 0): ?>
                <tr><td colspan="7" class="text-center text-muted">
                    No hay estudiantes con esos filtros.
                </td></tr>
            <?php endif; ?>

            <?php foreach ($lista as $a):
                $estado = $a->estado_credencial;
                $badgeClass = [
                    'vigente'    => 'badge-vigente',
                    'vencida'    => 'badge-vencida',
                    'revocada'   => 'badge-revocada',
                    'sin_emitir' => 'badge-sin-emitir',
                ][$estado] ?? 'badge-sin-emitir';
                $estadoTxt = [
                    'vigente'    => 'Vigente',
                    'vencida'    => 'Vencida',
                    'revocada'   => 'Revocada',
                    'sin_emitir' => 'Sin emitir',
                ][$estado] ?? 'Sin emitir';
            ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($a->matricula); ?></strong></td>
                    <td><?php echo htmlspecialchars(trim($a->nombre . ' ' . $a->apellido)); ?></td>
                    <td><small><?php echo htmlspecialchars($a->carrera ?: '—'); ?></small></td>
                    <td>
                        <span class="badge-estado <?php echo $badgeClass; ?>"><?php echo $estadoTxt; ?></span>
                    </td>
                    <td>
                        <?php if ($a->fecha_vencimiento): ?>
                            <?php echo date('d/m/Y', strtotime($a->fecha_vencimiento)); ?>
                        <?php else: ?>
                            <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center"><?php echo intval($a->num_renovacion); ?></td>
                    <td class="text-center" style="white-space:nowrap;">
                        <a href="./?view=credencial_detalle&id=<?php echo intval($a->alumno_id); ?>"
                           class="btn btn-xs btn-info" title="Ver detalle">
                            <i class="fa fa-eye"></i>
                        </a>

                        <?php if ($puedeRevocar && in_array($estado, ['vigente', 'vencida'])): ?>
                            <button type="button" class="btn btn-xs btn-warning btn-extender"
                                    data-id="<?php echo intval($a->alumno_id); ?>"
                                    data-nombre="<?php echo htmlspecialchars(trim($a->nombre . ' ' . $a->apellido)); ?>"
                                    data-vencimiento="<?php echo $a->fecha_vencimiento ? date('d/m/Y', strtotime($a->fecha_vencimiento)) : '—'; ?>"
                                    title="Extender vigencia">
                                <i class="fa fa-clock-o"></i>
                            </button>
                        <?php endif; ?>

                        <?php if ($puedeRevocar && $estado === 'vigente'): ?>
                            <button type="button" class="btn btn-xs btn-danger btn-revocar"
                                    data-id="<?php echo intval($a->alumno_id); ?>"
                                    data-nombre="<?php echo htmlspecialchars(trim($a->nombre . ' ' . $a->apellido)); ?>"
                                    title="Revocar credencial">
                                <i class="fa fa-ban"></i>
                            </button>
                        <?php endif; ?>

                        <?php if ($puedeRevocar && $estado !== 'sin_emitir'): ?>
                            <button type="button" class="btn btn-xs btn-default btn-eliminar"
                                    data-id="<?php echo intval($a->alumno_id); ?>"
                                    data-nombre="<?php echo htmlspecialchars(trim($a->nombre . ' ' . $a->apellido)); ?>"
                                    data-matricula="<?php echo htmlspecialchars($a->matricula); ?>"
                                    title="Eliminar registro de credencial"
                                    style="color:#7a0000;">
                                <i class="fa fa-trash"></i>
                            </button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
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
        <p>Estás a punto de <strong>revocar la credencial vigente</strong> de:</p>
        <p><strong id="modalRevocarNombre"></strong></p>
        <p>El estudiante no podrá usar su credencial actual. La verificación pública del QR mostrará "Credencial revocada".</p>
        <hr>
        <input type="hidden" name="alumno_id" id="modalRevocarId">
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
        <p><strong id="modalExtenderNombre"></strong></p>
        <p>Vencimiento actual: <strong id="modalExtenderVenc"></strong></p>
        <hr>
        <input type="hidden" name="alumno_id" id="modalExtenderId">

        <div class="form-group">
            <label>¿Cuánto tiempo extender?</label>
            <div class="btn-group btn-group-justified" data-toggle="buttons" role="group">
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
                Si la credencial está vigente, se suma a partir del vencimiento actual.
                Si está vencida, se suma a partir de hoy.
            </small>
        </div>

        <div class="form-group">
            <label>Motivo (opcional)</label>
            <textarea name="motivo" class="form-control" rows="2"
                      placeholder="Ej. Solicitud de Servicios Escolares, extensión administrativa..."></textarea>
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
            <strong>Esta acción es permanente</strong> y borra del sistema toda la
            historia de credenciales del alumno: vigencias, renovaciones y revocaciones.
            Solo úsala si el registro está corrupto o se creó por error.
        </div>
        <p>Vas a eliminar TODOS los registros de credencial de:</p>
        <p>
            <strong id="modalEliminarNombre"></strong><br>
            Matrícula: <code id="modalEliminarMatricula"></code>
        </p>
        <p class="muted">El alumno podrá volver a generar credencial al entrar al sistema /credencial/.</p>
        <hr>
        <input type="hidden" name="alumno_id" id="modalEliminarId">

        <div class="form-group">
            <label>Motivo (recomendado)</label>
            <textarea name="motivo" class="form-control" rows="2"
                      placeholder="Ej. Datos corruptos, registro duplicado, cambio de matrícula..."></textarea>
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

<script>
$(function () {
    // Datatable básico (si está disponible)
    if ($.fn.DataTable) {
        $('#tablaCredenciales').DataTable({
            language: { url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json" },
            pageLength: 25,
            order: [[0, 'asc']]
        });
    }

    $('.btn-revocar').on('click', function () {
        $('#modalRevocarId').val($(this).data('id'));
        $('#modalRevocarNombre').text($(this).data('nombre'));
        $('#modalRevocar').modal('show');
    });

    $('.btn-extender').on('click', function () {
        $('#modalExtenderId').val($(this).data('id'));
        $('#modalExtenderNombre').text($(this).data('nombre'));
        $('#modalExtenderVenc').text($(this).data('vencimiento'));
        $('#modalExtender').modal('show');
    });

    $('.btn-eliminar').on('click', function () {
        $('#modalEliminarId').val($(this).data('id'));
        $('#modalEliminarNombre').text($(this).data('nombre'));
        $('#modalEliminarMatricula').text($(this).data('matricula'));
        $('#modalEliminar').modal('show');
    });

    $('#btnExportExcel').on('click', function () {
        // Construir CSV simple desde la tabla actual
        let csv = [];
        const rows = document.querySelectorAll('#tablaCredenciales tr');
        rows.forEach(row => {
            const cols = row.querySelectorAll('th, td');
            const line = Array.from(cols).slice(0, -1)
                .map(c => '"' + (c.innerText || '').replace(/"/g, '""').trim() + '"')
                .join(',');
            csv.push(line);
        });
        const blob = new Blob(["﻿" + csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
        const a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = 'credenciales_' + (new Date().toISOString().slice(0,10)) + '.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    });
});
</script>