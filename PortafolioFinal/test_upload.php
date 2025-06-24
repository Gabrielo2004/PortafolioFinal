<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Establecer el directorio temporal para subida
ini_set('upload_tmp_dir', '/home/teclab.uct.cl/gabriel.alonso/tmp');
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Subida de archivo de prueba</title>
</head>
<body>
  <h2>Subida de archivo de prueba</h2>
  <form method="post" enctype="multipart/form-data">
    <input type="file" name="archivo" required>
    <button type="submit">Subir</button>
  </form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = basename($_FILES['archivo']['name']);
    $tmp = $_FILES['archivo']['tmp_name'];

    $destino = __DIR__ . '/uploads/' . $nombre;

    if (move_uploaded_file($tmp, $destino)) {
        echo "<p style='color:green;'>Archivo subido correctamente.</p>";
        echo "<p>Guardado en: <code>$destino</code></p>";
    } else {
        echo "<p style='color:red;'>No se pudo subir el archivo.</p>";
        echo "<pre>";
        print_r($_FILES);
        echo "</pre>";
    }
}
?>
</body>
</html>
