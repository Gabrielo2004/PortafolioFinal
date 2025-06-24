<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Establecer directorio temporal para uploads
ini_set('upload_tmp_dir', '/home/teclab.uct.cl/gabriel.alonso/tmp');

// Incluir archivos de conexión a base de datos y autenticación
require_once '../db.php';
require_once '../auth.php';

// Verificar si la petición es POST (formulario enviado)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obtener datos del formulario
  $titulo = $_POST['titulo'] ?? '';
  $descripcion = $_POST['descripcion'] ?? '';
  $url_github = $_POST['url_github'] ?? '';
  $url_produccion = $_POST['url_produccion'] ?? '';
  
  // Verifica que la imagen se haya subido correctamente
  if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
    echo "<p style='color:red;'>Error al subir la imagen.</p>";
    exit;
  }

  // Mover la imagen subida al directorio de uploads
  $nombreImagen = basename($_FILES['imagen']['name']);
  $rutaDestino = __DIR__ . '/../uploads/' . $nombreImagen;
  if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
    echo "<p style='color:red;'>No se pudo mover la imagen al servidor.</p>";
    exit;
  }

  // Preparar datos para enviar a la API
  $data = [
    'titulo' => $titulo,
    'descripcion' => $descripcion,
    'url_github' => $url_github,
    'url_produccion' => $url_produccion,
    'imagen' => $nombreImagen
  ];

  // Enviar datos a la API usando cURL
  $ch = curl_init("https://teclab.uct.cl/~gabriel.alonso/api/proyectos.php");
  curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => json_encode($data)
  ]);
  $resp = curl_exec($ch);
  curl_close($ch);

  // Redirigir al panel después de guardar
  header("Location: panel.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Proyecto</title>
  <link rel="stylesheet" href="../assets/css/stylesadd.css">
</head>
<body>
  <div class="form-container">
  <!-- Formulario para agregar proyecto -->
  <form method="post" enctype="multipart/form-data" class="add-form">
    <input name="titulo" required placeholder="Título del proyecto"><br>
    <textarea name="descripcion" required placeholder="Descripción del proyecto"></textarea><br>
    <input type="url" name="url_github" required placeholder="URL de GitHub"><br>
    <input type="url" name="url_produccion" required placeholder="URL de producción"><br>
    <input type="file" name="imagen" required><br>
    <div class="button-group">
    <button type="submit">Guardar</button>
    <button type="button" onclick="window.location.href='panel.php'">Cancelar</button>
    </div>
  </form>
  </div>
</body>
</html>
