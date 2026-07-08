<?php

$asignation = AsignationData::getById($_POST["asignation_id"]);
$asignation->teacher_id = $_POST["teacher_id"];
$asignation->asignature_id = $_POST["asignature_id"];
$asignation->asignature_type = $_POST["asignature_type"];
$asignation->update();
Core::alert("Actualizado exitosamente!");
Core::redir("./?view=teamasignatures&opt=all&id=$_POST[team_id]&period_id=$_POST[period_id]");

