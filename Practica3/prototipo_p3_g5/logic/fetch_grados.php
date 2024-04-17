<?php
require_once '../Aplicacion.php'; // Se utiliza la clase Aplicacion para obtener la conexión

if (isset($_GET['universidad_id'])) {
    $ID_universidad = intval($_GET['universidad_id']);

    $db = Aplicacion::getInstance()->getConnection(); // Obtener la conexión usando el patrón Singleton
    $query = "SELECT * FROM grados WHERE ID_universidad = :ID_universidad"; // Consulta preparada con PDO
    $stmt = $db->prepare($query);
    $stmt->bindParam(':ID_universidad', $ID_universidad, PDO::PARAM_INT); // Vincular el parámetro como entero

    if($stmt->execute()) {
        $grados = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener todos los grados asociados a la universidad
    } else {
        $grados = array(); // Devolver un arreglo vacío en caso de fallo
    }
   
    error_log("Grados: " . $grados, 0);

    header('Content-Type: application/json');
    echo json_encode($grados); // Devolver los resultados como JSON
} else {
    echo json_encode(array('error' => 'ID de universidad no proporcionado'));
}
?>
