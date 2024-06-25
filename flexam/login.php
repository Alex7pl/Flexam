<?php include 'includes/comun/config.php'; ?>
<?php require_once "includes/FormularioLogin.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <?php include 'includes/comun/header.php'; ?>
    <div class="form-container">
        <?php 
            $form = new FormularioLogin();
            echo $form->gestiona();
        ?>
    </div>   
    <?php include 'includes/comun/footer.php'; ?>
</body>
</html>
