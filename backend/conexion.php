<?php

$host=getenv('MYSQLHOST');
$user=getenv('MYSQLUSER');
$pass=getenv('MYSQLPASSWORD');
$db=getenv('MYSQLDATABASE');

if (!$host) {
    $host="localhost";
    $user="root";
    $pass="";
    $db="vinilocos";

    //Conexión
    $conn = new mysqli($host, $user, $pass, $db);

    //Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
}

//Conexión
$conn = new mysqli($host, $user, $pass, $db);

//Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


?>