<?php
if (isset($_GET['periodo'])) {

    include "../../controller/Database.php";
    $con = Database::getCon();
    $periodos = $_GET['periodo'];

    $sql = "SELECT * FROM period WHERE id = $periodos";
    $e = " SELECT DISTINCT inscription.period_id, team.grade, team.id, team.letter
    FROM inscription
    INNER JOIN team ON inscription.team_id = team.id WHERE inscription.period_id = $periodos;
    ";
    $query = mysqli_query($con, $e); ?>
    <option value="">-- SELECCIONE --</option>
    <?php
    while ($row = mysqli_fetch_array($query)) { 
        
        echo '<option form-control value = "' . $row['id'] . '">' . $row['grade'] . " - " . $row['letter'] . '</option>';
    }
}
