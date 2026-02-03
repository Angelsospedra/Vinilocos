<?php
require "../backend/conexion.php";

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
    <link rel="icon" href="IMG/favicon.png">
    <link rel="stylesheet" href="CSS/estilos.css">
    <title>Catálogo - Vinilocos</title>
</head>
<body>

    <!-- Botón hamburguesa (vinilo giratorio) -->
    <div class="vinyl-btn" id="menuToggle">
        <img src="IMG/icono desplegable.png" alt="Menú Vinilo">
    </div>

    <!-- Menú lateral -->
    <aside class="sidebar" id="sidebar">
        <img src="IMG/whitelogo.png" alt="Logo Vinilocos" class="logo">
        <nav>
            <ul>
                <li><a href="https://vinilocos-g8aa.vercel.app/">Inicio</a></li>
                <li><a href="https://vinilocos-g8aa.vercel.app/sobre-nosotros.html">Sobre nosotros</a></li>
                <li><a href="https://vinilocos-g8aa.vercel.app/contacto.html">Contacto</a></li>
                <li><a href="https://vinilocos-production.up.railway.app/frontend/catalogo.php">Catálogo</a></li>
                <li><a href="https://vinilocos-production.up.railway.app/frontend/login.php" class="btn-admin">Acceso admin</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Contenido principal -->
    <main class="content">
        <header>
            <h1>Vinilocos</h1>
            <h2>Catálogo de Vinilos</h2>
        </header>
    
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

    </main>

    <footer class="footer">
        <div class="footer-container">
            <!-- Columna 1: Logo y lema -->
            <div class="footer-section">
                <img src="IMG/whitelogo.png" alt="Logo Vinilocos" class="footer-logo">
                <p class="footer-tagline">Donde la música nunca pasa de moda 🎶</p>
            </div>

            <!-- Columna 2: Navegación -->
            <div class="footer-section">
                <h3>Explora</h3>
                <ul class="footer-links">
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="sobre-nosotros.html">Sobre nosotros</a></li>
                    <li><a href="contacto.html">Contacto</a></li>
                    <li><a href="catalogo.php">Catálogo</a></li>
                </ul>
            </div>

            <!-- Columna 3: Contacto -->
            <div class="footer-section">
                <h3>Contacto</h3>
                <p>Email: <a href="mailto:info@vinilocos.com">info@vinilocos.com</a></p>
                <p>Tel: <a href="tel:+34123456789">+34 123 456 789</a></p>
                <p>Madrid, España</p>
            </div>

            <!-- Columna 4: Redes sociales -->
            <div class="footer-section">
                <h3>Síguenos</h3>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><img src="IMG/facebook.png" alt="Facebook"></a>
                    <a href="#" aria-label="Instagram"><img src="IMG/instagram.png" alt="Instagram"></a>
                    <a href="#" aria-label="Twitter"><img src="IMG/twitter.png" alt="Twitter"></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© 2025 Vinilocos. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Enlazamos el script al final -->
    <script src="JS/main.js"></script>
    
    <?php
    $conn->close();
    ?>
</body>
</html>
