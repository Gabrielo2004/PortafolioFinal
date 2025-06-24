<?php
if (session_status() === PHP_SESSION_NONE) session_start();
session_unset();     // Limpia variables
session_destroy();   // Destruye sesión
header("Location: index.php");
exit;

?>