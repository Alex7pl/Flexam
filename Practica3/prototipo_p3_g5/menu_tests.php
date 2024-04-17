<?php include 'includes/comun/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="description" content="Página de búsqueda de tests de Flexam">
    <title>Flexam | Tests</title>
</head>
<body>
    <?php include 'includes/comun/header.php'; ?>
    <?php include 'logic/get_tests.php'; ?>

    <div class="container">
        <h2>Tests Disponibles</h2>
        <div class="separator-gray"></div>
        <div class="info-section">Aquí encontrarás los tests disponibles de tu Universidad y grado, puedes resolverlos y mejorar en cada intento viendo tus resultados. Próximamente podrás crear tus propios tests y consultar los de otras titulaciones :)</div>

        <?php if (!empty($tests)): ?>
            <?php foreach ($tests as $row): ?>
                <div class="card">
                    <h3><?php echo htmlspecialchars($row["titulo"]); ?></h3>
                    <p>Asignatura: <?php echo htmlspecialchars($row["asignatura_nombre"]); ?></p>
                    <p>Intentos realizados: <?php echo htmlspecialchars($row["numero_intentos"]); ?></p>
                    <a href="realize_test.php?id=<?php echo htmlspecialchars($row['ID_test']); ?>" class="buttonT">Realizar Test</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay tests disponibles para este usuario.</p>
        <?php endif; ?>
    </div>

    <?php include 'includes/comun/footer.php'; ?>
</body>
</html>
