<?php

if (isset($_GET["opt"]) && $_GET["opt"] == "add") {/* Inserccion */
    if (count($_POST) > 0) {
        $con = Database::getCon();
        $periodo = $_POST["periodo"];
        $grupo = $_POST["grupo"];
        $alumn_id = $_POST["alumn_id"];
        $productos = $_POST["productos"];
        $cuenta_beca = $_POST["cuen_beca"];
        /* evaluacion  */
        foreach ($alumn_id as $alumn_count) {

            foreach ($productos as $concepto) {

                $query = mysqli_query($con, "SELECT count(*) AS filas FROM plan_de_pago WHERE periodo=$periodo AND carrera=$grupo AND alumno=$alumn_count AND concepto=$concepto");
                $rw = mysqli_fetch_assoc($query);
                $filas = $rw['filas'];
            }
        }

        if ($filas >= 1) {

            Core::alert("El/Los alumno(s) ya esta(n) registrados con este producto.");

            Core::redir("./?view=planpago&opt=all");
        } else {

            foreach ($alumn_id as $alumnos) {


                foreach ($productos as $conceptos) {

                    $sql = "INSERT INTO plan_de_pago (periodoz,carrera,alumno,concepto,status,cuenta_beca,date_added) VALUES ('$periodo','$grupo','$alumnos','$conceptos','1','$cuenta_beca',NOW())";
                    $query_new = mysqli_query($con, $sql);
                    // if has been added successfully
                    if ($query_new) {
                        Core::alert("se acreado el registro exitosamente");
                        Core::redir("./?view=planpago&opt=all");
                    } else {
                        Core::alert("Lo sentimos, el registro falló. Por favor, regrese y vuelva a intentarlo.");
                        Core::redir("./?view=planpago&opt=all");
                    }
                }
            }
        }
    }
}
if (isset($_GET["opt"]) && $_GET["opt"] == "update") { /*EDICION */
    if (count($_POST) > 0) {
        $a = PlandepagoData::getById($_POST["id"]);
        $a->periodo = $_POST["periodo"];
        $a->carrera = $_POST["carrera"];
        $a->alumno = $_POST["alumn_id"];
        $a->concepto = $_POST["concepto"];
        $a->cuenta_beca = $_POST["cuenta_beca"];
        $u = $a->update();
        Core::alert("Se actualizaron los datos");
        Core::redir("./?view=planpago&opt=all");
    }
}
if (isset($_GET["opt"]) && $_GET["opt"] == "del") {/*ELIMINACION  */

    $user = PlandepagoData::getById($_GET["id"]);
    $user->del();

    Core::redir("./?view=planpago&opt=all");
}

if (isset($_GET["opt"]) && $_GET["opt"] == "val") {/*Validar  */

    $valid = PlandepagoData::getById($_GET["id"]);
    $valid->val();

    Core::redir("./?view=planpago&opt=all");
}
