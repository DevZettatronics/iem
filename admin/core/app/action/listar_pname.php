<?php
  

if (isset($_GET['periodo_academico'])) {

    include "../../controller/Database.php";
    $con = Database::getCon();
    $estado = $_GET['periodo_academico'];
   
    $sql = "SELECT * FROM period_type WHERE id = $estado";
    // echo '<option value = "">Nomenclatura</option>';
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo '<option form-control value = "' . $row['tipo'] . '">' . utf8_encode($row['tipo']) . '</option>';
    }
}
?>

