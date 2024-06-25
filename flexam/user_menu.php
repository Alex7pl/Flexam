<?php include 'includes/comun/config.php'; ?>
<?php require_once "includes/ListarTests.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Flexam | Menú de Usuario</title>
</head>
<body>
    <?php include 'includes/comun/header.php'; ?>
    <div class="container">
        <?php
            $lista = new ListarTests();
            if(!isset($_GET['asignatura']) || $_GET['asignatura'] == "All"){
                $asignatura = null;
            }
            else{
                $asignatura = $_GET['asignatura'];
            }
            $tests = $lista->user_menu($asignatura);
            $lista->tarjetaTest($tests, true);
        ?>
    </div>
    <?php include 'includes/comun/footer.php'; ?>
    <script> var asignatura = <?php echo json_encode($asignatura); ?>; </script>
    <script> var user_menu = <?php echo json_encode(true); ?>; </script>
    <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
    <script src="js/search_test.js"></script>
</body>
</html>
