<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="author" content="Flexam">
    <meta name="description" content="Página de test de Flexam">

    <title>Flexam | Test</title>

    <link rel="stylesheet" type="text/css" href="../styles/styles.css">

    <?php
        // Establecer conexión a la base de datos
        $servername = "localhost";
        $username = "root";
        $database = "flexam";

        $conn = new mysqli($servername, $username, '', $database);
        
        $test_id = $_GET['test_id'];
    
        // Consulta SQL para obtener todas las preguntas y opciones del test
        $sql = "SELECT preguntas.ID_pregunta, preguntas.texto AS pregunta, opciones.ID_opcion, opciones.texto AS opcion
                FROM preguntas
                INNER JOIN opciones ON preguntas.ID_pregunta = opciones.ID_pregunta
                WHERE preguntas.ID_test = $test_id";
    
        // Ejecutar la consulta
        $result = $conn->query($sql);
    ?>
</head>
<body>
    <?php
        // Verificar si hay preguntas para el test seleccionado
        if ($result->num_rows > 0) {
            // Inicio del formulario
            echo "<form action='corregir_test.php' method='post'>";

            // Iterar sobre cada fila de resultados (preguntas y opciones)
            while ($row = $result->fetch_assoc()) {
                $pregunta_id = $row['ID_pregunta'];
                $opcion_id = $row['ID_opcion'];
                $pregunta_texto = $row['pregunta'];
                $opcion_texto = $row['opcion'];

                // Mostrar la pregunta
                echo "<p>$pregunta_texto</p>";

                // Mostrar la opción como un botón de radio
                echo "<input type='radio' name='pregunta_$pregunta_id' value='$opcion_id'> $opcion_texto<br>";
            }

            // Botón para enviar el test
            echo "<input type='submit' value='Enviar Test'>";
            echo "</form>";
        } else {
            echo "No se encontraron preguntas para este test.";
        }

        // Cerrar conexión a la base de datos
        $conn->close();
    ?>
</body>
</html>