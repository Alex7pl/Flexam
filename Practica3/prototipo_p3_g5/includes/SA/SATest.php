<?php
require_once '../DAO/DAOTest.php';

class SATest {
    private $daoTest;

    public function __construct() {
        $this->daoTest = new DAOTest();
    }

    public function obtenerTestPorId($idTest) {
        // Validar el ID del test
        if (!is_int($idTest) || $idTest <= 0) {
            return false; // El ID del test no es válido
        }

        // Llamar al método del DAO para obtener el test por su ID
        return $this->daoTest->obtenerPorId($idTest);
    }

    public function obtenerTestsPorUsuario($idUsuario) {
        // Validar el ID del usuario
        if (!is_int($idUsuario) || $idUsuario <= 0) {
            return false; // El ID del usuario no es válido
        }

        // Llamar al método del DAO para obtener los tests asociados a un usuario
        return $this->daoTest->obtenerPorUsuario($idUsuario);
    }

    // Otros métodos relacionados con la lógica de negocio de los tests
}
?>
