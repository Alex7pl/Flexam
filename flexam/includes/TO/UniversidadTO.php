<?php
class UniversidadTO {
    private $idUniversidad;
    private $nombre;
    private $abreviatura;
    private $ciudad;

    public function __construct($idUniversidad = null, $nombre = null, $abreviatura = null, $ciudad = null) {
        $this->idUniversidad = $idUniversidad;
        $this->nombre = $nombre;
        $this->abreviatura = $abreviatura;
        $this->ciudad = $ciudad;
    }

    public function getIdUniversidad() {
        return $this->idUniversidad;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getAbreviatura() {
        return $this->abreviatura;
    }

    public function getCiudad() {
        return $this->ciudad;
    }
}
?>
