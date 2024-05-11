<?php include 'includes/comun/config.php'; ?>
<?php require_once "includes/DatosIntentos.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gráfico de Intentos de Test</title>
    <!-- Incluir Chart.js desde una CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include 'includes/comun/header.php';?>
    <div class="container">
        <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start(); // Asegurar que la sesión se inicia solo si no está activa
            }

            $test_id = isset($_GET['test_id']) ? intval($_GET['test_id']) : null;
            $user_id = $_SESSION['ID_usuario'];
            $asignatura = isset($_GET['asignatura']) ? $_GET['asignatura'] : null;
            $fallos = isset($_GET['fallos']) ? $_GET['fallos'] : null;

            $tablas = new DatosIntentos();
            $tablas->construirTablas(true, $user_id, $test_id, $asignatura, $fallos);
        ?>
        <canvas id="intentosChart" width="400" height="200" style="margin-top: 25px;"></canvas>
        <div class="centered-link-container">
            <a href="realize_test.php?test_id=<?php echo $test_id; ?>" class="submit-button">Repetir Test</a>
        </div>
    </div>
    <?php include 'includes/comun/footer.php'; ?>
    <script>
        // Pasar variables de PHP a JavaScript
        var testId = <?php echo json_encode($test_id); ?>;
        var userId = <?php echo json_encode($user_id); ?>;
    </script>
    <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
    <script src="js/grafica_resultados.js"></script>
</body>
</html>