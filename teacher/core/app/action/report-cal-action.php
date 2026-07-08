<?php
//include "../admin/core/app/model/PersonData.php";
include "../admin/core/app/model/PersonData.php";
include "../admin/core/app/model/CalificationData.php";
include "../admin/core/app/model/AsignatureData.php";
$asignation = AsignationData::getById($_GET["id"]);
$team = TeamData::getById($asignation->team_id);
$alumns = InscriptionData::getAllByTeamId($asignation->team_id);
$blocks = BlockData::getAllByAsignationId($_GET["id"]);
//print_r($alumns);
require_once '../admin/lib/PhpWord/Autoloader.php';
use PhpOffice\PhpWord\Autoloader;
use PhpOffice\PhpWord\Settings;

Autoloader::register();

$word = new  PhpOffice\PhpWord\PhpWord();

$section1 = $word->AddSection();
$section1->addText("CALIFICACIONES [".$asignation->getAsignature()->name."]: ".strtoupper($team->grade." -".$team->letter),array("size"=>22,"bold"=>true,"align"=>"right"));


$styleTable = array('borderSize' => 6, 'borderColor' => '888888', 'cellMargin' => 40);
$styleFirstRow = array('borderBottomColor' => '0000FF', 'bgColor' => 'AAAAAA');

$table1 = $section1->addTable("table1");
$table1->addRow();
$table1->addCell()->addText("Nombre Completo");
foreach ($blocks as $block) {
$table1->addCell()->addText($block->name);
}
foreach($alumns as $al){
$alumn = $al->getAlumn();
//print_r($alumn);
$table1->addRow();
$table1->addCell(5000)->addText($alumn->name." ".$alumn->lastname);

foreach ($blocks as $block) {
$exist = CalificationData::getExist($alumn->id,$block->id);

if($exist!=null){$table1->addCell()->addText($exist->val);}else{ $table1->addCell()->addText("");}

}
}
$word->addTableStyle('table1', $styleTable,$styleFirstRow);
/// datos bancarios
$section1->addText("");
$section1->addText("");
$section1->addText("");
$section1->addText("Generado por Xoolar Max v2.0");

$filename = "califications-".time().".docx";
#$word->setReadDataOnly(true);
$word->save($filename,"Word2007");
//chmod($filename,0444);
header("Content-Disposition: attachment; filename=$filename");
readfile($filename); // or echo file_get_contents($filename);
unlink($filename);  // remove temp file



?>