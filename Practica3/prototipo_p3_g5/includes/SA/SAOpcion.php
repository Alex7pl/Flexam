<?php
require_once '../DAO/DAOOpcion.php';

class SAOpcion {
    private $daoOpcion;

    public function __construct() {
        $this->daoOpcion = new DAOOpcion();
    }

    public function obtenerOpcionPorId($idOpcion) {
        // Validar el ID de la opción
        if (!is_int($idOpcion) || $idOpcion <= 0) {
            return false; // El ID de la opción no es válido
        }

        // Llamar al método del DAO para obtener la opción por su ID
        return $this->daoOpcion->obtenerPorId($idOpcion);
    }

    public function obtenerOpcionesPorPregunta($idPregunta) {
        // Validar el ID de la pregunta
        if (!is_int($idPregunta) || $idPregunta <= 0) {
            return false; // El ID de la pregunta no es válido
        }

        // Llamar al método del DAO para obtener las opciones asociadas a una pregunta
        return $this->daoOpcion->obtenerPorPregunta($idPregunta);
    }

    // Otros métodos relacionados con la lógica de negocio de las opciones
}
?>
