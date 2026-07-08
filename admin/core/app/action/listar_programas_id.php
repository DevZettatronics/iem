<?php

if (isset($_GET['program_a'])) {  
    include "../../controller/Database.php";
    $con = Database::getCon();
    $estado = $_GET['program_a'];
   
    $sql = "SELECT * FROM program WHERE id = $estado";
    // echo '<option value = "">Nomenclatura</option>';
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo '<option form-control value = "' . $row['id'] . '">' . utf8_encode($row['id']) . '</option>';
    }

}
?>

