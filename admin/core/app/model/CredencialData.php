<?php
/**
 * CredencialData
 * Modelo para el módulo de credenciales digitales del IEM.
 * Sigue convenciones del framework Lb (LegoBox) usado en este admin.
 *
 * Tablas que utiliza:
 *   - credencial_vigencia       (vigencia activa + histórico de renovaciones)
 *   - credencial_revocaciones   (auditoría de revocaciones)
 *   - person                    (estudiantes — kind=3)
 *   - program                   (carreras)
 *   - inscription, period, team, modalidad
 *   - estatus_alumnos
 *
 * @author IEM · Módulo Credenciales
 */
class CredencialData {

    public static $tablename  = 'credencial_vigencia';
    public static $tablename2 = 'credencial_revocaciones';

    public $id;
    public $alumno_id;
    public $fecha_emision;
    public $fecha_vencimiento;
    public $num_renovacion;
    public $activa;
    public $created_at;

    /* ====================================================================
     * UTILS BÁSICOS
     * ==================================================================== */

    /** Vigencia activa de un alumno (o null) */
    public static function getVigenciaActivaByAlumno($alumno_id) {
        $alumno_id = intval($alumno_id);
        $sql = "SELECT * FROM credencial_vigencia
                 WHERE alumno_id = $alumno_id AND activa = 1
                 ORDER BY id DESC LIMIT 1";
        $res = Executor::doit($sql);
        $rows = Model::many($res[0], new CredencialData());
        return count($rows) ? $rows[0] : null;
    }

    /** Histórico completo de un alumno (todas las emisiones/renovaciones) */
    public static function getHistorialByAlumno($alumno_id) {
        $alumno_id = intval($alumno_id);
        $sql = "SELECT * FROM credencial_vigencia
                 WHERE alumno_id = $alumno_id
                 ORDER BY id DESC";
        $res = Executor::doit($sql);
        return Model::many($res[0], new CredencialData());
    }

    /** Revocación asociada a una vigencia (si existe) */
    public static function getRevocacionByVigencia($vigencia_id) {
        $vigencia_id = intval($vigencia_id);
        $sql = "SELECT * FROM credencial_revocaciones
                 WHERE vigencia_id = $vigencia_id
                 ORDER BY id DESC LIMIT 1";
        $res = Executor::doit($sql);
        $rows = Model::many($res[0], new stdClass());
        return count($rows) ? $rows[0] : null;
    }

    /** Lista de revocaciones recientes (para dashboard) */
    public static function getRevocacionesRecientes($limit = 10) {
        $limit = intval($limit);
        $sql = "SELECT  cr.*,
                        p.code AS matricula,
                        p.name, p.lastname,
                        pr.name AS carrera
                  FROM credencial_revocaciones cr
                  LEFT JOIN person  p  ON p.id  = cr.alumno_id
                  LEFT JOIN program pr ON pr.id = p.carrera
                 ORDER BY cr.fecha_registro DESC
                 LIMIT $limit";
        $res = Executor::doit($sql);
        return Model::many($res[0], new stdClass());
    }

    /* ====================================================================
     * MÉTRICAS DEL DASHBOARD
     * ==================================================================== */

    /** Total de estudiantes activos (kind=3, is_active=1) */
    public static function getTotalEstudiantes() {
        $sql = "SELECT COUNT(*) AS total FROM person
                 WHERE kind=3 AND is_active=1";
        $res = Executor::doit($sql);
        $row = Model::one($res[0], new stdClass());
        return intval($row->total);
    }

    /** Total de credenciales activas (1 por alumno) */
    public static function getTotalCredencialesActivas() {
        $sql = "SELECT COUNT(DISTINCT alumno_id) AS total
                  FROM credencial_vigencia
                 WHERE activa=1";
        $res = Executor::doit($sql);
        $row = Model::one($res[0], new stdClass());
        return intval($row->total);
    }

    /** Credenciales que vencen en los próximos N días */
    public static function getProximasAVencer($dias = 30) {
        $dias = intval($dias);
        $sql = "SELECT COUNT(*) AS total FROM credencial_vigencia
                 WHERE activa=1
                   AND fecha_vencimiento BETWEEN CURDATE()
                                             AND DATE_ADD(CURDATE(), INTERVAL $dias DAY)";
        $res = Executor::doit($sql);
        $row = Model::one($res[0], new stdClass());
        return intval($row->total);
    }

    /** Credenciales ya vencidas (activas pero pasaron de fecha) */
    public static function getVencidas() {
        $sql = "SELECT COUNT(*) AS total FROM credencial_vigencia
                 WHERE activa=1 AND fecha_vencimiento < CURDATE()";
        $res = Executor::doit($sql);
        $row = Model::one($res[0], new stdClass());
        return intval($row->total);
    }

    /** Renovaciones del mes actual */
    public static function getRenovacionesDelMes() {
        $sql = "SELECT COUNT(*) AS total FROM credencial_vigencia
                 WHERE num_renovacion > 0
                   AND YEAR(created_at)  = YEAR(CURDATE())
                   AND MONTH(created_at) = MONTH(CURDATE())";
        $res = Executor::doit($sql);
        $row = Model::one($res[0], new stdClass());
        return intval($row->total);
    }

    /** Total de revocaciones (lifetime) */
    public static function getTotalRevocadas() {
        $sql = "SELECT COUNT(*) AS total FROM credencial_revocaciones";
        $res = Executor::doit($sql);
        $row = Model::one($res[0], new stdClass());
        return intval($row->total);
    }

    /** Cobertura por carrera (para gráfica del dashboard) */
    public static function getCoberturaPorCarrera() {
        $sql = "SELECT  pr.id           AS carrera_id,
                        pr.name         AS carrera,
                        COUNT(p.id)     AS total_alumnos,
                        COUNT(cv.id)    AS con_credencial,
                        ROUND(100 * COUNT(cv.id) / NULLIF(COUNT(p.id),0), 1) AS porcentaje
                  FROM program pr
                  LEFT JOIN person p
                         ON p.carrera = pr.id AND p.kind = 3 AND p.is_active = 1
                  LEFT JOIN credencial_vigencia cv
                         ON cv.alumno_id = p.id AND cv.activa = 1
                 GROUP BY pr.id, pr.name
                 ORDER BY total_alumnos DESC";
        $res = Executor::doit($sql);
        return Model::many($res[0], new stdClass());
    }

    /* ====================================================================
     * LISTADO MAESTRO (vista de tabla con filtros)
     * ==================================================================== */

    /**
     * Devuelve el listado completo de estudiantes con su estado de credencial.
     * Filtros opcionales: carrera_id, status (todos|emitida|sin_emitir|vencida|revocada)
     */
    public static function getListadoEstudiantes($filtros = []) {
        $where = ['p.kind = 3', 'p.is_active = 1'];

        if (!empty($filtros['carrera_id'])) {
            $cid = intval($filtros['carrera_id']);
            $where[] = "p.carrera = $cid";
        }

        if (!empty($filtros['q'])) {
            $con = Database::getCon();
            $q = $con->real_escape_string(trim($filtros['q']));
            $where[] = "(p.code LIKE '%$q%' OR p.name LIKE '%$q%' OR p.lastname LIKE '%$q%' OR p.curp LIKE '%$q%')";
        }

        $sqlWhere = implode(' AND ', $where);

        $sql = "
            SELECT  p.id          AS alumno_id,
                    p.code        AS matricula,
                    p.name        AS nombre,
                    p.lastname    AS apellido,
                    p.foto,
                    p.is_active,
                    p.curp,
                    p.f_nacimiento,
                    pr.id         AS carrera_id,
                    pr.name       AS carrera,
                    pr.grade      AS grado,
                    cv.id            AS vigencia_id,
                    cv.fecha_emision,
                    cv.fecha_vencimiento,
                    cv.num_renovacion,
                    cv.activa     AS vigencia_activa,
                    cr.id         AS revocacion_id,
                    cr.motivo     AS motivo_revocacion,
                    cr.fecha_registro AS fecha_revocacion,
                    CASE
                        WHEN cv.id IS NULL                           THEN 'sin_emitir'
                        WHEN cr.id IS NOT NULL                       THEN 'revocada'
                        WHEN cv.fecha_vencimiento < CURDATE()        THEN 'vencida'
                        ELSE 'vigente'
                    END AS estado_credencial
              FROM person p
              LEFT JOIN program pr ON pr.id = p.carrera
              LEFT JOIN credencial_vigencia cv
                     ON cv.alumno_id = p.id AND cv.activa = 1
              LEFT JOIN credencial_revocaciones cr
                     ON cr.vigencia_id = cv.id
             WHERE $sqlWhere
             ORDER BY p.code ASC
        ";

        $res  = Executor::doit($sql);
        $rows = Model::many($res[0], new stdClass());

        // Filtro post-SQL por estado (más simple que reescribir el WHERE)
        if (!empty($filtros['status']) && $filtros['status'] !== 'todos') {
            $rows = array_values(array_filter($rows, function($r) use ($filtros) {
                return $r->estado_credencial === $filtros['status'];
            }));
        }

        return $rows;
    }

    /** Carreras (para dropdown de filtros) */
    public static function getCarreras() {
        $sql = "SELECT id, name, grade FROM program ORDER BY name";
        $res = Executor::doit($sql);
        return Model::many($res[0], new stdClass());
    }

    /* ====================================================================
     * REVOCACIÓN
     * ==================================================================== */

    /**
     * Revoca la credencial vigente de un alumno.
     * Marca activa=0 y registra la auditoría en credencial_revocaciones.
     */
    public static function revocar($alumno_id, $motivo, $usuario_id, $nombre_usuario) {
        $alumno_id      = intval($alumno_id);
        $usuario_id     = intval($usuario_id);
        $con            = Database::getCon();
        $motivoEsc      = $con->real_escape_string(trim($motivo));
        $nombreUsrEsc   = $con->real_escape_string(trim($nombre_usuario));

        // Obtener vigencia activa
        $v = self::getVigenciaActivaByAlumno($alumno_id);
        if (!$v) return false;

        // Verificar que no esté ya revocada (defensa en profundidad)
        $checkSql = "SELECT id FROM credencial_revocaciones
                      WHERE vigencia_id = " . intval($v->id) . " LIMIT 1";
        $check = Executor::doit($checkSql);
        $existing = Model::many($check[0], new stdClass());
        if (count($existing) > 0) return 'already_revoked';

        // Insertar la revocación
        $sqlIns = "INSERT INTO credencial_revocaciones
                       (vigencia_id, alumno_id, motivo, usuario_id, nombre_usuario)
                   VALUES
                       (" . intval($v->id) . ", $alumno_id, '$motivoEsc', $usuario_id, '$nombreUsrEsc')";
        Executor::doit($sqlIns);

        // Marcar vigencia como inactiva
        $sqlUpd = "UPDATE credencial_vigencia
                      SET activa = 0
                    WHERE id = " . intval($v->id);
        Executor::doit($sqlUpd);

        return true;
    }

    /** ¿La vigencia indicada está revocada? */
    public static function isRevocada($vigencia_id) {
        $vigencia_id = intval($vigencia_id);
        $sql = "SELECT COUNT(*) AS total FROM credencial_revocaciones
                 WHERE vigencia_id = $vigencia_id";
        $res = Executor::doit($sql);
        $row = Model::one($res[0], new stdClass());
        return intval($row->total) > 0;
    }

    /* ====================================================================
     * ELIMINAR REGISTRO COMPLETO
     * Borra TODAS las vigencias y revocaciones del alumno y deja una pista
     * de auditoría en credencial_eliminaciones (auto-create).
     * ==================================================================== */

    /** Auto-crea la tabla de auditoría de eliminaciones */
    private static function ensureEliminacionesTable() {
        $sql = "CREATE TABLE IF NOT EXISTS `credencial_eliminaciones` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `alumno_id` INT NOT NULL,
                    `matricula` VARCHAR(50) DEFAULT NULL,
                    `motivo` TEXT,
                    `usuario_id` INT NOT NULL,
                    `nombre_usuario` VARCHAR(150) DEFAULT NULL,
                    `vigencias_borradas` INT DEFAULT 0,
                    `revocaciones_borradas` INT DEFAULT 0,
                    `fecha_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    KEY `idx_alumno` (`alumno_id`),
                    KEY `idx_fecha`  (`fecha_registro`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        Executor::doit($sql);
    }

    /**
     * Elimina TODOS los registros de credencial de un alumno (vigencia + revocaciones).
     * El alumno podrá emitir una nueva al volver a entrar al sistema /credencial/.
     */
    public static function eliminarRegistro($alumno_id, $motivo, $usuario_id, $nombre_usuario) {
        $alumno_id    = intval($alumno_id);
        $usuario_id   = intval($usuario_id);
        $con          = Database::getCon();
        $motivoEsc    = $con->real_escape_string(trim($motivo));
        $nombreUsrEsc = $con->real_escape_string(trim($nombre_usuario));

        self::ensureEliminacionesTable();

        // Snapshot: matrícula y conteos
        $resMat = Executor::doit("SELECT code FROM person WHERE id = $alumno_id LIMIT 1");
        $rowMat = Model::one($resMat[0], new stdClass());
        $matricula = $rowMat->code ?? '';
        $matriculaEsc = $con->real_escape_string($matricula);

        $resV = Executor::doit("SELECT COUNT(*) AS t FROM credencial_vigencia WHERE alumno_id = $alumno_id");
        $rowV = Model::one($resV[0], new stdClass());
        $totalV = intval($rowV->t);

        $resR = Executor::doit("SELECT COUNT(*) AS t FROM credencial_revocaciones WHERE alumno_id = $alumno_id");
        $rowR = Model::one($resR[0], new stdClass());
        $totalR = intval($rowR->t);

        if ($totalV === 0 && $totalR === 0) return 'sin_registros';

        // Borrar
        Executor::doit("DELETE FROM credencial_revocaciones WHERE alumno_id = $alumno_id");
        Executor::doit("DELETE FROM credencial_vigencia    WHERE alumno_id = $alumno_id");

        // Borrar la foto física del alumno (opcional, comentar si no se desea)
        $rutaFoto = $_SERVER['DOCUMENT_ROOT'] . '/credencial/uploads/fotos/'
                  . preg_replace('/[^A-Z0-9]/i', '', $matricula) . '.jpg';
        if (is_file($rutaFoto)) {
            // No borramos la foto por defecto — comenta la línea siguiente si la quieres conservar:
            // @unlink($rutaFoto);
        }

        // Auditar
        $sqlAud = "INSERT INTO credencial_eliminaciones
                       (alumno_id, matricula, motivo, usuario_id, nombre_usuario,
                        vigencias_borradas, revocaciones_borradas)
                   VALUES
                       ($alumno_id, '$matriculaEsc', '$motivoEsc', $usuario_id, '$nombreUsrEsc',
                        $totalV, $totalR)";
        Executor::doit($sqlAud);

        return [
            'vigencias' => $totalV,
            'revocaciones' => $totalR,
        ];
    }

    /* ====================================================================
     * EXTENDER VIGENCIA
     * Crea una nueva vigencia "renovación" añadiendo X meses sobre la actual.
     * Si el alumno no tiene vigencia activa (vencida o sin emitir), parte de hoy.
     * ==================================================================== */

    /**
     * Extiende la vigencia activa del alumno por X meses.
     * Crea un nuevo registro en credencial_vigencia (num_renovacion+1)
     * y desactiva la vigencia anterior. Bypassea el check de status_alumno
     * porque es acción admin.
     */
    public static function extenderVigencia($alumno_id, $meses, $usuario_id, $nombre_usuario, $motivo = '') {
        $alumno_id    = intval($alumno_id);
        $meses        = intval($meses);
        $usuario_id   = intval($usuario_id);

        if ($meses <= 0 || $meses > 60) return 'meses_invalidos';

        // Obtener vigencia activa (o última si no hay activa)
        $vigenciaActual = self::getVigenciaActivaByAlumno($alumno_id);

        // Si no tiene activa, buscar la última no activa
        if (!$vigenciaActual) {
            $sql = "SELECT * FROM credencial_vigencia
                     WHERE alumno_id = $alumno_id
                     ORDER BY id DESC LIMIT 1";
            $res = Executor::doit($sql);
            $rows = Model::many($res[0], new CredencialData());
            $vigenciaActual = count($rows) ? $rows[0] : null;
        }

        // Calcular fecha base
        // Si tiene vigencia con fecha futura, partimos de su vencimiento.
        // Si está vencida o no tiene, partimos de HOY.
        $hoy = date('Y-m-d');
        if ($vigenciaActual && strtotime($vigenciaActual->fecha_vencimiento) > strtotime($hoy)) {
            $fechaBase = $vigenciaActual->fecha_vencimiento;
        } else {
            $fechaBase = $hoy;
        }
        $nuevoVenc = date('Y-m-d', strtotime("$fechaBase +$meses months"));

        // Calcular siguiente número de renovación
        $stmt = Executor::doit(
            "SELECT COALESCE(MAX(num_renovacion), -1) AS num
               FROM credencial_vigencia WHERE alumno_id = $alumno_id"
        );
        $row = Model::one($stmt[0], new stdClass());
        $next = intval($row->num) + 1;

        // Desactivar vigencias anteriores
        Executor::doit("UPDATE credencial_vigencia SET activa = 0 WHERE alumno_id = $alumno_id");

        // Insertar la nueva
        $sqlIns = "INSERT INTO credencial_vigencia
                       (alumno_id, fecha_emision, fecha_vencimiento, num_renovacion, activa)
                   VALUES
                       ($alumno_id, '$hoy', '$nuevoVenc', $next, 1)";
        Executor::doit($sqlIns);

        // Si había una revocación previa para la vigencia anterior, NO la borramos —
        // queda en histórico, pero la nueva extensión es una credencial nueva sin revocar.

        return [
            'fecha_vencimiento' => $nuevoVenc,
            'meses' => $meses,
            'num_renovacion' => $next,
        ];
    }

    /* ====================================================================
     * BLOQUE DETALLE POR ESTUDIANTE
     * ==================================================================== */

    /**
     * Toda la info del estudiante para la vista de detalle:
     * datos personales + carrera + ciclo + vigencia + status + historial.
     */
    public static function getDetalleAlumno($alumno_id) {
        $alumno_id = intval($alumno_id);

        $sql = "
            SELECT  p.id, p.code, p.curp, p.name, p.lastname, p.email,
                    p.f_nacimiento, p.foto, p.is_active, p.status_alumno,
                    p.name_periodo, p.periodo_as,
                    pr.name           AS carrera,
                    pr.grade          AS grado,
                    pr.nc             AS clave_carrera,
                    t.semestre        AS semestre,
                    t.letter          AS grupo_letra,
                    m.nombre          AS modalidad,
                    pe.name           AS ciclo,
                    pe.start_at       AS ciclo_inicio,
                    pe.finish_at      AS ciclo_fin
              FROM person p
              LEFT JOIN program     pr ON pr.id = p.carrera
              LEFT JOIN inscription i  ON i.alumn_id = p.id AND i.is_finished = 0
              LEFT JOIN team        t  ON t.id = i.team_id
              LEFT JOIN modalidad   m  ON m.id_modalidad = t.modalidad
              LEFT JOIN period      pe ON pe.id = i.period_id
             WHERE p.id = $alumno_id
             ORDER BY i.id DESC
             LIMIT 1
        ";
        $res = Executor::doit($sql);
        $row = Model::one($res[0], new stdClass());
        return $row;
    }
}
?>