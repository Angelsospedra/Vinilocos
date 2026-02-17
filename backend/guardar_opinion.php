<?php
/**
 * guardar_opinion.php
 * 
 * Guarda una opinión en la base de datos
 * Versión mejorada: Funciona tanto con reload como con AJAX
 */

require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $ciudad = trim($_POST["ciudad"] ?? "");
    $comentario = trim($_POST["comentario"] ?? "");
    $viniloId = $_POST["viniloId"] ?? null;

    // Validación básica
    if (empty($nombre) || empty($ciudad) || empty($comentario) || !$viniloId) {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            // Es una petición AJAX
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => 'Campos incompletos']);
        } else {
            // Es una petición tradicional
            die("Error: Campos incompletos");
        }
        exit();
    }

    // Prepared statement (evita SQL injection)
    $stmt = $conn->prepare(
        "INSERT INTO opiniones (nombre, ciudad, comentario, viniloId) 
         VALUES (?, ?, ?, ?)"
    );

    if (!$stmt) {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'Error en la base de datos: ' . $conn->error]);
        } else {
            die("Error en la base de datos: " . $conn->error);
        }
        exit();
    }

    $stmt->bind_param("sssi", $nombre, $ciudad, $comentario, $viniloId);

    if ($stmt->execute()) {
        // ✅ Éxito: Verificar si es AJAX o petición normal
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            // Es AJAX: Retornar JSON
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Opinión guardada exitosamente'
            ]);
        } else {
            // Es petición normal: Redirigir (fallback)
            header("Location: ../catalogo.php?ok=1");
            exit();
        }
    } else {
        // ❌ Error al ejecutar
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'Error al guardar la opinión: ' . $stmt->error]);
        } else {
            echo "Error al guardar la opinión: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
} else {
    // Método no permitido
    http_response_code(405);
    echo "Método no permitido";
}
?>