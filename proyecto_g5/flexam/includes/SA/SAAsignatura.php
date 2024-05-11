<?php
require_once 'includes/DAO/DAOAsignatura.php';

/**
 * Clase que representa el Servicio de Aplicación para la entidad Asignatura.
 */
class SAAsignatura {

    public function __construct() {
    }
    
    /**
     * Obtiene el nombre de la asignatura para un test específico.
     *
     * @param int $idTest ID del test.
     * @return string|false Nombre de la asignatura o false si no se encuentra.
     */
    public static function obtenerNombreAsignaturaTest($idTest) {
        return DAOAsignatura::obtenerNombreAsignaturaTest($idTest);
    }

    /**
     * Obtiene las asignaturas asociadaa a un user mediante su ID.
     *
     * @param int $idUsuario ID del user
     * @return array asignaturas
     */
    public static function obtenerAsignaturasPorUsuario($idUsuario) {
        return DAOAsignatura::obtenerAsignaturasPorUsuario($idUsuario);
    }
}
?>
