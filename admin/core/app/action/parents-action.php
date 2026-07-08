<?php

if($_GET["opt"] && $_GET["opt"]=="add"){
if(count($_POST)>0){
	$user = new PersonData();
	$user->code = $_POST["code"];
	$user->password = sha1(md5($_POST["password"]));
	$user->name = $_POST["name"];
	$user->lastname = $_POST["lastname"];
	$user->address = $_POST["address"];
	$user->email = $_POST["email"];
	$user->phone = $_POST["phone"];
	$user->kind=2;
	$u = $user->add();
	print "<script>window.location='index.php?view=parents';</script>";
}
}
if($_GET["opt"] && $_GET["opt"]=="upd"){

if(count($_POST)>0){
	$user = PersonData::getById($_POST["alumn_id"]);
	$user->name = $_POST["name"];
	$user->lastname = $_POST["lastname"];
	$user->address = $_POST["address"];
	$user->email = $_POST["email"];
	$user->phone = $_POST["phone"];


	$user->user_id = $_SESSION["user_id"];


	$u = $user->update();
Core::alert("Actualizado Exitosamente!");
print "<script>window.location='index.php?view=parents';</script>";


}
}
if($_GET["opt"] && $_GET["opt"]=="del"){

$alumn = PersonData::getById($_GET["id"]);
$alumn->del();

Core::redir("./?view=parents");
}

?>

