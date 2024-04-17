<?php
require_once 'includes/Aplicacion.php';

// Obtener el ID de la universidad seleccionada
$universidad_id = isset($_POST['universidad_id']) ? intval($_POST['universidad_id']) : null;

if ($universidad_id === null) {
    // Manera simple de manejar si no se proporciona un ID de universidad
    echo json_encode([]);
    exit;
}

$db = Aplicacion::getInstance()->getConnection(); // Obtener la conexión usando el patrón Singleton

// Consulta preparada para obtener los grados de la universidad seleccionada
$stmt = $db->prepare("SELECT * FROM grados WHERE ID_universidad = ?");
$stmt->bind_param("i", $universidad_id);
$stmt->execute();
$result = $stmt->get_result();

// Inicializar un array para almacenar los grados
$grados = array();

// Obtener los datos de los grados y almacenarlos en el array
while ($row = $result->fetch_assoc()) {
    $grados[] = $row;
}

// Convertir el array de grados a formato JSON y enviarlo al cliente
echo json_encode($grados);

// No es necesario cerrar la conexión explícitamente, se maneja automáticamente
$stmt->close();
?>
