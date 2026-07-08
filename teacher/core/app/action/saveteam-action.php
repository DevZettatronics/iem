<?php
$asignation = AsignationData::getById($_POST["asignation_id"]);
//$alumn = AlumnData::getById($_POST["alumn_id"]);
$alumns = InscriptionData::getAllByTP($asignation->team_id,$asignation->period_id);
$blocks = BlockData::getAllbyAsignationId($asignation->id);
foreach($alumns as $alumnx){
$alumn = $alumnx->getAlumn();
foreach($blocks as $b){
	$exist = CalificationData::getExist($alumn->id,$b->id);
	if($exist==null){
		// agregamos
		$c = new CalificationData();
		$c->val = $_POST["val-".$alumn->id."-".$b->id];
		$c->alumn_id=$alumn->id;
		$c->block_id=$b->id;
		$c->add();
	}else{

		$exist->val = $_POST["val-".$alumn->id."-".$b->id];
		$exist->update_val();
	}

}
}
//Core::alert("Actualizado exitosamente!");
//Core::redir("./?view=teamcalifications&id=$asignation->id");
//print_r($_POST);

?>