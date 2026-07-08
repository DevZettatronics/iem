<?php
if (isset($_POST['password']) && !empty($_POST['password'])) {
    // Incluye el archivo que contiene la conexión a la base de datos
    include "../../controller/Database.php";

    // Obtiene la conexión a la base de datos
    $con = Database::getCon();

    // Obtiene el código del usuario desde el formulario (asumiendo que se envía por el campo 'code')
    $code = intval($_POST['code']);

    // Genera la nueva contraseña con el hash SHA-1 y MD5
    $password = sha1(md5($_POST["password"]));

    // Actualiza la contraseña en la base de datos
    $sql = "UPDATE person SET password = '" . $password . "' WHERE code = '" . $code . "'";
    $query = mysqli_query($con, $sql);

    if ($query) {
        // Si la actualización fue exitosa, muestra un mensaje de éxito
        echo '<div class="alert alert-success" role="alert">';
        echo '<strong>¡Contraseña actualizada con éxito!</strong> La contraseña se ha cambiado.';
        echo '</div>';

        // Redireccionar después de 2 segundos usando JavaScript
        echo '<script>';
        echo 'setTimeout(function() { window.location.href = "./?view=home"; }, 2000);';
        echo '</script>';
    } else {
        // Si la actualización falló, muestra un mensaje de error
        echo '<div class="alert alert-danger" role="alert">';
        echo '<strong>Error al actualizar la contraseña.</strong> Por favor, intenta nuevamente.';
        echo '</div>';
    }
} else {
    // Si no se envió ninguna contraseña o está vacía, muestra un mensaje de error
    echo '<div class="alert alert-danger" role="alert">';
    echo '<strong>Error.</strong> La contraseña no puede estar vacía.';
    echo '</div>';
}
?>

