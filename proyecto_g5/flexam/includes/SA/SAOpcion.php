<?php
require_once 'includes/DAO/DAOOpcion.php';

/**
 * Clase que representa el Servicio de Aplicación para la entidad Opcion.
 */
class SAOpcion {

    /**
     * Constructor de la clase SAOpcion.
     */
    public function __construct() {
    }

    /**
     * Lista las opciones asociadas a una pregunta específica de un test.
     *
     * @param int $idTest ID del test.
     * @param int $idPregunta ID de la pregunta.
     * @return array Arreglo de objetos OpcionTO.
     */
    public static function listarOpcionesPorPregunta($idTest, $idPregunta) {

        // Llamar al método del DAO para obtener las opciones asociadas a una pregunta
        return DAOOpcion::listarOpcionesPorPregunta($idTest, $idPregunta);
    }

    /**
     * Obtiene las opciones correctas de todas las preguntas de un test.
     *
     * @param int $test_id ID del test.
     * @return array Arreglo de objetos OpcionTO.
     */
    public static function opcionesCorrectas($test_id){

        return DAOOpcion::opcionesCorrectas($test_id);
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
        return DAOOpcion::crearOpciones($idTest, $idPregunta, $opciones);
    }

    /**
     * Actualiza las opciones de una pregunta en la base de datos.
     *
     * @param int $idPregunta ID de la pregunta.
     * @param array $opciones Arreglo de opciones a insertar o actualizar. Cada opción debe tener 'texto' y 'correcta'.
     * @return bool Devuelve true si las opciones se actualizaron correctamente, de lo contrario lanza una excepción.
     * @throws Exception Si ocurre algún error durante la actualización de las opciones.
     */
    public static function actualizarOpciones($idPregunta, $opciones) {
        return DAOOpcion::actualizarOpciones($idPregunta, $opciones);
    }

    /**
     * Elimina una opción de la base de datos.
     *
     * @param int $idOpcion ID de la opción a eliminar.
     * @return bool Devuelve true si la opción se eliminó correctamente, false en caso contrario.
     */
    public static function eliminarOpcion($idOpcion) {
        return DAOOpcion::eliminarOpcion($idOpcion);
    }

    /**
     * Elimina todas las opciones asociadas a una pregunta en la base de datos.
     *
     * @param int $idPregunta ID de la pregunta cuyas opciones se van a eliminar.
     * @return bool Devuelve true si las opciones se eliminaron correctamente, de lo contrario lanza una excepción.
     * @throws Exception Si ocurre algún error durante la eliminación de las opciones.
     */
    public static function eliminarOpcionesPorPregunta($idPregunta) {
        return DAOOpcion::eliminarOpcionesPorPregunta($idPregunta);
    }
}
?>

