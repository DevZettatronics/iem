<?php

if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	$a = new PaymentData();
	$a->alumn_id = $_POST["alumn_id"];
	$a->concept_id = $_POST["concept_id"];
	$a->limit_at = $_POST["limit_at"];
	$a->comment_before = $_POST["comment_before"];
	$a->status = $_POST["status"];
	$c = ConceptData::getById($_POST["concept_id"]);
	print_r($c);
	$a->price= $c->price;
	$a->add();
	Core::redir("./?view=payments&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="addconcept"){
	$a = new ConceptData();
	$a->name = $_POST["name"];
	$a->price = $_POST["price"];
	$a->add();
	Core::redir("./?view=payments&opt=concepts");
}

else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
	$a = PaymentData::getById($_POST["id"]);
	$a->name = $_POST["name"];
	$a->update();
	Core::redir("./?view=payments&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="updateconcept"){
	$a = ConceptData::getById($_POST["id"]);
	$a->name = $_POST["name"];
	$a->price = $_POST["price"];
	$a->update();
	Core::redir("./?view=payments&opt=concepts");
}

else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$a = PaymentData::getById($_GET["id"]);
	$a->del();
	Core::redir("./?view=payments&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="pay"){
	$a = PaymentData::getById($_GET["id"]);
	$a->pay();
	Core::redir("./?view=payments&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="delconcept"){
	$a = ConceptData::getById($_GET["id"]);
	$a->del();
	Core::redir("./?view=payments&opt=concepts");
}
?>