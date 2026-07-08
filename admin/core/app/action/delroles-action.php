<?php

if($_GET["id"]){

    //veridficamos si el kind de el usuario logeados es el que permisos que se eliminara 
    $kindObj  = Permisos::SelectKind($_SESSION["user_id"]);
    if ($kindObj->kind != $_GET["id"]) {

        $result = Permisos::delRoles($_GET["id"]);
        
        if ($result) {
                 echo "<script>alert('Rol Eliminado');</script>";
            } else {
                echo "<script>alert('Hubo un error al eliminar el rol');</script>";
            }
        }
    }else{
        echo "<script>alert('Error estas eliminando rol y permisos que te incluyen en tu session');</script>";
    }
    
print "<script>window.location='index.php?view=roles';</script>";

?>