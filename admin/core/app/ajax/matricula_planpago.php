<?php
/* if (isset($_GET['alumn_id'])) {

    include "../../controller/Database.php";
    $con = Database::getCon();
    $person = $_GET['alumn_id'];

    $sql = "SELECT * FROM person WHERE id = $person";
    $gr = " SELECT DISTINCT person.id, person.code
    FROM inscription
    INNER JOIN person ON inscription.alumn_id = person.id WHERE inscription.alumn_id = $person;
    ";
    $query = mysqli_query($con, $gr);
    while ($row = mysqli_fetch_array($query)) {
        echo '<option form-control value = "' . $row['id'] . '">' . utf8_encode($row['code']) .'</option>';
    }
} */
