<?php include 'includes/comun/config.php'; ?>
<?php require_once "includes/PreguntasTest.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Flexam | Test</title>
</head>
<body>
    <?php include 'includes/comun/header.php'; ?>
    <div class="container">
        <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start(); 
            }

            $test_id = isset($_GET['test_id']) ? intval($_GET['test_id']) : null;
            $user_id = $_SESSION['ID_usuario'];

            $test = new PreguntasTest();
            $test->test($user_id, $test_id);
        ?>
        <!-- Pop-up de Confirmación Envío Test -->
        <div id="sendTestPopUp" class="popup-overlay" style="display:none;">
            <div class="popup-content">
                <h2>¿Seguro que ya lo has terminado?</h2>
                <button onclick="closePopup()" class="btn-default">Cancelar</button>
                <button onclick="enviarTest()" class="btn-primary">Enviar</button>
            </div>
        </div>
        
    </div>    

    <?php include 'includes/comun/footer.php'; ?>
    <script src="js/realize_tests.js"></script>
</body>
</html>

