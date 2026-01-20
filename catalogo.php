<?php
require "conexion.php";

// Obtener todos los vinilos marcados como visibles
$sql = "SELECT nombre, descripcion, artista, precio, anio, foto 
        FROM catalogo 
        WHERE visible = 1 
        ORDER BY nombre";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/estilos.css">
    <title>Catálogo - Vinilocos</title>
</head>
<body>
    <h1>Catálogo de Vinilos</h1>
    
    <?php if ($result && $result->num_rows > 0): ?>
        <div class="catalogo-container">
            <div class="catalogo-grid">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="vinilo-card">
                        <div class="vinilo-contenido">
                            <?php if (!empty($row["foto"])): ?>
                                <img src="<?php echo htmlspecialchars($row["foto"]); ?>" 
                                     alt="<?php echo htmlspecialchars($row["nombre"]); ?>"
                                     class="vinilo-imagen"
                                     style="width: 100px !important; height: 100px !important; max-width: 100px !important; max-height: 100px !important; object-fit: cover !important;">
                            <?php endif; ?>
                            
                            <div class="vinilo-info">
                                <h2><?php echo htmlspecialchars($row["nombre"]); ?></h2>
                                <p><strong>Artista:</strong> <?php echo htmlspecialchars($row["artista"]); ?></p>
                                <p><strong>Descripción:</strong> <?php echo htmlspecialchars($row["descripcion"]); ?></p>
                                <p><strong>Precio:</strong> €<?php echo number_format($row["precio"], 2); ?></p>
                                <p><strong>Año:</strong> <?php echo (int)$row["anio"]; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php else: ?>
        <p>No hay vinilos visibles en este momento.</p>
    <?php endif; ?>
    
    <?php
    $conn->close();
    ?>
</body>
</html>
