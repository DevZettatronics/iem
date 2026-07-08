<?php
include "../../controller/Database.php";
$con = Database::getCon();

$query = mysqli_query($con, "
    SELECT 
        id,
        code,
        name,
        lastname
    FROM person
    ORDER BY name ASC
");

echo "<option value=''>Seleccionar alumno</option>";

while ($row = mysqli_fetch_assoc($query)) {

    $id = $row['id'];
    $texto = $row['code'] . " - " . $row['name'] . " " . $row['lastname'];

    echo "<option value='$id'>$texto</option>";
}