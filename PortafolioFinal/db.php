<?php
// Configuración de la conexión a la base de datos
$host = "localhost";
$db = "gabriel_ramirez_db2";
$user = "gabriel_ramirez";
$pass = "gabriel_ramirez2025";

// Crear una nueva conexión a MySQL usando mysqli
$conn = new mysqli($host, $user, $pass, $db);

// Verificar si hay un error en la conexión
if ($conn->connect_error) {
  // Mostrar mensaje de error y detener la ejecución si falla la conexión
  die("Error de conexión: " . $conn->connect_error);
}
?>