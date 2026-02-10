<?php
require "../backend/conexion.php";

// Obtener todos los vinilos visibles (IMPORTANTE: incluir id)
$sql = "SELECT id, nombre, descripcion, artista, precio, anio, foto 
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

    <!-- Botón hamburguesa -->
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
                <li><a href="catalogo.php">Catálogo</a></li>
                <li><a href="login.php" class="btn-admin">Acceso admin</a></li>
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
                                    <img 
                                        src="<?php echo htmlspecialchars($row["foto"]); ?>" 
                                        alt="<?php echo htmlspecialchars($row["nombre"]); ?>"
                                        class="vinilo-imagen"
                                        style="width:100px;height:100px;object-fit:cover;">
                                <?php endif; ?>

                                <div class="vinilo-info">
                                    <h2><?php echo htmlspecialchars($row["nombre"]); ?></h2>
                                    <p><strong>Artista:</strong> <?php echo htmlspecialchars($row["artista"]); ?></p>
                                    <p><strong>Descripción:</strong> <?php echo htmlspecialchars($row["descripcion"]); ?></p>
                                    <p><strong>Precio:</strong> €<?php echo number_format($row["precio"], 2); ?></p>
                                    <p><strong>Año:</strong> <?php echo (int)$row["anio"]; ?></p>

                                    <!-- BOTÓN RESEÑAS -->
                                    <button 
                                        class="btn-resenas"
                                        data-vinilo-id="<?php echo $row['id']; ?>">
                                        Reseñas
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>

                </div>
            </div>
        <?php else: ?>
            <p>No hay vinilos visibles en este momento.</p>
        <?php endif; ?>

        <!-- MODAL RESEÑAS -->
        <div class="modal" id="modalResena">
            <div class="modal-content">
                <button class="close-modal" aria-label="Cerrar">×</button>

                <h3 class="modal-title">Dejar una reseña</h3>
                <p class="modal-subtitle">Cuéntanos qué te ha parecido este vinilo</p>

                <form action="guardar_opinion.php" method="POST" class="modal-form">
                    <input type="hidden" name="viniloId" id="modalViniloId">

                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" placeholder="Tu nombre" required>
                    </div>

                    <div class="form-group">
                        <label>Ciudad</label>
                        <input type="text" name="ciudad" placeholder="Tu ciudad" required>
                    </div>

                    <div class="form-group">
                        <label>Comentario</label>
                        <textarea name="comentario" rows="4" placeholder="Escribe tu opinión..." required></textarea>
                    </div>

                    <button type="submit" class="btn-enviar">Enviar opinión</button>
                </form>
            </div>
        </div>


    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <img src="IMG/whitelogo.png" class="footer-logo">
                <p>Donde la música nunca pasa de moda 🎶</p>
            </div>

            <div class="footer-section">
                <h3>Explora</h3>
                <ul>
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="sobre-nosotros.html">Sobre nosotros</a></li>
                    <li><a href="contacto.html">Contacto</a></li>
                    <li><a href="catalogo.php">Catálogo</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Contacto</h3>
                <p>Email: info@vinilocos.com</p>
                <p>Madrid, España</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 Vinilocos</p>
        </div>
    </footer>

    <script src="JS/main.js"></script>

    <?php $conn->close(); ?>
</body>
</html>
