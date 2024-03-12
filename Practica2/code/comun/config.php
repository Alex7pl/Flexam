<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "rootpsw"; // Asegúrate de cambiar esto por tu contraseña real
$database = "flexam";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
