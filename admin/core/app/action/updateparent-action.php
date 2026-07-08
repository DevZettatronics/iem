<?php

if(count($_POST)>0){
	$user = ParentData::getById($_POST["alumn_id"]);
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


?>