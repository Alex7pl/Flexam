<?php
class PreguntaTO {
    private $idPregunta;
    private $idTest;
    private $pregunta;

    public function __construct($idPregunta = null, $idTest = null, $pregunta = null) {
        $this->idPregunta = $idPregunta;
        $this->idTest = $idTest;
        $this->pregunta = $pregunta;
    }

    // Getters
    public function getIdPregunta() {
        return $this->idPregunta;
    }

    public function getIdTest() {
        return $this->idTest;
    }

    public function getPregunta() {
        return $this->pregunta;
    }

    public function setPregunta($pregunta) {
        $this->pregunta = $pregunta;
    }
}
?>
