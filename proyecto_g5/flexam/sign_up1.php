<?php include 'includes/comun/config.php'; ?>
<?php require_once "includes/FormularioRegistro1.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
<?php include 'includes/comun/header.php'; ?>
    <div class="form-container">
        <?php 
            $form = new FormularioRegistro1();
            echo $form->gestiona();
        ?>
    </div>
    <?php include 'includes/comun/footer.php'; ?>
</body>
</html>