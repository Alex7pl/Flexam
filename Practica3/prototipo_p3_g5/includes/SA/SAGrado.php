<?php
require_once '../DAO/DAOGrado.php';

class SAGrado {
    private $daoGrado;

    public function __construct() {
        $this->daoGrado = new DAOGrado();
    }

    public function obtenerGradoPorId($idGrado) {
        // Validar el ID del grado
        if (!is_int($idGrado) || $idGrado <= 0) {
            return false; // El ID del grado no es válido
        }

        // Llamar al método del DAO para obtener el grado por su ID
        return $this->daoGrado->obtenerPorId($idGrado);
    }

    public function obtenerGradosPorUniversidad($idUniversidad) {
        // Validar el ID de la universidad
        if (!is_int($idUniversidad) || $idUniversidad <= 0) {
            return false; // El ID de la universidad no es válido
        }

        // Llamar al método del DAO para obtener los grados asociados a una universidad
        return $this->daoGrado->obtenerPorUniversidad($idUniversidad);
    }

    // Otros métodos relacionados con la lógica de negocio de los grados
}
?>
