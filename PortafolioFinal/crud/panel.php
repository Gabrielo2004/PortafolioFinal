<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

include_once __DIR__ . '/../api/api_helper.php';

$proyectos = api_get('proyectos.php');
if (!$proyectos) $proyectos = [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../assets/css/stylespanel.css">
</head>
<body class="panel-body">
    <header class="panel-header">
        <h1>Panel de Administración</h1>
        <div class="panel-user">
            <?php if (isset($_SESSION['user'])): ?>
                <span>Bienvenido, <strong><?= htmlspecialchars($_SESSION['user']) ?></strong></span>
                <a class="logout-link" href="/~gabriel.alonso/logout.php">Cerrar sesión</a>
            <?php else: ?>
                <span class="user-error">Usuario no autenticado</span>
            <?php endif; ?>
        </div>
        <nav class="panel-nav">
            <a class="nav-link" href="../index.php">← Volver al inicio público</a>
            <a class="nav-link add-link" href="add.php">+ Agregar Proyecto</a>
        </nav>
    </header>
    <main class="panel-main">
        <h2>Proyectos</h2>
        <section class="proyectos-list">
            <?php foreach ($proyectos as $p): ?>
                <article class="proyecto-card">
                    <div class="proyecto-header">
                        <h3><?= htmlspecialchars($p['titulo']) ?></h3>
                    </div>
                    <div class="proyecto-body">
                        <p><?= htmlspecialchars($p['descripcion']) ?></p>
                        <?php if (!empty($p['imagen'])): ?>
                            <img class="proyecto-img" src="../uploads/<?= htmlspecialchars($p['imagen']) ?>" width="150" alt="Imagen del proyecto">
                        <?php endif; ?>
                        <div class="proyecto-links">
                            <a href="<?= htmlspecialchars($p['url_github']) ?>" target="_blank">GitHub</a>
                            <span>|</span>
                            <a href="<?= htmlspecialchars($p['url_produccion']) ?>" target="_blank">Producción</a>
                        </div>
                    </div>
                    <footer class="proyecto-footer">
                        <a class="edit-link" href="edit.php?id=<?= htmlspecialchars($p['id']) ?>">Editar</a>
                        <span>|</span>
                        <a class="delete-link" href="delete.php?id=<?= htmlspecialchars($p['id']) ?>" onclick="return confirm('¿Seguro que deseas eliminar este proyecto?')">Eliminar</a>
                    </footer>
                </article>
            <?php endforeach; ?>
        </section>
    </main>
</body>
</html>
