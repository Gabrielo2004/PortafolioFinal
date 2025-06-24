<?php
// Mostrar todos los errores de PHP en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Metadatos principales -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portafolio profesional de Gabriel Ramirez, desarrollador junior y programador web. Especializado en HTML, CSS y JavaScript">
    <meta name="keywords" content="desarrollador junior, programador web, portafolio, HTML, CSS, JavaScript, React, Chile">
    <meta name="author" content="Gabriel Ramirez">
    <link rel="canonical" href="https://tudominio.com" />
    <title>Gabriel Ramirez | Portafolio</title>
    <!-- Hojas de estilo y fuentes -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <div class="nav-brand">
                    <!-- Logo y nombre -->
                    <img src="assets/img/tolkienlogo.jpg" alt="Logo Tolkien" class="logo"> Gabriel Ramirez
                </div>
                <div class="nav-links">
                    <!-- Enlace a login -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="crud/panel.php">Volver al panel</a>
                    <?php else: ?>
                        <a href="login.php">Iniciar sesión</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>

    <div class="main-wrapper">
        <!-- Barra lateral izquierda -->
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
                <li><a href="#about"><i class="fas fa-user"></i> Sobre mí</a></li>
                <li><a href="#work"><i class="fas fa-briefcase"></i> Proyectos</a></li>
                <li><a href="#contact"><i class="fas fa-envelope"></i> Contacto</a></li>
            </ul>
        </aside>

        <div class="main-content">
            <main>
                <!-- Sección Hero -->
                <section class="hero">
                    <div class="container">
                        <div class="hero-content">
                            <div class="hero-text">
                                <h1 class="hero-title">Gabriel Ramírez</h1>
                                <h2 class="hero-subtitle">Desarrollador Junior | Programador</h2>
                            </div>
                            <div class="hero-image">
                                <!-- Imagen de perfil -->
                                <img src="assets/img/gabrielfoto.jpeg" alt="Gabriel Ramirez Desarrollador web" class="profile-photo">
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Sección Sobre mí -->
                <section id="about" class="section">
                    <div class="container">
                        <h2 class="section-title">Sobre mí</h2>
                        <div class="about-content">
                            <div class="about-text">
                                <p>
                                    Soy Gabriel Ramirez, desarrollador web junior apasionado por la tecnología y el aprendizaje constante. Me enfoco en crear soluciones modernas, funcionales y visualmente atractivas, 
                                    siempre buscando mejorar mis habilidades y aportar valor en cada proyecto.
                                </p>
                                <!-- Habilidades -->
                                <div class="skills-row">
                                    <span class="badge">HTML5</span> |
                                    <span class="badge">CSS3</span> |
                                    <span class="badge">JavaScript</span> |
                                    <span class="badge">React</span> |
                                    <span class="badge">Git</span> |
                                    <span class="badge">Figma</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Sección Proyectos -->
                <?php
                // Cargar proyectos desde la API
                include_once __DIR__ . '/api/api_helper.php';
                $proyectos = api_get('proyectos.php');

                // Validar datos recibidos
                if (!$proyectos) $proyectos = [];
                ?>
                <section id="work" class="section">
                    <div class="container">
                        <h2 class="section-title">Proyectos</h2>
                        <div class="projects-grid">
                            <!-- Listado de proyectos -->
                            <?php foreach ($proyectos as $p): ?>
                            <article class="project-card">
                                <img src="uploads/<?=htmlspecialchars($p['imagen'])?>" alt="<?=htmlspecialchars($p['titulo'])?>" class="project-img">
                                <div class="project-info">
                                    <h3><?=htmlspecialchars($p['titulo'])?></h3>
                                    <p><?=htmlspecialchars($p['descripcion'])?></p>
                                    <div class="project-links">
                                        <a target="_blank" href="<?=htmlspecialchars($p['url_github'])?>" class="project-link underline-anim">GitHub</a>
                                        <a target="_blank" href="<?=htmlspecialchars($p['url_produccion'])?>" class="project-link underline-anim">Producción</a>
                                    </div>
                                </div>
                            </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>

                <!-- Sección Contacto -->
                <section id="contact" class="section bg-light">
                    <div class="container">
                        <h2 class="section-title">Contacto</h2>
                        <div class="contact-content">
                            <div class="contact-info">
                                <p>¿Interesado en trabajar juntos?</p>
                                <p>No dudes en contactarme:</p>
                                <ul class="contact-list">
                                    <li><i class="fas fa-envelope"></i> gabrieloramirezbrown2980@gmail.com</li>
                                    <li><i class="fas fa-phone"></i> +569 3760 3294</li>
                                </ul>
                            </div>
                            <!-- Formulario de contacto -->
                            <form class="contact-form">
                                <div class="form-group">
                                    <input type="text" placeholder="Nombre" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" placeholder="Email" required>
                                </div>
                                <div class="form-group">
                                    <textarea placeholder="Mensaje" required></textarea>
                                </div>
                                <button type="submit" class="btn">Enviar Mensaje</button>
                                <!-- Modal de éxito -->
                                <div class="modal-overlay" id="successModal">
                                    <div class="modal-content">
                                        <span class="close-modal">&times;</span>
                                        <div class="modal-body">
                                            <i class="fas fa-check-circle"></i>
                                            <h3>¡Mensaje enviado con éxito!</h3>
                                            <p>Nos pondremos en contacto contigo pronto.</p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>    
                <!-- Footer -->
                <footer class="footer">
                    <div class="container">
                        <div class="social-links">
                            <!-- Redes sociales -->
                            <a target="_blank" rel="noopener noreferrer" href="https://github.com/Gabrielo2004?tab=repositories" aria-label="GitHub"><i class="fab fa-github"></i></a>
                            <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                            <a target="_blank" href="https://www.instagram.com/gabrielo_rb/" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        </div>
                        <p>© 2025 Gabriel Ramirez. Todos los derechos reservados.</p>
                    </div>
                </footer>
            </main>
        </div>

        <!-- Scripts JS -->
        <script src="assets/js/scripts.js"></script>
    </body>
</html>