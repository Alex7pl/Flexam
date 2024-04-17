<?php
require_once '../DAO/DAOAsignatura.php';

class SAAsignatura {
    private $daoAsignatura;

    public function __construct() {
        $this->daoAsignatura = new DAOAsignatura();
    }

    public function obtenerAsignaturaPorId($idAsignatura) {
        // Validar el ID de la asignatura
        if (!is_int($idAsignatura) || $idAsignatura <= 0) {
            return false; // El ID de la asignatura no es válido
        }

        // Llamar al método del DAO para obtener la asignatura por su ID
        return $this->daoAsignatura->obtenerPorId($idAsignatura);
    }

    public function obtenerAsignaturasPorUniversidad($idUniversidad) {
        // Validar el ID de la universidad
        if (!is_int($idUniversidad) || $idUniversidad <= 0) {
            return false; // El ID de la universidad no es válido
        }

        // Llamar al método del DAO para obtener las asignaturas asociadas a una universidad
        return $this->daoAsignatura->obtenerPorUniversidad($idUniversidad);
    }

    // Otros métodos relacionados con la lógica de negocio de las asignaturas
}
?>
