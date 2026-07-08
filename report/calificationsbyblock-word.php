<?php
include "../admin/core/autoload.php";
include "../admin/core/app/model/AsignationData.php";
include "../admin/core/app/model/PeriodData.php";
include "../admin/core/app/model/InscriptionData.php";
include "../admin/core/app/model/PersonData.php";

include "../admin/core/app/model/TeamData.php";
include "../admin/core/app/model/AlumnTeamData.php";
include "../admin/core/app/model/AlumnData.php";
include "../admin/core/app/model/BlockData.php";
include "../admin/core/app/model/CalificationData.php";
include "../admin/core/app/model/AsignatureData.php";

require_once '../admin/lib/PhpWord/Autoloader.php';
use PhpOffice\PhpWord\Autoloader;
use PhpOffice\PhpWord\Settings;

Autoloader::register();




///////////////
$block = BlockData::getById($_GET["bid"]);
$asignation = AsignationData::getById($_GET["id"]);
$period = PeriodData::getById($asignation->period_id);
$team = TeamData::getById($asignation->team_id);
$alumns = InscriptionData::getAllByTP($team->id,$period->id);
$blocks = BlockData::getAllByBlockId($block->id);
$asinature = AsignatureData::getById($asignation->asignature_id);
///////////////

$word = new  PhpOffice\PhpWord\PhpWord();
//$blocks = BlockData::getAllByTeamId($_GET["team_id"]);
//$team =  TeamData::getById($_GET["team_id"]);
//$alumns = AlumnTeamData::getAllByTeamId($_GET["team_id"]);

$section1 = $word->AddSection();
$section1->addText("Acta de Calificaciones Oficial");
$section1->addText("$asinature->name - ".strtoupper($team->grade." - ".$team->letter),array("size"=>12,"bold"=>true,"align"=>"center"));


$styleTable = array('borderSize' => 6, 'borderColor' => '888888', 'cellMargin' => 40);
$styleFirstRow = array('borderBottomColor' => '0000FF', 'bgColor' => 'AAAAAA');

$table1 = $section1->addTable("table1");
$table1->addRow();
$table1->addCell()->addText("Nombre del Estudiante");
      $promedio = 0;
      $c=0;

/*foreach ($blocks as $block) {
$table1->addCell()->addText($block->name);
}*/
$table1->addCell()->addText("Calificación Definitiva");

foreach($alumns as $al){
$alumn = $al->getAlumn();
$table1->addRow();
$table1->addCell(5000)->addText($alumn->name." ".$alumn->lastname);

$total = 0;
$n=0;

foreach ($blocks as $block) {
$val = CalificationData::getExist($alumn->id, $block->id);
$v = "";
if($val!=null){ $v = $val->val; }
	
$table1->addCell()->addText($v);
$total+=$v;
$n++;
}
/*if($n>0){
$table1->addCell()->addText($total/$n);

}*/


}

$word->addTableStyle('table1', $styleTable,$styleFirstRow);
/// datos bancarios
$section1->addText("");
$section1->addText("");
$section1->addText("");
$section1->addText("Generado por Universidad Gestalt Viserio v3.0");

$filename = "calificationsbyblock-".time().".docx";
#$word->setReadDataOnly(true);
$word->save($filename,"Word2007");
//chmod($filename,0444);
header("Content-Disposition: attachment; filename=$filename");
readfile($filename); // or echo file_get_contents($filename);
unlink($filename);  // remove temp file



?>