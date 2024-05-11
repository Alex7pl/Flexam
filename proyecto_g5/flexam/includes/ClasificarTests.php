<?php

require_once 'includes/comun/config.php';
require_once 'includes/TO/TestTO.php';
require_once 'includes/SA/SATest.php';
require_once 'includes/SA/SAIntento.php';
require_once 'includes/SA/SAUsuario.php';
require_once 'includes/SA/SAAsignatura.php';

if(isset($_POST['input'])){

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if($_SESSION['loggedin']) {
        $user_id = $_SESSION["ID_usuario"];
        $tests = SATest::obtenerTestsPorNombreYUser($_POST['input'], $user_id, $_POST['asignatura']);
        $user_menu = $_POST['user_menu'];
    }

    if(!empty($tests)) {
        foreach ($tests as $test) {
            $testLink = $user_menu == "false" ? "realize_test.php?test_id=" . urlencode($test->getIdTest()) : "resultados_totales.php?test_id=" . urlencode($test->getIdTest()) . "&asignatura=" . urlencode(SAAsignatura::obtenerNombreAsignaturaTest($test->getIdTest()));
?>
            <a href="<?= $testLink ?>" class="cardA">
                <div class="card">
                    <div class="card2">
                        <h3><?= htmlspecialchars($test->getTitulo()) ?></h3>
                        <p>Asignatura: <?= htmlspecialchars(SAAsignatura::obtenerNombreAsignaturaTest($test->getIdTest())) ?></p>
                        <p>Autor: <?= $test->getEsAnonimo() ? '<span>Anónimo</span>' : htmlspecialchars(SAUsuario::buscaUsuarioPorID($test->getIdUsuario())->getNombreUsuario()) ?></p>
                        <p>Visibilidad: <?= $test->getEsPublico() ? '<span style="color: green; font-weight: 600;">PÚBLICO</span>' : '<span style="color: #2ca2c9; font-weight: 600;">PRIVADO</span>' ?></p>
                        <p>Intentos realizados: <?= htmlspecialchars(SAIntento::numIntentosPorTest($test->getIdTest(), $user_id)) ?></p>
                        <div class="button-container">
                            <?php
                            if ($test->getIdUsuario() == $user_id) {
                                echo "<a href='edit_questions.php?test_id=" . urlencode($test->getIdTest()) . "' class='btn-default'>Editar</a>";
                            }
                            if ($user_menu == "false") {
                                echo "<a href='realize_test.php?test_id=" . urlencode($test->getIdTest()) . "' class='btn-primary'>Resolver</a>";
                            } else {
                                echo "<a href='resultados_totales.php?test_id=" . urlencode($test->getIdTest()) . "&asignatura=" . urlencode(SAAsignatura::obtenerNombreAsignaturaTest($test->getIdTest())) . "' class='btn-primary'>Ver Estadísticas</a>";
                            }
                            ?>
                        </div>
                    </div>             
                </div>
            </a>
<?php
        }
    } else {
        echo "No se encontraron resultados";
    }
}

?>