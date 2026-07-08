<?php
$con = Database::getCon();

if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	$address1 = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["address1"], ENT_QUOTES))));

	$city = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["city"], ENT_QUOTES))));

	$state = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["state"], ENT_QUOTES))));

	$postal_code = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["postal_code"], ENT_QUOTES))));

	$first_name	 = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["first_name"], ENT_QUOTES))));

	$last_name	 = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["last_name"], ENT_QUOTES))));

	$email	 = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["email"], ENT_QUOTES))));

	$phone	 = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["phone"], ENT_QUOTES))));

	$muni = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["muni"], ENT_QUOTES))));

	$rfc = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["rfc"], ENT_QUOTES))));

	$country = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["country"], ENT_QUOTES))));

	$descuento = intval($_POST["descuento"]);

	$created_at = date("Y-m-d H:i:s");

	$regimen = intval($_POST["regimen"]);

	$bussi = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["bussines_name"], ENT_QUOTES))));

	$id_cust = intval($_POST["id_customer"]);
$con = Database::getCon();
$a = new ReceptoresData();

$a->name = $first_name;
$a->last_name = $last_name;
$a->address1 = $address1;
$a->telefono = $phone;
$a->email = $email;
$a->city = $city;
$a->state = $state;
$a->postal_code = $postal_code;
$a->muni = $muni;
$a->rfc = $rfc;
$a->country = $country;
$a->descuento = $descuento;
$a->regimen = $regimen;

$aa = new ReceptoresData();

$aa->name = $bussi;
$aa->address1 = $address1;
$a->telefono = $phone;
$a->email = $email;
$aa->city = $city;
$aa->state = $state;
$aa->postal_code = $postal_code;
$aa->muni = $muni;
$aa->rfc = $rfc;
$aa->country = $country;
$aa->descuento = $descuento;
$aa->regimen = $regimen;

if (isset($_POST['check'])) {

	$empresa = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["check"], ENT_QUOTES))));

	if (empty($_POST['bussines_name'])) {

		$errors[] = "Ingresa Nombre de la empresa";

	} elseif (!empty($_POST['bussines_name'])) {

	    $aa->addMoral();

	}

	} elseif (!isset($_POST['check'])) {

		$a->addFisica();

	}
Core::redir("./?view=receptoresform&opt=all");
}

elseif(isset($_GET["opt"]) && $_GET["opt"]=="update"){
	$address1 = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["address1"], ENT_QUOTES))));

	$city = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["city"], ENT_QUOTES))));

	$state = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["state"], ENT_QUOTES))));

	$postal_code = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["postal_code"], ENT_QUOTES))));

	$first_name	 = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["first_name"], ENT_QUOTES))));

	$last_name	 = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["last_name"], ENT_QUOTES))));

	$email	 = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["email"], ENT_QUOTES))));

	$phone	 = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["phone"], ENT_QUOTES))));

	$muni = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["muni"], ENT_QUOTES))));

	$rfc = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["rfc"], ENT_QUOTES))));

	$country = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["country"], ENT_QUOTES))));

	$descuento = intval($_POST["descuento"]);

	$created_at = date("Y-m-d H:i:s");

	$regimen = intval($_POST["regimen"]);

	$bussi = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["bussines_name"], ENT_QUOTES))));

	$id_cust = intval($_POST["id_customer"]);
	$con = Database::getCon();
	$a = new ReceptoresData();
	
	$a->name = $first_name;
	$a->last_name = $last_name;
	$a->address1 = $address1;
	$a->telefono = $phone;
	$a->email = $email;
	$a->city = $city;
	$a->state = $state;
	$a->postal_code = $postal_code;
	$a->muni = $muni;
	$a->rfc = $rfc;
	$a->country = $country;
	$a->descuento = $descuento;
	$a->regimen = $regimen;
	$a->id = $id_cust;
	
	$aa = new ReceptoresData();
	
	$aa->name = $bussi;
	$aa->address1 = $address1;
	$a->telefono = $phone;
	$a->email = $email;
	$aa->city = $city;
	$aa->state = $state;
	$aa->postal_code = $postal_code;
	$aa->muni = $muni;
	$aa->rfc = $rfc;
	$aa->country = $country;
	$aa->descuento = $descuento;
	$aa->regimen = $regimen;
	$aa->id = $id_cust;
	
	if (isset($_POST['check'])) {
	
		$empresa = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["check"], ENT_QUOTES))));
	
		if (empty($_POST['bussines_name'])) {
	
			$errors[] = "Ingresa Nombre de la empresa";
	
		} elseif (!empty($_POST['bussines_name'])) {
	
			$aa->updateMoral();
	
		}
	
		} elseif (!isset($_POST['check'])) {
	
			$a->updateFisica();
	
		}
	Core::redir("./?view=receptoresform&opt=all");


}

else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
$a = new ReceptoresData();
$a = ReceptoresData::getByIdOnly($_GET["id"]);

$a->del();

Core::redir("./?view=receptoresform&opt=all");
}



?>