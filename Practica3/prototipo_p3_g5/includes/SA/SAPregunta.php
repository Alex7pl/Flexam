<?php
require_once '../DAO/DAOPregunta.php';

class SAPregunta {
    private $daoPregunta;

    public function __construct() {
        $this->daoPregunta = new DAOPregunta();
    }

    public function obtenerPreguntaPorId($idPregunta) {
        // Validar el ID de la pregunta
        if (!is_int($idPregunta) || $idPregunta <= 0) {
            return false; // El ID de la pregunta no es válido
        }

        // Llamar al método del DAO para obtener la pregunta por su ID
        return $this->daoPregunta->obtenerPorId($idPregunta);
    }

    public function obtenerPreguntasPorTest($idTest) {
        // Validar el ID del test
        if (!is_int($idTest) || $idTest <= 0) {
            return false; // El ID del test no es válido
        }

        // Llamar al método del DAO para obtener las preguntas asociadas a un test
        return $this->daoPregunta->obtenerPorTest($idTest);
    }

    // Otros métodos relacionados con la lógica de negocio de las preguntas
}
?>
