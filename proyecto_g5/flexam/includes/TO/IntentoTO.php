<?php
class IntentoTO {
    private $idTest;
    private $idUsuario;
    private $idIntento;
    private $nota;
    private $aciertos;
    private $fecha;
    private $restriccion;

    public function __construct($idTest = null, $idUsuario = null, $idIntento = null, $nota = null, 
                                $aciertos = null, $fecha = null, $restriccion = null) {
        $this->idTest = $idTest;
        $this->idUsuario = $idUsuario;
        $this->idIntento = $idIntento;
        $this->nota = $nota;
        $this->aciertos = $aciertos;
        $this->fecha = $fecha;
        $this->restriccion = $restriccion;
    }

    // Getters
    public function getIdTest() {
        return $this->idTest;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getIdIntento() {
        return $this->idIntento;
    }

    public function getNota() {
        return $this->nota;
    }

    public function getAciertos() {
        return $this->aciertos;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getRestriccion() {
        return $this->restriccion;
    }
}
?>