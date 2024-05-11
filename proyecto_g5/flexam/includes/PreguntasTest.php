<?php

require_once 'includes/comun/config.php';
require_once 'includes/TO/TestTO.php';
require_once 'includes/SA/SATest.php';
require_once 'includes/SA/SAPregunta.php';
require_once 'includes/TO/PreguntaTO.php';
require_once 'includes/SA/SAOpcion.php';
require_once 'includes/TO/OpcionTO.php';
require_once 'includes/SA/SAIntento.php';
require_once 'includes/SA/SAAsignatura.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Llamar al método que se encarga de procesar los datos del formulario
    PreguntasTest::procesarTest();
}

/**
 * Clase para gestionar las preguntas de un test.
 */
class PreguntasTest
{
    /**
     * Constructor de la clase PreguntasTest.
     */
    public function __construct() {
    }

    /**
     * Muestra el formulario para realizar un test.
     *
     * @param int $idUser ID del usuario
     * @param int $idTest ID del test
     */
    public function test($idUser, $idTest){

        $test = SATest::obtenerTestPorId($idTest);

        $preguntas = SAPregunta::obtenerPreguntasPorTest($idTest);
        ?>

        <h2><?php echo $test->getTitulo(); ?></h2>
        <form action="includes/PreguntasTest.php" method="post" style="margin-top: 30px;">
            <input type="hidden" name="ID_test" value="<?php echo $idTest; ?>">
            <?php $questionNumber = 1; ?>
            <?php foreach ($preguntas as $row): ?>
                <div class="question-card">
                    <div class="question-header">
                        <div class="question-number"><?php echo $questionNumber++; ?></div>
                        <div class="question-text"><?php echo $row->getPregunta(); ?></div>
                    </div>
                    <?php $opciones = SAOpcion::listarOpcionesPorPregunta($idTest, $row->getIdPregunta()); ?>
                    <div class="question-options">
                        <?php foreach ($opciones as $row2): ?>
                            <div class="question-option">
                                <label>
                                    <input type="radio" name="pregunta_<?php echo $row->getIdPregunta(); ?>" value="<?php echo $row2->getIdOpcion(); ?>" onclick="toggleRadio(this);" waschecked="false">
                                    <?php echo $row2->getOpcion(); ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <button type="button" onclick="mostrarConfirmacion()" class="submit-button">Enviar Test!</button>
        </form>
        <?php
    }

    /**
     * Procesa las respuestas enviadas por el usuario.
     */
    public static function procesarTest(){

        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Asegurar que la sesión se inicia solo si no está activa
        }

        $user_id = $_SESSION['ID_usuario'];
        $test_id = isset($_POST['ID_test']) ? $_POST['ID_test'] : null;

        if ($test_id === null) {
            exit('El ID del test no está definido.');
        }
        
        $respuestasSeleccionadas = 0;

        // Contar respuestas seleccionadas
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'pregunta_') === 0 && !empty($value)) {
                $respuestasSeleccionadas++;
            }
        }

        $total_preguntas = SATest::numPreguntas($test_id);

        $aciertos = 0;
        $respuestas_en_blanco = 0;

        $respuestasCorrectas = SAOpcion::opcionesCorrectas($test_id);

        // Recorrer todas las preguntas del test para verificar respuestas
        foreach ($respuestasCorrectas as $clave => $valor) {
            if (isset($_POST["pregunta_$clave"])) {
                $opcion_seleccionada = $_POST["pregunta_$clave"];
                if ($valor == $opcion_seleccionada) {
                    $aciertos++;
                }
            }
            else {
                $respuestas_en_blanco++;
            }
        }

        // Nota sobre 10
        $nota = ($total_preguntas > 0) ? round(($aciertos / $total_preguntas) * 10, 2) : 0;

        $fallos = $total_preguntas - $aciertos - $respuestas_en_blanco;

        $resultado = SAIntento::registrarIntento($test_id, $user_id, $nota, $aciertos, date('Y-m-d H:i:s'), 0);

        // Verificar si la inserción fue exitosa
        if ($resultado) {
            header('Location: ../resultados_test.php?test_id=' . urlencode($test_id) 
            .'&asignatura='. urlencode(SAAsignatura::obtenerNombreAsignaturaTest($test_id))
            .'&fallos='. urlencode($fallos));
        }
    }
}
?>