<?php

if (isset($_GET["opt"]) && $_GET["opt"] == "update") { /*EDICION */
    if (count($_POST) > 0) {
        $a = RecibosData::getById($_POST["id"]);
        $a->alumn_id = $_POST["alumn_id"];
        $a->cantidad = $_POST["cantidad"];
        $a->folio = $_POST["folio"];
        $u = $a->update();
        Core::alert("Se actualizaron los datos");
        Core::redir("./?view=recibos&code=".$a->alumn_id);
    }
}
if (isset($_GET["opt"]) && $_GET["opt"] == "del") {/*ELIMINACION  */

    $user = RecibosData::getById($_GET["id"]);
    $user->code_user;
    $user->del();
    
    Core::redir("./?view=recibos&code=".$user->code_user);
}
// /* validar */
// if (isset($_GET["opt"]) && $_GET["opt"] == "validar") {

//     $user = RecibosData::getById($_GET["id"]);
//     $user->alumn_id = $_POST["alumn_id"];
//     $user->validar();

//     Core::redir("./?view=recibos&code=".$nalumn->alumn_id);
// }
// /* Rechazar */
// if (isset($_GET["opt"]) && $_GET["opt"] == "rechazar") {

//     $user = RecibosData::getById($_GET["id"]);
//     $user->alumn_id = $_POST["alumn_id"];
//     $user->rechazar();

//     Core::redir("./?view=recibos&code=".$nalumn->alumn_id);
// }
