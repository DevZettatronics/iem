<?php

class PagosData

{

    public static $tablename = "pagos";

    public function PagosData()

    {

        $this->total = "";

        $this->date_created = "NOW()";

        $this->description = "";

        $this->name = "";

        $this->number_card = "";

        $this->tipo_pago = "";

        $this->email = "";

        $this->order_id = "";

        $this->matricula = "";

        $this->status = "";

    }

    public static function GetAll()

    {

        $sql = "SELECT * FROM " . self::$tablename . " ORDER BY date_created DESC";

        $query = Executor::doit($sql);

        return Model::many($query[0], new PagosData());

    }



   public static function GetPagoByIdPerson($idPerson)
    {
        /** traer el pago x alumno  */
        $sql = "SELECT p.*, pr.product_name 
                FROM " . self::$tablename . " p
                LEFT JOIN products pr ON pr.product_id = p.description
                WHERE p.idPerson = '$idPerson'
                ORDER BY p.date_created DESC";

        $query = Executor::doit($sql);
        return Model::many($query[0], new PagosData());
    }




    public static function insertPago($data)

    {
        // 1. Obtener la conexión activa a la base de datos (mysqli)
        $conn = Database::getCon(); // conexión mysqli

        try {
            // 2. Iniciar una transacción. A partir de aquí, los cambios se "guardan" temporalmente
            $conn->begin_transaction();

             // 3. Crear el SQL para insertar un nuevo pago
            $sql = "INSERT INTO " . self::$tablename . " 
            (total, date_created, description, name, number_card, tipo_pago, email, idPerson, status, id_plan)
            VALUES (
                '{$data->total}', 
                NOW(), 
                '{$data->description}', 
                '{$data->name}', 
                '{$data->number_card}', 
                'LINEA', 
                '{$data->email}', 
                '{$data->idPerson}', 
                1, 
                '{$data->planp}'
            )";

               // 4. Si el modo debug está activado, imprime la consulta SQL (esto ayuda a depurar)
                if (Core::$debug_sql) {
                    echo "<pre>$sql</pre>";
                }
        
                // 5. Ejecutar la consulta en la base de datos
                $result = $conn->query($sql);
        
                // 6. Verificar si ocurrió un error al ejecutar la consulta
                if (!$result) {
                    throw new Exception("Error al ejecutar SQL: " . $conn->error);
                }
        
                 // Simulamos un error
                // throw new Exception("Error forzado de prueba en la base de datos.");
    
                // 7. Obtener el ID del registro recién insertado
                $lastInsertId = $conn->insert_id;
        
                // 8. Confirmar la transacción (aquí es cuando se guarda realmente en la BD)
                $conn->commit();
        
                // 9. Retornar el ID del pago insertado
                return $lastInsertId;
        } catch (Exception $e) {
             // 10. Si algo falló, hacer rollback (reversar la transacción)
            $conn->rollback();
             // 11. Guardar el error en el log del servidor
            error_log("Transacción fallida en insertPago: " . $e->getMessage());
             // 12. Retornar false para indicar que falló
            return false;
        }
        // $sql = "INSERT INTO " . self::$tablename . " (total,date_created,description,name,number_card,tipo_pago,email,order_id,idPerson,status,id_plan) VALUES ('$data->total',NOW(),'$data->description','$data->name','$data->number_card','LINEA','$data->email','$data->order_id','$data->idPerson',1,'$data->planp')";

        // $query = Executor::doit($sql);

        // return $query[1];

    }

    public static function updateOrderNumber($paymentId, $orderId)
    {
        // Obtener la conexión a la base de datos
        $conn = Database::getCon();

        try {
            // Iniciar transacción
            $conn->begin_transaction();

            // 1. Preparar la consulta SQL para actualizar el pago con el número de orden
            $sql = "UPDATE " . self::$tablename . " 
                    SET order_id = '{$orderId}' 
                    WHERE id = '{$paymentId}'";

            // 2. Ejecutar la consulta
            $result = $conn->query($sql);

            // 3. Verificar si la consulta fue exitosa
            if (!$result) {
                throw new Exception("Error al actualizar el número de orden: " . $conn->error);
            }

            // Simulamos un error
            // throw new Exception("Error forzado de prueba en la base de datos .");

            // 8. Confirmar la transacción (aquí es cuando se guarda realmente en la BD)
            $conn->commit();

            // 4. Retornar verdadero si la actualización fue exitosa
            return true;
        } catch (Exception $e) {
            // Si ocurre algún error, hacer rollback
            $conn->rollBack();
            error_log("Error en la actualización de la orden: " . $e->getMessage());
            
            // El registro fue eliminado, no es necesario volver a eliminarlo
            return false;
        }
    }

    public static function deleteRegister($paymentId)
    {
        // Obtener la conexión a la base de datos
        $conn = Database::getCon();

        try {
            // Iniciar transacción
            $conn->begin_transaction();

            // 1. Preparar la consulta SQL para actualizar el pago con el número de orden
            $sql = "DELETE FROM " . self::$tablename . " WHERE id = '{$paymentId}'";

            // 2. Ejecutar la consulta
            $result = $conn->query($sql);

            // 3. Verificar si la consulta fue exitosa
            if (!$result) {
                throw new Exception("Error al eliminar el registro: " . $conn->error);
            }

            // Simulamos un error
            // throw new Exception("Error forzado de prueba en la base de datos .");

            // 8. Confirmar la transacción (aquí es cuando se guarda realmente en la BD)
            $conn->commit();

            // 4. Retornar verdadero si la actualización fue exitosa
            return true;
        } catch (Exception $e) {
            // Si ocurre algún error, hacer rollback
            $conn->rollBack();
            error_log("Error en la eliminar el registro: " . $e->getMessage());
            
            // El registro fue eliminado, no es necesario volver a eliminarlo
            return false;
        }
    }
}

