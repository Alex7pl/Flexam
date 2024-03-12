<?php

// Debería ir al principio del archivo para asegurarse de que se incluyen los archivos necesarios antes de cualquier salida
include '../comun/config.php';

// Función para manejar el registro de usuarios
function registerUser($postData) {
    global $conn;

    // Inicializar variables
    $user = $password = $confirm_password = "";
    $user_err = $password_err = $confirm_password_err = "";

    // Validar nombre de usuario
    if (empty(trim($postData["user"]))) {
        $user_err = "Por favor, ingrese un nombre de usuario.";
    } else {
        // Preparar una declaración select
        $sql = "SELECT ID_usuario FROM usuarios WHERE user = ?";

        if ($stmt = $conn->prepare($sql)) {
            $param_user = trim($postData["user"]);
            $stmt->bind_param("s", $param_user);

            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $user_err = "Este nombre de usuario ya está en uso.";
                } else {
                    $user = trim($postData["user"]);
                }
            } else {
                $user_err = "¡Ups! Algo salió mal. Por favor, inténtalo de nuevo más tarde.";
            }
            $stmt->close();
        }
    }

    // Validar contraseña
    if (empty(trim($postData["password"]))) {
        $password_err = "Por favor, ingresa una contraseña.";
    } elseif (strlen(trim($postData["password"])) < 6) {
        $password_err = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        $password = trim($postData["password"]);
    }

    // Validar confirmación de contraseña
    if (empty(trim($postData["confirm_password"]))) {
        $confirm_password_err = "Por favor, confirma tu contraseña.";
    } else {
        $confirm_password = trim($postData["confirm_password"]);
        if ($password != $confirm_password) {
            $confirm_password_err = "Las contraseñas no coinciden.";
        }
    }

    // Comprobar errores antes de insertar en la base de datos
    if (empty($user_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO usuarios (user, psw) VALUES (?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("ss", $user, $param_password);

            if ($stmt->execute()) {
                // Redireccionar al login
                header("location: login.php");
                exit;
            } else {
                $user_err = "Algo salió mal. Por favor, inténtalo de nuevo más tarde.";
            }
            $stmt->close();
        }
    }

    // Cerrar conexión
    $conn->close();

    // Devolver los errores y los datos introducidos para mostrarlos en la vista
    return [
        'user' => $user,
        'user_err' => $user_err,
        'password' => $password,
        'password_err' => $password_err,
        'confirm_password' => $confirm_password,
        'confirm_password_err' => $confirm_password_err
    ];
}

?>
