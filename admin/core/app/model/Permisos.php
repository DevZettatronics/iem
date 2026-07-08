<?php
class Permisos {

    public static function usuarioTieneModulo($id_rol, $clave_modulo) {
        $sql = "SELECT COUNT(*) as total
                FROM permisos_roles pr
                JOIN modulos m ON pr.id_modulo = m.id_modulo
                WHERE pr.id_rol = $id_rol 
                AND m.clave = '$clave_modulo' 
                AND pr.puede_ver = 1";
                
        $res = Executor::doit($sql);
        $row = Model::one($res[0], new stdClass());
        return $row->total > 0;
    }

    public static function puede($id_rol, $clave_modulo, $accion) {
        $columna = '';
        switch ($accion) {
            case 'crear':
                $columna = 'puede_crear';
                break;
            case 'editar':
                $columna = 'puede_editar';
                break;
            case 'eliminar':
                $columna = 'puede_eliminar';
                break;
            default:
                return false;
        }

        $sql = "SELECT $columna
                FROM permisos_roles pr
                JOIN modulos m ON pr.id_modulo = m.id_modulo
                WHERE pr.id_rol = $id_rol AND m.clave = '$clave_modulo'";
        
        $res = Executor::doit($sql);
        $row = Model::one($res[0], new stdClass());
        return $row->$columna == 1;
    }

    //Esto ba en los booten pero por lemomento lo dejamos aqui
    // if (Permisos::puede(Core::$user->kind, 'ciclos_escolares', 'crear')):
    //     <a href="./?view=inscription" class="btn btn-success">Nueva Inscripción</a>
    //  endif; 

    public static function allpermisos($id_rol){
        $id_rol = intval($id_rol);

        $queryall = "SELECT pr.*, modu.nombre, modu.es_padre
                    FROM permisos_roles pr
                    INNER JOIN modulos modu ON pr.id_modulo = modu.id_modulo
                    WHERE pr.id_rol = $id_rol
                    ORDER BY modu.es_padre DESC, modu.nombre ASC";

        // echo "<pre>Consulta SQL: $queryall</pre>"; // Muestra la consulta

        $query = Executor::doit($queryall);

        if (!is_array($query) || empty($query) || !isset($query[0]) || $query[0] === false) {
            $con = Database::getCon();
            die("Error en la consulta SQL: " . $con->error . "<br>Consulta: " . $queryall);
        }

        return Model::many($query[0], new stdClass());
    }

    public static function allRoles (){
        $query = "SELECT * FROM roles";
        $res = Executor::doit($query);
        return Model::many($res[0], new stdClass());
    }


    public static function updateOrInsertPermiso($rol_id, $id_permiso, $puede_ver, $puede_crear, $puede_editar, $puede_eliminar) {
        $sql = "SELECT * FROM permisos_roles WHERE id_rol = $rol_id AND id_permiso = $id_permiso";
        list($res,) = Executor::doit($sql); // resultado está en el primer índice

        if (!$res) {
            echo "❌ Error en la consulta SQL: " . Database::getCon()->error;
            return;
        }

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();

            // Forzar valores a enteros para comparación estricta y evitar confusión con NULL
            $bd_puede_ver = (int)$row['puede_ver'];
            $bd_puede_crear = (int)$row['puede_crear'];
            $bd_puede_editar = (int)$row['puede_editar'];
            $bd_puede_eliminar = (int)$row['puede_eliminar'];

            // Mostrar valores para depuración
            // var_dump([
            //     'Valores en BD' => [
            //         'puede_ver' => $bd_puede_ver,
            //         'puede_crear' => $bd_puede_crear,
            //         'puede_editar' => $bd_puede_editar,
            //         'puede_eliminar' => $bd_puede_eliminar,
            //     ],
            //     'Valores recibidos' => [
            //         'puede_ver' => $puede_ver,
            //         'puede_crear' => $puede_crear,
            //         'puede_editar' => $puede_editar,
            //         'puede_eliminar' => $puede_eliminar,
            //     ]
            // ]);

            if (
                $bd_puede_ver !== $puede_ver ||
                $bd_puede_crear !== $puede_crear ||
                $bd_puede_editar !== $puede_editar ||
                $bd_puede_eliminar !== $puede_eliminar
            ) {
                $update = "UPDATE permisos_roles SET 
                    puede_ver = $puede_ver, 
                    puede_crear = $puede_crear, 
                    puede_editar = $puede_editar, 
                    puede_eliminar = $puede_eliminar
                    WHERE id_rol = $rol_id AND id_permiso = $id_permiso";
                Executor::doit($update);
                // list($updateRes,) = Executor::doit($update);

                // if ($updateRes && Database::getCon()->affected_rows > 0) {
                //     echo "✅ Permiso actualizado correctamente.<br>";
                // } elseif ($updateRes) {
                //     echo "⚠️ No se modificó ninguna fila (quizás los valores eran iguales).<br>";
                // } else {
                //     echo "❌ Error al actualizar permiso: " . Database::getCon()->error . "<br>";
                // }
            } 
            // else {
            //     echo "🔹 Permiso ya estaba configurado con esos valores. No se actualizó.<br>";
            // }
        } else {
            $insert = "INSERT INTO permisos_roles (id_permiso, id_rol, puede_ver, puede_crear, puede_editar, puede_eliminar)
                VALUES ($id_permiso, $rol_id, $puede_ver, $puede_crear, $puede_editar, $puede_eliminar)";
            Executor::doit($insert);
            // list($insertRes,) = Executor::doit($insert);

            // if ($insertRes) {
            //     echo "✅ Permiso insertado correctamente.<br>";
            // } else {
            //     echo "❌ Error al insertar permiso: " . Database::getCon()->error . "<br>";
            // }
        }
    }

    public static function nombreRoles($rol_id) {
        $rol_id = (int)$rol_id; // Cast seguro
        $sql = "SELECT nombre_rol FROM roles WHERE id_rol = $rol_id";
        $res = Executor::doit($sql);
        
        if ($res && $res[0]->num_rows > 0) {
            $row = Model::one($res[0], new stdClass());
            return $row->nombre_rol; // devuelve directamente el nombre
        }

        return null; // o puedes lanzar una excepción si prefieres
    }
    
    public static function delRoles($id) {
        $conn = Database::getCon(); // conexión mysqli

        $conn->begin_transaction();

        try {
            // 1. Eliminar de permisos_roles primero
            $stmt1 = mysqli_prepare($conn, "DELETE FROM permisos_roles WHERE id_rol = ?");
            if (!$stmt1) {
                throw new Exception("Error al preparar la consulta permisos_roles");
            }

            mysqli_stmt_bind_param($stmt1, "i", $id);
            if (!mysqli_stmt_execute($stmt1)) {
                throw new Exception("Error al ejecutar la consulta permisos_roles: " . mysqli_error($conn));
            }

            // 2. Luego eliminar de roles
            $stmt2 = mysqli_prepare($conn, "DELETE FROM roles WHERE id_rol = ?");
            if (!$stmt2) {
                throw new Exception("Error al preparar la consulta roles");
            }

            mysqli_stmt_bind_param($stmt2, "i", $id);
            if (!mysqli_stmt_execute($stmt2)) {
                throw new Exception("Error al ejecutar la consulta roles: " . mysqli_error($conn));
            }

            // Commit si todo va bien
            mysqli_commit($conn);
            return true;

        } catch (Exception $e) {
            mysqli_rollback($conn);
            error_log("Error al eliminar rol: " . $e->getMessage());
            return false;
        }
    }


    public static function SelectKind($id) {
        $sql = "SELECT kind FROM user WHERE id = $id";               // Correcto (a nivel funcional)
        $res = Executor::doit($sql);                                 // Ejecutas la consulta
        return $row = Model::one($res[0], new stdClass());           // Extraes y devuelves un objeto con el campo 'kind'
    }


    public static function insertRol($nameRol) {
        
        //Iniciamos transaccion
        $conn = Database::getCon(); // conexión mysqli

        $conn->begin_transaction();

        try {
            $sql = mysqli_prepare($conn,"INSERT INTO roles (nombre_rol) VALUES (?)");
            if (!$sql) {
                    throw new Exception("Error al preparar la consulta roles");
            }

            mysqli_stmt_bind_param($sql,"s",$nameRol);
            if (!mysqli_stmt_execute($sql)) {
                    throw new Exception("Error al ejecutar la consulta roles: " . mysqli_error($conn));
            }

            // Obtenemos el ID del nuevo rol insertado
            $newRolId = $conn->insert_id;

            //Obtenemos todos los id_modulo de los modulos
            $query1 = "SELECT id_modulo FROM modulos";
            $res = mysqli_query($conn, $query1);
            
            //Recorremos los datos id_modulo
            while ($r = mysqli_fetch_assoc($res)) {
                $id_modulo = $r['id_modulo'];

                //Insertamos cada mopdulo con los permisos iniciales 
                $query2 = mysqli_prepare($conn,"INSERT INTO permisos_roles (id_rol ,
                                                                            id_modulo ,
                                                                            puede_ver ,
                                                                            puede_crear ,
                                                                            puede_editar ,
                                                                            puede_eliminar ) 
                                                VALUES (?,?,?,?,?,?)");
                if (!$query2) {
                    throw new Exception("Error al preparar la consulta permisos_roles");
                }

                $puede_ver = 0;
                $puede_crear = 0;
                $puede_editar = 0;
                $puede_eliminar = 0;
                mysqli_stmt_bind_param($query2,"iiiiii",$newRolId,$id_modulo,$puede_ver,$puede_crear,$puede_editar,$puede_eliminar);
                if (!mysqli_stmt_execute($query2)) {
                    throw new Exception("Error al ejecutar la consulta permisos_roles: " . mysqli_error($conn));
                }


            }
            
            // Commit si todo va bien
            mysqli_commit($conn);
            return [
                "success" => true,
                "message" => "Rol creado exitosamente"
            ];

        } catch (Exception $e) {
            mysqli_rollback($conn);
            error_log("Error al insertar rol: " . $e->getMessage());
            return [
                "success" => false,
                "message" => "Error al crear el rol",
                "error" => $e->getMessage()
            ];
        }
        
    }
}
?>
