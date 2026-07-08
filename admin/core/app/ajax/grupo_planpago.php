<?php
if (isset($_GET['grupo']) && isset($_GET['periodo'])) {

    include "../../controller/Database.php";
    $con = Database::getCon();
    $group = $_GET['grupo'];
    $peris = $_GET['periodo'];


    $sql = "SELECT * FROM team WHERE id = $group";
    $gr = " SELECT DISTINCT inscription.alumn_id, inscription.team_id, person.name, person.id as nom_al, person.lastname, person.code, inscription.period_id, period.id
    FROM inscription
    JOIN period ON  inscription.period_id = period.id
    INNER JOIN person ON inscription.alumn_id = person.id
    WHERE inscription.team_id = $group AND inscription.period_id = $peris;
    ";
    $query = mysqli_query($con, $gr);
    while ($row = mysqli_fetch_array($query)) {
        echo '<option form_comtrol value = "' . $row['nom_al'] . '">' . $row['code']. "-" . $row['name'] . " " . $row['lastname'] . '</option>';
    }
}


/* DISTINCT */