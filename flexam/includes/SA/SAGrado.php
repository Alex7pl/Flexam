<?php
require_once 'includes/DAO/DAOGrado.php';

/**
 * Clase que representa el Servicio de Aplicación para la entidad Grado.
 */
class SAGrado {

    /**
     * Constructor de la clase SAGrado.
     */
    public function __construct() {
    }

    /**
     * Obtiene los grados asociados a una universidad.
     *
     * @param int $idUniversidad ID de la universidad.
     * @return array|false Arreglo de grados asociados a la universidad o false si no se encuentra.
     */
    public static function obtenerGradosPorUniversidad($idUniversidad) {
        // Validar el ID de la universidad
        if ($idUniversidad <= 0) {
            return false; // El ID de la universidad no es válido
        }

        // Llamar al método del DAO para obtener los grados asociados a una universidad
        return DAOGrado::listarGradosPorUniversidad($idUniversidad);
    }

    /**
     * Obtiene los datos de los grados asociados a una universidad en formato JSON.
     *
     * @param int $idUniversidad ID de la universidad.
     * @return string|false Datos de los grados en formato JSON o false si no se encuentra.
     */
    public static function obtenerJSON($idUniversidad){

        if ($idUniversidad <= 0) {
            return false; // El ID de la universidad no es válido
        }

        return DAOGrado::obtenerJSON($idUniversidad);
    }

    /**
     * Lista todos los grados disponibles.
     *
     * @return mysqli_result Resultado de la consulta
     */
    public static function listarGrados() {

        return DAOGrado::obtenerGrados();
    }
}
?>

