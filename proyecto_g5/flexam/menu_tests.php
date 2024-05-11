<?php include 'includes/comun/config.php'; ?>
<?php require_once "includes/ListarTests.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Flexam | Tests</title>
</head>
<body>
    <?php include 'includes/comun/header.php'; ?>
    <div class="container">
        <?php
            if($_SESSION['loggedin']) {
                $lista = new ListarTests();

                if(!isset($_GET['asignatura']) || $_GET['asignatura'] == "All"){
                    $asignatura = null;
                }
                else{
                    $asignatura = $_GET['asignatura'];
                }
                $tests = $lista->menu_tests($asignatura);
                $lista->tarjetaTest($tests, false);
            }
            else{
                header('Location: login.php'); // Redirigir al usuario a la página de inicio de sesión
            }
        ?>
    </div>
    <?php include 'includes/comun/footer.php'; ?>
    <script> var asignatura = <?php echo json_encode($asignatura); ?>; </script>
    <script> var user_menu = <?php echo json_encode(false); ?>; </script>
    <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
    <script src="js/search_test.js"></script>
</body>
</html>
