<?php

if (empty($_POST['curp'])) {
	$errors[] = "La CURP esta vacía";
} elseif (strlen($_POST['curp']) < 18) {
	$errors[] = "La CURP debe contener 18 caracteres";
} elseif (empty($_POST['nacionalidad'])) {
	$errors[] = "La nacionalidad esta vacía";
} elseif (empty($_POST['f_nacimiento'])) {
	$errors[] = "La fecha de nacimiento esta vacía";
} elseif (empty($_POST['telefono'])) {
	$errors[] = "El numero telefonico esta vacío";
} elseif (strlen($_POST['telefono']) < 10) {
	$errors[] = "El numero telefonico debe contener 10 caracteres";
} elseif (empty($_POST['correo'])) {
	$errors[] = "El correo personal esta vacío";
} elseif (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
	$errors[] = "Su dirección de correo electrónico no está en un formato de correo electrónico válida";
} elseif (empty($_POST['estado'])) {
	$errors[] = "El estado esta vacío";
} elseif (empty($_POST['alcaldia'])) {
	$errors[] = "La alcaldia/municipio esta vacío";
} elseif (empty($_POST['colonia'])) {
	$errors[] = "La colonia esta vacía";
} elseif (empty($_POST['calle'])) {
	$errors[] = "La calle esta vacía";
} elseif (empty($_POST['numero'])) {
	$errors[] = "El numero esta vacío";
} elseif (empty($_POST['cp'])) {
	$errors[] = "El codigo postal esta vacío";
} elseif (strlen($_POST['cp']) < 5) {
	$errors[] = "El codigo postal debe contener 5 caracteres";
} elseif (empty($_POST['telemergencia'])) {
	$errors[] = "El telefono de emergencia esta vacío";
} elseif (strlen($_POST['telemergencia']) < 10) {
	$errors[] = "El telefono de emergencia debe contener 10 caracteres";
} elseif (empty($_POST['namecontacto'])) {
	$errors[] = "El nombre del contacto de emergencia esta vacío";
} elseif (
	!empty($_POST['curp'])
	&& strlen($_POST['curp']) == 18
	&& !empty($_POST['nacionalidad'])
	&& !empty($_POST['f_nacimiento'])
	&& !empty($_POST['telefono'])
	&& strlen($_POST['telefono']) == 10
	&& !empty($_POST['correo'])
	&& filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)
	&& !empty($_POST['estado'])
	&& !empty($_POST['alcaldia'])
	&& !empty($_POST['colonia'])
	&& !empty($_POST['calle'])
	&& !empty($_POST['numero'])
	&& !empty($_POST['cp'])
	&& strlen($_POST['cp']) == 5
	&& !empty($_POST['telemergencia'])
	&& strlen($_POST['telemergencia']) == 10
	&& !empty($_POST['namecontacto'])
) {

	include "../../controller/Database.php";

	$con = Database::getCon();

	$code = intval($_POST['code']);
	$curp = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["curp"], ENT_QUOTES))));
	$nacionalidad = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["nacionalidad"], ENT_QUOTES))));
	$correo = mb_strtolower(mysqli_real_escape_string($con, (strip_tags($_POST["correo"], ENT_QUOTES))));
	$telefono = intval($_POST['telefono']);
	$genero = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["genero"], ENT_QUOTES))));
	$nacionalidad = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["nacionalidad"], ENT_QUOTES))));
	$civil = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["civil"], ENT_QUOTES))));
	$telemergencia = intval($_POST['telemergencia']);
	$namecontacto = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["namecontacto"], ENT_QUOTES))));
	$f_nacimiento = mysqli_real_escape_string($con, (strip_tags($_POST["f_nacimiento"], ENT_QUOTES)));
	$estado = intval($_POST['estado']);

	$query_estado = mysqli_query($con, "SELECT * FROM estados WHERE id = $estado");
	$row_estado = mysqli_fetch_array($query_estado);
	$name_estado = mb_strtoupper($row_estado['nombre']);

	$alcaldia = intval($_POST['alcaldia']);

	$query_alcaldia = mysqli_query($con, "SELECT * FROM municipios WHERE id = $alcaldia");
	$row_alcaldia = mysqli_fetch_array($query_alcaldia);
	$name_alcaldia = mb_strtoupper($row_alcaldia['nombre']);

	$colonia = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["colonia"], ENT_QUOTES))));
	$calle = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["calle"], ENT_QUOTES))));
	$numero = mysqli_real_escape_string($con, (strip_tags($_POST['numero'])));
	$numero_interior = mysqli_real_escape_string($con, (strip_tags($_POST['numero_interior'])));
	$cp = mysqli_real_escape_string($con, (strip_tags($_POST['cp'])));
	$telemergencia = intval($_POST['telemergencia']);
	$namecontacto = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["namecontacto"], ENT_QUOTES))));

	if ($_POST["password"] != "") {
		$password = sha1(md5($_POST["password"]));
		$query_update = mysqli_query($con, "UPDATE person SET password='" . $password . "' WHERE code ='" . $code . "' ");
		$messages[] = "La contraseña se cambio con Exito! <br>";
	}

	$direccion = $calle . "," . $numero . "," . $numero_interior . "," . $colonia . "," . $name_estado . "," . $name_alcaldia . "," . $cp;

	$sql = "UPDATE person SET curp='" . $curp . "', person_email='" . $correo . "', address='" . $direccion . "' , phone='" . $telefono . "',  f_nacimiento= '" . $f_nacimiento . "',  gender= '" . $genero . "',  nationality= '" . $nacionalidad . "',  civil= '" . $civil . "',  phone_contact= '" . $telemergencia . "',  name_contact= '" . $namecontacto . "' WHERE code ='" . $code . "' ";
	$query = mysqli_query($con, $sql);
	if ($query) {
		$messages[] = "Se han actualizado con exito tus datos en el sistema";
		/* NOtificaciones */
		$mensaje = 'Informacion o Documentacion actualizada';
		$estado = 0;
		$autor = $code;
		$kind = 1;
		$sql2 = "INSERT INTO notificaciones (mensaje,estado,user_id,id_receptor,kind) VALUES ('$mensaje', '$estado','$code','1','$kind');";
		$query_notificacion = mysqli_query($con, $sql2);
		/**/
		if ($_FILES["docs"]) {
			//Recorre el array de los archivos a subir
			foreach ($_FILES["docs"]['tmp_name'] as $key => $tmp_name) {
				//Si el archivo docs
				if ($_FILES["docs"]["name"][$key]) {
					// Nombres de archivos de temporales
					$archivonombre = $_FILES["docs"]["name"][$key];
					$files = $_FILES["docs"]["name"];
					$fuente = $_FILES["docs"]["tmp_name"][$key];
					$carpeta = "../../app/repository/" . $code; //Carpeta donde guardamos los archivos
					//Si no existe la carpeta
					if (!file_exists($carpeta)) {
						//Se crea o se genera un error.
						mkdir($carpeta, 0777) or die($errors[] = "Hubo un error al crear la carpeta");
					}
					$dir = opendir($carpeta);
					if (move_uploaded_file($fuente, $carpeta . '/' . $archivonombre)) {
						$query_docs = mysqli_query($con, "INSERT INTO repository (code_person,file) VALUES ('" . $code . "','" . $archivonombre . "')");
					} else {
						$errors[]	 = "Se ha producido un error, al cargar los archivos, intentelo de nuevo.<br>";
					}
					closedir($dir);
				}
			}
		}
		print "<script>setTimeout('document.location.reload()',1500);</script>";
	} else {
		$errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo. <br><br> <u>Si persiste el error puede ser que su CURP ya este regristrada en el sistema, favor de contactar con servicios escolares.</u>";
	}
} else {
	$errors[] = "Error desconocido";
}


if (isset($errors)) {

?>
	<div class="alert alert-danger" role="alert">
		<strong>Error!</strong>
		<?php
		foreach ($errors as $error) {
			echo $error;
		}
		?>
	</div>
<?php
}
if (isset($messages)) {

?>
	<div class="alert alert-success" role="alert">
		<strong>¡Bien hecho!</strong>
		<?php
		foreach ($messages as $message) {
			echo $message;
		}
		?>
	</div>
<?php
}
?>