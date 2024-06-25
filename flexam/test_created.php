<?php include 'includes/comun/config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Test Creado | Flexam</title>
</head>
<body>
<?php include 'includes/comun/header.php'; ?>
    <div class="container test-created" style="text-align: center;">
        <h1>Preguntas añadidas con éxito!</h1>
        <div class="info-box">
            <section class="info-section">                
                <p>Ya puedes resolver el test con las nuevas preguntas creadas. Recuerda que también puedes modificarlas.</p>
            </section>
        </div>

        <a href="menu_tests.php"> 
                <button class="learn-more">
                <span class="circle" aria-hidden="true">
                    <span class="icon arrow"></span>
                </span>
                <span class="button-text">&nbsp;&nbsp;Ver Tests</span>
                </button>
            </a>
    </div>
    <?php include 'includes/comun/footer.php'; ?>
</body>
</html>