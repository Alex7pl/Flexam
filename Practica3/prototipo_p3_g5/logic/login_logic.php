<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "includes/Aplicacion.php";

function authenticate($user, $psw) {
    $db = Aplicacion::getInstance()->getConnection(); // Obtener la conexión a través del Singleton

    // La consulta SQL para seleccionar también la contraseña, asumiendo que está hasheada
    $sql = "SELECT ID_usuario, user, nombre, psw FROM usuarios WHERE user = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $user);  // Usar bindParam() para vincular el parámetro $user al marcador de posición en la consulta SQL

    if($stmt->execute()){
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // Ahora también obtenemos la contraseña hasheada de la base de datos
            $id = $row['ID_usuario'];
            $name = $row['nombre'];
            $hashed_psw = $row['psw'];

            // Verificar la contraseña con el hash
            if(password_verify($psw, $hashed_psw)){
                // Iniciar nueva sesión si la contraseña coincide
                $_SESSION["loggedin"] = true;
                $_SESSION["ID_usuario"] = $id;
                $_SESSION["user"] = $user;

                // Redireccionar al usuario a la página de inicio
                header("location: index.php");
                exit;
            } else {
                // La contraseña no coincide, prepara un mensaje de error
                $login_err = "Usuario o contraseña inválidos.";
                return $login_err;  // Puedes retornar el error o manejarlo según necesites
            }
        } else {
            // No se encontraron credenciales válidas, prepara un mensaje de error
            $login_err = "Usuario o contraseña inválidos.";
            return $login_err;  // Puedes retornar el error o manejarlo según necesites
        }
    }
}
?>
