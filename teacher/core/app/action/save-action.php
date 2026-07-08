<?php
$asignation = AsignationData::getById($_POST["asignation_id"]);
$alumn = PersonData::getById($_POST["alumn_id"]);
$blocks = BlockData::getAllbyAsignationId($asignation->id);
foreach($blocks as $b){
	$exist = CalificationData::getExist($alumn->id,$b->id);
	if($exist==null){
		// agregamos
		$c = new CalificationData();
		$c->val = $_POST["val-".$b->id];
		$c->alumn_id=$alumn->id;
		$c->block_id=$b->id;
		$c->add();
	}else{

		$exist->val = $_POST["val-".$b->id];
		$exist->update_val();
	}

}
Core::alert("Actualizado exitosamente!");
Core::redir("./?view=califications&alumn_id=$alumn->id&asignation_id=$asignation->id");
//print_r($_POST);

?>