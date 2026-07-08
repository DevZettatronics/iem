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

	$arrayCalificaciones = []; //ARRAY VACIO PARA METER LAS CALIFICACIONES (TODAS SUMADAS)


	foreach ($bloquesPadre as $bPadre) { //ITERAMOS EL LOS BLOQUES PADRES -
		$sumaBloquesPadre = CalificationData::calificacionesL($a->alumn_id, $bPadre->BloquePadre);
		foreach ($sumaBloquesPadre as $sumBP) {
			array_push($arrayCalificaciones, $sumBP->val); //LLENAMOS EL ARRAY -> $arrayCalificaciones
		}
	}
$promedioFinal = in_array('NP', $arrayCalificaciones) ? 'NP' : (count(array_diff($arrayCalificaciones, ['AC'])) > 0 ? 'NA' : 'AC');
// 	$promedioFinal = count(array_diff($arrayCalificaciones, ['AC'])) > 0 ? 'NA' : 'AC';

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
Core::redir("./?view=editcalificationsL&id=$asignation->id");
