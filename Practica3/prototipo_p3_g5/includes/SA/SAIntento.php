<?php
require_once '../DAO/DAOIntento.php';

class SAIntento {
    private $daoIntento;

    public function __construct() {
        $this->daoIntento = new DAOIntento();
    }

    public function obtenerIntentoPorId($idIntento) {
        // Validar el ID del intento
        if (!is_int($idIntento) || $idIntento <= 0) {
            return false; // El ID del intento no es válido
        }

        // Llamar al método del DAO para obtener el intento por su ID
        return $this->daoIntento->obtenerPorId($idIntento);
    }

    public function obtenerIntentosPorUsuarioYTest($idUsuario, $idTest) {
        // Validar los IDs del usuario y el test
        if (!is_int($idUsuario) || $idUsuario <= 0 || !is_int($idTest) || $idTest <= 0) {
            return false; // Los IDs no son válidos
        }

        // Llamar al método del DAO para obtener los intentos asociados a un usuario y un test
        return $this->daoIntento->obtenerPorUsuarioYTest($idUsuario, $idTest);
    }

    // Otros métodos relacionados con la lógica de negocio de los intentos
}
?>