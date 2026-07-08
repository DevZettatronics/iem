<?php



if (isset($_GET['programa'])) {

    include "../../controller/Database.php";
    $con = Database::getCon();
    $estado = $_GET['programa'];
   
    $sql = "SELECT * FROM program WHERE id = $estado";
    // echo '<option value = "">Nomenclatura</option>';
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo '<option form-control value = "' . $row['grade'] . '">' . utf8_encode($row['grade']) . '</option>';
    }
}
?>

  