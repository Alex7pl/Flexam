<?php
class GradoTO {
    public $idGrado;
    public $nombre;
    public $idUniversidad;

    public function __construct($idGrado = null, $nombre = null, $idUniversidad = null) {
        $this->idGrado = $idGrado;
        $this->nombre = $nombre;
        $this->idUniversidad = $idUniversidad;
    }
}
?>
