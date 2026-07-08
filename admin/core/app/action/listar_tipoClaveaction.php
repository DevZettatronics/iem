<?php
require_once("../../../config/db.php");
require_once("../../../config/conexion.php");
if (isset($_GET['clave'])) {
    
$tipo = $_GET['clave'];
    $sql = "SELECT Descripcion ,c_ClaveProdServ as clave from c_claveprodserv where c_claveprodserv like '$tipo%' ;";
    $query = mysqli_query($con, $sql);
    echo "<option form-control value = ''>Seleccionar</option>";
    while ($row = mysqli_fetch_array($query)) {
        echo '<option form-control value = "' . $row['clave'] . '">' . " Clave: " .  $row['clave'] . ". Descripción: " . $row['Descripcion']  . '</option>';
    }
}
// Descripcion ,substring(c_ClaveProdServ,1,6) from c_claveprodserv where c_claveprodserv like '5015%' and c_claveprodserv like '%00';