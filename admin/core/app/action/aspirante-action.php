<?php

if (isset($_GET["opt"]) && $_GET["opt"] == "add") {

    $con = Database::getCon();

    // Obtener los datos del formulario

    $name = $_POST["name"];

    $lastname = $_POST["lastname"];

    $fecha_n = $_POST['fecha_n'];

    $nacionalidad = $_POST['nacionalidad'];

    $curp = $_POST["curp"];

    $genero = $_POST["genero"];

    $person_email = $_POST["person_email"];

    $phone = $_POST["phone"];

    $carrera = $_POST["carrera"];

    $beca = $_POST["beca"];

    $promocion = $_POST["promo"];

    $documentos_extranjero = $_POST["documentos_extranjero"];

    $country_id   = !empty($_POST['country']) ? $_POST['country'] : 0;   

    // Verificar la nacionalidad y asignar el campo correspondiente

    if ($nacionalidad == "1") {

        // Consultar si la CURP ya existe en la base de datos

        $sql = "SELECT COUNT(*) as count FROM person WHERE curp = '$curp' AND nationality = '1'";

        $result = mysqli_query($con, $sql);

        $row = mysqli_fetch_assoc($result);

        $curpExistente = $row['count'];

        if ($curpExistente > 0) {

            Core::alert("El CURP ingresado ya ha sido registrado anteriormente, intenta de nuevo.");

            Core::redir("./?view=aspirante&opt=new");

            exit;

        }

        $campoNacionalidad = $curp;

    } else if ($nacionalidad == "2") {

        $campoNacionalidad = $documentos_extranjero;

    }

    // Realizar la inserción en la base de datos

    $user = new AspiranteData();

    $user->name = $name;

    $user->lastname = $lastname;

    $user->fecha_n = $fecha_n;

    $user->nacionalidad = $nacionalidad;

    $user->curp = $campoNacionalidad;

    $user->genero = $genero;

    $user->person_email = $person_email;

    $user->phone = $phone;

    $user->carrera = $carrera;

    $user->beca = $beca;

    $user->promocion = $promocion;

    $user->country_id = $country_id;

    $u = $user->add();

    // if (mysqli_error($con)) {

    //     Core::alert("Hubo un error al registrar el aspirante, reintente en unos minutos");

    //     error_log("Se recuperó el siguiente error: " . mysqli_error($con));

    // } else {

    //     Core::alert("Se ha creado el registro exitosamente");

    // }

    // Core::redir("./?view=aspirante&opt=all");

    if (mysqli_error($con)) {
        $errorMsg = mysqli_error($con);

        // Guardar en log
        error_log("Error al registrar aspirante: " . $errorMsg);

        // Enviar JSON con el error real
        echo json_encode([
            "success" => false,
            // "error"   => "Hubo un error al registrar el aspirante: " . $errorMsg
            "error"   => "Hubo un error al registrar el aspirante: "
        ]);
    }else {
        // Insert exitoso
        echo json_encode([
            "success" => true,
            "message" => "Se ha creado el registro exitosamente"
        ]);
    }

    exit;

}

/* validacion del aspirante para asignarlos a alumnos */

if (isset($_GET["opt"]) && $_GET["opt"] == "validar") { /* Inserccion */
    if (count($_POST) > 0) {
        $con = Database::getCon();

        $a = AspiranteData::getById($_POST["id"]); /* aspirante temporal */

        $user = new PersonData;

        $user->code = $_POST["code"];
        $user->name = $a->name;
        $user->lastname = $a->lastname;
        $user->f_nacimiento = $a->fecha_n;
        $user->nacionalidad = $a->nacionalidad;
        $user->curp = $a->curp;
        $user->gender = $a->genero;
        $user->person_email = $a->person_email;
        $user->phone = $a->phone;
        $user->carrera = $a->carrera;
        $user->name_periodo = $_POST["name_periodo"];
        $user->periodo_as = $_POST["periodo_as"];
        $user->beca = $a->beca;
        $user->promocion = $a->promocion;
        $user->email = $_POST["correo"];

        $u = $user->add_insert(); /* inserta en person */

        if (!$u || mysqli_error($con)) {
            echo json_encode([
                "success" => false,
                "error"   => "No se pudo registrar el alumno. Intente de nuevo."
            ]);
            exit;
        }

        // eliminar aspirante temporal
        $aspiranteTmp = AspiranteData::getById($_POST["id"]);
        $aspiranteTmp->del();

        // insertar en becas/promociones
        $user1 = new PersonData;
        $user1->code = $_POST["code"];
        $user1->name = $a->name;
        $user1->lastname = $a->lastname;
        $user1->beca = $a->beca;
        $user1->promocion = $a->promocion;
        $user1->email = $_POST["correo"];

        $uno = $user1->add_becas_proms();

        if (!$uno || mysqli_error($con)) {
            echo json_encode([
                "success" => false,
                "error"   => "El registro del alumno se guardó, pero falló la inserción en becas/promociones."
            ]);
            exit;
        }

        echo json_encode([
            "success" => true,
            "message" => "El alumno fue validado y registrado exitosamente."
        ]);
        exit;
    }
}


if (isset($_GET["opt"]) && $_GET["opt"] == "update") { /*EDICION */

    if (count($_POST) > 0) {

        $con = Database::getCon();

        $a = AspiranteData::getById($_POST["id"]);

        $a->name = $_POST["name"];

        $a->lastname = $_POST["lastname"];

        $a->fecha_n = $_POST['fecha_n'];/* new */

        $a->curp = $_POST["curp"];/* new */

        $a->genero = $_POST["genero"];/* new */

        $a->person_email = $_POST["person_email"];

        $a->phone = $_POST["phone"];

        $a->carrera = $_POST['carrera'];

        $a->beca = $_POST['beca'];

        $a->promocion = $_POST['promocion'];

        $nacionalidad = $_POST['nacionalidad'];

        $a->nacionalidad = $_POST['nacionalidad'];

        $a->country_id   = !empty($_POST['country']) ? $_POST['country'] : 0;   

        /******/

        if ($nacionalidad == "1") {

            // Consultar si la CURP ya existe en la base de datos

            $sql = "SELECT COUNT(*) as count FROM person WHERE curp = '$a->curp' AND nationality = '1'";

            $result = mysqli_query($con, $sql);

            $row = mysqli_fetch_assoc($result);

            $curpExistente = $row['count'];

            if ($curpExistente > 0) {

                Core::alert("El CURP ingresado ya ha sido registrado anteriormente, intenta de nuevo.");

                Core::redir("./?view=aspirante&opt=new");

                exit;

            }

            $campoNacionalidad = $a->curp;

        } else if ($nacionalidad == "2") {

            $campoNacionalidad = "";

        }

        $a->curp = $campoNacionalidad;

        $a->update();

        if (mysqli_error($con)) {
            // Hubo error al insertar
            error_log("Error al actualizar aspirante: " . mysqli_error($con));

            echo json_encode([
                "success" => false,
                "error"   => "Hubo un error al actualizar el aspirante, reintente en unos minutos"
            ]);
        } else {
            // Insert exitoso
            echo json_encode([
                "success" => true,
                "message" => "Se ha actualizado el registro exitosamente"
            ]);
        }

    exit;

    }

}


if (isset($_GET["opt"]) && $_GET["opt"] == "del") { /* ELIMINACION  */

    header('Content-Type: application/json');

    $user = AspiranteData::getById($_GET["id"]);

    $user->del();
    header('Content-Type: application/json');   
    echo json_encode([
        "success" => true,
        "message" => "Aspirante eliminado correctamente.",
        "redirect" => "index.php?view=aspirante&opt=all"
    ]);
    exit;
}

