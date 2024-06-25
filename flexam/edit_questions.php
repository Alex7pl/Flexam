<?php include 'includes/comun/config.php'; ?>
<?php require_once "includes/EditQuestions.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Preguntas | Flexam</title>
</head>
<body>
    <?php include 'includes/comun/header.php'; ?>
    <div class="container">
        <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
            $editQuestions = new EditQuestions();
            $testID = $_GET['test_id'] ?? null;

            if ($testID) {
                $editQuestions->procesarAccion($testID);
            } else {
                echo "<p>Error: No se especificó un ID de test válido.</p>";
            }
            
        ?>
    </div>    
    <?php include 'includes/comun/footer.php'; ?>
    <script src="js/edit_questions.js"></script>
</body>
</html>
