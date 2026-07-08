<?php
function conectar (){
    $conn = null;
    $host = '127.0.0.1';
    $db = 'zettservice';
    $user = 'root';
    $pwd = 'pcplus123';
    try{
        $conn = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pwd);
    }
    catch (PDOException $e) {
        echo '<p>No se puede conectar ala base de datos !!</p>';
        exit;
    }
    return $conn;
}