<?php
class GradoTO {
    private $idGrado;
    private $nombre;
    private $idUniversidad;

    public function __construct($idGrado = null, $nombre = null, $idUniversidad = null) {
        $this->idGrado = $idGrado;
        $this->nombre = $nombre;
        $this->idUniversidad = $idUniversidad;
    }

    // Getter para obtener el ID del grado
    public function getIdGrado() {
        return $this->idGrado;
    }

    // Getter para obtener el nombre del grado
    public function getNombre() {
        return $this->nombre;
    }

    // Getter para obtener el ID de la universidad asociada al grado
    public function getIdUniversidad() {
        return $this->idUniversidad;
    }
}
?>
