<?php



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

		$user->parent_id = $_POST["parent_id"];

		$u = $user->add_alumn();

		print "<script>window.location='index.php?view=alumns';</script>";

	}

} elseif ($_GET["opt"] && $_GET["opt"] == "upd") {



	if (count($_POST) > 0) {

		$con = Database::getCon();



		$id = $_POST["alumn_id"];

		$name = mb_strtoupper($_POST["name"]);

		$lastname = mb_strtoupper($_POST["lastname"]);

		$email = mb_strtolower($_POST["email"]);

		$name_periodo = !empty($_POST["name_periodo"]) ? "'" . mb_strtolower($_POST["name_periodo"]) . "'" : 'NULL';;/* modif periodo */

		$genero = !empty($_POST["genero"]) ? "'" . mysqli_real_escape_string($con, ($_POST["genero"])) . "'" : 'NULL';

		$f_nacimiento = !empty($_POST["f_nacimiento"]) ? "'" . mysqli_real_escape_string($con, $_POST['f_nacimiento']) . "'" : 'NULL';

		$nacionalidad = !empty($_POST["nacionalidad"]) ? "'" . mysqli_real_escape_string($con, mb_strtoupper($_POST["nacionalidad"])) . "'" : 'NULL';

		$phone = !empty($_POST["phone"]) ? "'" . mysqli_real_escape_string($con,  intval($_POST["phone"])) . "'" : 'NULL';

		$correo = !empty($_POST["correo"]) ? "'" . mysqli_real_escape_string($con,  mb_strtolower($_POST["correo"])) . "'" : 'NULL';

		$civil = !empty($_POST["civil"]) ? "'" . mysqli_real_escape_string($con,  mb_strtoupper($_POST["civil"])) . "'" : 'NULL';



		if (!empty($_POST["estado"]) && isset($_POST["estado"])) {

			$estado = intval($_POST["estado"]);

			$query_estado = mysqli_query($con, "SELECT * FROM estados WHERE id = $estado");

			$row_estado = mysqli_fetch_array($query_estado);

			$name_estado = mb_strtoupper($row_estado['nombre']);

		} else {

			$name_estado = 'NULL';

		}

		if (!empty($_POST["estado"]) && isset($_POST["estado"])) {



			$alcaldia = intval($_POST["alcaldia"]);

			$query_alcaldia = mysqli_query($con, "SELECT * FROM municipios WHERE id = $alcaldia");

			$row_alcaldia = mysqli_fetch_array($query_alcaldia);

			$name_alcaldia = mb_strtoupper($row_alcaldia['nombre']);

		} else {

			$name_alcaldia = 'NULL';

		}



		$calle = !empty($_POST["calle"]) ? mb_strtoupper($_POST["calle"]) : 'NULL';

		$colonia = !empty($_POST["colonia"]) ? mb_strtoupper($_POST["colonia"]) : 'NULL';

		$numero = !empty($_POST["numero"]) ? $_POST["numero"] : 'NULL';

		$numero_exterior = !empty($_POST["numero_exterior"]) ? $_POST["numero_exterior"] : 'NULL';

		$cp = !empty($_POST["cp"]) ? intval($_POST["cp"]) : 'NULL';

		$telemergencia = !empty($_POST["telemergencia"]) ? "'" . mysqli_real_escape_string($con, intval($_POST["telemergencia"])) . "'" : 'NULL';

		$namecontacto = !empty($_POST["namecontacto"]) ? "'" . mysqli_real_escape_string($con, $_POST["namecontacto"]) . "'" : 'NULL';

		$parent_id = !empty($_POST["parent_id"]) ? "'" . mysqli_real_escape_string($con, $_POST["parent_id"]) . "'" : 'NULL';



		$array = [$calle, $numero, $colonia, $name_estado, $name_alcaldia, $cp];



		if (in_array('NULL', $array)) {

			$address = 'NULL';

		} else {

			$a = $calle . "," . $numero . "," . $numero_exterior . "," . $colonia . "," . $name_estado . "," . $name_alcaldia . "," . $cp;

			$address = "'" . mysqli_real_escape_string($con, $a) . "'";

		}





		$sql = "UPDATE person SET name= '$name' ,lastname='$lastname',email='$email',gender=$genero,

		f_nacimiento=$f_nacimiento,nationality=$nacionalidad,phone=$phone,person_email=$correo,civil=$civil,		

		address=$address,phone_contact=$telemergencia,name_contact=$namecontacto,parent_id=$parent_id,name_periodo=$name_periodo  WHERE id=$id";



		$query = mysqli_query($con, $sql);



		if ($query) {

			Core::alert("Se actualizaron los datos");

			$user = PersonData::getById($_POST["alumn_id"]);

			if ($_POST["password"] != "") {

				$user->password = sha1(md5($_POST["password"]));

				$user->update_passwd();

				Core::alert("La contrase���a se cambio con Exito!");

			}

			print "<script>window.location='index.php?view=alumns';</script>";

		} else {

			Core::alert("Ocurrio un error al querer actualizar los datos");

			echo  mysqli_error($con);

			/* print "<script>window.location='index.php?view=alumns';</script>"; */

		}

	}

} elseif ($_GET["opt"] && $_GET["opt"] == "del") {



	$alumn = PersonData::getById($_GET["id"]);

	$alumn->del();



	Core::redir("./?view=alumns");

} elseif ($_GET["opt"] && $_GET["opt"] == "validate") {



	//$con = Database::getCon();

	$repository = RepositoryData::getById($_GET["id"]);

	$repository->status = 2;

	$repository->updatestatus();

	Core::alert("Se valido documento");

	print "<script>window.location='index.php?view=alumndocs&code=$repository->code_person';</script>";

} elseif ($_GET["opt"] && $_GET["opt"] == "deldocument") {
    $con = Database::getCon();
    $id = $_GET["id"];

    $query = mysqli_query($con, "SELECT * FROM repository WHERE id = '$id'");
    $rw = mysqli_fetch_array($query);

    if (!$rw) {
        echo json_encode(["status" => "error", "msg" => "Documento no encontrado en la base de datos"]);
        exit;
    }

    $code = $rw['code_person'];
    $file_name = $rw['file'];
    $mensaje = 'El Documento ha sido rechazado por ilegibilidad';
    $url = "../alumnos/core/app/repository/$code/$file_name";

    if (file_exists($url)) {
        if (unlink($url)) {
            $delete = mysqli_query($con, "DELETE FROM repository WHERE id = '$id'");

            if ($delete) {
                // Insertar notificación
                $sql2 = "INSERT INTO notificaciones (mensaje, file, estado, user_id, id_receptor)
                         VALUES ('$mensaje', '$file_name', 0, '1', '$code')";
                mysqli_query($con, $sql2);

                echo json_encode(["status" => "ok", "msg" => "Se eliminó con éxito el documento"]);
            } else {
                echo json_encode(["status" => "error", "msg" => "Error al eliminar el registro de la base de datos"]);
            }
        } else {
            echo json_encode(["status" => "error", "msg" => "Hubo un error al eliminar el archivo"]);
        }
    } else {
        // Archivo no existe, intentamos eliminar solo el registro
        $delete = mysqli_query($con, "DELETE FROM repository WHERE id = '$id'");

        if ($delete && mysqli_affected_rows($con) > 0) {
            echo json_encode(["status" => "ok", "msg" => "Se eliminó el registro, pero el archivo no existía"]);
        } else {
            echo json_encode(["status" => "error", "msg" => "Hubo un error al eliminar el documento"]);
        }
    }

    exit;
}


/* editar beca */

if (isset($_GET["opt"]) && $_GET["opt"] == "editb") { /*EDICION */

	if (count($_POST) > 0) {

		$a = PersonData::getById($_POST["id"]);

		$a->beca = $_POST['beca'];

		$a->promocion = $_POST['promoc'];

		$u = $a->updatebeca();


		$b = PersonData::getById($_POST["id"]);
		$b->code = $_POST["code"];
		$b->name = $_POST["name"];
		$b->lastname = $_POST["lastname"];
		$b->beca = $_POST['beca'];
		$b->promocion = $_POST['promoc'];
		$b->email = $_POST["email"];
		$c = $b->add_becas_proms();


		Core::alert("Se actualizaron los datos");

		Core::redir("./?view=alumns&opt=all");

	}

}

