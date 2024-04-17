<?php
class UsuarioTO {
    public $idUsuario;
    public $username;
    public $passwordHash;
    public $nombre;
    public $apellidos;
    public $email;
    public $idUniversidad;
    public $idGrado;
    public $rol;

    public function __construct($idUsuario = null, $username = null, $passwordHash = null, $nombre = null, 
                                $apellidos = null, $email = null, $idUniversidad = null, $idGrado = null, $rol = null) {
        $this->idUsuario = $idUsuario;
        $this->username = $username;
        $this->passwordHash = $passwordHash;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->idUniversidad = $idUniversidad;
        $this->idGrado = $idGrado;
        $this->rol = $rol;
    }
}
?>
