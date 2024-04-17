<?php include 'includes/comun/config.php'; ?>
<?php
session_start();

require 'includes/Aplicacion.php'; 
$db = Aplicacion::getInstance()->getConnection(); 

include 'includes/comun/header.php';

// Obtener universidades
$universidades_query = "SELECT * FROM universidades";
$universidades_result = $db->query($universidades_query);

// Obtener todos los grados
$grados_query = "SELECT * FROM grados";
$grados_result = $db->query($grados_query); 

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>

</head>
<body>
<?php include 'includes/comun/header.php'; ?>
    <div class="container">
        <h2>Formulario de Registro</h2>
        <form id="signup-form" action="logic/sign_up_logic.php" method="post" onsubmit="submitForm(event);">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" name="apellidos" id="apellidos" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
                <div class="error-message" id="error-email"></div>
            </div>
            <div class="form-group">
                <label for="user">Usuario:</label>
                <input type="text" name="user" id="user" required>
                <div class="error-message" id="error-user"></div>
            </div>
            <div class="form-group">
                <label for="psw">Contraseña:</label>
                <input type="password" name="psw" id="psw" required>
            </div>
            <div class="form-group">
                <label for="psw-confirm">Confirmar Contraseña:</label>
                <input type="password" name="psw_confirm" id="psw-confirm" required>
                <div id="error-psw-confirm" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="universidad">Universidad:</label>
                <select name="ID_universidad" id="universidad" required onchange="fetchGrados(this.value);">
                    <option value="">Seleccione una universidad</option>
                    <?php
                    if ($universidades_result->rowCount() > 0) {
                        while($row = $universidades_result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$row['ID_universidad']}'>{$row['nombre']}</option>";
                        }
                    }
                    ?>
                </select>
                <div id="error-universidad" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="grado">Grado:</label>
                <select name="ID_grado" id="grado" required>
                    <option value="">Seleccione un grado</option>
                    <?php
                    if ($grados_result->rowCount() > 0) {
                        while($row = $grados_result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$row['ID_grado']}'>{$row['nombre']}</option>";
                        }
                    }
                    ?>
                </select>
                <div id="error-grado" class="error-message"></div>
            </div>
            <div class="form-group">
                <input type="submit" value="Registrarse">
            </div>
        </form>

        <!--  contenedores de mensajes de error para cada campo relevante -->
        <div class="form-group error-container" id="error-nombre"></div>
        <div class="form-group error-container" id="error-apellidos"></div>
        <div class="form-group error-container" id="error-email"></div>
        <div class="form-group error-container" id="error-user"></div>
        <div class="form-group error-container" id="error-psw"></div>
        <div class="form-group error-container" id="error-psw-confirm"></div>

    </div>
    <script src="js/sign_up.js"></script>
    <?php include 'includes/comun/footer.php'; ?>
</body>
</html>