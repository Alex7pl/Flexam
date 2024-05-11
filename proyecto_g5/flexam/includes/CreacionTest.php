<?php

require_once 'includes/comun/config.php';
require_once 'includes/TO/TestTO.php';
require_once 'includes/SA/SATest.php';
require_once 'includes/SA/SAAsignatura.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CreacionTest::procesarCreacion(); // Llama al método de procesamiento si se ha enviado el formulario.
}

class CreacionTest
{
    /**
     * Constructor de la clase CreacionTest.
     */
    public function __construct() {
    }

    /**
     * Muestra el formulario para crear un test.
     *
     * @param int $idUser ID del usuario
     */
    public function mostrarFormulario($idUser){
        $asignaturas = SAAsignatura::obtenerAsignaturasPorUsuario($idUser);
        ?>

        <h1>Crear nuevo test</h1>
        <div class="info-box">
            <section class="info-section">                
                <p>Puedes crear tus tests propios en base a las asigntaruras de tu carrera.</p>
                <p>Recuerda que un test puede ser <strong style="color:#2ca2c9;">PÚBLICO</strong>, es decir, cualquier usuario puede verlo y realizar intentos con él, o <strong style="color:green;">PRIVADO</strong>, es decir, solo el autor puede verlo y realizarlo.</p>
                <p>También puedes elegir si quieres que se muestre tu nombre de usuario o no (<strong>anónimo</strong>).</p>
            </section>
        </div>
        <form action="includes/CreacionTest.php" method="post" class="form-new-test">
            <input type="text" class="textarea titulo-test" name="titulo" placeholder="Título del test" required >
            <label><input type="checkbox" name="es_publico"> Público</label>
            <label><input type="checkbox" name="es_anonimo"> Anónimo</label>
            <select name="asignatura" required>
                <?php foreach ($asignaturas as $asignatura): ?>
                    <option value="<?php echo $asignatura->getIdAsignatura(); ?>">
                        <?php echo $asignatura->getNombre(); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <!-- Aquí irán las preguntas y opciones dinámicamente generadas con JavaScript -->
            <button class="learn-more" type="submit" style="margin-left: -30px;">
                <span class="circle" aria-hidden="true">
                    <span class="icon arrow"></span>
                </span>
                <span class="button-text">&nbsp;&nbsp;&nbsp;&nbsp;Crear</span>
                <img src="https://www.proxusacademy.com/wp-content/uploads/2024/05/save.png" style="max-width: 35px;" class="save-icon">
            </button>
        </form>
        <?php
    }

    /**
     * Procesa la creación del test cuando se envía el formulario.
     */
    public static function procesarCreacion() {

        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Asegurar que la sesión se inicia solo si no está activa
        }

        $userID = $_SESSION['ID_usuario'];  
        $titulo = $_POST['titulo'];
        $esPublico = isset($_POST['es_publico']) ? 1 : 0;
        $esAnonimo = isset($_POST['es_anonimo']) ? 1 : 0;
        $asignaturaID = $_POST['asignatura']; 

        $test = new TestTO(null, $titulo, $userID, 0, $esPublico, $esAnonimo);

        // Crear test y obtener ID
        if (SATest::crearTest($test)) {
            $_SESSION['test_id'] = $test->getIdTest();
            // Insertar relación de test con asignatura
            $idUniversidad = $_SESSION['ID_universidad'];
            if (SATest::insertarTestAsignatura($test->getIdTest(), $asignaturaID, $idUniversidad)) {
                header('Location: ../add_questions.php?test_id=' . $test->getIdTest());
                exit;
            } else {
                echo "Error al relacionar el test con la asignatura.";
            }
        } else {
            echo "Error al crear el test. Intente de nuevo.";
        }
    }
}