<?php
session_start();
include("conexion.php");

$conexion = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conexion) {
    die("Imposible conectarse: " . mysqli_connect_error());
}

if (@mysqli_connect_errno()) {
    die("Conexión falló: " . mysqli_connect_errno() . " : " . mysqli_connect_error());
}

$code = $_POST["code"] ?? '';
$year = $_POST["year"] ?? '';

$busqueda = "SELECT * FROM `person` WHERE `code` ='$code' AND `year` ='$year'";
$resultado = mysqli_query($conexion, $busqueda);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

if (mysqli_num_rows($resultado) >= 1) {
    while ($res = mysqli_fetch_assoc($resultado)) {

        $is_active = $res['is_active'];
        $kind = $res['kind'];

        if ($is_active == "1" && $kind == "1") { // Caso 1B

            $_SESSION['1B'] = true;
            $_SESSION['id'] = $res['id'];
            $_SESSION['name'] = $res['name'];
            $_SESSION['lastname'] = $res['lastname'];
            $_SESSION['directorio'] = $res['directorio'];
            
            echo '<script type="text/javascript">
					// Localhost
				    // location.href="http://localhost/Zettatronics/iem/teacher/index.php?view=entrada";

					// Developer
					// location.href="https://aula.iemueem.edu.mx/Developer/iem/teacher/index.php?view=entrada";

					// UAT
					// location.href="https://aula.iemueem.edu.mx/UAT/iem/teacher/index.php?view=entrada";

					// Servicios
					location.href="https://aula.iemueem.edu.mx/Servicios/iem/teacher/index.php?view=entrada";

                  </script>';
            exit;
        } else {
            // Aquí iría el código para otros casos
            echo '<script type="text/javascript">
                    alert("Acceso no permitido");
                    location.href="index.php";
                  </script>';
            exit;
        }
    }
} else {
    echo '<script type="text/javascript">
            alert("Datos incorrectos");
            location.href="index.php";
          </script>';
    exit;
}

mysqli_close($conexion);
?>
