<?php
require_once 'includes/Aplicacion.php'; // Asumiendo que la clase Aplicacion está en este archivo

if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Asegurar que la sesión se inicia solo si no está activa
}

$db = Aplicacion::getInstance()->getConnection(); // Obtener la conexión usando el patrón Singleton

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // Si no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["ID_usuario"];

$sql = "SELECT tests.ID_test, tests.titulo, asignaturas.nombre AS asignatura_nombre, COUNT(respuesta_usuario.ID_intento) AS numero_intentos 
FROM tests 
INNER JOIN test_asignatura ON tests.ID_test = test_asignatura.ID_test 
INNER JOIN asignaturas ON test_asignatura.ID_asignatura = asignaturas.ID_asignatura 
INNER JOIN grado_asignatura ON asignaturas.ID_asignatura = grado_asignatura.ID_asignatura 
INNER JOIN usuarios ON grado_asignatura.ID_grado = usuarios.ID_grado 
LEFT JOIN respuesta_usuario ON tests.ID_test = respuesta_usuario.ID_test AND respuesta_usuario.ID_usuario = :userID
WHERE usuarios.ID_usuario = :userID 
GROUP BY tests.ID_test, asignaturas.nombre";

$stmt = $db->prepare($sql);
$stmt->bindValue(':userID', $user_id, PDO::PARAM_INT);

if ($stmt->execute()) {
    $tests = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetchAll ya que no estás enviando como JSON ahora
} else {
    // Manejo del error
    echo "Error: " . $stmt->errorInfo()[2];
}
?>
