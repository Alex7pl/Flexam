<?php
require_once 'includes/comun/config.php';
require_once 'includes/SA/SAPregunta.php';
require_once 'includes/SA/SAOpcion.php';

class EditQuestions {
    public function __construct() {
    }

    public function mostrarFormulario($testID) {
        $preguntas = SAPregunta::obtenerPreguntasPorTest($testID);
        echo "<h1>Editar Preguntas del Test</h1>";

        echo "<a href='add_questions.php?test_id=$testID' style='margin-left: 35%;'> 
                <button class='learn-more' style='min-width: 280px;'>
                <span class='circle' aria-hidden='true'>
                    <span class='icon arrow'></span>
                </span>
                <span class='button-text'>&nbsp;&nbsp;Añadir Preguntas</span>
                </button>
            </a>";   

        echo "<div id='preguntas-container' style='margin-top: 20px;'>";
    
        foreach ($preguntas as $pregunta) {
            $this->mostrarPregunta($pregunta);
        }

        // Pop-up de confirmación
        echo "
        <div id='deleteConfirmationPopup' class='popup-overlay' style='display:none;'>
            <div class='popup-content'>
                <h2>¿Seguro que deseas eliminar esta pregunta?</h2>
                <button onclick='closePopup()' class='btn-default'>Cancelar</button>
                <button id='confirmDelete' class='btn-primary' style='text-decoration: none;'>Eliminar</button>
            </div>
        </div>";
    
        echo "</div>";
             
    }    

    private function mostrarPregunta($pregunta) {
        $opciones = SAOpcion::listarOpcionesPorPregunta($pregunta->getIDTest(), $pregunta->getIDPregunta());
        echo "<div class='question-card' data-id-pregunta='{$pregunta->getIDPregunta()}'>";
        echo "<div class='question-header'>";
        echo "<textarea name='preguntas[texto]' class='textarea pregunta-textarea'>{$pregunta->getPregunta()}</textarea>";
        echo "</div>";
        
        echo "<div class='opciones'>";
        foreach ($opciones as $opcion) {
            $checked = $opcion->getCorrecta() ? "checked" : "";
            echo "<div class='opcion-container'>";
            echo "<textarea name='opciones[texto]' class='textarea opcion-textarea'>{$opcion->getOpcion()}</textarea>";
            echo "Correcta <input type='radio' name='correcta[{$pregunta->getIDPregunta()}]' {$checked}>";
            echo "</div>";
        }
        echo "</div>";

        echo "<div class='button-container'>";
        echo "<button onclick='agregarOpcion(this.parentNode.parentNode);' class='btn btn-primary'>Añadir Opción</button>";
        echo "<button onclick=\"guardarCambios(this.closest('.question-card'), {$pregunta->getIDTest()}, this);\" class='btn btn-primary'>Guardar</button>";
        echo "</div>";

        echo "<div class='button-container'>";
        echo "<button onclick=\"confirmarEliminacion({$pregunta->getIDPregunta()}, {$pregunta->getIDTest()});\" class='btn btn-danger btn-primary eliminar-pregunta' style='border-radius: 12px;'>Eliminar Pregunta</button>";
        echo "</div>";
        echo "</div>";
    }

    public function procesarAccion($testID) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->actualizarPregunta($testID);
        } elseif (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id_pregunta'])) {
            $idPregunta = $_GET['id_pregunta'];
            $this->triggerEliminarPregunta($idPregunta, $testID);
            SATest::actualizarNumPreguntas($testID, SATest::numPreguntas($testID));
        } else {
            $this->mostrarFormulario($testID);
        }
    }

    private function actualizarPregunta($testID) {
        if (!isset($_POST['guardar'])) {
            return;
        }
    
        $idPregunta = $_POST['id_pregunta'];
        $preguntaText = $_POST['pregunta_text'];
        $opciones = json_decode($_POST['opciones'], true); // Decodifica el JSON recibido
    
        if (!SAPregunta::actualizarPregunta($testID, $idPregunta, $preguntaText, $opciones)) {
            echo "<script>alert('Error al actualizar la pregunta y opciones');</script>";
        } else {
            // Redirigir a la misma página para evitar reenvío del formulario
            header("Location: edit_questions.php?test_id=$testID");
            exit;
        }
    }    

    public function triggerEliminarPregunta($idPregunta, $testId) {
        if (SAPregunta::eliminarPregunta($idPregunta)) {
            // Redirecciona a la misma página de edición del test con el ID del test correcto
            header("Location: edit_questions.php?test_id=$testId");
            exit;
        } else {
            echo "<script>alert('Error al eliminar la pregunta');</script>";
        }
    }
    
}
