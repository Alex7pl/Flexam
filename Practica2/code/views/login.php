<?php
// Incluye la lógica del login
require_once "../logic/login_logic.php";

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
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <?php include '../comun/header.php'; ?>
    <div>
        <h2>Login</h2>
        <p>Por favor, introduce tus credenciales.</p>
        <?php 
        if(!empty($login_err)){
            echo '<div>' . $login_err . '</div>';
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label>Usuario</label>
                <input type="text" name="user">
            </div>    
            <div>
                <label>Contraseña</label>
                <input type="password" name="psw">
            </div>
            <div>
                <input type="submit" value="Login">
            </div>
        </form>
    </div>    
    <?php include '../comun/footer.php'; ?>
</body>
</html>
