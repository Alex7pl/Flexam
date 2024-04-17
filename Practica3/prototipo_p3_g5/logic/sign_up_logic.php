<?php
require_once '../includes/Aplicacion.php';

// Preparar la respuesta para errores de validación
$errors = [];

// Asegurarse de que el método de solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'errors' => ['general' => 'Método de solicitud no válido.']]);
    exit;
}

$db = Aplicacion::getInstance()->getConnection(); // Obtener la conexión usando el patrón Singleton

// Validar los datos recibidos
$nombre = filter_var($_POST['nombre'] ?? '', FILTER_SANITIZE_STRING);
$apellidos = filter_var($_POST['apellidos'] ?? '', FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$user = filter_var($_POST['user'] ?? '', FILTER_SANITIZE_STRING);
$psw = $_POST['psw'] ?? '';
$psw_confirm = $_POST['psw_confirm'] ?? '';
$ID_universidad = intval($_POST['ID_universidad'] ?? 0);
$ID_grado = intval($_POST['ID_grado'] ?? 0);

// Validaciones
if (empty($nombre)) $errors['nombre'] = 'El nombre es obligatorio.';
if (empty($apellidos)) $errors['apellidos'] = 'Los apellidos son obligatorios.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'El formato del email no es válido.';
if (empty($user)) $errors['user'] = 'El usuario es obligatorio.';
if (empty($psw) || empty($psw_confirm) || $psw !== $psw_confirm) $errors['psw-confirm'] = 'Las contraseñas no coinciden o están vacías.';
if ($ID_universidad <= 0) $errors['ID_universidad'] = 'La universidad es obligatoria.';
if ($ID_grado <= 0) $errors['ID_grado'] = 'El grado es obligatorio.';

if (empty($errors)) {
    // Comprobar si el nombre de usuario o email ya existe
    $stmt = $db->prepare("SELECT ID_usuario FROM usuarios WHERE user = ? OR email = ?");
    $stmt->bindParam(1, $user);
    $stmt->bindParam(2, $email);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $errors['user'] = 'El nombre de usuario o email ya está en uso.';
    }
}

// Si hay errores, devolverlos y detener la ejecución del script
if (!empty($errors)) {
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

// Continuar con la lógica de inserción sólo si no hay errores
$hashed_psw = password_hash($psw, PASSWORD_DEFAULT);
$stmt = $db->prepare("INSERT INTO usuarios (user, psw, nombre, apellidos, email, ID_universidad, ID_grado, rol) VALUES (?, ?, ?, ?, ?, ?, ?, 'estudiante')");
$stmt->bindParam(1, $user);
$stmt->bindParam(2, $hashed_psw);
$stmt->bindParam(3, $nombre);
$stmt->bindParam(4, $apellidos);
$stmt->bindParam(5, $email);
$stmt->bindParam(6, $ID_universidad);
$stmt->bindParam(7, $ID_grado);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'redirect' => 'index.php']);
} else {
    // En caso de error en la inserción, devolver un mensaje general
    $errors['general'] = "Error al registrar usuario: " . $db->errorInfo()[2];
    echo json_encode(['success' => false, 'errors' => $errors]);
}
