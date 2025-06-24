<?php
// Mostrar todos los errores de PHP en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = md5($_POST['password']);

  $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = $conn->query($sql);

  if ($result->num_rows === 1) {
    $_SESSION['user'] = $username;
    $_SESSION['username'] = $username;
    $_SESSION['user_id'] = $result->fetch_assoc()['id'];
    header("Location: crud/panel.php");
  } else {
    echo "Credenciales incorrectas.";
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="assets/css/styleslogin1.css">
</head>
<body>
<form method="post">
  <input type="text" name="username" placeholder="Usuario" required><br>
  <input type="password" name="password" placeholder="Contraseña" required><br>
  <button type="submit">Iniciar Sesión</button>
</form>
</body>
</html>