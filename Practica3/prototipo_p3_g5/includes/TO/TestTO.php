<?php
class TestTO {
    public $idTest;
    public $titulo;
    public $idUsuario;
    public $numPreguntas;
    public $esPublico;
    public $esAnonimo;

    public function __construct($idTest = null, $titulo = null, $idUsuario = null, $numPreguntas = null, 
                                $esPublico = null, $esAnonimo = null) {
        $this->idTest = $idTest;
        $this->titulo = $titulo;
        $this->idUsuario = $idUsuario;
        $this->numPreguntas = $numPreguntas;
        $this->esPublico = $esPublico;
        $this->esAnonimo = $esAnonimo;
    }
}
?>
