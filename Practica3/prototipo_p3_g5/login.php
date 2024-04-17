<?php include 'includes/comun/config.php'; ?>
<?php
// Incluye la lógica del login
require_once "logic/login_logic.php";

// Define variables y las inicializa con valores vacíos
$user = $psw = "";
$login_err = "";

// Procesa los datos del formulario al enviarlo
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["user"])) || empty(trim($_POST["psw"]))){
        $login_err = "Por favor, introduce usuario y contraseña.";
    } else{
        $user = trim($_POST["user"]);
        $psw = trim($_POST["psw"]);

        // Intenta autenticar al usuario
        authenticate($user, $psw);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<?php include 'includes/comun/header.php'; ?>
    <div class="container">
        <h2>Login</h2>
        <p>Por favor, introduce tus credenciales.</p>
        <?php 
        if(!empty($login_err)){
            echo '<div class="alert">' . $login_err . '</div>';
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Usuario</label>
                <input type="text" name="user" class="form-control">
            </div>    
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="psw" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" value="Login" class="btn btn-primary">
            </div>
        </form>
        <!--  enlace para el registro  -->
        <p class="register-prompt">¿No tienes una cuenta? <a href="sign_up.php">Regístrate ahora</a>.</p>


    </div>   
    <?php include 'includes/comun/footer.php'; ?>
</body>
</html>
