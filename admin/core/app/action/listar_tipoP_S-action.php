<?php
require_once("../../../config/db.php");
require_once("../../../config/conexion.php");
if (isset($_GET['division'])) {
    $tipo = $_GET['division'];
    $sql = "SELECT * FROM producto_servicio where tipo=$tipo";
    $query = mysqli_query($con, $sql);
    echo "<option form-control value = ''>Seleccionar</option>";
    while ($row = mysqli_fetch_array($query)) {
        echo '<option form-control value = "' . $row['id_ps'] . '">' . $row['descripcion'] . '</option>';
    }
}