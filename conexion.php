<?php

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


?>