<?php
if (isset($_GET['name_periodo'])) {

    include "../../controller/Database.php";
    $con = Database::getCon();
    $perios = $_GET['name_periodo'];

    $sql = "SELECT * FROM period WHERE id = $perios";
    $e= "SELECT period_type.tipo FROM period join period_type WHERE period.id = '$perios' and period.periodo = period_type.id_type";
    $query = mysqli_query($con, $e);
    while ($row = mysqli_fetch_array($query)) {
        echo '<option form-control value = "' . $row['tipo'] . '">' . utf8_encode($row['tipo']) . '</option>';
    }
}