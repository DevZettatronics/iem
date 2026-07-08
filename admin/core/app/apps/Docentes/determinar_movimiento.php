<?php
require("conectar.php");
require("EnviarCorreoIngreso.php");

date_default_timezone_set('america/mexico_city');

if (isset($_POST["tarjeta"])) {
  $cedula = test_input($_POST["tarjeta"]);

  $sql = "SELECT * FROM person WHERE tarjeta = '$cedula'";
  $result = mysqli_query($db, $sql);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  $count = mysqli_num_rows($result);


  if ($count > 0) {

    $fecha = date("Y-m-d");
    $hora = date("H:i:s");

    $sql2 = "SELECT * FROM tiempo_docentes WHERE tarjeta = '$cedula'"; /* coneion a tabla de registros  */
    $result2 = mysqli_query($db, $sql2);
    $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);

    $count2 = mysqli_num_rows($result2); 

    $par = abs($count2 % 2);
    //        require("conectar.php");


    if ($par == 0) {

      $tipo = "Entrada";

      $entrada = mysqli_query($db, "SELECT name,lastname,person_email,foto FROM  person WHERE tarjeta = '$cedula'"); /* conexion a los alumnos  */
      while ($entradaResultado = mysqli_fetch_array($entrada)) {
        $name = $entradaResultado['name'];
        $apellido = $entradaResultado['lastname'];
        $correo = $entradaResultado['person_email'];
        $foto = $entradaResultado['foto'];

        $query = "INSERT INTO tiempo_docentes (tarjeta,name,apellido,tipo,fecha,hora)  /* insercion a tiempo de alumnos */
            VALUES ('$cedula', '$name', '$apellido','$tipo', '$fecha','$hora')";
        $result = mysqli_query($connect, $query);
        /* enviarcorreoingreso($correo, $name, $apellido); */
        $movimiento = 0;
      } //FIN DEL WHILE    

    } else {

      $tipo = "Salida";

      $salida = mysqli_query($db, "SELECT name,lastname,person_email,foto FROM person WHERE tarjeta = '$cedula'"); /* conexion a los alumnos  */
      while ($salidaResultado = mysqli_fetch_array($salida)) {
        $name = $salidaResultado['name'];
        $apellido = $salidaResultado['lastname'];
        $correo = $salidaResultado['person_email'];
        $foto = $salidaResultado['foto'];

        $query = "INSERT INTO tiempo_docentes (tarjeta,name,apellido,tipo,fecha,hora)  /* insercion a tiempo de alumnos */
            VALUES ('$cedula', '$name', '$apellido','$tipo', '$fecha','$hora')";
        $result = mysqli_query($connect, $query);
        /* enviarcorreosalida($correo, $name, $apellido); */
        $movimiento = 1;
      }
    }
  } else {
    header("location: index.php?error");
  }
}

if (!isset($_POST["tarjeta"])) {

  echo "Acceso prohibido";
}

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
