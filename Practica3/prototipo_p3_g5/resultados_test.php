<!DOCTYPE html>
<html lang="es">
<head>
    <title>Gráfico de Intentos de Test</title>
    <!-- Incluir Chart.js desde una CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
</head>
<body>
<?php
session_start();

require 'includes/Aplicacion.php';

$db = Aplicacion::getInstance()->getConnection(); // Obtener la conexión usando el patrón Singleton

include 'includes/comun/header.php';?>

<div class="container">
    <?php
    $test_id = isset($_GET['test_id']) ? intval($_GET['test_id']) : null;
    $user_id = $_SESSION['ID_usuario'];

    // Obtener el título y número de preguntas del test
    $stmt = $db->prepare("SELECT titulo, num_preguntas FROM tests WHERE ID_test = ?");
    $stmt->bindParam(1, $test_id, PDO::PARAM_INT);
    $stmt->execute();
    $row_test = $stmt->fetch(PDO::FETCH_ASSOC);
    $titulo_test = $row_test ? $row_test['titulo'] : "Desconocido";
    $total_preguntas = $row_test ? $row_test['num_preguntas'] : 0;

    // Preparar y ejecutar la consulta para obtener los detalles del último intento del usuario
    $stmt_ultimo_intento = $db->prepare("SELECT aciertos, nota FROM respuesta_usuario WHERE ID_test = ? AND ID_usuario = ? ORDER BY ID_intento DESC LIMIT 1");
    $stmt_ultimo_intento->bindParam(1, $test_id, PDO::PARAM_INT);
    $stmt_ultimo_intento->bindParam(2, $user_id, PDO::PARAM_INT);
    $stmt_ultimo_intento->execute();
    $result_ultimo_intento = $stmt_ultimo_intento->fetch(PDO::FETCH_ASSOC);

    $aciertos = $result_ultimo_intento ? $result_ultimo_intento['aciertos'] : 0;
    $nota = $result_ultimo_intento ? $result_ultimo_intento['nota'] : 0.0;
    $respuestasSeleccionadas = $aciertos; // Aquí debes ajustar según cómo determinas las respuestas seleccionadas
    $respuestas_en_blanco = $total_preguntas - $respuestasSeleccionadas;
    $fallos = $total_preguntas - $aciertos - $respuestas_en_blanco;

    $stmt = $db->prepare("SELECT COUNT(*) AS total_intentos, AVG(nota) AS nota_media, SUM(aciertos) AS total_aciertos FROM respuesta_usuario WHERE ID_test = ? AND ID_usuario = ?");
    $stmt->bindParam(1, $test_id, PDO::PARAM_INT);
    $stmt->bindParam(2, $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $row_intentos = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <h2>Resultados del test '<?php echo $titulo_test; ?>'</h2>
    <div style='text-align: center; margin-top: 25px'>
        <h2>En este intento has obtenido...</h2>
        <table style='margin: auto;'>
            <tr><th>Evaluación</th><th>Valor</th></tr>
            <tr><td>Preguntas totales</td><td><?php echo $total_preguntas; ?></td></tr>
            <tr><td>Aciertos</td><td><?php echo $aciertos; ?></td></tr>
            <tr><td>Fallos</td><td><?php echo $fallos; ?></td></tr>
            <tr><td>Respuestas en blanco</td><td><?php echo $respuestas_en_blanco; ?></td></tr>
            <tr><td>Nota</td><td><?php echo $nota; ?> / 10</td></tr>
        </table>
    </div>

    <?php
    $total_intentos = $row_intentos['total_intentos'] ?? 0;
    $nota_media = $row_intentos['nota_media'] ? round($row_intentos['nota_media'], 2) : 0;
    $total_aciertos = $row_intentos['total_aciertos'] ?? 0;
    $porcentaje_aciertos = ($total_preguntas * $total_intentos) > 0 ? round(($total_aciertos / ($total_preguntas * $total_intentos)) * 100, 2) : 0;

    echo "<div style='text-align: center; margin-top: 25px'>";
    echo "<h2>Estadísticas de todos los intentos</h2>";
    echo "<table style='margin: auto;'>";
    echo "<tr><th>Evaluación</th><th>Valor</th></tr>";
    echo "<tr><td>Número total de intentos</td><td>$total_intentos</td></tr>";
    echo "<tr><td>Nota media entre todos los intentos</td><td>$nota_media / 10</td></tr>";
    echo "<tr><td>Porcentaje de aciertos entre todos los intentos</td><td>$porcentaje_aciertos%</td></tr>";
    echo "</table></div>";
    ?>
    <canvas id="intentosChart" width="400" height="200" style="margin-top: 25px;"></canvas>
    <div class="centered-link-container">
        <a href="realize_test.php?id=<?php echo $test_id; ?>" class="submit-button">Repetir Test</a>
    </div>
</div>

<?php include 'includes/comun/footer.php'; ?>

<script>
    // Pasar variables de PHP a JavaScript
    var testId = <?php echo json_encode($test_id); ?>;
    var userId = <?php echo json_encode($user_id); ?>;
</script>
<script src="js/grafica_resultados.js"></script>

</body>
</html>