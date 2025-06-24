<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../auth.php';
include '../db.php';

include_once __DIR__ . '/../api/api_helper.php';
$id = intval($_GET['id']);
$p = api_get("proyectos.php/$id");
if (!$p) {
    echo "<p style='color:red;'>No se pudo obtener el proyecto.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD']=='POST') {
  $data = [
    'titulo'=>$_POST['titulo'],
    'descripcion'=>$_POST['descripcion'],
    'url_github'=>$_POST['url_github'],
    'url_produccion'=>$_POST['url_produccion']
  ];

  if (!empty($_FILES['imagen']['name'])) {
    $img = basename($_FILES['imagen']['name']);
    $destino = __DIR__ . '/../uploads/' . $img;
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
        $data['imagen'] = $img;
    } else {
        echo '<p style="color:red;">No se pudo subir la nueva imagen</p>';
        exit;
    }
  }

  $ch = curl_init("https://teclab.uct.cl/~gabriel.alonso/api/proyectos.php/$id");
  curl_setopt_array($ch, [
    CURLOPT_CUSTOMREQUEST=>'PATCH',
    CURLOPT_HTTPHEADER=>['Content-Type: application/json'],
    CURLOPT_RETURNTRANSFER=>true,
    CURLOPT_POSTFIELDS=>json_encode($data)
  ]);
  curl_exec($ch);
  curl_close($ch);
  header("Location: panel.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Proyecto</title>
    <link rel="stylesheet" href="../assets/css/stylesedit.css">
</head>
<body>
    <h2>Editar: <?= htmlspecialchars($p['titulo']) ?></h2>
    <form method="post" enctype="multipart/form-data">
        <input name="titulo" value="<?= htmlspecialchars($p['titulo']) ?>" required>
        <textarea name="descripcion"><?= htmlspecialchars($p['descripcion']) ?></textarea>
        <input name="url_github" value="<?= htmlspecialchars($p['url_github']) ?>">
        <input name="url_produccion" value="<?= htmlspecialchars($p['url_produccion']) ?>">
        <input type="file" name="imagen">
        <button>Actualizar</button>
    </form>
    <br>
    <a href="panel.php">← Volver al Panel</a>
</body>
</html>
