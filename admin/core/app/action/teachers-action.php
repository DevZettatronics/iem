<?php

/******REGISTRO DE FOTOGRAFIA*****/
//include("actionn/class.upload.php");

use  Verot\Upload\Upload;

$url = "storage/data/" . $_SESSION["user_id"];

if ($_GET["opt"] && $_GET["opt"] == "add") {
	if (count($_POST) > 0) {
		$user = new PersonData();
		$user->code = $_POST["code"];
		$user->password = sha1(md5($_POST["password"]));
		$user->name = $_POST["name"];
		$user->lastname = $_POST["lastname"];
		$user->address = $_POST["address"];
		$user->email = $_POST["email"];
		$user->phone = $_POST["phone"];
		$user->year = $_POST["year"];
		$user->kind = 1;
		$u = $user->add();
		print "<script>window.location='index.php?view=teachers';</script>";
	}
}
if ($_GET["opt"] && $_GET["opt"] == "upd") {

	if (count($_POST) > 0) {
		$user = PersonData::getById($_POST["alumn_id"]);
		$user->name = $_POST["name"];
		$user->lastname = $_POST["lastname"];
		$user->address = $_POST["address"];
		$user->email = $_POST["email"];
		$user->phone = $_POST["phone"];
		$user->year = $_POST["year"];
		/* $user->filename = $_POST["filename"]; */
		$user->tarjeta = $_POST["tarjeta"];


	/* 	$alphabeth = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_-";
		$codes = "";
		for ($i = 0; $i < 12; $i++) {
			$codes .= $alphabeth[rand(0, strlen($alphabeth) - 1)];
		}
		$codes = $codes; */
		/****************************************************/

		/*  $filename = $_FILES["filename"];

		$handle = new Upload($filename);
		if ($handle->uploaded) {
			$handle->image_resize = true;
			$handle->image_x = $handle->image_src_x / 2;
			$handle->image_ratio_y        = true;
			$handle->jpeg_quality = 50;
			$handle->process($url);
			if ($handle->processed) {
				$filename_r = $handle->file_dst_name; */

				$user->user_id = $_SESSION["user_id"];
				$u = $user->update();
				if ($_POST["password"] != "") {
					$user->password = sha1(md5($_POST["password"]));
					$user->update_passwd();
					Core::alert("Password Actualizado Exitosamente!");
				}
			/* }
		}  */
			print "<script>window.location='index.php?view=teachers';</script>";
	}
}
if ($_GET["opt"] && $_GET["opt"] == "del") {

	$alumn = PersonData::getById($_GET["id"]);
	$alumn->del();

	Core::redir("./?view=teachers");
}
