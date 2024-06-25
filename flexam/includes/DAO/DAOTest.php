<?php
require_once 'includes/Aplicacion.php';
require_once 'includes/TO/TestTO.php';

class DAOTest {

    public function __construct() {
    }

    /**
     * Obtiene un test por su ID.
     *
     * @param int $id ID del test
     * @return TestTO|null Objeto TestTO si se encuentra, o null si no se encuentra
     */
    public static function obtenerTestPorId($id) {
        $db = Aplicacion::getInstance()->getConexionBd();
        $idTest = mysqli_real_escape_string($db, $id);
        $query = "SELECT * FROM tests WHERE ID_test = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $idTest);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            $fila = $result->fetch_assoc();
            return new TestTO($fila['ID_test'], $fila['titulo'], $fila['ID_usuario'], $fila['num_preguntas'], $fila['es_publico'], $fila['es_anonimo']);
        } else {
            return null;
        }
    }

    /**
     * Obtiene tests con intentos asociados por un usuario específico.
     *
     * @param int $id ID del usuario
     * @return array Arreglo de objetos TestTO
     */
    public static function obtenerTestsconIntentosPorUser($id) {
        $db = Aplicacion::getInstance()->getConexionBd();
        $id = mysqli_real_escape_string($db, $id);
        $query = "SELECT * FROM tests WHERE ID_test IN (SELECT ID_test FROM respuesta_usuario WHERE ID_usuario = ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $tests = [];
        while ($fila = $result->fetch_assoc()) {
            $tests[] = new TestTO($fila['ID_test'], $fila['titulo'], $fila['ID_usuario'], $fila['num_preguntas'], $fila['es_publico'], $fila['es_anonimo']);
        }
        return $tests;
    }

    /**
     * Obtiene tests con intentos asociados por un usuario específico y asignatura.
     *
     * @param int $asignatura abreviatura de la asignatura
     * @param int $id ID del usuario
     * @return array Arreglo de objetos TestTO
     */
    public static function obtenerTestsconIntentosPorUseryAsignatura($id, $asignatura) {
        $db = Aplicacion::getInstance()->getConexionBd();
        $id = mysqli_real_escape_string($db, $id);
        $asignatura = mysqli_real_escape_string($db, $asignatura);
        $query = "SELECT tests.* FROM tests 
        INNER JOIN test_asignatura ON tests.ID_test = test_asignatura.ID_test 
        INNER JOIN asignaturas ON test_asignatura.ID_asignatura = asignaturas.ID_asignatura 
        WHERE tests.ID_test IN (SELECT ID_test 
                                FROM respuesta_usuario 
                                WHERE ID_usuario = ?) 
        AND asignaturas.abreviatura = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("is", $id, $asignatura);
        $stmt->execute();
        $result = $stmt->get_result();
        $tests = [];
        while ($fila = $result->fetch_assoc()) {
            $tests[] = new TestTO($fila['ID_test'], $fila['titulo'], $fila['ID_usuario'], $fila['num_preguntas'], $fila['es_publico'], $fila['es_anonimo']);
        }
        return $tests;
    }

    /**
     * Obtiene tests asociados a un usuario específico.
     *
     * @param int $id ID del usuario
     * @return array Arreglo de objetos TestTO
     */
    public static function obtenerTestsPorUser($id) {
        $db = Aplicacion::getInstance()->getConexionBd();
        $id = mysqli_real_escape_string($db, $id);
        $query = "SELECT tests.* FROM tests 
                  INNER JOIN test_asignatura ON tests.ID_test = test_asignatura.ID_test 
                  INNER JOIN asignaturas ON test_asignatura.ID_asignatura = asignaturas.ID_asignatura 
                  INNER JOIN grado_asignatura ON asignaturas.ID_asignatura = grado_asignatura.ID_asignatura 
                  INNER JOIN usuarios ON grado_asignatura.ID_grado = usuarios.ID_grado 
                  LEFT JOIN respuesta_usuario ON tests.ID_test = respuesta_usuario.ID_test AND respuesta_usuario.ID_usuario = ? 
                  WHERE usuarios.ID_usuario = ? AND (tests.es_publico = 1 OR tests.ID_usuario = ?)
                  GROUP BY tests.ID_test";
        $stmt = $db->prepare($query);
        $stmt->bind_param("iii", $id, $id, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $tests = [];
        while ($fila = $result->fetch_assoc()) {
            $tests[] = new TestTO($fila['ID_test'], $fila['titulo'], $fila['ID_usuario'], $fila['num_preguntas'], $fila['es_publico'], $fila['es_anonimo']);
        }
        return $tests;
    }

    /**
     * Obtiene tests asociados a un usuario específico y a una asignatura.
     *
     * @param int $asignatura abreviatura de la asignatura
     * @param int $id ID del usuario
     * @return array Arreglo de objetos TestTO
     */
    public static function obtenerTestsPorUseryAsignatura($id, $asignatura) {
        $db = Aplicacion::getInstance()->getConexionBd();
        $id = mysqli_real_escape_string($db, $id);
        $asignatura = mysqli_real_escape_string($db, $asignatura);
        $query = "SELECT tests.* FROM tests 
                  INNER JOIN test_asignatura ON tests.ID_test = test_asignatura.ID_test 
                  INNER JOIN asignaturas ON test_asignatura.ID_asignatura = asignaturas.ID_asignatura 
                  INNER JOIN grado_asignatura ON asignaturas.ID_asignatura = grado_asignatura.ID_asignatura 
                  INNER JOIN usuarios ON grado_asignatura.ID_grado = usuarios.ID_grado 
                  LEFT JOIN respuesta_usuario ON tests.ID_test = respuesta_usuario.ID_test AND respuesta_usuario.ID_usuario = ? 
                  WHERE usuarios.ID_usuario = ? AND asignaturas.abreviatura = ? AND (tests.es_publico = 1 OR tests.ID_usuario = ?)
                  GROUP BY tests.ID_test";
        $stmt = $db->prepare($query);
        $stmt->bind_param("iisi", $id, $id, $asignatura, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $tests = [];
        while ($fila = $result->fetch_assoc()) {
            $tests[] = new TestTO($fila['ID_test'], $fila['titulo'], $fila['ID_usuario'], $fila['num_preguntas'], $fila['es_publico'], $fila['es_anonimo']);
        }
        return $tests;
    }

    /**
     * Obtiene tests asociados a un usuario específico por un nombre buscado.
     *
     * @param int $id ID del usuario
     * @param string $nombre nombre del test
     * @return array Arreglo de objetos TestTO
     */
    public static function obtenerTestsPorNombreYUser($nombre, $id) {
        $db = Aplicacion::getInstance()->getConexionBd();
        $id = mysqli_real_escape_string($db, $id);
        $nombre = mysqli_real_escape_string($db, $nombre);
        $query = "SELECT tests.* FROM tests 
                  INNER JOIN test_asignatura ON tests.ID_test = test_asignatura.ID_test 
                  INNER JOIN asignaturas ON test_asignatura.ID_asignatura = asignaturas.ID_asignatura 
                  INNER JOIN grado_asignatura ON asignaturas.ID_asignatura = grado_asignatura.ID_asignatura 
                  INNER JOIN usuarios ON grado_asignatura.ID_grado = usuarios.ID_grado 
                  LEFT JOIN respuesta_usuario ON tests.ID_test = respuesta_usuario.ID_test AND respuesta_usuario.ID_usuario = ? 
                  WHERE usuarios.ID_usuario = ? AND tests.titulo LIKE '{$nombre}%' AND (tests.es_publico = 1 OR tests.ID_usuario = ?)
                  GROUP BY tests.ID_test";
        $stmt = $db->prepare($query);
        $stmt->bind_param("iii", $id, $id, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $tests = [];
        while ($fila = $result->fetch_assoc()) {
            $tests[] = new TestTO($fila['ID_test'], $fila['titulo'], $fila['ID_usuario'], $fila['num_preguntas'], $fila['es_publico'], $fila['es_anonimo']);
        }
        return $tests;
    }

        /**
     * Obtiene tests asociados a un usuario específico por un nombre buscado.
     *
     * @param int $asignatura abreviatura de la asignatura
     * @param int $id ID del usuario
     * @param string $nombre nombre del test
     * @return array Arreglo de objetos TestTO
     */
    public static function obtenerTestsPorNombreYUserYAsignatura($nombre, $id, $asignatura) {
        $db = Aplicacion::getInstance()->getConexionBd();
        $id = mysqli_real_escape_string($db, $id);
        $nombre = mysqli_real_escape_string($db, $nombre);
        $asignatura = mysqli_real_escape_string($db, $asignatura);
        $query = "SELECT tests.* FROM tests 
                  INNER JOIN test_asignatura ON tests.ID_test = test_asignatura.ID_test 
                  INNER JOIN asignaturas ON test_asignatura.ID_asignatura = asignaturas.ID_asignatura 
                  INNER JOIN grado_asignatura ON asignaturas.ID_asignatura = grado_asignatura.ID_asignatura 
                  INNER JOIN usuarios ON grado_asignatura.ID_grado = usuarios.ID_grado 
                  LEFT JOIN respuesta_usuario ON tests.ID_test = respuesta_usuario.ID_test AND respuesta_usuario.ID_usuario = ? 
                  WHERE usuarios.ID_usuario = ? AND tests.titulo LIKE '{$nombre}%' AND (tests.es_publico = 1 OR tests.ID_usuario = ?)
                  AND asignaturas.abreviatura = ?
                  GROUP BY tests.ID_test";
        $stmt = $db->prepare($query);
        $stmt->bind_param("iiis", $id, $id, $id, $asignatura);
        $stmt->execute();
        $result = $stmt->get_result();
        $tests = [];
        while ($fila = $result->fetch_assoc()) {
            $tests[] = new TestTO($fila['ID_test'], $fila['titulo'], $fila['ID_usuario'], $fila['num_preguntas'], $fila['es_publico'], $fila['es_anonimo']);
        }
        return $tests;
    }

    /**
     * Obtiene el número total de preguntas para un test específico.
     *
     * @param int $test_id ID del test
     * @return int|false Número de preguntas o false si no se encuentra
     */
    public static function numPreguntas($test_id) {
        $db = Aplicacion::getInstance()->getConexionBd();
        $idTest = mysqli_real_escape_string($db, $test_id);
        $query = "SELECT num_preguntas FROM tests WHERE ID_test = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $idTest);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            $fila = $result->fetch_assoc();
            return $fila['num_preguntas'];
        } else {
            return false;
        }
    }

    /**
     * Inserta un nuevo test en la base de datos.
     *
     * @param TestTO $test Objeto TestTO que contiene la información del test a insertar.
     * @return bool Devuelve true si el test se insertó correctamente, false en caso contrario.
     */
    public static function insertarTest(TestTO $test) {
        $db = Aplicacion::getInstance()->getConexionBd();
        $query = "INSERT INTO tests (titulo, ID_usuario, num_preguntas, es_publico, es_anonimo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);

        $titulo = htmlspecialchars($test->getTitulo()); // Sanitizar el título del test
        $idUsuario = (int)$test->getIdUsuario(); // Asegurar que el ID de usuario sea un entero
        $numPreguntas = (int)$test->getNumPreguntas(); // Asegurar que el número de preguntas sea un entero
        $esPublico = (int)$test->getEsPublico(); // Asegurar que el valor de esPublico sea un entero
        $esAnonimo = (int)$test->getEsAnonimo(); // Asegurar que el valor de esAnonimo sea un entero

        $stmt->bind_param("siiii", $titulo, $idUsuario, $numPreguntas, $esPublico, $esAnonimo);
        if ($stmt->execute()) {
            $test->setIdTest($db->insert_id);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Actualiza el número de preguntas de un test en la base de datos.
     *
     * @param int $idTest ID del test que se desea actualizar.
     * @param int $numPreguntas Nuevo número de preguntas para el test.
     * @return bool Devuelve true si se actualizó correctamente el número de preguntas, false en caso contrario.
     */
    public static function actualizarNumPreguntas($idTest, $numPreguntas) {
        $db = Aplicacion::getInstance()->getConexionBd();
        $query = "UPDATE tests SET num_preguntas = ? WHERE ID_test = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ii", $numPreguntas, $idTest);
        return $stmt->execute();
    }


    /**
     * Inserta un nuevo test asociado a una asignatura en la base de datos.
     *
     * @param int $idTest ID del test que se desea asociar a la asignatura.
     * @param int $idAsignatura ID de la asignatura a la que se asociará el test.
     * @param int $idUniversidad ID de la universidad a la que pertenece la asignatura.
     * @return bool Devuelve true si el test se insertó correctamente en la tabla test_asignatura, false en caso contrario.
     */
    public static function insertarTestAsignatura($idTest, $idAsignatura, $idUniversidad) {
        $db = Aplicacion::getInstance()->getConexionBd();
        $query = "INSERT INTO test_asignatura (ID_test, ID_asignatura, ID_universidad) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("iii", $idTest, $idAsignatura, $idUniversidad);
        if (!$stmt->execute()) {
            error_log("Error al insertar en test_asignatura: " . $stmt->error);
            return false;
        }
        return true;
    }   
}
?>