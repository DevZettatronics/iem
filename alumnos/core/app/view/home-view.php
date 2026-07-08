<?php
/* ============================================================================
 * VISTA: home-view (Portal Estudiantil — version moderna)
 * Reemplaza /Servicios/iem/alumnos/core/app/view/home-view.php
 * Texto en HTML entities para evitar problemas de UTF-8 vs latin1
 * ============================================================================ */

if (!headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
}

/* Forzar timezone de Mexico para que el saludo sea correcto sin importar la
   configuracion del servidor (a veces queda en UTC) */
date_default_timezone_set('America/Mexico_City');

/* Inscripcion activa (lo usa el sistema; lo dejamos por si hace falta) */
$inscription = InscriptionData::getActive($_SESSION["alumn_id"]);

/* Datos del estudiante */
$alumn         = isset($_SESSION["alumn_id"]) ? PersonData::getById($_SESSION["alumn_id"]) : null;
$alumnId       = $alumn ? intval($alumn->id) : 0;
$alumnCode     = $alumn ? $alumn->code : '';
$alumnNombre   = $alumn ? trim(($alumn->name ?? '') . ' ' . ($alumn->lastname ?? '')) : '';
$alumnPrimerNm = $alumn ? trim(strtok($alumn->name ?? '', ' ')) : '';

/* Iniciales del alumno como fallback de avatar */
$alumnIniciales = '';
if ($alumn) {
    $alumnIniciales  = strtoupper(mb_substr($alumn->name ?? 'X', 0, 1));
    $alumnIniciales .= strtoupper(mb_substr($alumn->lastname ?? 'X', 0, 1));
}

/* Foto del alumno: buscar primero en /credencial/uploads/fotos/{matricula}.jpg
   Si no existe, usar el campo person.foto del sistema actual.
   Si nada existe, dejar vacio (se mostraran iniciales). */
$alumnFotoUrl = '';
if ($alumnCode) {
    $matriculaLimpia = preg_replace('/[^A-Z0-9]/i', '', $alumnCode);
    $rutaFoto    = $_SERVER['DOCUMENT_ROOT'] . '/credencial/uploads/fotos/' . $matriculaLimpia . '.jpg';
    if (is_file($rutaFoto)) {
        $alumnFotoUrl = '/credencial/uploads/fotos/' . $matriculaLimpia . '.jpg?v=' . filemtime($rutaFoto);
    } elseif ($alumn && !empty($alumn->foto) && $alumn->foto !== 'img/user/user.png') {
        // Fallback: campo foto en BD si esta poblado y no es el default
        $alumnFotoUrl = '/' . ltrim($alumn->foto, '/');
    }
}

/* Saludo segun hora (HTML entities) */
$hora = (int)date('H');
if      ($hora < 12) { $saludo = 'Buenos d&iacute;as'; }
elseif  ($hora < 19) { $saludo = 'Buenas tardes'; }
else                 { $saludo = 'Buenas noches'; }

/* Fecha en espanol con entities */
$diasSemana  = ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'];
$mesesNombre = ['','enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
$fechaLarga  = $diasSemana[(int)date('w')] . ' ' . (int)date('d') . ' de ' . $mesesNombre[(int)date('n')] . ', ' . date('Y');

/* Conteo de avisos para el alumno */
$totalAvisos = 0;
try {
    $totalAvisos = count(PostData::getAllByQ("where kind_pub=1 and (kind=1 or kind=4)"));
} catch (Exception $e) {}
?>

<style>
.al-modern {
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
    --c-gold:      #d4a437;
    --c-navy:      #0b2545;

    color: var(--c-text);
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", system-ui, sans-serif;
    -webkit-font-smoothing: antialiased;
    margin: 0;
    padding: 4px 0;
}
.al-modern * { box-sizing: border-box; }

/* === HERO ============================================================ */
.al-hero {
    background: linear-gradient(135deg, var(--c-navy) 0%, #1e293b 60%, #334155 100%);
    color: #fff;
    border-radius: 18px;
    padding: 28px 32px;
    margin-bottom: 22px;
    position: relative;
    overflow: hidden;
}
.al-hero::before {
    content: ""; position: absolute;
    width: 320px; height: 320px; border-radius: 50%;
    background: radial-gradient(circle, rgba(212,164,55,.22) 0%, rgba(212,164,55,0) 70%);
    top: -100px; right: -80px; pointer-events: none;
}
.al-hero::after {
    content: ""; position: absolute;
    width: 220px; height: 220px; border-radius: 50%;
    background: radial-gradient(circle, rgba(59,130,246,.15) 0%, rgba(59,130,246,0) 70%);
    bottom: -90px; left: 30%; pointer-events: none;
}
.al-hero-content {
    position: relative; z-index: 2;
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 24px;
}
.al-hero-greeting {
    display: flex; align-items: center; gap: 18px;
    flex: 1 1 auto; min-width: 0;
}
.al-hero-avatar {
    width: 78px; height: 78px;
    border-radius: 50%;
    overflow: hidden;
    flex: 0 0 78px;
    background: linear-gradient(135deg, #d4a437, #f0c764);
    color: #0b2545;
    display: flex; align-items: center; justify-content: center;
    font-size: 26px; font-weight: 700;
    letter-spacing: -0.02em;
    border: 3px solid rgba(255,255,255,.18);
    box-shadow: 0 6px 18px rgba(0,0,0,.2), inset 0 0 0 2px rgba(255,255,255,.08);
    position: relative;
}
.al-hero-avatar img {
    width: 100%; height: 100%; object-fit: cover; display: block;
}
.al-hero-avatar::after {
    content: ""; position: absolute;
    bottom: 4px; right: 4px;
    width: 14px; height: 14px;
    border-radius: 50%; background: #10b981;
    border: 2px solid #0f172a;
    box-shadow: 0 0 0 1px #10b981;
}
.al-hero-greeting-text { flex: 1 1 auto; min-width: 0; }
.al-hero h1 {
    margin: 0 0 6px;
    font-size: 28px; font-weight: 700; letter-spacing: -0.02em;
}
.al-hero h1 small {
    display: block;
    font-size: 14px; font-weight: 400;
    color: rgba(255,255,255,.7); letter-spacing: 0; margin-top: 2px;
}
.al-hero-meta {
    display: flex; gap: 12px; flex-wrap: wrap; margin-top: 10px;
}
.al-hero-pill {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,.1); color: #fff;
    padding: 5px 12px; border-radius: 999px;
    font-size: 12px; font-weight: 500;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.15);
}
.al-hero-pill svg { width: 13px; height: 13px; }
.al-hero-pill .dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: #10b981; box-shadow: 0 0 0 3px rgba(16,185,129,.2);
}
.al-hero-version {
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.15);
    padding: 6px 14px; border-radius: 10px;
    font-size: 12px; font-weight: 600; letter-spacing: .04em;
}

/* === CARD DESTACADO DE CREDENCIAL ==================================== */
.al-feature {
    background: linear-gradient(135deg, #d4a437 0%, #f0c764 100%);
    border-radius: 18px;
    padding: 0;
    margin-bottom: 22px;
    overflow: hidden;
    position: relative;
    color: var(--c-navy);
    text-decoration: none;
    display: block;
    transition: all .25s ease;
    box-shadow: 0 6px 20px rgba(212,164,55,.25);
}
.al-feature:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 32px rgba(212,164,55,.4);
    color: var(--c-navy);
    text-decoration: none;
}
.al-feature-inner {
    display: flex; align-items: center; justify-content: space-between;
    padding: 22px 26px; gap: 20px; flex-wrap: wrap;
    position: relative; z-index: 2;
}
.al-feature::before {
    content: ""; position: absolute;
    inset: 0;
    background: radial-gradient(circle at 90% 50%, rgba(255,255,255,.3) 0%, rgba(255,255,255,0) 50%);
    pointer-events: none;
}
.al-feature-text { flex: 1 1 300px; min-width: 0; }
.al-feature-tag {
    display: inline-block;
    background: var(--c-navy); color: #fff;
    padding: 3px 10px; border-radius: 999px;
    font-size: 11px; font-weight: 700; letter-spacing: .08em;
    text-transform: uppercase;
    margin-bottom: 8px;
}
.al-feature h2 {
    margin: 0 0 4px;
    font-size: 22px; font-weight: 700; letter-spacing: -0.02em;
    color: var(--c-navy);
}
.al-feature p {
    margin: 0;
    font-size: 14px;
    color: rgba(11,37,69,.78);
    max-width: 540px;
}
.al-feature-cta {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--c-navy); color: #fff;
    padding: 12px 22px; border-radius: 12px;
    font-size: 14px; font-weight: 600;
    flex: 0 0 auto;
    transition: all .15s ease;
}
.al-feature:hover .al-feature-cta {
    background: #1e293b;
    transform: translateX(4px);
}
.al-feature-cta svg { width: 16px; height: 16px; }
.al-feature-icon {
    width: 64px; height: 64px;
    border-radius: 14px;
    background: var(--c-navy);
    color: var(--c-gold);
    display: flex; align-items: center; justify-content: center;
    flex: 0 0 64px;
    box-shadow: 0 4px 12px rgba(11,37,69,.25);
}
.al-feature-icon svg { width: 32px; height: 32px; }

/* === SECCIONES ======================================================= */
.al-section { margin-bottom: 28px; }
.al-section-title {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 14px; flex-wrap: wrap; gap: 10px;
}
.al-section-title h2 {
    margin: 0; font-size: 16px; font-weight: 700;
    letter-spacing: -0.01em; color: var(--c-text);
}
.al-section-title .hint {
    color: var(--c-muted); font-size: 13px;
}

/* === GRID DE CARDS =================================================== */
.al-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 14px;
}

.al-card {
    background: var(--c-card);
    border: 1px solid var(--c-border);
    border-radius: 16px;
    padding: 20px;
    text-decoration: none; color: inherit;
    display: flex; flex-direction: column; gap: 10px;
    position: relative; overflow: hidden;
    transition: all .2s ease;
    min-height: 168px;
}
.al-card::before {
    content: ""; position: absolute; inset: 0;
    background: linear-gradient(180deg, transparent 60%, var(--accent-soft) 130%);
    opacity: 0; transition: opacity .2s ease; pointer-events: none;
}
.al-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 30px rgba(15, 23, 42, .08);
    border-color: var(--accent);
    color: inherit; text-decoration: none;
}
.al-card:hover::before { opacity: 1; }

.al-card-top {
    display: flex; align-items: flex-start; justify-content: space-between;
}
.al-card-icon {
    width: 44px; height: 44px;
    border-radius: 11px;
    background: var(--accent-soft); color: var(--accent);
    display: flex; align-items: center; justify-content: center;
    flex: 0 0 44px;
}
.al-card-icon svg { width: 24px; height: 24px; }
.al-card-arrow {
    width: 30px; height: 30px;
    border-radius: 8px;
    background: var(--c-bg); color: var(--c-muted);
    display: flex; align-items: center; justify-content: center;
    transition: all .2s ease;
}
.al-card-arrow svg { width: 14px; height: 14px; }
.al-card:hover .al-card-arrow { background: var(--accent); color: #fff; }

.al-card-num {
    font-size: 32px; font-weight: 700;
    letter-spacing: -0.02em; line-height: 1;
    color: var(--c-text); margin-top: 2px;
    font-variant-numeric: tabular-nums;
}
.al-card-title {
    font-size: 15px; font-weight: 700; color: var(--c-text);
}
.al-card-desc {
    font-size: 12.5px; color: var(--c-muted);
    line-height: 1.45;
}
.al-card-pay-icons {
    display: flex; gap: 4px; align-items: center;
    margin-top: 4px;
}
.al-card-pay-icons img {
    height: 16px; width: auto;
    filter: grayscale(20%);
}

/* Variantes */
.al-card-blue   { --accent: var(--c-blue);   --accent-soft: var(--c-blue-soft); }
.al-card-green  { --accent: var(--c-green);  --accent-soft: var(--c-green-soft); }
.al-card-amber  { --accent: var(--c-amber);  --accent-soft: var(--c-amber-soft); }
.al-card-rose   { --accent: var(--c-rose);   --accent-soft: var(--c-rose-soft); }
.al-card-violet { --accent: var(--c-violet); --accent-soft: var(--c-violet-soft); }
.al-card-cyan   { --accent: var(--c-cyan);   --accent-soft: var(--c-cyan-soft); }
.al-card-indigo { --accent: var(--c-indigo); --accent-soft: var(--c-indigo-soft); }
.al-card-teal   { --accent: var(--c-teal);   --accent-soft: var(--c-teal-soft); }
.al-card-orange { --accent: var(--c-orange); --accent-soft: var(--c-orange-soft); }
.al-card-pink   { --accent: var(--c-pink);   --accent-soft: var(--c-pink-soft); }
</style>

<div class="al-modern">

    <!-- ============== HERO ============== -->
    <div class="al-hero">
        <div class="al-hero-content">
            <div class="al-hero-greeting">
                <!-- Avatar: foto del alumno o iniciales como fallback -->
                <div class="al-hero-avatar" title="<?php echo htmlspecialchars($alumnNombre); ?>">
                    <?php if ($alumnFotoUrl): ?>
                        <img src="<?php echo htmlspecialchars($alumnFotoUrl); ?>"
                             alt="<?php echo htmlspecialchars($alumnNombre); ?>"
                             onerror="this.parentNode.innerHTML='<?php echo addslashes($alumnIniciales); ?>'; this.parentNode.classList.add('al-avatar-fallback');">
                    <?php else: ?>
                        <?php echo $alumnIniciales; ?>
                    <?php endif; ?>
                </div>

                <div class="al-hero-greeting-text">
                    <h1>
                        <?php echo $saludo; ?><?php echo $alumnPrimerNm ? ', ' . htmlspecialchars($alumnPrimerNm) : ''; ?>
                        <small>Bienvenido(a) al Portal Estudiantil del Instituto Ejecutivo Mexicano</small>
                    </h1>
                    <div class="al-hero-meta">
                        <span class="al-hero-pill"><span class="dot"></span> En l&iacute;nea</span>
                        <span class="al-hero-pill">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            <?php echo $fechaLarga; ?>
                        </span>
                        <?php if ($alumnCode): ?>
                        <span class="al-hero-pill">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="8.5" cy="7" r="4"/>
                                <line x1="20" y1="8" x2="20" y2="14"/>
                                <line x1="23" y1="11" x2="17" y2="11"/>
                            </svg>
                            Matr&iacute;cula: <?php echo htmlspecialchars($alumnCode); ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="al-hero-version">IEM Estudiantes &middot; v4.0</div>
        </div>
    </div>

    <!-- ============== CARD DESTACADO: CREDENCIAL ============== -->
    <a class="al-feature" href="https://aula.iemueem.edu.mx/credencial/" target="_blank" rel="noopener">
        <div class="al-feature-inner">
            <div class="al-feature-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="16" rx="2"/>
                    <circle cx="9" cy="10" r="2"/>
                    <path d="M15 8h2M15 12h2M7 16h10"/>
                </svg>
            </div>
            <div class="al-feature-text">
                <span class="al-feature-tag">Nuevo</span>
                <h2>Trami&shy;ta tu Credencial Digital</h2>
                <p>Genera tu credencial estudiantil oficial con QR de verificaci&oacute;n, des&shy;c&aacute;rgala como imagen o agr&eacute;gala a tu Wallet del celular.</p>
            </div>
            <span class="al-feature-cta">
                Ir al sistema
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="7" y1="17" x2="17" y2="7"/>
                    <polyline points="7 7 17 7 17 17"/>
                </svg>
            </span>
        </div>
    </a>

    <!-- ============== CARDS DE MODULOS ESTUDIANTILES ============== -->
    <div class="al-section">
        <div class="al-section-title">
            <h2>Acceso r&aacute;pido</h2>
            <span class="hint">Tus herramientas como estudiante</span>
        </div>

        <div class="al-grid">

            <!-- Avisos -->
            <a href="./?view=news" class="al-card al-card-rose">
                <div class="al-card-top">
                    <div class="al-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                        </svg>
                    </div>
                    <div class="al-card-arrow">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/>
                        </svg>
                    </div>
                </div>
                <div class="al-card-num"><?php echo number_format($totalAvisos); ?></div>
                <div class="al-card-title">Avisos</div>
                <div class="al-card-desc">Comunicados y notificaciones para estudiantes</div>
            </a>

            <!-- Asignaturas -->
            <a href="./?view=kardexhistory" class="al-card al-card-blue">
                <div class="al-card-top">
                    <div class="al-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2zM22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                        </svg>
                    </div>
                    <div class="al-card-arrow">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/>
                        </svg>
                    </div>
                </div>
                <div class="al-card-title" style="margin-top:auto;font-size:18px;">Mis Asignaturas</div>
                <div class="al-card-desc">Consulta las materias que has cursado en tu kardex</div>
            </a>

            <!-- Calificaciones -->
            <a href="./index.php?view=alumnhistory&id=<?php echo $alumnId; ?>" class="al-card al-card-amber">
                <div class="al-card-top">
                    <div class="al-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                            <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                        </svg>
                    </div>
                    <div class="al-card-arrow">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/>
                        </svg>
                    </div>
                </div>
                <div class="al-card-title" style="margin-top:auto;font-size:18px;">Calificaciones</div>
                <div class="al-card-desc">Ver tus calificaciones desglosadas por ciclo escolar</div>
            </a>

            <!-- Expediente Digital -->
            <a href="index.php?view=edituser&id=<?php echo $alumnId; ?>" class="al-card al-card-violet">
                <div class="al-card-top">
                    <div class="al-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    <div class="al-card-arrow">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/>
                        </svg>
                    </div>
                </div>
                <div class="al-card-title" style="margin-top:auto;font-size:18px;">Mi Expediente Digital</div>
                <div class="al-card-desc">Carga y consulta tu documentaci&oacute;n oficial</div>
            </a>

            <!-- Estado de Cuenta -->
            <a href="./?view=pagos&code=<?php echo htmlspecialchars($alumnCode); ?>" class="al-card al-card-green">
                <div class="al-card-top">
                    <div class="al-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="5" width="20" height="14" rx="2"/>
                            <line x1="2" y1="10" x2="22" y2="10"/>
                        </svg>
                    </div>
                    <div class="al-card-arrow">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/>
                        </svg>
                    </div>
                </div>
                <div class="al-card-title" style="margin-top:auto;font-size:18px;">Estado de Cuenta</div>
                <div class="al-card-desc">Pagos en l&iacute;nea con tarjeta de cr&eacute;dito o d&eacute;bito</div>
                <div class="al-card-pay-icons">
                    <img src="../storage/posts/visa.png" alt="Visa" onerror="this.style.display='none'">
                    <img src="../storage/posts/mastercard.png" alt="Mastercard" onerror="this.style.display='none'">
                    <img src="../storage/posts/american-express.png" alt="AmEx" onerror="this.style.display='none'">
                </div>
            </a>

            <!-- PayPal -->
            <a href="https://www.paypal.com/mx/digital-wallet/send-receive-money/paypal-me" target="_blank" rel="noopener" class="al-card al-card-cyan">
                <div class="al-card-top">
                    <div class="al-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M7 11V7a5 5 0 0 1 9.9-1"/>
                            <rect x="3" y="11" width="18" height="11" rx="2"/>
                        </svg>
                    </div>
                    <div class="al-card-arrow">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/>
                        </svg>
                    </div>
                </div>
                <div class="al-card-title" style="margin-top:auto;font-size:18px;">Pago PayPal</div>
                <div class="al-card-desc">Paga tus servicios y env&iacute;a comprobante a ingresos@iemueem.edu.mx</div>
            </a>

        </div>
    </div>

</div>