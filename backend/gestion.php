    <?php
    require "conexion.php";

    // Crear tabla catalogo si no existe
    $sql_create = "CREATE TABLE IF NOT EXISTS catalogo (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        descripcion VARCHAR(255) NOT NULL,
        artista VARCHAR(100) NOT NULL,
        precio DECIMAL(6,2) NOT NULL,
        anio INT(4) NOT NULL,
        foto VARCHAR(255),
        visible TINYINT(1) DEFAULT 1
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

    $conn->query($sql_create);

    $mensaje = "";
    $tipo_mensaje = "";
    $modo = isset($_GET['modo']) ? $_GET['modo'] : 'listar';
    $id_editar = isset($_GET['id']) ? $_GET['id'] : null;
    $vinilo_editar = null;

    // Obtener vinilo para editar
    if ($modo == 'editar' && $id_editar) {
        $sql = "SELECT * FROM catalogo WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_editar);
        $stmt->execute();
        $result = $stmt->get_result();
        $vinilo_editar = $result->fetch_assoc();
        $stmt->close();
    }

    // Procesar formulario de añadir/modificar
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["accion"])) {
        $accion = $_POST["accion"];
        $nombre = $_POST["nombre"];
        $artista = $_POST["artista"];
        $descripcion = $_POST["descripcion"];
        $precio = floatval($_POST["precio"]);
        $anio = intval($_POST["anio"]);
        $foto_ruta = null;
        
        // Procesar carga de foto
        $foto_ruta = null;
        if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
            // Guardar solo el nombre relativo dentro de IMG/ sin renombrar ni duplicar
            $nombre_foto = $_FILES["foto"]["name"];
            $tmp_foto = $_FILES["foto"]["tmp_name"];
            $foto_ruta = "../frontend/IMG/" . $nombre_foto;

            // Mover solo si no existe ya
            if (!file_exists($foto_ruta)) {
                move_uploaded_file($tmp_foto, $foto_ruta);
            }
        }
        
        // Si es modificar, obtener el id del formulario
        $id_para_modificar = null;
        if ($accion == "modificar" && isset($_POST["id_editar"])) {
            $id_para_modificar = intval($_POST["id_editar"]);
        }

        if ($accion == "añadir") {
    // Siempre define $sql y $stmt, aunque no haya foto
    if ($foto_ruta) {
        $sql = "INSERT INTO catalogo (nombre, artista, descripcion, precio, anio, foto) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdis", $nombre, $artista, $descripcion, $precio, $anio, $foto_ruta);
    } else {
        $sql = "INSERT INTO catalogo (nombre, artista, descripcion, precio, anio) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdi", $nombre, $artista, $descripcion, $precio, $anio);
    }

    if ($stmt->execute()) {
        header("Location: gestion.php?modo=listar");
        exit();
    } else {
        $mensaje = "Error al añadir el vinilo: " . $stmt->error;
        $tipo_mensaje = "error";
    }
    $stmt->close();
            } elseif ($accion == "modificar" && $id_para_modificar) {
                if ($foto_ruta) {
                    // Actualizar incluyendo la foto
                    $sql = "UPDATE catalogo SET nombre=?, descripcion=?, artista=?, precio=?, anio=?, foto=? WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssdisi", $nombre, $descripcion, $artista, $precio, $anio, $foto_ruta, $id_para_modificar);
                } else {
                    // Actualizar sin cambiar la foto
                    $sql = "UPDATE catalogo SET nombre=?, descripcion=?, artista=?, precio=?, anio=? WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssdi", $nombre, $descripcion, $artista, $precio, $anio, $id_para_modificar);
                }

                if ($stmt->execute()) {
                    header("Location: gestion.php?modo=listar");
                    exit();
                } else {
                    $mensaje = "Error al modificar el vinilo: " . $stmt->error;
                    $tipo_mensaje = "error";
                }
                $stmt->close();
            } elseif ($accion == "modificar" && $id_para_modificar) {
            if ($foto_ruta) {
                // Si hay foto nueva, actualizar incluyendo la foto
                $sql = "UPDATE catalogo SET nombre=?, descripcion=?, artista=?, precio=?, anio=?, foto=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssdiis", $nombre, $descripcion, $artista, $precio, $anio, $foto_ruta, $id_para_modificar);
            } else {
                // Sin foto nueva, no actualizar la foto
                $sql = "UPDATE catalogo SET nombre=?, descripcion=?, artista=?, precio=?, anio=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssdii", $nombre, $descripcion, $artista, $precio, $anio, $id_para_modificar);
            }
            
            if ($stmt->execute()) {
                header("Location: gestion.php?modo=listar");
                exit();
            } else {
                $mensaje = "Error al modificar el vinilo: " . $stmt->error;
                $tipo_mensaje = "error";
            }
            $stmt->close();
        }
    }

    // Cambiar visibilidad del vinilo
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cambiar_visibilidad_id"])) {
        $id = $_POST["cambiar_visibilidad_id"];
        $sql = "UPDATE catalogo SET visible = NOT visible WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            header("Location: gestion.php?modo=listar");
            exit();
        } else {
            $mensaje = "Error al cambiar visibilidad del vinilo.";
            $tipo_mensaje = "error";
        }
        $stmt->close();
    }

    // Eliminar vinilo
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["eliminar_id"])) {
        $id = $_POST["eliminar_id"];
        $sql = "DELETE FROM catalogo WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            header("Location: gestion.php?modo=listar");
            exit();
        } else {
            $mensaje = "Error al eliminar el vinilo.";
            $tipo_mensaje = "error";
        }
        $stmt->close();
    }

    // Obtener término de búsqueda
    $busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

    // Obtener todos los vinilos o filtrar por búsqueda
    if ($busqueda) {
        $busqueda_param = "%$busqueda%";
        $sql = "SELECT id, nombre, descripcion, artista, precio, anio, foto, visible FROM catalogo WHERE nombre LIKE ? OR artista LIKE ? OR descripcion LIKE ? ORDER BY nombre";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $busqueda_param, $busqueda_param, $busqueda_param);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } else {
        $sql = "SELECT id, nombre, descripcion, artista, precio, anio, foto, visible FROM catalogo ORDER BY nombre";
        $result = $conn->query($sql);
    }
    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../frontend/IMG/favicon.png">
    <link rel="stylesheet" href="../frontend/CSS/estilos.css">
    <title>Gestión de Vinilos - Vinilocos</title>
    </head>

    <body>

    <!-- Botón hamburguesa (vinilo giratorio) -->
    <div class="vinyl-btn" id="menuToggle">
        <img src="https://vinilocos-parallax.vercel.app/IMG/icono desplegable.png" alt="Menú Vinilo">
    </div>

    <!-- Menú lateral -->
    <aside class="sidebar" id="sidebar">
        <img src="https://vinilocos-parallax.vercel.app/IMG/whitelogo.png" alt="Logo Vinilocos" class="logo">
        <nav>
        <ul>
            <li><a href="../frontend/index.html">Inicio</a></li>
            <li><a href="../frontend/sobre-nosotros.html">Sobre nosotros</a></li>
            <li><a href="../frontend/contacto.html">Contacto</a></li>
            <li><a href="../frontend/catalogo.php">Catálogo</a></li>
            <li><a href="../frontend/login.php" class="btn-admin">Acceso admin</a></li>
        </ul>
        </nav>
    </aside>

    <!-- Contenido principal -->
    <main class="content">
        <h1>Gestión de Vinilos</h1>
        
        <?php if ($mensaje): ?>
        <div class="mensaje <?php echo $tipo_mensaje; ?>">
        <?php echo $mensaje; ?>
        </div>
        <?php endif; ?>

        <!-- Botones de navegación -->
        <div class="nav-gestion">
        <a href="gestion.php?modo=listar" class="btn <?php echo $modo == 'listar' ? 'activo' : ''; ?>">Ver Catálogo</a>
        <a href="gestion.php?modo=añadir" class="btn <?php echo $modo == 'añadir' ? 'activo' : ''; ?>">Añadir Vinilo</a>
        </div>

        <!-- FORMULARIO AÑADIR/EDITAR -->
        <?php if ($modo == 'añadir' || $modo == 'editar'): ?>
        <div class="form-container">
        <h2><?php echo $modo == 'añadir' ? 'Añadir Nuevo Vinilo' : 'Modificar Vinilo'; ?></h2>
        
        <form method="POST" enctype="multipart/form-data" class="form-vinilo">
            <input type="hidden" name="accion" value="<?php echo $modo == 'editar' ? 'modificar' : 'añadir'; ?>">
            <?php if ($modo == 'editar'): ?>
            <input type="hidden" name="id_editar" value="<?php echo $id_editar; ?>">
            <?php endif; ?>

            <div class="form-group">
            <label for="foto">Foto del Vinilo:</label>
            <input type="file" id="foto" name="foto" accept="image/*">
            <?php if ($modo == 'editar' && $vinilo_editar && $vinilo_editar['foto']): ?>
            <p style="color: var(--gray); margin-top: 0.5rem; font-size: 0.9rem;">Foto actual:</p>
            <img src="<?php echo htmlspecialchars($vinilo_editar['foto']); ?>" alt="Vinilo" style="max-width: 150px; border-radius: 5px; margin-top: 0.5rem;">
            <?php endif; ?>
            </div>

            <div class="form-group">
            <label for="nombre">Nombre del Vinilo:</label>
            <input type="text" id="nombre" name="nombre" required value="<?php echo $modo == 'editar' ? htmlspecialchars($vinilo_editar['nombre']) : ''; ?>">
            </div>

            <div class="form-group">
            <label for="artista">Artista:</label>
            <input type="text" id="artista" name="artista" required value="<?php echo $modo == 'editar' ? htmlspecialchars($vinilo_editar['artista']) : ''; ?>">
            </div>

            <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4"><?php echo $modo == 'editar' ? htmlspecialchars($vinilo_editar['descripcion']) : ''; ?></textarea>
            </div>

            <div class="form-group">
            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" required value="<?php echo $modo == 'editar' ? $vinilo_editar['precio'] : ''; ?>">
            </div>

            <div class="form-group">
            <label for="anio">Año:</label>
            <input type="number" id="anio" name="anio" min="1900" max="2100" required value="<?php echo $modo == 'editar' ? $vinilo_editar['anio'] : ''; ?>">
            </div>

            <div class="form-buttons">
            <button type="submit" class="btn-submit">Guardar</button>
            <a href="gestion.php?modo=listar" class="btn-cancel">Cancelar</a>
            </div>
        </form>
        </div>

        <!-- TABLA LISTAR -->
        <?php else: ?>
        <div class="tabla-container">
            <div class="buscador-container">
                <form method="GET" class="form-buscador">
                    <input type="text" name="busqueda" placeholder="Buscar por nombre, artista o descripción..." value="<?php echo htmlspecialchars($busqueda); ?>" class="input-buscador">
                    <button type="submit" class="btn-buscar">Buscar</button>
                    <?php if ($busqueda): ?>
                    <a href="gestion.php?modo=listar" class="btn-limpiar">Limpiar</a>
                    <?php endif; ?>
                </form>
            </div>
        <table class="tabla-vinilos">
            <thead>
            <tr>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Artista</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Año</th>
                <th>Visible</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    if ($row["foto"]) {
                        echo "<td><img src='" . htmlspecialchars($row["foto"]) . "' alt='Vinilo' style='max-width: 60px; max-height: 60px; border-radius: 5px;'></td>";
                    } else {
                        echo "<td style='text-align:center; color: var(--gray);'>Sin foto</td>";
                    }
                    echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["artista"]) . "</td>";
                    echo "<td>" . htmlspecialchars(substr($row["descripcion"], 0, 50)) . "...</td>";
                    echo "<td>€" . number_format($row["precio"], 2) . "</td>";
                    echo "<td>" . $row["anio"] . "</td>";
                    echo "<td>";
                    echo "<form method='POST' style='display:inline;'>";
                    echo "<input type='hidden' name='cambiar_visibilidad_id' value='" . $row["id"] . "'>";
                    $estado = $row["visible"] ? "Visible" : "Oculto";
                    $clase = $row["visible"] ? "btn-visible" : "btn-oculto";
                    echo "<button type='submit' class='btn-visibilidad $clase'>$estado</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "<td>";
                    echo "<a href='gestion.php?modo=editar&id=" . $row["id"] . "' class='btn-editar'>Editar</a>";
                    echo "<form method='POST' style='display:inline;'>";
                    echo "<input type='hidden' name='eliminar_id' value='" . $row["id"] . "'>";
                    echo "<button type='submit' class='btn-eliminar' onclick='return confirm(\"¿Estás seguro?\")'>Eliminar</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8' style='text-align:center; padding: 2rem;'>No hay vinilos registrados.</td></tr>";
            }
            ?>
            </tbody>
        </table>
        </div>
        <?php endif; ?>
    </main>

    <footer class="footer">
        <div class="footer-container">
        <div class="footer-section">
            <img src="https://vinilocos-parallax.vercel.app/IMG/whitelogo.png" alt="Logo Vinilocos" class="footer-logo">
            <p class="footer-tagline">Donde la música nunca pasa de moda 🎶</p>
        </div>

        <div class="footer-section">
            <h3>Explora</h3>
            <ul class="footer-links">
            <li><a href="../frontend/index.html">Inicio</a></li>
            <li><a href="../frontend/sobre-nosotros.html">Sobre nosotros</a></li>
            <li><a href="../frontend/contacto.html">Contacto</a></li>
            <li><a href="../frontend/catalogo.php">Catálogo</a></li>
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
            <a href="#" aria-label="Facebook"><img src="https://vinilocos-parallax.vercel.app/IMG/facebook.png" alt="Facebook"></a>
            <a href="#" aria-label="Instagram"><img src="https://vinilocos-parallax.vercel.app/IMG/instagram.png" alt="Instagram"></a>
            <a href="#" aria-label="Twitter"><img src="https://vinilocos-parallax.vercel.app/IMG/twitter.png" alt="Twitter"></a>
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