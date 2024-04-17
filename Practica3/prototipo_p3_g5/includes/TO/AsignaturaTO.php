<?php
class AsignaturaTO {
    public $idAsignatura;
    public $idUniversidad;
    public $nombre;
    public $abreviatura;

    public function __construct($idAsignatura = null, $idUniversidad = null, $nombre = null, $abreviatura = null) {
        $this->idAsignatura = $idAsignatura;
        $this->idUniversidad = $idUniversidad;
        $this->nombre = $nombre;
        $this->abreviatura = $abreviatura;
    }
}
?>
