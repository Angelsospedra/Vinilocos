<?php
// Intentar coger variables de entorno (Railway)
$host = getenv('MYSQLHOST');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$db   = getenv('MYSQLDATABASE');

// Si NO existen → estamos en local (XAMPP)
if (!$host) {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "vinilocos";
}

// Crear conexión (solo una vez)
$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
