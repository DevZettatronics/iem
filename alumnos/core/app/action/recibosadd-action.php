<?php

$con = Database::getCon();

if (empty($_POST['total'])) {
    $errors[] = "Cantidad esta vacía";
} elseif (empty($_POST['folio'])) {
    $errors[] = "El folio esta vacío";
} elseif (

    !empty($_POST['total'])
    && !empty($_POST['folio'])
) {
    $folio = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["folio"], ENT_QUOTES))));
    $alumn_id = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["alumn_id"], ENT_QUOTES))));
    $folioExist = mysqli_query($con, "SELECT id FROM recibos WHERE folio = '$folio'");
    if (mysqli_num_rows($folioExist) > 0) {
        echo '<script>alert("¡Error! El Folio ya se encuentra registrado en otro recibo");</script>';
        Core::redir("./?view=recibos&opt=new&id=".$alumn_id);
    } else {

    /****************************************************/
    $idpp = $_POST['description'];
    $planp = PlandepagoData::getById($idpp); //id plan de pago
    $idprod =  $planp->concepto;
    $importe = intval($_POST["total"]);
    $folio = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["folio"], ENT_QUOTES))));
    $alumn_id = mb_strtoupper(mysqli_real_escape_string($con, (strip_tags($_POST["alumn_id"], ENT_QUOTES))));
    $created_at =  date("Y-m-d");


    if ($_FILES["filename"]) {
        // Nombres de archivos de temporales
        if ($_FILES["filename"]["name"]) {

            $archivonombre = $_FILES["filename"]["name"];/* nombre del archivo */
            $fuente = $_FILES["filename"]["tmp_name"];/* nombre de carpeta temporal */

            $carpeta = "../storage/recibos/" . $alumn_id; //Carpeta donde guardamos los archivos-
            //Si no existe la carpeta
            if (!file_exists($carpeta)) {
                //Se crea o se genera un error.
                mkdir($carpeta, 0777) or die($errors[] = "Hubo un error al crear la carpeta");
            }
            $dir = opendir($carpeta);

            if (move_uploaded_file($fuente, $carpeta . '/' . $archivonombre)) {

                $sqlprincipal = mysqli_query($con, "INSERT INTO recibos (filename,importe,code_user,folio,created_at, id_plan, concepto) VALUES ('" . $archivonombre . "','" . $importe . "','" . $alumn_id . "','" . $folio . "','" . $created_at . "', $idpp, $idprod)");
                
                if ($sqlprincipal) {
                    $messages[] = "Se han creado con exito tus datos en el sistema";
                    Core::redir("./?view=recibos&code=".$alumn_id);
                    $queryPlanPago = mysqli_query($con, "UPDATE plan_de_pago SET status = 5 WHERE id = $idpp");
                } else {
                    $errors[]  = "Los datos no fueron registrados correctamente, intentalo de nuevo";
                }
            } else {
                $errors[]     = "Se ha producido un error, al cargar los archivos, intentelo de nuevo.<br>";
            }
            closedir($dir);
        }
    }
  }
}

/* if (file_exists($archivonombre)) {
echo "La carpeta $archivonombre existe";
} else {
echo "La carpeta $archivonombre No existe";
} */
/********************************************/
else {
    $errors[] = "Error Desconocido";
}

if (isset($errors)) {
?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
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
        <button type="button" class="close" data-dismiss="alert">&times;</button>
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