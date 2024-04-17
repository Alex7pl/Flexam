<?php
require_once '../DAO/DAOUniversidad.php';

class SAUniversidad {
    private $daoUniversidad;

    public function __construct() {
        $this->daoUniversidad = new DAOUniversidad();
    }

    public function obtenerUniversidadPorId($idUniversidad) {
        // Validar el ID de la universidad
        if (!is_int($idUniversidad) || $idUniversidad <= 0) {
            return false; // El ID de la universidad no es válido
        }

        // Llamar al método del DAO para obtener la universidad por su ID
        return $this->daoUniversidad->obtenerPorId($idUniversidad);
    }

    public function obtenerTodasUniversidades() {
        // Llamar al método del DAO para obtener todas las universidades
        return $this->daoUniversidad->obtenerTodos();
    }

    // Otros métodos relacionados con la lógica de negocio de las universidades
}
?>
