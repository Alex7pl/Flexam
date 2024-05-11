<?php
require_once 'includes/Aplicacion.php';
require_once 'includes/TO/OpcionTO.php';

class DAOOpcion {

    public function __construct() {
    }

    /**
     * Lista todas las opciones de una pregunta de un test.
     *
     * @param int $idTest ID del test
     * @param int $idPregunta ID de la pregunta
     * @return array Array de objetos OpcionTO
     */
    public static function listarOpcionesPorPregunta($idTest, $idPregunta) {

        $db = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM opciones WHERE ID_test = ? AND ID_pregunta = ?";
        $stmt = $db->prepare($query);
        $idTest = mysqli_real_escape_string($db, $idTest);
        $idPregunta = mysqli_real_escape_string($db, $idPregunta);
        $stmt->bind_param("ss", $idTest, $idPregunta);
        $stmt->execute();
        $result = $stmt->get_result();
        $opciones = [];
        while ($row = $result->fetch_assoc()) {
            $opciones[] = new OpcionTO($row['ID_test'], $row['ID_pregunta'], $row['ID_opcion'], $row['opcion'], $row['correcta']);
        }
        return $opciones;
    }

    /**
     * Obtiene las opciones correctas de todas las preguntas del test.
     *
     * @param int $test_id ID del test
     * @return array Array asociativo de preguntas y sus opciones correctas
     */
    public static function opcionesCorrectas($test_id){

        $db = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT ID_pregunta, ID_opcion FROM opciones WHERE ID_test = ? AND correcta = 1";
        $stmt = $db->prepare($query);
        $test_id = mysqli_real_escape_string($db, $test_id);
        $stmt->bind_param("i", $test_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $respuestasCorrectas = [];
        while ($rowRespuestas = $result->fetch_assoc()) {
            $respuestasCorrectas[$rowRespuestas['ID_pregunta']] = $rowRespuestas['ID_opcion'];
        }

        return $respuestasCorrectas;
    }

    /**
     * Crea opciones para una pregunta en un test.
     *
     * @param int $idTest ID del test.
     * @param int $idPregunta ID de la pregunta.
     * @param array $opciones Arreglo de opciones a insertar. Cada opción debe tener 'texto' y 'correcta'.
     * @return bool Devuelve true si las opciones se crearon correctamente, false en caso contrario.
     */
    public static function crearOpciones($idTest, $idPregunta, $opciones) {
        $db = Aplicacion::getInstance()->getConexionBd();
        $idOpcion = 1;

        foreach ($opciones as $opcion) {
            $textoOpcion = htmlspecialchars($opcion['texto']); // Sanitizar el texto de la opción
            $correcta = ($opcion['correcta'] == 1) ? 1 : 0; // Asegurarse de que 'correcta' sea 0 o 1
            
            $query = "INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES (?, ?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param("iiisi", $idTest, $idPregunta, $idOpcion, $textoOpcion, $correcta);
            
            if (!$stmt->execute()) {
                error_log('Error al insertar opción: ' . $stmt->error);
                return false;
            }
            $idOpcion++;
        }
        return true;
    }

    /**
     * Actualiza las opciones de una pregunta en la base de datos.
     *
     * @param int $idTest ID del test
     * @param int $idPregunta ID de la pregunta.
     * @param array $opciones Arreglo de opciones a insertar o actualizar. Cada opción debe tener 'texto' y 'correcta'.
     * @return bool Devuelve true si las opciones se actualizaron correctamente, de lo contrario lanza una excepción.
     * @throws Exception Si ocurre algún error durante la actualización de las opciones.
     */
    public static function actualizarOpciones($idTest, $idPregunta, $opciones) {
        $db = Aplicacion::getInstance()->getConexionBd();

        // Eliminar todas las opciones existentes primero
        $deleteQuery = "DELETE FROM opciones WHERE ID_pregunta = ?";
        $deleteStmt = $db->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $idPregunta);
        $deleteStmt->execute();

        // Insertar nuevas opciones
        $insertQuery = "INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES (?, ?, ?, ?, ?)";
        $insertStmt = $db->prepare($insertQuery);

        $idOpcion = 1;
        foreach ($opciones as $opcion) {
            $textoOpcion = htmlspecialchars($opcion['texto']); // Sanitizar el texto de la opción
            $correcta = isset($opcion['correcta']) && $opcion['correcta'] ? 1 : 0; // Marca como correcta solo la opción señalada

            $insertStmt->bind_param("iiisi", $idTest, $idPregunta, $idOpcion, $textoOpcion, $correcta);
            if (!$insertStmt->execute()) {
                throw new Exception("Error al insertar opción: " . $insertStmt->error);
            }

            $idOpcion++;
        }

        return true;
    }

    /**
     * Elimina una opción de la base de datos.
     *
     * @param int $idOpcion ID de la opción a eliminar.
     * @return bool Devuelve true si la opción se eliminó correctamente, false en caso contrario.
     */
    public static function eliminarOpcion($idOpcion) {
        $db = Aplicacion::getInstance()->getConexionBd();
        $query = "DELETE FROM opciones WHERE ID_opcion = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $idOpcion);
        return $stmt->execute();
    }

    /**
     * Elimina todas las opciones asociadas a una pregunta en la base de datos.
     *
     * @param int $idPregunta ID de la pregunta cuyas opciones se van a eliminar.
     * @return bool Devuelve true si las opciones se eliminaron correctamente, de lo contrario lanza una excepción.
     * @throws Exception Si ocurre algún error durante la eliminación de las opciones.
     */
    public static function eliminarOpcionesPorPregunta($idPregunta) {
        $db = Aplicacion::getInstance()->getConexionBd();
        $query = "DELETE FROM opciones WHERE ID_pregunta = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $idPregunta);
        if (!$stmt->execute()) {
            // Manejo de error si falla la eliminación de opciones
            throw new Exception("Error al eliminar opciones: " . $stmt->error);
        }
        return true;
    }
}
?>