<?php
class UsuarioTO {
    private $idUsuario;
    private $username;
    private $passwordHash;
    private $nombre;
    private $apellidos;
    private $email;
    private $idUniversidad;
    private $idGrado;
    private $rol;

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

    public function getId()
    {
        return $this->idUsuario;
    }

    public function getNombreUsuario()
    {
        return $this->username;
    }

    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getIdUniversidad()
    {
        return $this->idUniversidad;
    }

    public function getIdGrado()
    {
        return $this->idGrado;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function compruebaPassword($password)
    {
        return password_verify($password, $this->passwordHash);
    }
}
?>
