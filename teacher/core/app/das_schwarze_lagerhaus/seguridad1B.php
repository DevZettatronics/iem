<?
//Inicio la sesiиоn
session_start();
    
//COMPRUEBA QUE EL USUARIO ESTA AUTENTICADO
if($_SESSION['1B']!=true) {
//si no existe, va a la pивgina de autenticacion
header("Location:https://viserion.gestalt.education/teacher/core/app/das_schwarze_lagerhaus/");
//salimos de este script
exit();
}
?>