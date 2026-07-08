<?php
// =============================================================================
// VISTA: credenciales_dashboard (versión moderna)
// =============================================================================
if (!Permisos::usuarioTieneModulo(Core::$user->kind, 'credenciales_dashboard')) {
    Core::redir("./");
    exit;
}

$totalEstudiantes  = CredencialData::getTotalEstudiantes();
$totalActivas      = CredencialData::getTotalCredencialesActivas();
$proximasVencer    = CredencialData::getProximasAVencer(30);
$vencidas          = CredencialData::getVencidas();
$renovacionesMes   = CredencialData::getRenovacionesDelMes();
$totalRevocadas    = CredencialData::getTotalRevocadas();
$cobertura         = CredencialData::getCoberturaPorCarrera();
$revocacionesRec   = CredencialData::getRevocacionesRecientes(8);

$pctCobertura = $totalEstudiantes > 0
    ? round(100 * $totalActivas / $totalEstudiantes, 1)
    : 0;

$sinCredencial = $totalEstudiantes - $totalActivas;
?>

<style>
/* === RESET ESCOPADO PARA ESTE DASHBOARD ============================== */
.crd-modern {
    --c-bg:        #f1f5f9;
    --c-card:      #ffffff;
    --c-text:      #0f172a;
    --c-muted:     #64748b;
    --c-border:    #e2e8f0;
    --c-blue:      #3b82f6;
    --c-blue-soft: #dbeafe;
    --c-green:     #10b981;
    --c-green-soft:#d1fae5;
    --c-amber:     #f59e0b;
    --c-amber-soft:#fef3c7;
    --c-rose:      #f43f5e;
    --c-rose-soft: #ffe4e6;
    --c-violet:    #8b5cf6;
    --c-violet-soft:#ede9fe;
    --c-slate:     #475569;
    --c-slate-soft:#e2e8f0;

    color: var(--c-text);
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", system-ui, sans-serif;
    -webkit-font-smoothing: antialiased;
}
.crd-modern * { box-sizing: border-box; }

/* === HEADER ========================================================== */
.crd-modern .crd-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 28px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--c-border);
}
.crd-modern .crd-header h1 {
    margin: 0 0 6px;
    font-size: 24px;
    font-weight: 700;
    letter-spacing: -0.02em;
    color: var(--c-text);
}
.crd-modern .crd-header p {
    margin: 0;
    color: var(--c-muted);
    font-size: 14px;
}
.crd-modern .crd-header-actions { display: flex; gap: 8px; flex-wrap: wrap; }
.crd-modern .crd-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    border: 1px solid transparent;
    cursor: pointer;
    transition: all .15s ease;
    color: inherit;
}
.crd-modern .crd-btn-ghost {
    background: var(--c-card);
    border-color: var(--c-border);
    color: var(--c-slate);
}
.crd-modern .crd-btn-ghost:hover {
    background: #f8fafc; border-color: #cbd5e1;
}
.crd-modern .crd-btn-primary {
    background: var(--c-text);
    color: #fff;
    border-color: var(--c-text);
}
.crd-modern .crd-btn-primary:hover { background: #1e293b; color:#fff; }
.crd-modern .crd-btn svg { width: 16px; height: 16px; }

/* === GRID DE STATS =================================================== */
.crd-modern .crd-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 14px;
    margin-bottom: 24px;
}
.crd-modern .stat-card {
    position: relative;
    background: var(--c-card);
    border: 1px solid var(--c-border);
    border-radius: 14px;
    padding: 18px 20px;
    transition: all .2s ease;
    cursor: default;
    display: flex;
    flex-direction: column;
    gap: 12px;
    overflow: hidden;
}
.crd-modern .stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(15, 23, 42, .08);
    border-color: #cbd5e1;
}
.crd-modern .stat-icon {
    width: 38px; height: 38px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 10px;
}
.crd-modern .stat-icon svg { width: 20px; height: 20px; }
.crd-modern .stat-label {
    font-size: 12px;
    color: var(--c-muted);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: .03em;
}
.crd-modern .stat-value {
    font-size: 32px;
    font-weight: 700;
    line-height: 1.1;
    letter-spacing: -0.02em;
    color: var(--c-text);
}
.crd-modern .stat-value .stat-pct {
    font-size: 14px;
    font-weight: 600;
    color: var(--c-muted);
    margin-left: 6px;
}
.crd-modern .stat-link {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    font-weight: 600;
    color: var(--c-muted);
    text-decoration: none;
    margin-top: auto;
}
.crd-modern .stat-link:hover { color: var(--c-text); }
.crd-modern .stat-link svg { width: 14px; height: 14px; transition: transform .15s ease; }
.crd-modern .stat-link:hover svg { transform: translateX(2px); }

.crd-modern .stat-icon.icon-blue   { background: var(--c-blue-soft);   color: var(--c-blue); }
.crd-modern .stat-icon.icon-green  { background: var(--c-green-soft);  color: var(--c-green); }
.crd-modern .stat-icon.icon-amber  { background: var(--c-amber-soft);  color: var(--c-amber); }
.crd-modern .stat-icon.icon-rose   { background: var(--c-rose-soft);   color: var(--c-rose); }
.crd-modern .stat-icon.icon-violet { background: var(--c-violet-soft); color: var(--c-violet); }
.crd-modern .stat-icon.icon-slate  { background: var(--c-slate-soft);  color: var(--c-slate); }

/* === FILA INFERIOR (chart + lista) =================================== */
.crd-modern .crd-grid-2 {
    display: grid;
    grid-template-columns: 1.4fr 1fr;
    gap: 14px;
    margin-bottom: 24px;
}
@media (max-width: 1100px) { .crd-modern .crd-grid-2 { grid-template-columns: 1fr; } }

.crd-modern .panel {
    background: var(--c-card);
    border: 1px solid var(--c-border);
    border-radius: 14px;
    padding: 22px;
    overflow: hidden;
}
.crd-modern .panel-head {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 18px;
}
.crd-modern .panel-head h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    letter-spacing: -.01em;
}
.crd-modern .panel-head .badge {
    background: var(--c-slate-soft);
    color: var(--c-slate);
    padding: 3px 9px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 600;
}

/* === Donut chart container ========================================== */
.crd-modern .donut-wrap {
    display: flex;
    gap: 24px;
    align-items: center;
    flex-wrap: wrap;
}
.crd-modern .donut-canvas {
    flex: 0 0 200px;
    width: 200px; height: 200px;
    position: relative;
}
.crd-modern .donut-center {
    position: absolute; inset: 0;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    pointer-events: none;
}
.crd-modern .donut-center .num {
    font-size: 28px; font-weight: 700;
    line-height: 1; letter-spacing: -.02em;
}
.crd-modern .donut-center .lbl {
    font-size: 11px; color: var(--c-muted);
    text-transform: uppercase; letter-spacing: .04em;
    margin-top: 4px;
}
.crd-modern .donut-legend { flex: 1 1 200px; }
.crd-modern .legend-item {
    display: flex; align-items: center; gap: 10px;
    padding: 7px 0;
    border-bottom: 1px dashed var(--c-border);
    font-size: 14px;
}
.crd-modern .legend-item:last-child { border-bottom: 0; }
.crd-modern .legend-dot {
    width: 10px; height: 10px; border-radius: 3px;
    flex: 0 0 10px;
}
.crd-modern .legend-name { flex: 1; }
.crd-modern .legend-num  { font-weight: 700; color: var(--c-text); }

/* === Tabla de cobertura (modo lista limpia) ========================== */
.crd-modern .cov-row {
    display: flex; align-items: center; gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid var(--c-border);
}
.crd-modern .cov-row:last-child { border-bottom: 0; }
.crd-modern .cov-name {
    flex: 1 1 auto; min-width: 0;
    font-size: 14px;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}
.crd-modern .cov-stat {
    flex: 0 0 auto;
    font-size: 12px; color: var(--c-muted);
    font-variant-numeric: tabular-nums;
}
.crd-modern .cov-bar {
    flex: 0 0 120px;
    height: 6px;
    background: var(--c-slate-soft);
    border-radius: 999px;
    overflow: hidden;
    position: relative;
}
.crd-modern .cov-bar-fill {
    height: 100%; border-radius: 999px;
    transition: width .8s ease;
}
.crd-modern .cov-pct {
    flex: 0 0 48px;
    text-align: right;
    font-size: 13px; font-weight: 700;
    font-variant-numeric: tabular-nums;
    color: var(--c-text);
}

/* === Lista de revocaciones recientes ================================= */
.crd-modern .rev-item {
    display: flex; gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid var(--c-border);
    text-decoration: none; color: inherit;
}
.crd-modern .rev-item:last-child { border-bottom: 0; }
.crd-modern .rev-item:hover { background: #f8fafc; margin: 0 -10px; padding-left: 10px; padding-right: 10px; border-radius: 8px;}
.crd-modern .rev-avatar {
    width: 36px; height: 36px;
    border-radius: 999px;
    background: var(--c-rose-soft); color: var(--c-rose);
    display: flex; align-items: center; justify-content: center;
    flex: 0 0 36px;
    font-size: 13px; font-weight: 700;
}
.crd-modern .rev-info { flex: 1; min-width: 0; }
.crd-modern .rev-name {
    font-size: 14px; font-weight: 600;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}
.crd-modern .rev-meta {
    font-size: 12px; color: var(--c-muted); margin-top: 2px;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}
.crd-modern .rev-date {
    font-size: 11px; color: var(--c-muted);
    flex: 0 0 auto;
    align-self: flex-start;
}

.crd-modern .empty {
    text-align: center; color: var(--c-muted);
    font-size: 13px; padding: 40px 20px;
}
.crd-modern .empty svg { width: 36px; height: 36px; opacity: .5; margin-bottom: 8px; }
</style>

<div class="crd-modern">

    <!-- ============== HEADER ============== -->
    <div class="crd-header">
        <div>
            <h1>Dashboard de Credenciales</h1>
            <p>Estado en tiempo real de las credenciales digitales del IEM · <?php echo date('d/m/Y H:i'); ?></p>
        </div>
        <div class="crd-header-actions">
            <a href="./?view=home" class="crd-btn crd-btn-ghost">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Regresar
            </a>
            <a href="./?view=credenciales_lista" class="crd-btn crd-btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="8" y1="6" x2="21" y2="6"/>
                    <line x1="8" y1="12" x2="21" y2="12"/>
                    <line x1="8" y1="18" x2="21" y2="18"/>
                    <line x1="3" y1="6" x2="3.01" y2="6"/>
                    <line x1="3" y1="12" x2="3.01" y2="12"/>
                    <line x1="3" y1="18" x2="3.01" y2="18"/>
                </svg>
                Ver listado completo
            </a>
        </div>
    </div>

    <!-- ============== STATS ============== -->
    <div class="crd-stats">

        <div class="stat-card">
            <div class="stat-icon icon-blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                </svg>
            </div>
            <div>
                <div class="stat-label">Estudiantes activos</div>
                <div class="stat-value"><?php echo number_format($totalEstudiantes); ?></div>
            </div>
            <a class="stat-link" href="./?view=credenciales_lista">
                Ver listado
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-green">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="16" rx="2"/>
                    <circle cx="9" cy="10" r="2"/>
                    <path d="M15 8h2M15 12h2M7 16h10"/>
                </svg>
            </div>
            <div>
                <div class="stat-label">Credenciales emitidas</div>
                <div class="stat-value"><?php echo number_format($totalActivas); ?><span class="stat-pct"><?php echo $pctCobertura; ?>%</span></div>
            </div>
            <a class="stat-link" href="./?view=credenciales_lista&status=vigente">
                Ver vigentes
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-amber">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div>
                <div class="stat-label">Vencen en 30 días</div>
                <div class="stat-value"><?php echo number_format($proximasVencer); ?></div>
            </div>
            <a class="stat-link" href="./?view=credenciales_lista">
                Ver próximas
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-rose">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
            </div>
            <div>
                <div class="stat-label">Vencidas</div>
                <div class="stat-value"><?php echo number_format($vencidas); ?></div>
            </div>
            <a class="stat-link" href="./?view=credenciales_lista&status=vencida">
                Ver vencidas
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-violet">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 4 23 10 17 10"/>
                    <polyline points="1 20 1 14 7 14"/>
                    <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
                </svg>
            </div>
            <div>
                <div class="stat-label">Renovaciones este mes</div>
                <div class="stat-value"><?php echo number_format($renovacionesMes); ?></div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-slate">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                </svg>
            </div>
            <div>
                <div class="stat-label">Revocadas (histórico)</div>
                <div class="stat-value"><?php echo number_format($totalRevocadas); ?></div>
            </div>
            <a class="stat-link" href="./?view=credenciales_lista&status=revocada">
                Ver lista
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>

    </div>

    <!-- ============== DONUT + COBERTURA ============== -->
    <div class="crd-grid-2">

        <!-- Cobertura por carrera (lista limpia con barras) -->
        <div class="panel">
            <div class="panel-head">
                <h3>Cobertura por carrera</h3>
                <span class="badge"><?php echo count($cobertura); ?> programas</span>
            </div>

            <?php if (count($cobertura) === 0): ?>
                <div class="empty">No hay datos disponibles.</div>
            <?php else:
                // Tomar solo top 8 con más alumnos para no saturar
                $topCobertura = array_slice($cobertura, 0, 10);
                foreach ($topCobertura as $c):
                    $pct = floatval($c->porcentaje ?? 0);
                    $color = $pct >= 80 ? 'var(--c-green)'
                           : ($pct >= 50 ? 'var(--c-amber)' : 'var(--c-rose)');
            ?>
                <div class="cov-row">
                    <div class="cov-name" title="<?php echo htmlspecialchars($c->carrera); ?>"><?php echo htmlspecialchars($c->carrera); ?></div>
                    <div class="cov-stat"><?php echo intval($c->con_credencial); ?>/<?php echo intval($c->total_alumnos); ?></div>
                    <div class="cov-bar">
                        <div class="cov-bar-fill" style="width: <?php echo $pct; ?>%; background: <?php echo $color; ?>;"></div>
                    </div>
                    <div class="cov-pct"><?php echo $pct; ?>%</div>
                </div>
            <?php endforeach; endif; ?>
        </div>

        <!-- Donut chart de adopción global -->
        <div class="panel">
            <div class="panel-head">
                <h3>Adopción global</h3>
                <span class="badge">Tiempo real</span>
            </div>
            <div class="donut-wrap">
                <div class="donut-canvas">
                    <canvas id="donutAdopcion" width="200" height="200"></canvas>
                    <div class="donut-center">
                        <div class="num"><?php echo $pctCobertura; ?>%</div>
                        <div class="lbl">Cobertura</div>
                    </div>
                </div>
                <div class="donut-legend">
                    <div class="legend-item">
                        <div class="legend-dot" style="background: var(--c-green);"></div>
                        <div class="legend-name">Con credencial</div>
                        <div class="legend-num"><?php echo number_format($totalActivas); ?></div>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: var(--c-slate-soft); border: 1px solid var(--c-border);"></div>
                        <div class="legend-name">Sin emitir</div>
                        <div class="legend-num"><?php echo number_format($sinCredencial); ?></div>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: var(--c-rose);"></div>
                        <div class="legend-name">Revocadas</div>
                        <div class="legend-num"><?php echo number_format($totalRevocadas); ?></div>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: var(--c-amber);"></div>
                        <div class="legend-name">Por vencer (30d)</div>
                        <div class="legend-num"><?php echo number_format($proximasVencer); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============== REVOCACIONES RECIENTES ============== -->
    <div class="panel">
        <div class="panel-head">
            <h3>Revocaciones recientes</h3>
            <span class="badge"><?php echo count($revocacionesRec); ?></span>
        </div>

        <?php if (count($revocacionesRec) === 0): ?>
            <div class="empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
                <div>No hay revocaciones registradas.</div>
            </div>
        <?php else: ?>
            <?php foreach ($revocacionesRec as $r):
                $iniciales = strtoupper(substr(($r->name ?? 'X'), 0, 1) . substr(($r->lastname ?? 'X'), 0, 1));
            ?>
                <a class="rev-item" href="./?view=credencial_detalle&id=<?php echo intval($r->alumno_id); ?>">
                    <div class="rev-avatar"><?php echo htmlspecialchars($iniciales); ?></div>
                    <div class="rev-info">
                        <div class="rev-name"><?php echo htmlspecialchars(trim(($r->name ?? '') . ' ' . ($r->lastname ?? ''))); ?></div>
                        <div class="rev-meta">
                            <?php echo htmlspecialchars($r->matricula ?? '—'); ?>
                            <?php if (!empty($r->motivo)): ?>
                                · <?php echo htmlspecialchars(mb_strimwidth($r->motivo, 0, 60, '…')); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="rev-date"><?php echo date('d/m/y', strtotime($r->fecha_registro)); ?></div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>

<!-- Chart.js para la dona — escopado a esta vista -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function(){
    function drawDonut(){
        var canvas = document.getElementById('donutAdopcion');
        if (!canvas || !window.Chart) return;
        var ctx = canvas.getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Con credencial', 'Sin emitir', 'Revocadas', 'Por vencer'],
                datasets: [{
                    data: [
                        <?php echo intval($totalActivas); ?>,
                        <?php echo max(0, intval($sinCredencial)); ?>,
                        <?php echo intval($totalRevocadas); ?>,
                        <?php echo intval($proximasVencer); ?>
                    ],
                    backgroundColor: ['#10b981','#e2e8f0','#f43f5e','#f59e0b'],
                    borderWidth: 0,
                    hoverOffset: 8,
                }]
            },
            options: {
                cutout: '72%',
                responsive: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 10,
                        cornerRadius: 8,
                        bodyFont: { size: 12 },
                    }
                },
                animation: { duration: 800 }
            }
        });
    }

    if (window.Chart) drawDonut();
    else window.addEventListener('load', drawDonut);
})();
</script>