<?php
class UniversidadTO {
    public $idUniversidad;
    public $nombre;
    public $abreviatura;
    public $ciudad;

    public function __construct($idUniversidad = null, $nombre = null, $abreviatura = null, $ciudad = null) {
        $this->idUniversidad = $idUniversidad;
        $this->nombre = $nombre;
        $this->abreviatura = $abreviatura;
        $this->ciudad = $ciudad;
    }
}
?>
