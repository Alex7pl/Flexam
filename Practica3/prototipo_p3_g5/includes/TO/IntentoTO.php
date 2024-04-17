<?php
class IntentoTestTO {
    public $idTest;
    public $idUsuario;
    public $idIntento;
    public $nota;
    public $aciertos;
    public $fecha;
    public $restriccion;

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
}
?>
