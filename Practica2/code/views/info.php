<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <title>Información de Flexam</title>
    <!-- Agrega aquí estilos específicos de info.php si los hay -->
</head>
    <style>
        /* Aquí puedes añadir estilos adicionales o sobrescribir los que vienen con styles.css */
        .info-section {
            text-align: center; /* Centra el texto del h1 */
            /* Otros estilos para la sección como padding o márgenes pueden ir aquí */
        }

        /* Asegúrate de que el contenedor principal también esté centrado si es necesario */
        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            /* Otros estilos como altura mínima, etc., pueden ir aquí */
        }
    </style>
<body>
    <?php include '../comun/header.php'; ?>

    <!-- Contenido de la página -->
    <div class="main-content">
        <section class="info-section">
            <h1>Acerca de Flexam</h1>
            <p>FLEXAM es una innovadora plataforma diseñada para la creación y resolución de exámenes tipo test, permitiendo a los usuarios generar y resolver pruebas de cualquier asignatura universitaria. Con un énfasis en la personalización y la eficiencia, Flexam ofrece a los estudiantes la posibilidad de filtrar los tests disponibles según la universidad a la que pertenecen o el grado que están cursando, facilitando así un estudio dirigido y enfocado en sus necesidades académicas.</p>
            <p>Además de la realización de tests, Flexam destaca por su capacidad para proporcionar estadísticas detalladas de rendimiento, lo que permite a los usuarios monitorear su progreso y entender mejor sus áreas de fortaleza y las que requieren mayor atención. Flexam no es solo una herramienta para la evaluación, sino un compañero de estudio integral que apoya el desarrollo académico continuo.</p>
        </section>
        <!-- Aquí puedes añadir más secciones con detalles o características adicionales de Flexam -->
    </div>

    <?php include '../comun/footer.php'; ?>
</body>
</html>
