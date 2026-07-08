<?php
if (isset($_GET['estado'])) {

    include "../../controller/Database.php";
    $con = Database::getCon();

    $estado = intval($_REQUEST['estado']);
    $sql = "SELECT * FROM municipios WHERE estado_id = '$estado'";
    echo '<option value = "">Alcaldia/Municipio</option>';
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo '<option value = "' . $row['id'] . '">' . utf8_encode($row['nombre']) . '</option>';
    }
}
