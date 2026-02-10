<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $ciudad = $_POST["ciudad"];
    $comentario = $_POST["comentario"];
    $viniloId = $_POST["viniloId"];

    // Prepared statement (evita SQL injection)
    $stmt = $conn->prepare(
        "INSERT INTO opiniones (nombre, ciudad, comentario, viniloId) 
         VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param("sssi", $nombre, $ciudad, $comentario, $viniloId);

    if ($stmt->execute()) {
        header("Location: catalogo.php?ok=1");
        exit();
    } else {
        echo "Error al guardar la opinión";
    }
}
?>