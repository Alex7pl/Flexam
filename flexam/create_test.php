<?php include 'includes/comun/config.php'; ?>
<?php require_once "includes/CreacionTest.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Test | Flexam</title>
</head>
<body>
    <?php include 'includes/comun/header.php'; ?>
    <div class="container">
        <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start(); // Asegurar que la sesión se inicia solo si no está activa
            }

            $creacionTest = new CreacionTest();
            $creacionTest->mostrarFormulario($_SESSION['ID_usuario']);
        ?>
    </div>    

    <?php include 'includes/comun/footer.php'; ?>
</body>
</html>
