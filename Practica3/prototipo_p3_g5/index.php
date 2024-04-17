<?php include 'includes/comun/config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Inicio - FLEXAM</title>
<script src="/js/functions.js?v=<?php echo time(); ?>"></script>
</head>
<body>
    <?php include 'includes/comun/header.php'; ?>
    <div class="container">
        <h1 class="text-center">Gánale a tu examen con FLEXAM</h1>
        <div class="image-space">
            <img src="<?php echo BASE_URL; ?>resources/imagenes/estudiantes.jpg" alt="Estudiantes" class="rounded-image">
        </div>
        <div class="separator-gray"></div>
        <p class="text-center">Saca un 10 antes de tu examen final, el día de la prueba solo tendrás que ir a recogerlo.
            FLEXAM está ideado por y para estudiantes, permitiéndote practicar los contenidos de tu próximo examen TEST de manera
            que llegues a tu examen final y puedas clavarlo, habiendo interiorizado todo el proceso de enfrentarte al examen 
            las veces que quieras anteriormente.
        </p>
        <div class="separator-gray"></div>
        <div class="info-box">
            <h2 class="text-center">¿Cómo funciona FLEXAM?</h2>
            <ul>
                <li>Resolución de tests reales de exámenes que han caído en otros años.</li>
                <li>Tests de tu grado y universidad.</li>
                <li>Pruebas adaptadas a nivel y dificultad que elijas</li>
                <li>Aciertos y fallos, estadísticas... </li>
                <li>PRÓXIMAMENTE: Podrás subir y elaborar tus propios tests de examen.</li>
            </ul>
        </div>

        <div class="button-container text-center">
            <a href="menu_tests.php" class="buttonT">Tests</a>
            <a href="aboutus.php" class="buttonT">Sobre Nosotros</a>
            <a href="info.php" class="buttonT">Info</a>
            <a href="login.php" class="buttonT">Login</a> 
        </div>
    </div>
    <?php include 'includes/comun/footer.php'; ?>
</body>
</html>
