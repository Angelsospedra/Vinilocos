# Proyecto Vinilocos - Estructura Frontend/Backend

## Descripción del Proyecto
Vinilocos es una tienda de vinilos que cuenta con un sitio web con catálogo, gestión de administrador y más.

## Estructura de Carpetas

```
Vinilocos/
├── frontend/                 # Archivos de presentación
│   ├── CSS/
│   │   └── estilos.css
│   ├── IMG/                  # Imágenes del proyecto (incluyendo portadas de vinilos)
│   ├── JS/
│   │   └── main.js
│   ├── index.html            # Página de inicio
│   ├── contacto.html         # Página de contacto
│   ├── sobre-nosotros.html   # Página sobre nosotros
│   ├── catalogo.php          # Catálogo de vinilos (PHP)
│   └── login.php             # Página de login para admin
│
├── backend/                  # Archivos de servidor
│   ├── conexion.php          # Conexión a base de datos
│   ├── gestion.php           # Panel de gestión de vinilos (admin)
│   ├── adminer.php           # Herramienta de administración de BD
│   └── vinilocos.sql         # Script SQL de base de datos
│
├── Dockerfile                # Configuración de Docker
├── index.php                 # Punto de entrada (redirige a frontend/)
└── README.md                 # Este archivo

```

## Cómo Funciona

### Frontend
- **index.html, contacto.html, sobre-nosotros.html**: Páginas estáticas HTML
- **catalogo.php**: Página dinámica que muestra vinilos de la BD (requiere ../backend/conexion.php)
- **login.php**: Formulario de login (requiere ../backend/conexion.php y redirige a ../backend/gestion.php)
- **CSS/estilos.css**: Estilos globales para todo el sitio
- **JS/main.js**: JavaScript para interactividad (menú hamburguesa, etc.)
- **IMG/**: Todas las imágenes incluyendo portadas de vinilos

### Backend
- **conexion.php**: Crea la conexión mysqli a la base de datos usando variables de entorno
- **gestion.php**: Panel administrativo para CRUD de vinilos
- **adminer.php**: Herramienta web para administrar la BD
- **vinilocos.sql**: Script SQL para crear la estructura de la BD

## Rutas Importantes

| Página | Ruta |
|--------|------|
| Inicio | `/Vinilocos/index.php` → `frontend/index.html` |
| Catálogo | `frontend/catalogo.php` |
| Login Admin | `frontend/login.php` |
| Gestión Admin | `backend/gestion.php` |
| Adminer | `backend/adminer.php` |

## Variables de Entorno Requeridas

En el archivo `conexion.php` se espera:
- `MYSQLHOST`: Host de la BD
- `MYSQLUSER`: Usuario de BD
- `MYSQLPASSWORD`: Contraseña de BD
- `MYSQLDATABASE`: Nombre de la BD

## Notas Importantes

1. Todos los archivos PHP del frontend incluyen la conexión mediante `require "../backend/conexion.php"`
2. gestion.php (backend) apunta a ../frontend/ para acceder a IMG, CSS, etc.
3. Las imágenes de vinilos se guardan en `frontend/IMG/`
4. El punto de entrada es `index.php` en la raíz que redirige a `frontend/index.html`
5. Los estilos CSS se comparten entre frontend y backend

