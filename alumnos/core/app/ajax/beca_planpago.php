<?php
if (isset($_GET['beca'])) {

    include "../../controller/Database.php";
    $con = Database::getCon();
    $becas = $_GET['beca'];

    $sql = "SELECT * FROM becas WHERE id = $becas";
    $desc = " SELECT  becas.id, becas.porcentaje
    FROM becas
    INNER JOIN person ON becas.id = person.beca WHERE becas.id = $becas;";

    $query = mysqli_query($con, $desc);
    while ($row = mysqli_fetch_array($query)) {
        echo '<option form-control value = "' . $row['porcentaje'] . '">' . utf8_encode($row['porcentaje']) . '</option>';
    }
}
