<?php include 'includes/comun/config.php'; ?>
<?php require_once "includes/AddQuestions.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Preguntas | Flexam</title>
</head>
<body>
    <?php include 'includes/comun/header.php'; ?>
    <div class="container">
        <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['test_id'] = $_GET['test_id'];

            $addQuestions = new AddQuestions();
            $addQuestions->mostrarFormulario($_GET['test_id']); // Asumiendo que recibimos el ID del test
        ?>
    </div>    
    <?php include 'includes/comun/footer.php'; ?>
    <script src="js/add_questions.js"></script>
</body>
</html>
