<?php include 'includes/comun/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="description" content="Menú de usuario de Flexam">
    <title>Flexam | Tests</title>
</head>
<body>
    <?php 
        include 'includes/comun/header.php'; 
        require 'includes/Aplicacion.php';

        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Asegurar que la sesión se inicia solo si no está activa
        }

        // Verificar si el usuario ha iniciado sesión
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: login.php"); // Si no ha iniciado sesión, redirigir a la página de inicio de sesión
            exit();
        }

        $db = Aplicacion::getInstance()->getConnection(); // Obtener la conexión a través del Singleton

        $user_id = $_SESSION["ID_usuario"]; // Obtener el ID de usuario de la sesión

        // Consulta para obtener los tests realizados por el usuario
        $sql = "SELECT tests.ID_test, tests.titulo, asignaturas.nombre AS asignatura_nombre, COUNT(respuesta_usuario.ID_intento) AS numero_intentos
        FROM tests 
        INNER JOIN test_asignatura ON tests.ID_test = test_asignatura.ID_test 
        INNER JOIN asignaturas ON test_asignatura.ID_asignatura = asignaturas.ID_asignatura 
        INNER JOIN grado_asignatura ON asignaturas.ID_asignatura = grado_asignatura.ID_asignatura 
        INNER JOIN usuarios ON grado_asignatura.ID_grado = usuarios.ID_grado 
        INNER JOIN respuesta_usuario ON tests.ID_test = respuesta_usuario.ID_test AND respuesta_usuario.ID_usuario = :userID
        WHERE usuarios.ID_usuario = :userID
        GROUP BY tests.ID_test, asignaturas.nombre";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':userID', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $tests = $stmt->fetchAll(PDO::FETCH_ASSOC); // Usar fetchAll para obtener todos los resultados
    ?>

    <div class="container">
        <h2>Tests Realizados</h2>
        <div class="separator-gray"></div>
        <div class="info-section">Aquí encontrarás todos los tests realizados por ti y puedes acceder a las estadísticas medias que has obtenido en cada uno.</div>

        <?php if (!empty($tests)): ?>
            <?php foreach ($tests as $row): ?>
                <div class="card">
                    <h3><?php echo htmlspecialchars($row["titulo"]); ?></h3>
                    <p>Asignatura: <?php echo htmlspecialchars($row["asignatura_nombre"]); ?></p>
                    <p>Intentos realizados: <?php echo htmlspecialchars($row["numero_intentos"]); ?></p>
                    <a href="resultados_totales.php?test_id=<?php echo urlencode($row['ID_test']);?>&titulo=<?php echo urlencode($row["titulo"]);?>&asignatura=<?php echo urlencode($row["asignatura_nombre"]);?>" class="buttonT">Mostrar resultados</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Todavía no has completado ningún test.</p>
        <?php endif; ?>
    </div>

    <?php include 'includes/comun/footer.php'; ?>
</body>
</html>
