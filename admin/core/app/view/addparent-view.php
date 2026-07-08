<?php

if(count($_POST)>0){
	$user = new ParentData();
	$user->code = $_POST["code"];
	$user->password = sha1(md5($_POST["password"]));
	$user->name = $_POST["name"];
	$user->lastname = $_POST["lastname"];
	$user->address = $_POST["address"];
	$user->email = $_POST["email"];
	$user->phone = $_POST["phone"];




	$u = $user->add();


print "<script>window.location='index.php?view=parents';</script>";


}


?>