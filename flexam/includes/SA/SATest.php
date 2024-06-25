<?php
require_once 'includes/DAO/DAOTest.php';

/**
 * Clase que representa el Servicio de Aplicación para la entidad Test.
 */
class SATest {

    /**
     * Constructor de la clase SATest.
     */
    public function __construct() {
    }

    /**
     * Obtiene un test por su ID.
     *
     * @param int $idTest ID del test.
     * @return TestTO|false Objeto TestTO si se encuentra el test, false en caso contrario.
     */
    public static function obtenerTestPorId($idTest) {

        return DAOTest::obtenerTestPorId($idTest);
    }

    /**
     * Obtiene los tests con intentos asociados para un usuario.
     *
     * @param int $asignatura abreviatura de la asignatura
     * @param int $id ID del usuario.
     * @return array Arreglo de objetos TestTO.
     */
    public static function obtenerTestsconIntentosPorUser($id, $asignatura) {

        if($asignatura){
            return DAOTest::obtenerTestsconIntentosPorUseryAsignatura($id, $asignatura);
        }
        else{
            return DAOTest::obtenerTestsconIntentosPorUser($id);
        }
    }

    /**
     * Obtiene los tests asociados a un usuario.
     *
     * @param int $asignatura abreviatura de la asignatura
     * @param int $id ID del usuario.
     * @return array Arreglo de objetos TestTO.
     */
    public static function obtenerTestsPorUser($id, $asignatura) {

        if($asignatura){
            return DAOTest::obtenerTestsPorUseryAsignatura($id, $asignatura);
        }
        else{
            return DAOTest::obtenerTestsPorUser($id);
        }
    }

     /**
     * Obtiene tests asociados a un usuario específico por un nombre buscado.
     *
     * @param int $id ID del usuario
     * @param string $nombre nombre del test
     * @return array Arreglo de objetos TestTO
     */
    public static function obtenerTestsPorNombreYUser($nombre, $id, $asignatura) {
        
        if($asignatura){
            return DAOTest::obtenerTestsPorNombreYUserYAsignatura($nombre, $id, $asignatura);
        }
        else{
            return DAOTest::obtenerTestsPorNombreYUser($nombre, $id);
        }
    }

    /**
     * Obtiene el número total de preguntas para un test específico.
     *
     * @param int $test_id ID del test.
     * @return int Número total de preguntas.
     */
    public static function numPreguntas($test_id){

        return DAOTest::numPreguntas($test_id);
    }

     /**
     * Inserta un nuevo test en la base de datos.
     *
     * @param TestTO $test Objeto TestTO que contiene la información del test a insertar.
     * @return bool Devuelve true si el test se insertó correctamente, false en caso contrario.
     */
    public static function crearTest(TestTO $test) {
        return DAOTest::insertarTest($test);
    }

    /**
     * Actualiza el número de preguntas de un test en la base de datos.
     *
     * @param int $idTest ID del test que se desea actualizar.
     * @param int $numPreguntas Nuevo número de preguntas para el test.
     * @return bool Devuelve true si se actualizó correctamente el número de preguntas, false en caso contrario.
     */
    public static function actualizarNumPreguntas($idTest, $numPreguntas) {
        return DAOTest::actualizarNumPreguntas($idTest, $numPreguntas);
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
        return DAOTest::insertarTestAsignatura($idTest, $idAsignatura, $idUniversidad);
    }
}
?>
