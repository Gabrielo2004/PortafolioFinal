<?php
// Inicia la sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluye el archivo de autenticación
include 'auth.php';
// Incluye la conexión a la base de datos
include 'db.php';

// Obtiene el ID del proyecto a eliminar desde la URL y lo convierte a entero
$id = intval($_GET['id']);

// Inicializa una sesión cURL para llamar a la API y eliminar el proyecto
$ch = curl_init("https://teclab.uct.cl/~gabriel.alonso/api/proyectos.php/$id");
curl_setopt_array($ch, [
    CURLOPT_CUSTOMREQUEST => 'POST',  // Usa POST para simular DELETE
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => json_encode(['_method' => 'DELETE']) // Envía el método DELETE en el cuerpo
]);
curl_exec($ch); // Ejecuta la petición cURL
curl_close($ch); // Cierra la sesión cURL

// Redirige al usuario de vuelta al panel después de eliminar
header("Location: panel.php");
exit;
?>
