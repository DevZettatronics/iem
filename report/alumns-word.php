<?php
$debug= true;
if($debug){
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
}
include "../admin/core/autoload.php";
include "../admin/core/dapp/model/AlumnData.php";
include "../admin/core/dapp/model/TeamData.php";
include "../admin/core/dapp/model/PeriodData.php";
include "../admin/core/dapp/model/InscriptionData.php";

require_once '../lib/PhpWord/Autoloader.php';
use PhpOffice\PhpWord\Autoloader;
use PhpOffice\PhpWord\Settings;

Autoloader::register();

$word = new  PhpOffice\PhpWord\PhpWord();
$clients = AlumnData::getAll();
$team = TeamData::getById($_GET["id"]);
$period = PeriodData::getById($_GET["period_id"]);

$alumns = InscriptionData::getAllByTP($_GET["id"],$_GET["period_id"]);

$section1 = $word->AddSection();
$section1->addText("ALUMNOS",array("size"=>22,"bold"=>true,"align"=>"right"));
$section1->addText("Periodo: $period->name",array("size"=>22,"bold"=>true,"align"=>"right"));
$section1->addText("Grupo: $team->grade - $team->letter",array("size"=>22,"bold"=>true,"align"=>"right"));


$styleTable = array('borderSize' => 6, 'borderColor' => '888888', 'cellMargin' => 40);
$styleFirstRow = array('borderBottomColor' => '0000FF', 'bgColor' => 'AAAAAA');

$table1 = $section1->addTable("table1");
$table1->addRow();
$table1->addCell()->addText("Nombre");
$table1->addCell()->addText("");
$table1->addCell()->addText("");
$table1->addCell()->addText("");
foreach($alumns as $alumnx){
$alumn = $alumnx->getAlumn();
$table1->addRow();
$table1->addCell(5000)->addText($alumn->name." ".$alumn->lastname);
$table1->addCell(2500)->addText("");
$table1->addCell(2000)->addText("");
$table1->addCell(2000)->addText("");

}

$word->addTableStyle('table1', $styleTable,$styleFirstRow);
/// datos bancarios

$filename = "alumns-".time().".docx";
#$word->setReadDataOnly(true);
$word->save($filename,"Word2007");
//chmod($filename,0444);
header("Content-Disposition: attachment; filename='$filename'");
readfile($filename); // or echo file_get_contents($filename);
unlink($filename);  // remove temp file



?>