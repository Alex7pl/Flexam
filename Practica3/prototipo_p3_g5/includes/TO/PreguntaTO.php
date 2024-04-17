<?php
class PreguntaTO {
    public $idPregunta;
    public $idTest;
    public $pregunta;

    public function __construct($idPregunta = null, $idTest = null, $pregunta = null) {
        $this->idPregunta = $idPregunta;
        $this->idTest = $idTest;
        $this->pregunta = $pregunta;
    }
}
?>
