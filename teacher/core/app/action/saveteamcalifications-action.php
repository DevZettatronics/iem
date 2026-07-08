<?php
$asignation = AsignationData::getById($_POST["asignation_id"]);
//$alumn = AlumnData::getById($_POST["alumn_id"]);
$alumns = InscriptionData::getAllByTP($asignation->team_id, $asignation->period_id);
$blocks = BlockData::getAllByAsignationId($asignation->id);

$block_id = [];
foreach ($blocks as $bs) {
	$datos = array_push($block_id, $bs->id . ',');
}
$prs = implode($block_id);
$inId = substr($prs, 0, -1);


foreach ($alumns as $alumnx) {
	$alumn = $alumnx->getAlumn();
	foreach ($blocks as $b) {
		if (isset($_POST["val-" . $alumn->id . "-" . $b->id])) {
			$calificacion = $_POST["val-" . $alumn->id . "-" . $b->id];
			$exist = CalificationData::getExist($alumn->id, $b->id);
			if ($exist == null) {
				// agregamos
				$c = new CalificationData();
				$c->val = $calificacion;
				$c->alumn_id = $alumn->id;
				$c->block_id = $b->id;
				$c->block_id_father = $b->block_id;
				$c->add();
			} else {
				$exist->val = $calificacion;
				$exist->block_id_father = $b->block_id;
				$exist->update_val();
			}
		}
	}
}

sleep(2);

/**INSERTAR || ACTUALIZAR CALIFICACION FINAL */

foreach ($alumns as $a) { // ITERAMOS LOS ALUMNOS
	$nB = CalificationData::numeroBloques($a->alumn_id, $inId);
	$bloquesPadre = CalificationData::numeroDeBloquesPadre($a->alumn_id, $inId);

	$numeroDeBloquesPadre = count($bloquesPadre); //NUMERO DE BLOQUES PADRES DE LAS CALIFICACIONES
	$arrayCalificaciones = []; //ARRAY VACIO PARA METER LAS CALIFICACIONES (TODAS SUMADAS)
	$bloquesHijos = []; //ARRAY VACIO PARA METER LOS BLOQUES HIJOS DE LOS BLOQUES PADRES
	$calificacionFinalXBloque = []; //ARRAY VACIO PARA METER LAS CALIFICACIONES PREVIAS A PROMEDIAR

	foreach ($bloquesPadre as $bPadre) { //ITERAMOS EL LOS BLOQUES PADRES -
		////MANDAMOS A LLAMAR LA SUMA DE CALIFICACIONES DE LOS BLOQUES PADRES(GLOBALES)
		$sumaBloquesPadre = CalificationData::sumaBloquesPadre($a->alumn_id, $bPadre->BloquePadre);
		////MANDAMOS A LLAMAR EL NUMERO DE BLOQUES HIJOS X CADA BLOQUE PADRE (LO QUE ITERAMOS)
		$numeroHijosxBloque = CalificationData::numeroHijosxBloque($a->alumn_id, $bPadre->BloquePadre);
		/**
		 * 	LLENAMOS LOS DOS ARRAYS VACIOS,  
		 * 	EL PRIMERO CON LA SUMA DE LAS CALIFICACIONES POR BLOQUE
		 * 	EL SEGUNDO CON NUMERO DE BLOQUES HIJOS
		 */
		array_push($arrayCalificaciones, $sumaBloquesPadre->SumaDeBloque); //LLENAMOS EL ARRAY -> $arrayCalificaciones
		array_push($bloquesHijos, $numeroHijosxBloque->hijosDelBloque); //LLENAMOS EL ARRAY ->  $bloquesHijos
	}

	foreach ($arrayCalificaciones as $key => $value) { // ITERAMOS EL ARRAY DE CALIFICACIONES, SACANDO SU KEY Y EL VALOR DE CADA KEY
		$calificacionXBloque =  $value / $bloquesHijos[$key]; //HACEMOS LA OPERACION DE LA CALIFICACION PREVIA FINAL ENTRE EL NUMERO DE BLOQUES HIJOS
		array_push($calificacionFinalXBloque, $calificacionXBloque); //LLENAMOS EL ARRAY -> $calificacionFinalXBloque
	}

	$calificacionPacialFinal = array_sum($calificacionFinalXBloque); //SUMA DE LAS CALIFICACIONES X BLOQUE PADRE
	$promedioFinal = round($calificacionPacialFinal / $numeroDeBloquesPadre); //OPERACION DE DIVISION DE LA SUMA DE LAS CALIFICACIONES ENTRE EL NUMERO DE BLOQUES PADRE

	$existCalificacionF = CalificationFinalData::getExist($a->alumn_id, $_POST["asignation_id"]); //INSTANCIAMOS LA CLASE CalificationFinalData CON SU FUNCION PARA COMPROBAR QUE NO HAYA CALIFICACIONES 

	if ($existCalificacionF->existe == 0) { // SI AUN NO HAY CALIFICACION FINAL SE INSERTA 
		$cF = new CalificationFinalData();
		$cF->asignation_id = $_POST["asignation_id"];
		$cF->alumn_id = $a->alumn_id;
		$cF->calificacion = $promedioFinal;
		$cF->add();
	} else { // SI YA EXISTEN CALIFICACIONES ENTONCES AHORA SOLO ACTUALIZAMOS
		CalificationFinalData::update_val($a->alumn_id, $_POST["asignation_id"], $promedioFinal);
	}
}

Core::alert("Actualizado exitosamente!");
Core::redir("./?view=teamcalifications&id=$asignation->id");
