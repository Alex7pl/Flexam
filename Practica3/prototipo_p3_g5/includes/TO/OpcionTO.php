<?php
class OpcionTO {
    public $idTest;
    public $idPregunta;
    public $idOpcion;
    public $opcion;
    public $correcta;

    public function __construct($idTest = null, $idPregunta = null, $idOpcion = null, $opcion = null, $correcta = null) {
        $this->idTest = $idTest;
        $this->idPregunta = $idPregunta;
        $this->idOpcion = $idOpcion;
        $this->opcion = $opcion;
        $this->correcta = $correcta;
    }
}
?>
