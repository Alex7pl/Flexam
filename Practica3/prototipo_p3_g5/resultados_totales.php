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

require 'includes/Aplicacion.php';  // Cambiado para usar la clase Aplicacion
$db = Aplicacion::getInstance()->getConnection();  // Obtener la conexión usando el patrón Singleton

include 'includes/comun/header.php';
?>

<div class="container">

    <?php
    $test_id = isset($_GET['test_id']) ? intval($_GET['test_id']) : null;
    $user_id = $_SESSION['ID_usuario'];
    $titulo = isset($_GET['titulo']) ? $_GET['titulo'] : null;
    $asignatura = isset($_GET['asignatura']) ? $_GET['asignatura'] : null;

    $stmt_test = $db->prepare("SELECT num_preguntas FROM tests WHERE ID_test = ?");
    $stmt_test->bindParam(1, $test_id, PDO::PARAM_INT);
    $stmt_test->execute();
    $row_test = $stmt_test->fetch(PDO::FETCH_ASSOC);
    $total_preguntas = $row_test ? $row_test['num_preguntas'] : 0;

    $stmt_intentos = $db->prepare("SELECT COUNT(*) AS total_intentos, AVG(nota) AS nota_media, SUM(aciertos) AS total_aciertos FROM respuesta_usuario WHERE ID_test = ? AND ID_usuario = ?");
    $stmt_intentos->bindParam(1, $test_id, PDO::PARAM_INT);
    $stmt_intentos->bindParam(2, $user_id, PDO::PARAM_INT);
    $stmt_intentos->execute();
    $row_intentos = $stmt_intentos->fetch(PDO::FETCH_ASSOC);

    echo "<div style='text-align: center;'>";
    echo '<h2>Estadísticas de "'.$titulo.'"</h2>';
    echo '<h3>'.$asignatura.'</h3>';
    if ($row_intentos && $row_intentos['total_intentos'] > 0) {
        $total_intentos = $row_intentos['total_intentos'];
        $nota_media = round($row_intentos['nota_media'], 2);
        $total_aciertos = $row_intentos['total_aciertos'];
        $porcentaje_aciertos = round(($total_aciertos / ($total_preguntas * $total_intentos)) * 100, 2);

        echo "<table style='margin: auto;'>";
        echo "<tr><th>Evaluación</th><th>Valor</th></tr>";
        echo "<tr><td>Número total de intentos</td><td>$total_intentos</td></tr>";
        echo "<tr><td>Nota media entre todos los intentos</td><td>$nota_media / 10</td></tr>";
        echo "<tr><td>Porcentaje de aciertos entre todos los intentos</td><td>$porcentaje_aciertos%</td></tr>";
        echo "</table></div>";
    } else {
        echo "<p>No se encontraron registros de intentos anteriores para este usuario en este test.</p>";
    }
    ?>

    <canvas id="intentosChart" width="400" height="200" style="margin-top: 25px;"></canvas>

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
