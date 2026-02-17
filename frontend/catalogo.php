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

                <form id="formResena" class="modal-form">
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
                    <p class="form-feedback" id="formFeedback"></p>

                </form>
            </div>
        </div>

        <!-- CARRUSEL DE RESEÑAS -->
        <section class="reviews-section">
            <h2 class="reviews-section-title">Lo que dicen nuestros clientes</h2>
            <div class="reviews-carousel-container">
                <button class="carousel-btn carousel-btn-prev" aria-label="Reseña anterior">‹</button>
                <div class="reviews-carousel-wrapper">
                    <div class="reviews-carousel" id="reviewsCarousel">
                        <!-- Tarjeta de reseña 1 -->
                        <div class="review-card">
                            <div class="review-vinyl-image">
                                <img src="IMG/placeholder-vinyl.png" alt="Abbey Road" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22%3E%3Crect fill=%22%23C92C23%22 width=%22100%22 height=%22100%22/%3E%3Ctext fill=%22%23FFF3B0%22 font-family=%22Arial%22 font-size=%2214%22 x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22%3EVinyl%3C/text%3E%3C/svg%3E'">
                            </div>
                            <div class="review-content">
                                <h3 class="review-vinyl-title">Abbey Road</h3>
                                <div class="review-rating">
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                </div>
                                <p class="review-text">"Una experiencia increíble. La calidad del sonido es excepcional y el servicio de Vinilocos es impecable. Definitivamente volveré a comprar."</p>
                                <p class="review-author">— María González, Madrid</p>
                            </div>
                        </div>

                        <!-- Tarjeta de reseña 2 -->
                        <div class="review-card">
                            <div class="review-vinyl-image">
                                <img src="IMG/placeholder-vinyl.png" alt="Dark Side of the Moon" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22%3E%3Crect fill=%22%23C92C23%22 width=%22100%22 height=%22100%22/%3E%3Ctext fill=%22%23FFF3B0%22 font-family=%22Arial%22 font-size=%2214%22 x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22%3EVinyl%3C/text%3E%3C/svg%3E'">
                            </div>
                            <div class="review-content">
                                <h3 class="review-vinyl-title">The Dark Side of the Moon</h3>
                                <div class="review-rating">
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star">★</span>
                                </div>
                                <p class="review-text">"Vinilo en perfecto estado, llegó bien empaquetado y rápido. La atención al cliente es excelente. Muy recomendable."</p>
                                <p class="review-author">— Carlos Ruiz, Barcelona</p>
                            </div>
                        </div>

                        <!-- Tarjeta de reseña 3 -->
                        <div class="review-card">
                            <div class="review-vinyl-image">
                                <img src="IMG/placeholder-vinyl.png" alt="Rumours" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22%3E%3Crect fill=%22%23C92C23%22 width=%22100%22 height=%22100%22/%3E%3Ctext fill=%22%23FFF3B0%22 font-family=%22Arial%22 font-size=%2214%22 x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22%3EVinyl%3C/text%3E%3C/svg%3E'">
                            </div>
                            <div class="review-content">
                                <h3 class="review-vinyl-title">Rumours</h3>
                                <div class="review-rating">
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                </div>
                                <p class="review-text">"Mi colección de vinilos ha encontrado su lugar favorito. Calidad premium y un catálogo impresionante. ¡Gracias Vinilocos!"</p>
                                <p class="review-author">— Ana Martínez, Valencia</p>
                            </div>
                        </div>

                        <!-- Tarjeta de reseña 4 -->
                        <div class="review-card">
                            <div class="review-vinyl-image">
                                <img src="IMG/placeholder-vinyl.png" alt="Kind of Blue" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22%3E%3Crect fill=%22%23C92C23%22 width=%22100%22 height=%22100%22/%3E%3Ctext fill=%22%23FFF3B0%22 font-family=%22Arial%22 font-size=%2214%22 x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22%3EVinyl%3C/text%3E%3C/svg%3E'">
                            </div>
                            <div class="review-content">
                                <h3 class="review-vinyl-title">Kind of Blue</h3>
                                <div class="review-rating">
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star">★</span>
                                </div>
                                <p class="review-text">"La mejor tienda de vinilos que he encontrado. El sonido es cristalino y el precio es justo. Volveré sin duda."</p>
                                <p class="review-author">— Javier López, Sevilla</p>
                            </div>
                        </div>

                        <!-- Tarjeta de reseña 5 -->
                        <div class="review-card">
                            <div class="review-vinyl-image">
                                <img src="IMG/placeholder-vinyl.png" alt="Hotel California" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22%3E%3Crect fill=%22%23C92C23%22 width=%22100%22 height=%22100%22/%3E%3Ctext fill=%22%23FFF3B0%22 font-family=%22Arial%22 font-size=%2214%22 x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22%3EVinyl%3C/text%3E%3C/svg%3E'">
                            </div>
                            <div class="review-content">
                                <h3 class="review-vinyl-title">Hotel California</h3>
                                <div class="review-rating">
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                </div>
                                <p class="review-text">"Servicio excepcional y productos de primera calidad. Vinilocos ha superado todas mis expectativas. ¡Altamente recomendado!"</p>
                                <p class="review-author">— Laura Sánchez, Bilbao</p>
                            </div>
                        </div>

                        <!-- Tarjeta de reseña 6 -->
                        <div class="review-card">
                            <div class="review-vinyl-image">
                                <img src="IMG/placeholder-vinyl.png" alt="Thriller" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22%3E%3Crect fill=%22%23C92C23%22 width=%22100%22 height=%22100%22/%3E%3Ctext fill=%22%23FFF3B0%22 font-family=%22Arial%22 font-size=%2214%22 x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22%3EVinyl%3C/text%3E%3C/svg%3E'">
                            </div>
                            <div class="review-content">
                                <h3 class="review-vinyl-title">Thriller</h3>
                                <div class="review-rating">
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star">★</span>
                                </div>
                                <p class="review-text">"Increíble calidad y atención personalizada. Vinilocos es mi tienda de referencia para todos mis vinilos. ¡Gracias!"</p>
                                <p class="review-author">— Pedro Fernández, Málaga</p>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-btn carousel-btn-next" aria-label="Siguiente reseña">›</button>
            </div>
            <div class="carousel-dots" id="carouselDots"></div>
        </section>

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
