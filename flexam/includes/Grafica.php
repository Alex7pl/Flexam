<?php
require_once 'includes/SA/SAIntento.php';
include 'includes/comun/config.php'; // Incluir el archivo de configuración

// Verificar si el usuario y el ID del test están presentes en la solicitud
if (isset($_GET['test_id']) && isset($_GET['user_id'])) {
    // Obtener los valores de ID del test y del usuario de la solicitud y convertirlos a enteros
    $test_id = intval($_GET['test_id']);
    $user_id = intval($_GET['user_id']);

    // Obtener los intentos del usuario para el test específico
    $intentos = SAIntento::obtenerIntentosPorUsuarioTest($user_id, $test_id);
    
    // Inicializar arrays para almacenar fechas y notas
    $fechas = array();
    $notas = array();

    if ($intentos) {
        // Si se encontraron intentos, iterar sobre ellos y obtener fechas y notas
        foreach ($intentos as $intento) {
            // Agregar la fecha y la nota a los arrays
            $fechas[] = $intento->getFecha();
            $notas[] = $intento->getNota();
        }

        // Crear un array asociativo con las fechas y las notas
        $data = array(
            'fechas' => $fechas,
            'notas' => $notas
        );
    } else {
        // Si no se encontraron intentos, generar un mensaje de error
        $data = array('error' => "Error al obtener los intentos: No se encontraron registros para el usuario y el test dados.");
    }

    // Devolver los datos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // Si faltan el ID del test o el ID del usuario en la solicitud, generar un mensaje de error
    echo json_encode(array('error' => 'Faltan el ID del test o el ID del usuario en la solicitud'));
}
?>
