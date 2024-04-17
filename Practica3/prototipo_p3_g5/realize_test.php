<!DOCTYPE html>
<html lang="es">
<head>
    <title>Flexam | Test</title>
    <?php
        require_once 'includes/Aplicacion.php';
        $db = Aplicacion::getInstance()->getConnection(); // Obtener la conexión usando el patrón Singleton
        
        $test_id = isset($_GET['id']) ? intval($_GET['id']) : null;
        
        if ($test_id === null) {
            exit('El ID del test no está definido.');
        }
        
        // Preparar y ejecutar la consulta para obtener el título del test
        $stmtTitulo = $db->prepare("SELECT titulo FROM tests WHERE ID_test = ?");
        $stmtTitulo->bindValue(1, $test_id, PDO::PARAM_INT);
        $stmtTitulo->execute();
        $tituloTest = $stmtTitulo->rowCount() > 0 ? $stmtTitulo->fetch(PDO::FETCH_ASSOC)['titulo'] : "Título no encontrado";

        // Preparar y ejecutar la consulta para obtener el nombre de la asignatura
        $stmtAsignatura = $db->prepare("SELECT asignaturas.nombre FROM asignaturas INNER JOIN test_asignatura ON asignaturas.ID_asignatura = test_asignatura.ID_asignatura WHERE test_asignatura.ID_test = ?");
        $stmtAsignatura->bindValue(1, $test_id, PDO::PARAM_INT);
        $stmtAsignatura->execute();
        $nombreAsignatura = $stmtAsignatura->rowCount() > 0 ? $stmtAsignatura->fetch(PDO::FETCH_ASSOC)['nombre'] : "Asignatura no encontrada";

        // Preparar y ejecutar la consulta para obtener las preguntas
        $stmtPreguntas = $db->prepare("SELECT preguntas.ID_pregunta, preguntas.pregunta FROM preguntas WHERE preguntas.ID_test = ?");
        $stmtPreguntas->bindValue(1, $test_id, PDO::PARAM_INT);
        $stmtPreguntas->execute();
        $preguntas = $stmtPreguntas->fetchAll(PDO::FETCH_ASSOC);
    ?>
</head>
<body>
    <?php include 'includes/comun/header.php'; ?>

    <div class="container">
        <h2><?php echo htmlspecialchars($tituloTest); ?></h2>
        <form action="logic/procesar_test.php" method="post" style="margin-top: 30px;">
            <input type="hidden" name="ID_test" value="<?php echo $test_id; ?>">
            <?php $questionNumber = 1; ?>
            <?php foreach ($preguntas as $row): ?>
                <div class="question-card">
                    <div class="question-header">
                        <div class="question-number"><?php echo $questionNumber++; ?></div>
                        <div class="question-text"><?php echo $row['pregunta']; ?></div>
                    </div>
                    <?php
                        $pregunta_id = $row['ID_pregunta'];
                        $stmtOpciones = $db->prepare("SELECT ID_opcion, opcion FROM opciones WHERE opciones.ID_test = ? AND opciones.ID_pregunta = ?");
                        $stmtOpciones->bindValue(1, $test_id, PDO::PARAM_INT);
                        $stmtOpciones->bindValue(2, $pregunta_id, PDO::PARAM_INT);
                        $stmtOpciones->execute();
                        $opciones = $stmtOpciones->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="question-options">
                        <?php foreach ($opciones as $row2): ?>
                            <div class="question-option">
                                <label>
                                    <input type='radio' name='pregunta_<?php echo $pregunta_id; ?>' value='<?php echo $row2['ID_opcion']; ?>' onclick='toggleRadio(this);' waschecked='false'>
                                    <?php echo $row2['opcion']; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="submit-button">Enviar Test</button>
        </form>
    </div>

    <?php include 'includes/comun/footer.php'; ?>
</body>
</html>
<script src="js/scripts.js"></script>
