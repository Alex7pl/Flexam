<?php
require_once '../includes/Aplicacion.php'; // Asumiendo que la clase Aplicacion está en este archivo

// Verificar si el usuario y el test ID están presentes
if (isset($_GET['test_id']) && isset($_GET['user_id'])) {
    $test_id = intval($_GET['test_id']);
    $user_id = intval($_GET['user_id']);

    $db = Aplicacion::getInstance()->getConnection(); // Obtener la conexión usando el patrón Singleton

    // Consultar la base de datos para obtener los datos de los intentos del usuario en este test
    $sql = "SELECT fecha, nota FROM respuesta_usuario WHERE ID_test = :test_id AND ID_usuario = :user_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':test_id', $test_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    $fechas = array();
    $notas = array();

    if ($stmt->execute()) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Agregar la fecha y la nota a los arrays
            $fechas[] = $row['fecha'];
            $notas[] = $row['nota'];
        }

        // Crear un array asociativo con las fechas y las notas
        $data = array(
            'fechas' => $fechas,
            'notas' => $notas
        );
    } else {
        // Manejar error de ejecución
        $errorInfo = $stmt->errorInfo();
        $data = array('error' => "Error al ejecutar la consulta: " . $errorInfo[2]);
    }

    // Devolver los datos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo json_encode(array('error' => 'Faltan el ID de test o el ID de usuario'));
}
?>
