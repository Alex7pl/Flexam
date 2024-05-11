<?php
require_once 'includes/DAO/DAOUsuario.php';

/**
 * Clase que representa el Servicio de Aplicación para la entidad Usuario.
 */
class SAUsuario {

    /**
     * Constructor de la clase SAUsuario.
     */
    public function __construct() {
    }

    /**
     * Registra un nuevo usuario en la base de datos.
     *
     * @param string $user Nombre de usuario.
     * @param string $psw Contraseña del usuario.
     * @param string $nombre Nombre del usuario.
     * @param string $apellidos Apellidos del usuario.
     * @param string $email Correo electrónico del usuario.
     * @param int $ID_universidad ID de la universidad del usuario.
     * @param int $ID_grado ID del grado del usuario.
     * @return int Código de resultado: 1 si se registró correctamente, 0 si hubo un error en el registro, -1 si el usuario ya existe.
     */
    public static function registrarUsuario($user, $psw, $nombre, $apellidos, $email, $ID_universidad, $ID_grado) {

        $usuario = new UsuarioTO(null, $user, DAOUsuario::hashPassword($psw), $nombre,
        $apellidos, $email, $ID_universidad, $ID_grado, 'estudiante');

        $result = DAOUsuario::buscaUsuarioPorNombre($usuario->getNombreUsuario());

        if(!$result) {

            if(DAOUsuario::insertarUsuario($usuario)){
                return 1;
            }
            else{
                return 0;
            }
        }
        else{
            return -1;
        }
    }

    /**
     * Inicia sesión de usuario.
     *
     * @param string $user Nombre de usuario.
     * @param string $psw Contraseña del usuario.
     * @return UsuarioTO|false Objeto UsuarioTO si las credenciales son válidas, false en caso contrario.
     */
    public static function login($user, $psw) {

        // Llamar al DAO para verificar las credenciales y obtener los datos del usuario
        $usuario = DAOUsuario::buscaUsuarioPorNombre($user);
        if ($usuario && $usuario->compruebaPassword($psw)) {
            return $usuario;
        }
        return false;
    }

    /**
     * Busca un usuario por su nombre de usuario.
     *
     * @param string $user Nombre de usuario.
     * @return UsuarioTO|false Objeto UsuarioTO si se encuentra el usuario, false en caso contrario.
     */
    public static function buscaUsuarioPorNombre($user){
        $usuario = DAOUsuario::buscaUsuarioPorNombre($user);
        if($usuario){
            return $usuario;
        }
        else{
            return false;
        }
    }

    /**
     * Busca un usuario por su ID de usuario.
     *
     * @param string $user Nombre de usuario.
     * @return UsuarioTO|false Objeto UsuarioTO si se encuentra el usuario, false en caso contrario.
     */
    public static function buscaUsuarioPorID($user){
        $usuario = DAOUsuario::buscaUsuarioPorID($user);
        if($usuario){
            return $usuario;
        }
        else{
            return false;
        }
    }
}
?>
