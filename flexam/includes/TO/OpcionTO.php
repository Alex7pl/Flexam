<?php
class OpcionTO {
    private $idTest;
    private $idPregunta;
    private $idOpcion;
    private $opcion;
    private $correcta;

    public function __construct($idTest = null, $idPregunta = null, $idOpcion = null, $opcion = null, $correcta = null) {
        $this->idTest = $idTest;
        $this->idPregunta = $idPregunta;
        $this->idOpcion = $idOpcion;
        $this->opcion = $opcion;
        $this->correcta = $correcta;
    }

    // Getters
    public function getIdTest() {
        return $this->idTest;
    }

    public function getIdPregunta() {
        return $this->idPregunta;
    }

    public function getIdOpcion() {
        return $this->idOpcion;
    }

    public function getOpcion() {
        return $this->opcion;
    }

    public function getCorrecta() {
        return $this->correcta;
    }

    public function setOpcion($opcion) {
        $this->opcion = $opcion;
    }
}
?>
