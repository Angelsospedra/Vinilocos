<?php
require "../backend/conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $correo = $_POST["correo"];
    $pass = $_POST["contraseña"];

    $sql = "SELECT id, nombre, apellido, correo, contraseña FROM usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {

        // OJO: aquí deben haber 5 variables para 5 columnas
        $stmt->bind_result($id, $nombre, $apellido, $correo_db, $hash_guardado);
        $stmt->fetch();

        // Verificar contraseña
        if ($pass === $hash_guardado) {
            header("Location: ../backend/gestion.php");
            exit();
        } else {
            $mensaje = "Contraseña incorrecta.";
            $tipo_mensaje = "error";
        }

    } else {
        $mensaje = "El correo no existe.";
        $tipo_mensaje = "error";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="IMG/favicon.png">
  <link rel="stylesheet" href="CSS/estilos.css">
  <title>Login Admin - Vinilocos</title>
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
        <li><a href="https://vinilocos-parallax.vercel.app/">Inicio</a></li>
        <li><a href="https://vinilocos-parallax.vercel.app/sobre-nosotros.html">Sobre nosotros</a></li>
        <li><a href="https://vinilocos-parallax.vercel.app/contacto.html">Contacto</a></li>
        <li><a href="https://vinilocos-production.up.railway.app/frontend/catalogo.php">Catálogo</a></li>
        <li><a href="https://vinilocos-production.up.railway.app/frontend/login.php" class="btn-admin">Acceso admin</a></li>
      </ul>
    </nav>
  </aside>

  <!-- Contenido principal -->
  <main class="content">
    <div class="login-container">
      <h2>Acceso Admin</h2>

      <?php if ($mensaje): ?>
      <div class="mensaje <?php echo $tipo_mensaje; ?>">
        <?php echo $mensaje; ?>
      </div>
      <?php endif; ?>

      <form method="POST">
        <div class="form-group">
          <label for="correo">Correo Electrónico:</label>
          <input type="email" id="correo" name="correo" required placeholder="tu@email.com">
        </div>

        <div class="form-group">
          <label for="contraseña">Contraseña:</label>
          <input type="password" id="contraseña" name="contraseña" required placeholder="••••••••">
        </div>

        <button type="submit" class="btn-login">Iniciar sesión</button>
      </form>

      <a href="index.html" class="btn-volver">← Volver al inicio</a>
    </div>
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
          <li><a href="#">Catálogo</a></li>
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

  <script>
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');

    menuToggle.addEventListener('click', function() {
      sidebar.classList.toggle('open');
      menuToggle.classList.toggle('active');
    });

    // Cerrar menú al hacer click en un enlace
    const sidebarLinks = sidebar.querySelectorAll('a');
    sidebarLinks.forEach(link => {
      link.addEventListener('click', function() {
        sidebar.classList.remove('open');
        menuToggle.classList.remove('active');
      });
    });
  </script>

</body>

</html>
