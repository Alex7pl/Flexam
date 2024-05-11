<?php

require_once 'includes/comun/config.php';
require_once 'includes/SA/SAPregunta.php';
require_once 'includes/SA/SAOpcion.php';
require_once 'includes/SA/SATest.php';

class AddQuestions
{
    public function __construct() {
    }

    public function mostrarFormulario($testID){

        $test = SATest::obtenerTestPorId($testID);

        ?>
        <h1>Añadir Preguntas a '<?php echo $test->getTitulo(); ?>'</h1>
        <div id="preguntas-container">
            <!-- Las preguntas se cargarán aquí dinámicamente usando JavaScript -->
        </div>
        <div style="align-items:center; text-align: center; display:flex; flex-direction: column; gap: 30px;">
            <button onclick="agregarPregunta();" class="plus-button">+</button>
            
            <button class="learn-more" onclick="enviarPreguntas();">
                <span class="circle" aria-hidden="true">
                    <span class="icon arrow"></span>
                </span>
                <span class="button-text">&nbsp;&nbsp;&nbsp;&nbsp;Guardar</span>
                <img src="https://www.proxusacademy.com/wp-content/uploads/2024/05/save.png" style="max-width: 35px;" class="save-icon">
            </button>

        </div>
        <?php
    }

    public static function procesarPreguntas() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = json_decode(file_get_contents("php://input"), true);
            if (empty($data['preguntas'])) {
                echo "No se recibieron preguntas.";
                return;
            }

            $num_preguntas = SATest::numPreguntas($_SESSION['test_id']);
    
            foreach ($data['preguntas'] as $preg) {
                // Crear una nueva pregunta usando SAPregunta
                $idPregunta = SAPregunta::crearPregunta($_SESSION['test_id'], $preg['pregunta']);
                if (!$idPregunta) {
                    echo "Error al crear la pregunta: " . $preg['pregunta'];
                    return;
                }
                // Crear opciones para la pregunta creada usando SAOpcion
                if (!SAOpcion::crearOpciones($_SESSION['test_id'], $idPregunta, $preg['opciones'])) {
                    echo "Error al crear opciones para la pregunta: " . $preg['pregunta'];
                    return;
                }

                $num_preguntas++;
            }

            SATest::actualizarNumPreguntas($_SESSION['test_id'], $num_preguntas);
            echo "Preguntas y opciones creadas correctamente";
        }
    }    
    
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    AddQuestions::procesarPreguntas();
    exit;
}

?>
