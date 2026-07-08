<?php

if(count($_POST)>0){
	$user = new AlumnData();
	$user->parent_id = $_POST["parent_id"];
	$user->code = $_POST["code"];
	$user->password = sha1(md5($_POST["password"]));
	$user->name = $_POST["name"];
	$user->lastname = $_POST["lastname"];
	$user->address = $_POST["address"];
	$user->email = $_POST["email"];
	$user->phone = $_POST["phone"];

	$user->c1_code = $_POST["c1_code"];
	$user->c1_password = sha1(md5($_POST["c1_password"]));
	$user->c1_fullname = $_POST["c1_fullname"];
	$user->c1_address = $_POST["c1_address"];
	$user->c1_phone = $_POST["c1_phone"];
	$user->c1_note = $_POST["c1_note"];



	$u = $user->add();


print "<script>window.location='index.php?view=alumns';</script>";


}


?>