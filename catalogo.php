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
                <li><a href="index.html">Inicio</a></li>
                <li><a href="sobre-nosotros.html">Sobre nosotros</a></li>
                <li><a href="contacto.html">Contacto</a></li>
                <li><a href="catalogo.php">Catálogo</a></li>
                <li><a href="login.php" class="btn-admin">Acceso admin</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Contenido principal -->
    <main class="content">
        <h1>Catálogo de Vinilos</h1>
        <p style="max-width: 800px; color: var(--gray); margin-top: 0.5rem;">
            Aquí puedes ver todos los vinilos que actualmente están disponibles en nuestra tienda.
        </p>

        <section class="catalogo-container">
            <?php if ($result && $result->num_rows > 0): ?>
                <div class="catalogo-grid">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <article class="vinilo-card">
                            <div class="vinilo-imagen">
                                <?php if (!empty($row["foto"])): ?>
                                    <img src="<?php echo htmlspecialchars($row["foto"]); ?>"
                                         alt="<?php echo htmlspecialchars($row["nombre"]); ?>">
                                <?php else: ?>
                                    <div class="vinilo-sin-foto">Sin foto</div>
                                <?php endif; ?>
                            </div>
                            <div class="vinilo-info">
                                <h3><?php echo htmlspecialchars($row["nombre"]); ?></h3>
                                <p class="vinilo-artista"><?php echo htmlspecialchars($row["artista"]); ?></p>
                                <p class="vinilo-descripcion">
                                    <?php
                                    $texto = $row["descripcion"];
                                    if (mb_strlen($texto) > 150) {
                                        $texto = mb_substr($texto, 0, 150) . '...';
                                    }
                                    echo htmlspecialchars($texto);
                                    ?>
                                </p>
                                <div class="vinilo-meta">
                                    <span class="vinilo-precio">
                                        €<?php echo number_format($row["precio"], 2); ?>
                                    </span>
                                    <span class="vinilo-anio">
                                        Año: <?php echo (int)$row["anio"]; ?>
                                    </span>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p style="margin-top: 2rem;">No hay vinilos visibles en este momento.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <img src="IMG/whitelogo.png" alt="Logo Vinilocos" class="footer-logo">
                <p class="footer-tagline">Donde la música nunca pasa de moda 🎶</p>
            </div>

            <div class="footer-section">
                <h3>Explora</h3>
                <ul class="footer-links">
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="sobre-nosotros.html">Sobre nosotros</a></li>
                    <li><a href="contacto.html">Contacto</a></li>
                    <li><a href="catalogo.php">Catálogo</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Contacto</h3>
                <p>Email: <a href="mailto:info@vinilocos.com">info@vinilocos.com</a></p>
                <p>Tel: <a href="tel:+34123456789">+34 123 456 789</a></p>
                <p>Madrid, España</p>
            </div>

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

    <script src="JS/main.js"></script>
</body>

</html>