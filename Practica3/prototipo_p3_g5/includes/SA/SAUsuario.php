<?php
require_once 'DAOUsuario.php';

class SAUsuario {
    private $daoUsuario;

    public function __construct() {
        $this->daoUsuario = new DAOUsuario();
    }

    // Método para registrar un nuevo usuario
    public function registrarUsuario($user, $psw, $nombre, $apellidos, $email, $ID_universidad, $ID_grado) {
        // Aquí podrías realizar validaciones adicionales antes de llamar al DAO
        // Por ejemplo, verificar que el email no esté ya registrado, etc.

        // Llamar al DAO para registrar el usuario en la base de datos
        return $this->daoUsuario->insertarUsuario($user, $psw, $nombre, $apellidos, $email, $ID_universidad, $ID_grado);
    }

    // Método para iniciar sesión de usuario
    public function iniciarSesion($user, $psw) {
        // Aquí podrías realizar validaciones adicionales antes de llamar al DAO
        // Por ejemplo, verificar que las credenciales sean válidas, etc.

        // Llamar al DAO para verificar las credenciales y obtener los datos del usuario
        return $this->daoUsuario->validarCredenciales($user, $psw);
    }

    // Método para cerrar sesión de usuario
    public function cerrarSesion() {
        // Aquí podrías realizar cualquier operación necesaria al cerrar sesión
        // Por ejemplo, limpiar variables de sesión, etc.
    }

    // Otros métodos relacionados con la lógica de negocio de usuarios
}
?>
