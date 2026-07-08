<?php
/* ============================================================================
 * VISTA: home-view (version moderna)
 * Reemplaza /Servicios/iem/admin/core/app/view/home-view.php
 * Texto en HTML entities para evitar problemas de UTF-8 vs latin1
 * ============================================================================ */
require_once("./config/db.php");
require_once("./config/conexion.php");

// Forzar UTF-8 en la salida (defensa por capas)
if (!headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
}

$userName  = '';
$userRole  = '';
$kind      = Core::$user->kind ?? 0;
if (isset($_SESSION["user_id"])) {
    $u         = UserData::getById($_SESSION["user_id"]);
    $userName  = trim(($u->name ?? '') . ' ' . ($u->lastname ?? ''));
}

/* Saludo segun hora (con HTML entities) */
$hora = (int)date('H');
if      ($hora < 12) { $saludo = 'Buenos d&iacute;as'; }
elseif  ($hora < 19) { $saludo = 'Buenas tardes'; }
else                 { $saludo = 'Buenas noches'; }

/* Fecha en espanol con entities (sin depender de strftime/locale) */
$diasSemana  = ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'];
$mesesNombre = ['','enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
$fechaLarga  = $diasSemana[(int)date('w')] . ' ' . (int)date('d') . ' de ' . $mesesNombre[(int)date('n')] . ', ' . date('Y');

/* Helper local para crear cards solo si tiene permiso.
   NOTA: $titulo, $desc y $secondary se imprimen sin escape porque son strings
   estaticos definidos por nosotros (pueden contener HTML entities como
   &aacute;). NO usar con datos de usuario sin sanitizar. */
function home_card($mod, $titulo, $count, $url, $iconSvg, $color, $desc = '', $secondary = '') {
    if (!Permisos::usuarioTieneModulo(Core::$user->kind, $mod)) return;
    ?>
    <a href="<?php echo $url; ?>" class="hm-card hm-card-<?php echo $color; ?>">
        <div class="hm-card-top">
            <div class="hm-card-icon"><?php echo $iconSvg; ?></div>
            <div class="hm-card-arrow">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/>
                </svg>
            </div>
        </div>
        <div class="hm-card-num">
            <?php echo number_format($count); ?>
            <?php if ($secondary !== ''): ?><span class="hm-card-num-sub"><?php echo $secondary; ?></span><?php endif; ?>
        </div>
        <div class="hm-card-title"><?php echo $titulo; ?></div>
        <?php if ($desc): ?><div class="hm-card-desc"><?php echo $desc; ?></div><?php endif; ?>
    </a>
    <?php
}

/* Si CredencialData existe (modulo nuevo), preparamos su metrica */
$credActivas = 0;
if (class_exists('CredencialData')) {
    try { $credActivas = CredencialData::getTotalCredencialesActivas(); } catch (Exception $e) {}
}

/* Conteo de estudiantes (activos y totales) */
$totalEstudiantesActivos = 0;
$totalEstudiantesGeneral = 0;
try {
    $resAct = Executor::doit("SELECT COUNT(*) AS t FROM person WHERE kind=3 AND is_active=1");
    $rowAct = Model::one($resAct[0], new stdClass());
    $totalEstudiantesActivos = intval($rowAct->t);

    $resGen = Executor::doit("SELECT COUNT(*) AS t FROM person WHERE kind=3");
    $rowGen = Model::one($resGen[0], new stdClass());
    $totalEstudiantesGeneral = intval($rowGen->t);
} catch (Exception $e) {
    $totalEstudiantesActivos = count(PersonData::getAlumns()); // fallback
    $totalEstudiantesGeneral = $totalEstudiantesActivos;
}
?>

<style>
/* ===== DASHBOARD HOME · MODERN ====================================== */
.hm-modern {
    --c-bg:        #f8fafc;
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
    --c-cyan:      #06b6d4;
    --c-cyan-soft: #cffafe;
    --c-indigo:    #6366f1;
    --c-indigo-soft:#e0e7ff;
    --c-pink:      #ec4899;
    --c-pink-soft: #fce7f3;
    --c-teal:      #14b8a6;
    --c-teal-soft: #ccfbf1;
    --c-orange:    #f97316;
    --c-orange-soft:#ffedd5;
    --c-slate:     #475569;
    --c-slate-soft:#e2e8f0;

    color: var(--c-text);
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", system-ui, sans-serif;
    -webkit-font-smoothing: antialiased;
    margin: 0;
    padding: 4px 0;
}
.hm-modern * { box-sizing: border-box; }

/* === HERO ============================================================ */
.hm-hero {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #334155 100%);
    color: #fff;
    border-radius: 18px;
    padding: 28px 32px;
    margin-bottom: 22px;
    position: relative;
    overflow: hidden;
}
.hm-hero::before {
    content: "";
    position: absolute;
    width: 320px; height: 320px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(59,130,246,.25) 0%, rgba(59,130,246,0) 70%);
    top: -120px; right: -80px;
    pointer-events: none;
}
.hm-hero::after {
    content: "";
    position: absolute;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(245,158,11,.15) 0%, rgba(245,158,11,0) 70%);
    bottom: -90px; left: 30%;
    pointer-events: none;
}
.hm-hero-content {
    position: relative; z-index: 2;
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 24px;
}
.hm-hero h1 {
    margin: 0 0 6px;
    font-size: 28px;
    font-weight: 700;
    letter-spacing: -0.02em;
}
.hm-hero h1 small {
    display: block;
    font-size: 14px;
    font-weight: 400;
    color: rgba(255,255,255,.7);
    letter-spacing: 0;
    margin-top: 2px;
}
.hm-hero-meta {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 10px;
}
.hm-hero-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,.1);
    color: #fff;
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 500;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.15);
}
.hm-hero-pill svg { width: 13px; height: 13px; }
.hm-hero-pill .dot { width: 7px; height: 7px; border-radius: 50%; background: #10b981; box-shadow: 0 0 0 3px rgba(16,185,129,.2); }

.hm-hero-version {
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.15);
    padding: 6px 14px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .04em;
}

/* === SECTION HEADER =================================================== */
.hm-section {
    margin-bottom: 28px;
}
.hm-section-title {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 14px;
    flex-wrap: wrap; gap: 10px;
}
.hm-section-title h2 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    letter-spacing: -0.01em;
    color: var(--c-text);
}
.hm-section-title .hint {
    color: var(--c-muted);
    font-size: 13px;
}

/* === GRID DE MÓDULOS ================================================= */
.hm-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 14px;
}

/* === HM CARD ========================================================= */
.hm-card {
    background: var(--c-card);
    border: 1px solid var(--c-border);
    border-radius: 16px;
    padding: 18px;
    text-decoration: none;
    color: inherit;
    display: flex; flex-direction: column;
    gap: 10px;
    position: relative;
    overflow: hidden;
    transition: all .2s ease;
    min-height: 138px;
}
.hm-card::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 60%, var(--accent-soft) 130%);
    opacity: 0;
    transition: opacity .2s ease;
    pointer-events: none;
}
.hm-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 30px rgba(15, 23, 42, .08);
    border-color: var(--accent);
    color: inherit;
    text-decoration: none;
}
.hm-card:hover::before { opacity: 1; }

.hm-card-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
}
.hm-card-icon {
    width: 40px; height: 40px;
    border-radius: 10px;
    background: var(--accent-soft);
    color: var(--accent);
    display: flex; align-items: center; justify-content: center;
    flex: 0 0 40px;
}
.hm-card-icon svg { width: 22px; height: 22px; }
.hm-card-arrow {
    width: 28px; height: 28px;
    border-radius: 8px;
    background: var(--c-bg);
    color: var(--c-muted);
    display: flex; align-items: center; justify-content: center;
    transition: all .2s ease;
}
.hm-card-arrow svg { width: 14px; height: 14px; }
.hm-card:hover .hm-card-arrow {
    background: var(--accent);
    color: #fff;
}

.hm-card-num {
    font-size: 32px;
    font-weight: 700;
    letter-spacing: -0.02em;
    line-height: 1;
    color: var(--c-text);
    margin-top: 2px;
    font-variant-numeric: tabular-nums;
    display: flex;
    align-items: baseline;
    gap: 8px;
    flex-wrap: wrap;
}
.hm-card-num-sub {
    font-size: 14px;
    font-weight: 600;
    color: var(--c-muted);
    letter-spacing: 0;
}
.hm-card-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--c-text);
}
.hm-card-desc {
    font-size: 12px;
    color: var(--c-muted);
    line-height: 1.4;
    margin-top: -4px;
}

/* Variantes de color por card */
.hm-card-blue   { --accent: var(--c-blue);   --accent-soft: var(--c-blue-soft); }
.hm-card-green  { --accent: var(--c-green);  --accent-soft: var(--c-green-soft); }
.hm-card-amber  { --accent: var(--c-amber);  --accent-soft: var(--c-amber-soft); }
.hm-card-rose   { --accent: var(--c-rose);   --accent-soft: var(--c-rose-soft); }
.hm-card-violet { --accent: var(--c-violet); --accent-soft: var(--c-violet-soft); }
.hm-card-cyan   { --accent: var(--c-cyan);   --accent-soft: var(--c-cyan-soft); }
.hm-card-indigo { --accent: var(--c-indigo); --accent-soft: var(--c-indigo-soft); }
.hm-card-pink   { --accent: var(--c-pink);   --accent-soft: var(--c-pink-soft); }
.hm-card-teal   { --accent: var(--c-teal);   --accent-soft: var(--c-teal-soft); }
.hm-card-orange { --accent: var(--c-orange); --accent-soft: var(--c-orange-soft); }
.hm-card-slate  { --accent: var(--c-slate);  --accent-soft: var(--c-slate-soft); }

/* === CALENDARIO MODERNIZADO ========================================== */
.hm-calendar-wrap {
    background: var(--c-card);
    border: 1px solid var(--c-border);
    border-radius: 16px;
    padding: 22px;
    margin-top: 8px;
}
.hm-calendar-wrap h3 {
    margin: 0 0 14px;
    font-size: 16px;
    font-weight: 700;
    letter-spacing: -0.01em;
    display: flex; align-items: center; gap: 10px;
}
.hm-calendar-wrap h3 svg { width: 18px; height: 18px; color: var(--c-blue); }
#hmCalendar { min-height: 500px; }

/* Override del FullCalendar para que combine con el look */
.hm-calendar-wrap .fc-toolbar h2 {
    font-size: 16px;
    font-weight: 600;
    color: var(--c-text);
}
.hm-calendar-wrap .fc-button {
    background: var(--c-card) !important;
    border: 1px solid var(--c-border) !important;
    color: var(--c-text) !important;
    font-size: 12px !important;
    padding: 5px 12px !important;
    box-shadow: none !important;
    text-shadow: none !important;
    text-transform: capitalize !important;
}
.hm-calendar-wrap .fc-button:hover {
    background: var(--c-bg) !important;
    border-color: #cbd5e1 !important;
}
.hm-calendar-wrap .fc-state-active {
    background: var(--c-text) !important;
    color: #fff !important;
    border-color: var(--c-text) !important;
}
.hm-calendar-wrap .fc-event {
    background: var(--c-blue) !important;
    border: 0 !important;
    border-radius: 4px !important;
    padding: 1px 4px !important;
    font-size: 11px !important;
}
.hm-calendar-wrap .fc-day-today {
    background: var(--c-blue-soft) !important;
}
</style>

<div class="hm-modern">

    <!-- ========================= HERO ========================= -->
    <div class="hm-hero">
        <div class="hm-hero-content">
            <div>
                <h1>
                    <?php echo $saludo; ?>, <?php echo htmlspecialchars($userName); ?>
                    <small>Bienvenido al panel de administraci&oacute;n del Instituto Ejecutivo Mexicano</small>
                </h1>
                <div class="hm-hero-meta">
                    <span class="hm-hero-pill"><span class="dot"></span> En l&iacute;nea</span>
                    <span class="hm-hero-pill">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        <?php echo $fechaLarga; ?>
                    </span>
                    <span class="hm-hero-pill">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <span id="hmClock"><?php echo date('H:i'); ?></span>
                    </span>
                </div>
            </div>
            <div class="hm-hero-version">IEM Sistema &middot; v4.0</div>
        </div>
    </div>

    <!-- ========================= GRID DE MÓDULOS ========================= -->
    <div class="hm-section">
        <div class="hm-section-title">
            <h2>Tus m&oacute;dulos</h2>
            <span class="hint">Acceso r&aacute;pido a los m&oacute;dulos seg&uacute;n tus permisos</span>
        </div>
        <div class="hm-grid">

            <?php
            /* === Definición de iconos SVG inline (Lucide style) === */
            $icoBell    = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>';
            $icoCal     = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>';
            $icoUserPlus= '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>';
            $icoGrad    = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>';
            $icoChalk   = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>';
            $icoBook    = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2zM22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>';
            $icoUsers   = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>';
            $icoDollar  = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>';
            $icoCheck   = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>';
            $icoCard    = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>';
            $icoTag     = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41 13.42 20.58a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>';
            $icoClock   = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';
            $icoReceipt = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>';
            $icoFile    = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>';
            $icoIdCard  = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="2"/><path d="M15 8h2M15 12h2M7 16h10"/></svg>';

            /* Cards (orden según importancia) */
            home_card('estudiantes',      'Estudiantes activos', $totalEstudiantesActivos,                  './?view=alumns',                 $icoGrad,    'blue',   'Alumnos con cuenta activa', 'de '.number_format($totalEstudiantesGeneral).' totales');
            home_card('docentes',         'Docentes',            count(PersonData::getTeachers()),          './?view=teachers',               $icoChalk,   'indigo', 'Plantilla acad&eacute;mica');
            home_card('aspirante',        'Aspirantes',          count(AspiranteData::getAll()),            './?view=aspirante&opt=all',      $icoUserPlus,'amber',  'Nuevos prospectos');
            home_card('navegar_periodos', 'Periodos',            count(PeriodData::getAll()),               './?view=selectperiod',           $icoCal,     'cyan',   'Ciclos escolares operativos');
            home_card('grupos',           'Grupos',              count(TeamData::getAll()),                 './?view=teams&opt=all',          $icoUsers,   'teal',   'Aulas y agrupaciones');
            home_card('asignaturas',      'Asignaturas',         count(AsignatureData::getAll()),           './?view=asignatures&opt=all',    $icoBook,    'violet', 'Cat&aacute;logo de materias');
            home_card('avisos',           'Avisos',              count(PostData::getAllByQ("where kind_pub=1")), './?view=posts&opt=all',       $icoBell,    'rose',   'Comunicados publicados');
            home_card('becas',            'Cat&aacute;logo de Becas',  count(BecasData::getType1()),        './?view=becas&opt=all',          $icoDollar,  'green',  'Tipos de becas');
            home_card('promo_inscripcion','Inscripciones',       count(BecasData::getType2()),              './?view=promociones&opt=all',    $icoCheck,   'pink',   'Promociones de inscripci&oacute;n');
            home_card('caja_virtual',     'Caja Virtual',        0,                                          './pos.php',                      $icoCard,    'orange', 'Sistema de cobros y ventas');
            home_card('conceptos',        'Conceptos Caja',      count(ProductsData::getAll()),             './?view=productos&opt=all',      $icoTag,     'amber',  'Productos y servicios');
            home_card('control_planes',   'Planes de Pago',      count(PlandepagoData::getAll()),           './?view=planpago&opt=all',       $icoClock,   'teal',   'Calendarizaci&oacute;n de cobros');
            home_card('historial_pagos',  'Historial de Pagos',  count(PaymentData::getAll()),              './?view=payments&opt=all',       $icoReceipt, 'green',  'Movimientos registrados');

            /* Card de credenciales -- solo si el modulo nuevo esta activo */
            if (Permisos::usuarioTieneModulo(Core::$user->kind, 'credenciales')) {
                home_card('credenciales', 'Credenciales',        $credActivas,                              './?view=credenciales_dashboard', $icoIdCard,  'slate',  'Sistema de credenciales digitales');
            }
            ?>

        </div>
    </div>

    <!-- ========================= CALENDARIO ========================= -->
    <div class="hm-calendar-wrap">
        <h3>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            Calendario de Eventos
        </h3>
        <div id="hmCalendar"></div>
    </div>

</div>

<script>
$(document).ready(function() {
    // Reloj en tiempo real en el hero
    setInterval(function () {
        var d = new Date();
        var hh = String(d.getHours()).padStart(2, '0');
        var mm = String(d.getMinutes()).padStart(2, '0');
        var el = document.getElementById('hmClock');
        if (el) el.textContent = hh + ':' + mm;
    }, 30000);

    // Reusar FullCalendar (mismo plugin que ya está cargado por el layout)
    var eventData = <?php echo json_encode($thejson ?? []); ?>;
    if ($.fn.fullCalendar) {
        $('#hmCalendar').fullCalendar({
            header: {
                left:   'prev,next today',
                center: 'title',
                right:  'month,agendaWeek,agendaDay'
            },
            defaultDate: new Date(),
            editable: false,
            eventLimit: true,
            events: eventData,
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week:  'Semana',
                day:   'D\u00EDa'
            }
        });
    }
});
</script>