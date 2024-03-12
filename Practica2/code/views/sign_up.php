<?php 
// Incluir el archivo de lógica
include '../logic/sign_up_logic.php';

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Llamar a la función y obtener los datos de registro
    $registrationData = registerUser($_POST);
    // Extraer los datos para que estén disponibles en el ámbito local
    extract($registrationData);
} else {
    // Inicializar las variables para evitar errores si se accede directamente
    $user = $user_err = $password = $password_err = $confirm_password = $confirm_password_err = "";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
<?php include '../comun/header.php'; ?>
    <div class="wrapper">
        <h2>Registro</h2>
        <p>Rellena este formulario para crear una cuenta.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($user_err)) ? 'has-error' : ''; ?>">
                <label>Nombre de Usuario</label>
                <input type="text" name="user" class="form-control" value="<?php echo $user; ?>">
                <span class="help-block"><?php echo $user_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirmar Contraseña</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Registrar">
                <input type="reset" class="btn btn-default" value="Resetear">
            </div>
            <p>¿Ya tienes una cuenta? <a href="login.php">Ingresa aquí</a>.</p>
        </form>
    </div>   
<?php include '../comun/footer.php'; ?>
</body>
</html>
