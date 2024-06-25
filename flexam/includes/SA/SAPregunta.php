<?php
require_once 'includes/DAO/DAOPregunta.php';

/**
 * Clase que representa el Servicio de Aplicación para la entidad Pregunta.
 */
class SAPregunta {

    /**
     * Constructor de la clase SAPregunta.
     */
    public function __construct() {
    }

    /**
     * Obtiene las preguntas asociadas a un test.
     *
     * @param int $idTest ID del test.
     * @return array Arreglo de objetos PreguntaTO.
     */
    public static function obtenerPreguntasPorTest($idTest) {

        // Llamar al método del DAO para obtener las preguntas asociadas a un test
        return DAOPregunta::listarPreguntasPorTest($idTest);
    }

    public static function crearPregunta($idTest, $pregunta) {
        // Llamar al método del DAO para crear la pregunta
        return DAOPregunta::crearPregunta($idTest, $pregunta);
    }

    /**
     * Actualiza la información de una pregunta y sus opciones asociadas.
     *
     * @param int $idTest ID del test
     * @param int $idPregunta ID de la pregunta a actualizar.
     * @param string $preguntaText Nuevo texto para la pregunta.
     * @param array $opciones Array de opciones para la pregunta.
     */
    public static function actualizarPregunta($idTest, $idPregunta, $preguntaText, $opciones) {

        try {
            // Actualizar el texto de la pregunta
            if (!DAOPregunta::actualizarPregunta($idPregunta, $preguntaText)) {
                throw new Exception("No se pudo actualizar la pregunta");
            }

            // Actualizar las opciones de la pregunta
            if (!DAOOpcion::actualizarOpciones($idTest, $idPregunta, $opciones)) {
                throw new Exception("No se pudieron actualizar las opciones de la pregunta");
            }
        } catch (Exception $e) {
    
            error_log("Error al actualizar la pregunta y opciones: " . $e->getMessage());
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
        // Llamar al método del DAO para eliminar la pregunta
        try {

            return DAOPregunta::eliminarPregunta($idPregunta);
        } catch (Exception $e) {
    
            error_log("Error al eliminar la pregunta y opciones: " . $e->getMessage());
            return false;
        }
    }
}
?>

