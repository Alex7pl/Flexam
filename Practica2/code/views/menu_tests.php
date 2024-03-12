<?php
// Iniciar sesión
session_start();

// Verificar si el usuario está logueado, si no, redirigir a login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

include 'include/config.php';

// Intentar consultar la lista de tests
$sql = "SELECT * FROM tests WHERE ID_usuario = ?";
if($stmt = $conn->prepare($sql)){
    // Vincular variables a la declaración preparada como parámetros
    $stmt->bind_param("i", $_SESSION["ID_usuario"]);
    
    // Configurar parámetros
    // Ejemplo: $param_ID_usuario = $_SESSION["ID_usuario"];
    
    // Intentar ejecutar la declaración preparada
    if($stmt->execute()){
        $result = $stmt->get_result();
        
        if($result->num_rows > 0){
            echo "<ul>";
            while($row = $result->fetch_assoc()){
                echo "<li>" . $row["titulo"] . "</li>";
            }
            echo "</ul>";
        } else{
            echo "No encontraste ningún test.";
        }
    } else{
        echo "Oops! Algo salió mal. Por favor intenta de nuevo.";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tests</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <?php include 'include/header.php'; ?>
    <h1>Tests disponibles</h1>
    <!-- Aquí se mostrará la lista de tests -->
    <?php include 'include/footer.php'; ?>
</body>
</html>
