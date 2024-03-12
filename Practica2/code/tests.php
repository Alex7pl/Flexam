<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="author" content="Flexam">
    <meta name="description" content="Página de busqqueda de tests de Flexam">

    <title>Flexam | Tests</title>

    <link rel="stylesheet" type="text/css" href="../styles/styles.css">

    <?php
        // Iniciar sesión
        session_start();

        // Verificar si el usuario ha iniciado sesión
        if (!isset($_SESSION['user_id'])) {
            // Si no ha iniciado sesión, redirigir a la página de inicio de sesión
            header("Location: login.php");
            exit();
        }

        // Conectar a la base de datos
        $servername = "localhost";
        $username = "root";
        $database = "flexam";

        $conn = new mysqli($servername, $username, '', $database);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Obtener el ID de usuario de la sesión
        $user_id = $_SESSION['user_id'];

        // Consulta para obtener los tests disponibles para el usuario
        $sql = "SELECT tests.ID_test, tests.titulo
                FROM tests
                INNER JOIN test_asignatura ON tests.ID_test = test_asignatura.ID_test
                INNER JOIN asignaturas ON test_asignatura.ID_asignatura = asignaturas.ID_asignatura
                INNER JOIN grados ON asignaturas.ID_grado = grados.ID_grado
                INNER JOIN usuarios ON grados.ID_grado = usuarios.ID_grado
                WHERE usuarios.ID_usuario = $user_id";

        $result = $conn->query($sql);
    ?>
</head>
<body>
    <h2>Tests Disponibles</h2>
    <?php
        
        // Verificar si hay resultados de la consulta
        if ($result->num_rows > 0) {
            // Mostrar los tests como tarjetas
            while($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<h3>' . $row["titulo"] . '</h3>';
                echo '<a href="realizar_test.php?id=' . $row["ID_test"] . '">Realizar Test</a>';
                echo '</div>';
            }
        } else {
            echo "No hay tests disponibles para este usuario.";
        }

        // Cerrar la conexión
        $conn->close();
    ?>
</body>
</html>