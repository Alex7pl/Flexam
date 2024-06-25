<?php
require_once 'includes/DAO/DAOUniversidad.php';

/**
 * Clase que representa el Servicio de Aplicación para la entidad Universidad.
 */
class SAUniversidad {

    /**
     * Constructor de la clase SAUniversidad.
     */
    public function __construct() {
    }

    /**
     * Lista todas las universidades.
     *
     * @return array Arreglo de objetos UniversidadTO.
     */
    public static function listarUniversidades() {
        // Llamar al método del DAO para obtener todas las universidades
        return DAOUniversidad::obtenerUniversidades();
    }
}
?>
