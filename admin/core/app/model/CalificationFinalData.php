<?php
class CalificationFinalData
{
	public static $tablename = "calificaciones_finales";
	public $calificacion;  // Definimos la propiedad para calificacion
    public $observaciones; // Definimos la propiedad para observaciones


	public function CalificationFinalData()
	{
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->password = "";
		$this->created_at = "NOW()";
	}

	public function add()
	{
		$sql = "insert into " . self::$tablename . " (asignation_id,person_id,calificacion,date_add) ";
		$sql .= "value (\"$this->asignation_id\",\"$this->alumn_id\",\"$this->calificacion\",NOW())";
		return Executor::doit($sql);
	}

	public static function getExist($person_id, $asignation_id)
	{
		$sql = "select count(*) as existe from " . self::$tablename . " where person_id = $person_id and asignation_id = $asignation_id ";
		$query = Executor::doit($sql);
		return Model::one($query[0], new CalificationFinalData());
	}

	public static function promedioFinal($person_id, $asignation_id)
	{
		$sql = "SELECT * FROM " . self::$tablename . " WHERE person_id = $person_id AND asignation_id = $asignation_id ";
		$query = Executor::doit($sql);
		return Model::one($query[0], new CalificationFinalData());
	}

	public static function update_val($person_id, $asignation_id, $calificacion, $observacion )
	{
		try {
			// Si $calificacion y $observacion son arrays, los convertimos a cadenas separadas por coma
			if (is_array($calificacion)) {
				// Si es un array, solo tomamos el valor correspondiente al ID
				$calificacion = isset($calificacion[$person_id]) ? $calificacion[$person_id] : '';
			}
	
			if (is_array($observacion)) {
				// Si es un array, solo tomamos el valor correspondiente al ID
				$observacion = isset($observacion[$person_id]) ? $observacion[$person_id] : '';
			}
	
			// Escapar las variables para prevenir inyecciones SQL
			$calificacion = addslashes($calificacion); 
			$observacion = addslashes($observacion); 
	
			// Crear la consulta SQL
			$sql = "UPDATE " . self::$tablename . " SET calificacion=\"$calificacion\", observaciones=\"$observacion\" WHERE person_id = $person_id AND asignation_id = $asignation_id";
	
			// Ejecutar la consulta
			$query = Executor::doit($sql);
	
			// Verificar si la consulta fue exitosa
			if ($query) {
				// Retorna un mensaje de éxito si la consulta fue exitosa
				return "Actualización exitosa de la calificación y observación.";
			} else {
				// Retorna un mensaje de error si no se actualizó ninguna fila
				return "No se realizó ninguna actualización. Verifica los datos.";
			}
		} catch (Exception $e) {
			error_log($e->getMessage());
			// Captura cualquier error y muestra el mensaje
			return "Error al actualizar la calificación: " . $e->getMessage();
		}
	}


	public static function getObservation($person_id, $asignation_id)
	{
		$sql = "SELECT calificacion,observaciones FROM " . self::$tablename . " WHERE person_id = $person_id AND asignation_id = $asignation_id ";
		$query = Executor::doit($sql);
		return Model::one($query[0], new CalificationFinalData());
	}

}
