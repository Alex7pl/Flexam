<?php
class TestTO {
    private $idTest;
    private $titulo;
    private $idUsuario;
    private $numPreguntas;
    private $esPublico;
    private $esAnonimo;

    public function __construct($idTest = null, $titulo = null, $idUsuario = null, $numPreguntas = null, 
                                $esPublico = null, $esAnonimo = null) {
        $this->idTest = $idTest;
        $this->titulo = $titulo;
        $this->idUsuario = $idUsuario;
        $this->numPreguntas = $numPreguntas;
        $this->esPublico = $esPublico;
        $this->esAnonimo = $esAnonimo;
    }

    // Getters
    public function getIdTest() {
        return $this->idTest;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getNumPreguntas() {
        return $this->numPreguntas;
    }

    public function getEsPublico() {
        return $this->esPublico;
    }

    public function getEsAnonimo() {
        return $this->esAnonimo;
    }

    //Setters
    public function setIdTest($newID) {
        $this->idTest = $newID;
    }

}
?>
