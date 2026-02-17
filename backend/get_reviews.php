<?php
/**
 * get_reviews.php
 * Retorna el HTML del carrusel de opiniones sin toda la página
 * Usado por AJAX en main.js para actualizar dinámicamente
 */

require_once "conexion.php";

header('Content-Type: text/html; charset=utf-8');

// Obtener todas las opiniones con datos del vinilo correspondiente
$sqlOpiniones = "SELECT 
                    o.id,
                    o.nombre,
                    o.ciudad,
                    o.comentario,
                    o.viniloId,
                    c.nombre as vinilo_nombre,
                    c.foto as vinilo_foto
                 FROM opiniones o
                 LEFT JOIN catalogo c ON o.viniloId = c.id
                 ORDER BY o.createdAt DESC";

$resultOpiniones = $conn->query($sqlOpiniones);
$opiniones = [];

if ($resultOpiniones && $resultOpiniones->num_rows > 0) {
    while ($row = $resultOpiniones->fetch_assoc()) {
        $opiniones[] = $row;
    }
}

$conn->close();

// Generar HTML de las tarjetas
if (!empty($opiniones)):
    foreach ($opiniones as $opinion):
        ?>
        <div class="review-card">
            <div class="review-vinyl-image">
                <?php if (!empty($opinion["vinilo_foto"])): ?>
                    <img 
                        src="<?php echo htmlspecialchars($opinion["vinilo_foto"]); ?>" 
                        alt="<?php echo htmlspecialchars($opinion["vinilo_nombre"]); ?>"
                        onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22%3E%3Crect fill=%22%23C92C23%22 width=%22100%22 height=%22100%22/%3E%3Ctext fill=%22%23FFF3B0%22 font-family=%22Arial%22 font-size=%2214%22 x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22%3EVinyl%3C/text%3E%3C/svg%3E'">
                <?php else: ?>
                    <img 
                        src="IMG/placeholder-vinyl.png" 
                        alt="Vinilo"
                        onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22%3E%3Crect fill=%22%23C92C23%22 width=%22100%22 height=%22100%22/%3E%3Ctext fill=%22%23FFF3B0%22 font-family=%22Arial%22 font-size=%2214%22 x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22%3EVinyl%3C/text%3E%3C/svg%3E'">
                <?php endif; ?>
            </div>
            <div class="review-content">
                <h3 class="review-vinyl-title"><?php echo htmlspecialchars($opinion["vinilo_nombre"] ?? "Vinilo"); ?></h3>
                <div class="review-rating">
                    <span class="star filled">★</span>
                    <span class="star filled">★</span>
                    <span class="star filled">★</span>
                    <span class="star filled">★</span>
                    <span class="star filled">★</span>
                </div>
                <p class="review-text">"<?php echo htmlspecialchars($opinion["comentario"]); ?>"</p>
                <p class="review-author">— <?php echo htmlspecialchars($opinion["nombre"]); ?>, <?php echo htmlspecialchars($opinion["ciudad"]); ?></p>
            </div>
        </div>
        <?php
    endforeach;
else:
    // Mostrar un mensaje si no hay opiniones
    ?>
    <div class="review-card">
        <div class="review-vinyl-image">
            <img src="IMG/placeholder-vinyl.png" alt="No hay opiniones" 
                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22%3E%3Crect fill=%22%23C92C23%22 width=%22100%22 height=%22100%22/%3E%3Ctext fill=%22%23FFF3B0%22 font-family=%22Arial%22 font-size=%2214%22 x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22%3EVinyl%3C/text%3E%3C/svg%3E'">
        </div>
        <div class="review-content">
            <h3 class="review-vinyl-title">Sé el primero en opinar</h3>
            <div class="review-rating">
                <span class="star filled">★</span>
                <span class="star filled">★</span>
                <span class="star filled">★</span>
                <span class="star filled">★</span>
                <span class="star filled">★</span>
            </div>
            <p class="review-text">"Aún no hay opiniones. ¡Déjanos tu comentario sobre tu vinilo favorito!"</p>
            <p class="review-author">— Vinilocos Team</p>
        </div>
    </div>
    <?php
endif;
?>
