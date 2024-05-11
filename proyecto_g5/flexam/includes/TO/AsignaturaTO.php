<?php
class AsignaturaTO {
    private $idAsignatura;
    private $idUniversidad;
    private $nombre;
    private $abreviatura;

    public function __construct($idAsignatura = null, $idUniversidad = null, $nombre = null, $abreviatura = null) {
        $this->idAsignatura = $idAsignatura;
        $this->idUniversidad = $idUniversidad;
        $this->nombre = $nombre;
        $this->abreviatura = $abreviatura;
    }

    // Getters
    public function getIdAsignatura() {
        return $this->idAsignatura;
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
}
?>
