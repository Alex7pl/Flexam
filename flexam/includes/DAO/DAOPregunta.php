<?php
require_once 'includes/Aplicacion.php';
require_once 'includes/TO/PreguntaTO.php';

class DAOPregunta {

    public function __construct() {
    }

    /**
     * Lista todas las preguntas de un test.
     *
     * @param int $idTest ID del test
     * @return array Array de objetos PreguntaTO
     */
    public static function listarPreguntasPorTest($idTest) {
        $db = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM preguntas WHERE ID_test = ?";
        $stmt = $db->prepare($query);
        $idTest = mysqli_real_escape_string($db, $idTest);
        $stmt->bind_param("s", $idTest);
        $stmt->execute();
        $result = $stmt->get_result();
        $preguntas = [];
        while ($row = $result->fetch_assoc()) {
            $preguntas[] = new PreguntaTO($row['ID_pregunta'], $row['ID_test'], $row['pregunta']);
        }
        return $preguntas;
    }

    /**
     * Crea una nueva pregunta para un test en la base de datos.
     *
     * @param int $idTest ID del test al que se asociará la pregunta.
     * @param string $pregunta Texto de la pregunta a crear.
     * @return int|bool Devuelve el ID de la pregunta creada si se realizó con éxito, false en caso contrario.
     */
    public static function crearPregunta($idTest, $pregunta) {
        $db = Aplicacion::getInstance()->getConexionBd();
        $pregunta = htmlspecialchars($pregunta); // Sanitizar el texto de la pregunta
        $query = "INSERT INTO preguntas (ID_test, pregunta) VALUES (?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("is", $idTest, $pregunta);
        if ($stmt->execute()) {
            return $db->insert_id;
        }
        return false;
    }

    /**
     * Actualiza el texto de una pregunta en la base de datos.
     *
     * @param int $idPregunta ID de la pregunta a actualizar.
     * @param string $preguntaText Nuevo texto de la pregunta.
     * @return bool Devuelve true si la pregunta se actualizó correctamente, false en caso contrario.
     * @throws Exception Si ocurre algún error durante la preparación o ejecución de la consulta de actualización.
     */
    public static function actualizarPregunta($idPregunta, $preguntaText) {
        $db = Aplicacion::getInstance()->getConexionBd();
        $preguntaText = htmlspecialchars($preguntaText); // Sanitizar el texto de la pregunta
        $query = "UPDATE preguntas SET pregunta = ? WHERE ID_pregunta = ?";
        $stmt = $db->prepare($query);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $db->error);
        }
        $stmt->bind_param("si", $preguntaText, $idPregunta);
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la actualización: " . $stmt->error);
        }
        return true;
    }

    /**
     * Elimina una pregunta y todas sus opciones asociadas de la base de datos.
     *
     * @param int $idPregunta ID de la pregunta a eliminar.
     * @return bool Devuelve true si la pregunta y sus opciones se eliminaron correctamente, de lo contrario lanza una excepción.
     * @throws Exception Si ocurre algún error durante la eliminación de la pregunta o sus opciones.
     */
    public static function eliminarPregunta($idPregunta) {
        $db = Aplicacion::getInstance()->getConexionBd();

        // Primero, eliminar todas las opciones asociadas con la pregunta
        DAOOpcion::eliminarOpcionesPorPregunta($idPregunta);

        // Luego, eliminar la pregunta
        $query = "DELETE FROM preguntas WHERE ID_pregunta = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $idPregunta);
        if (!$stmt->execute()) {
            // Manejo de error si falla la eliminación de la pregunta
            throw new Exception("Error al eliminar pregunta: " . $stmt->error);
        }

        return true;
    }
}
?>

