<?php
// Iniciar sesión
session_start();

// Conexión a la base de datos
require_once '../includes/Aplicacion.php'; // Incluye la clase Aplicacion para el patrón Singleton

$db = Aplicacion::getInstance()->getConnection(); // Obtener la conexión usando el patrón Singleton

// Obtener datos del formulario y el usuario
$test_id = isset($_POST['ID_test']) ? $_POST['ID_test'] : null;
$user_id = $_SESSION['ID_usuario'];

if ($test_id === null) {
    exit('El ID del test no está definido.');
}

$respuestasSeleccionadas = 0;

// Contar respuestas seleccionadas
foreach ($_POST as $key => $value) {
    if (strpos($key, 'pregunta_') === 0 && !empty($value)) {
        $respuestasSeleccionadas++;
    }
}

// Obtener el número total de preguntas para el test específico de la base de datos
$sql_test = "SELECT num_preguntas FROM tests WHERE ID_test = ?";
$stmt = $db->prepare($sql_test);
$stmt->bindParam(1, $test_id, PDO::PARAM_INT);
$stmt->execute();
$row_test = $stmt->fetch(PDO::FETCH_ASSOC);
$total_preguntas = $row_test ? $row_test['num_preguntas'] : 0;

$aciertos = 0;
$respuestas_en_blanco = 0;

// Obtener las opciones correctas de todas las preguntas del test
$sqlRespuestas = "SELECT ID_pregunta, ID_opcion FROM opciones WHERE ID_test = ? AND correcta = 1";
$stmtRespuestas = $db->prepare($sqlRespuestas);
$stmtRespuestas->bindParam(1, $test_id, PDO::PARAM_INT);
$stmtRespuestas->execute();
$respuestasCorrectas = [];
while ($rowRespuestas = $stmtRespuestas->fetch(PDO::FETCH_ASSOC)) {
    $respuestasCorrectas[$rowRespuestas['ID_pregunta']] = $rowRespuestas['ID_opcion'];
}

// Recorrer todas las preguntas del test para verificar respuestas
for ($i = 1; $i <= $total_preguntas; $i++) {
    if (isset($_POST["pregunta_$i"])) {
        $opcion_seleccionada = $_POST["pregunta_$i"];
        if (isset($respuestasCorrectas[$i]) && $respuestasCorrectas[$i] == $opcion_seleccionada) {
            $aciertos++;
        }
    } else {
        $respuestas_en_blanco++;
    }
}

$fallos = $total_preguntas - $aciertos - $respuestas_en_blanco;

// Nota sobre 10
$nota = ($total_preguntas > 0) ? round(($aciertos / $total_preguntas) * 10, 2) : 0;

// Insertar los resultados en la tabla
$sql_insert = "INSERT INTO respuesta_usuario (ID_test, ID_usuario, nota, aciertos, fecha, restriccion) VALUES (?, ?, ?, ?, NOW(), 0)";
$stmt_insert = $db->prepare($sql_insert);
$stmt_insert->bindParam(1, $test_id, PDO::PARAM_INT);
$stmt_insert->bindParam(2, $user_id, PDO::PARAM_INT);
$stmt_insert->bindParam(3, $nota);
$stmt_insert->bindParam(4, $aciertos, PDO::PARAM_INT);
$success = $stmt_insert->execute();

// Verificar si la inserción fue exitosa
if ($success) {
    header('Location: ../resultados_test.php?test_id=' . urlencode($test_id) . '&respuestasSeleccionadas=' . $respuestasSeleccionadas);
} else {
    echo "Error al guardar los resultados: " . $db->errorInfo()[2];
}

exit();
?>
