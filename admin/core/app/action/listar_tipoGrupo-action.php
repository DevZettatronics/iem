<?php
require_once("../../../config/db.php");
require_once("../../../config/conexion.php");

if (isset($_GET['grupo'])) {
    $tipo = $_GET['grupo'];
    $sql = "SELECT * FROM t_grupo where grupo_id like '$tipo%'";
    $query = mysqli_query($con, $sql);
    echo "<option form-control value = ''>Seleccionar</option>";
    while ($row = mysqli_fetch_array($query)) {
        echo '<option form-control value = "' . $row['grupo_id'] . '">' . $row['descripcion'] . '</option>';
    }
}