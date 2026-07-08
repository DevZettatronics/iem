<?php if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
$sell =  new SellData();
$sell->alumn_id = $_POST["alumn_id"];
$sell->concept_id = $_POST["concept_id"];
$sell->add();

	}?>
