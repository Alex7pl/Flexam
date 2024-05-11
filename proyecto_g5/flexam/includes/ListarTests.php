<?php

require_once 'includes/TO/TestTO.php';
require_once 'includes/SA/SATest.php';
require_once 'includes/SA/SAUsuario.php';
require_once 'includes/SA/SAIntento.php';
require_once 'includes/SA/SAAsignatura.php';

class ListarTests
{
    /**
     * Constructor de la clase ListarTests.
     */
    public function __construct() {
    }

    /**
     * Genera la tarjeta de un test con su información.
     *
     * @param array $tests Arreglo de objetos TestTO
     * @param bool $user_menu Indica si se debe mostrar el menú de usuario o no
     */
    public function tarjetaTest($tests, $user_menu){

        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Asegurar que la sesión se inicia solo si no está activa
        }

        $user_id = $_SESSION["ID_usuario"]; // Obtener el ID de usuario de la sesión
        $asignaturas = SAAsignatura::obtenerAsignaturasPorUsuario($user_id);
?>
            <div class="searchContainer">
            <div class="custom-select">
                <select class="options">
                    <option value="All">All</option>
                    <?php foreach ($asignaturas as $asignatura): ?>
                        <option value="<?= htmlspecialchars($asignatura->getAbreviatura()) ?>"><?= htmlspecialchars($asignatura->getAbreviatura()) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="group">
                <svg class="icon" aria-hidden="true" viewBox="0 0 24 24"><g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path></g></svg>
                <input placeholder="Search" type="search" class="searchBar">
            </div>
        </div>
<?php
        if(!$user_menu) {
?>
            <h1>Tests Disponibles</h1>
            <div class="separator-gray"></div>
            <div class="info-section">Aquí encontrarás los tests disponibles de tu Universidad y grado, puedes resolverlos y mejorar en cada intento viendo tus resultados. Además, podrás crear y editar tus propios tests.</div>   
<?php           
        } else {
?>          
            <h1>Tests Realizados</h1>
            <div class="separator-gray"></div>
            <div class="info-section">Aquí encontrarás todos los tests realizados por ti y puedes acceder a las estadísticas medias que has obtenido en cada uno.</div>
<?php
        }

        echo "<a a href='create_test.php'' class='large-button'> 
                <button class='learn-more' style='min-width: 280px;'>
                <span class='circle' aria-hidden='true'>
                    <span class='icon arrow'></span>
                </span>
                <span class='button-text'>&nbsp;&nbsp;Crear Nuevo Test</span>
                </button>
            </a>";   

        echo "<div id='preguntas-container' style='margin-top: 20px;'>";
?>
        <div class="search">
<?php
        if (!empty($tests)) {
            foreach ($tests as $test) {
                if(!$user_menu) {
        ?>
                    <a href="realize_test.php?test_id=<?= urlencode($test->getIdTest()) ?>" class="cardA">
        <?php           
                } else {
        ?>          
                    <a href="resultados_totales.php?test_id=<?= urlencode($test->getIdTest()) ?>&asignatura=<?= urlencode(SAAsignatura::obtenerNombreAsignaturaTest($test->getIdTest())) ?>" class="cardA">
        <?php
                }
        ?>
                <div class="card">
                    <div class="card2">
                        <h3><?= htmlspecialchars($test->getTitulo()) ?></h3>
                        <p>Asignatura: <?= htmlspecialchars(SAAsignatura::obtenerNombreAsignaturaTest($test->getIdTest())) ?></p>
                        <p>Autor: <?= $test->getEsAnonimo() ? '<span>Anónimo</span>' : htmlspecialchars(SAUsuario::buscaUsuarioPorID($test->getIdUsuario())->getNombreUsuario()) ?></p>
                        <p>Visibilidad: <?= $test->getEsPublico() ? '<span style="color: green; font-weight: 600;">PÚBLICO</span>' : '<span style="color: #2ca2c9; font-weight: 600;">PRIVADO</span>' ?></p>
                        <p>Intentos realizados: <?= htmlspecialchars(SAIntento::numIntentosPorTest($test->getIdTest(), $user_id)) ?></p>
                        <div class="button-container">
                        <?php
                            if(!$user_menu && $test->getIdUsuario() == $user_id) {
                                // Link para editar si el usuario es el creador del test
                                echo "<a href='edit_questions.php?test_id=" . urlencode($test->getIdTest()) . "' class='btn-default'>Editar</a>";
                            }
                        
                            if($user_menu){
                                echo "<a href='resultados_totales.php?test_id=" . urlencode($test->getIdTest()) ?>&asignatura=<?= urlencode(SAAsignatura::obtenerNombreAsignaturaTest($test->getIdTest())) . "' class='btn-primary'>Ver Estadísticas</a>";
                            } else {
                                echo "<a href='realize_test.php?test_id=" . urlencode($test->getIdTest()) . "' class='btn-primary'>Resolver</a>";
                            }
                        ?>
                        </div>  <!-- Cierre de button container -->
                    </div> <!-- Cierre de card2 -->
                </div> <!-- Cierre de card -->
                </a> <!-- Cierre de a -->
        <?php
            }
        }
        ?></div></div> <!-- Cierre contenedor --> <?php
    }
    /**
     * Obtiene los tests disponibles para el menú del usuario.
     *
     * @return array|bool Arreglo de objetos TestTO si el usuario está logueado, de lo contrario false
     */
    public function user_menu($asignatura){
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Asegurar que la sesión se inicia solo si no está activa
        }

        if($_SESSION['loggedin']) {
            $user_id = $_SESSION["ID_usuario"]; // Obtener el ID de usuario de la sesión
            return SATest::obtenerTestsconIntentosPorUser($user_id, $asignatura); // Obtener los tests con intentos realizados por el usuario
        } else {
            return false; // Retornar falso si el usuario no está logueado
        }
    }

    /**
     * Obtiene los tests disponibles para el menú de tests.
     *
     * @return array|bool Arreglo de objetos TestTO si el usuario está logueado, de lo contrario false
     */
    public function menu_tests($asignatura){
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Asegurar que la sesión se inicia solo si no está activa
        }

        if($_SESSION['loggedin']) {
            $user_id = $_SESSION["ID_usuario"]; // Obtener el ID de usuario de la sesión
            return SATest::obtenerTestsPorUser($user_id, $asignatura); // Obtener los tests disponibles para el usuario
        } else {
            return false; // Retornar falso si el usuario no está logueado
        }
    }
}
?>