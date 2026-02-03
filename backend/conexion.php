<?php

// Cargar configuración
$config = require 'config.php';

$host = $config['host'];
$user = $config['user'];
$pass = $config['pass'];
$db = $config['db'];

//Conexión
$conn = new mysqli($host, $user, $pass, $db);

//Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


?>