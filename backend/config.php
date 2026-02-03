<?php

// Configuración de la Base de Datos
// Para desarrollo local en XAMPP, ajusta estos valores según tu instalación

// Obtener del entorno o usar valores por defecto
$db_host = getenv('MYSQLHOST') ?: 'localhost';
$db_user = getenv('MYSQLUSER') ?: 'root';
$db_pass = getenv('MYSQLPASSWORD') ?: '';
$db_name = getenv('MYSQLDATABASE') ?: 'vinilocos';

// Retornar configuración
return [
    'host' => $db_host,
    'user' => $db_user,
    'pass' => $db_pass,
    'db'   => $db_name
];

?>
