<?php
require_once 'includes/Aplicacion.php';
require_once 'includes/TO/UsuarioTO.php';

/**
 * Clase que gestiona la interacción con la base de datos para la entidad Usuario.
 */
class DAOUsuario {

    /**
     * Constructor de la clase DAOUsuario.
     */
    public function __construct() {
    }

    /**
     * Inserta un nuevo usuario en la base de datos.
     *
     * @param UsuarioTO $usuario Objeto UsuarioTO que representa al usuario a insertar.
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public static function insertarUsuario(UsuarioTO $usuario) {
        $db = Aplicacion::getInstance()->getConexionBd();
        $query = "INSERT INTO usuarios (user, psw, nombre, apellidos, email, ID_universidad, ID_grado, rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
    
        // Sanitizar los valores de los getters y almacenarlos en variables
        $user = filter_var(htmlspecialchars($usuario->getNombreUsuario()), FILTER_SANITIZE_STRING);
        $psw = htmlspecialchars($usuario->getPasswordHash());
        $nombre = filter_var(htmlspecialchars($usuario->getNombre()), FILTER_SANITIZE_STRING);
        $apellidos = filter_var(htmlspecialchars($usuario->getApellidos()), FILTER_SANITIZE_STRING);
        $email = filter_var(htmlspecialchars($usuario->getEmail()), FILTER_SANITIZE_EMAIL);
        $idUniversidad = intval($usuario->getIdUniversidad()); // Convertir a entero para evitar inyección de SQL
        $idGrado = intval($usuario->getIdGrado()); // Convertir a entero para evitar inyección de SQL
        $rol = filter_var(htmlspecialchars($usuario->getRol()), FILTER_SANITIZE_STRING);
    
        // Vincular los parámetros utilizando las variables
        $stmt->bind_param("ssssssss", $user, $psw, $nombre, $apellidos, 
        $email, $idUniversidad, $idGrado, $rol);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Genera un hash de contraseña utilizando el algoritmo por defecto de PHP.
     *
     * @param string $password Contraseña a hashear.
     * @return string El hash de la contraseña.
     */
    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Busca un usuario en la base de datos por su nombre de usuario.
     *
     * @param string $nombreUsuario Nombre de usuario a buscar.
     * @return UsuarioTO|false Objeto UsuarioTO si se encontró el usuario, false en caso contrario.
     */
    public static function buscaUsuarioPorNombre($nombreUsuario)
    {   
        $db = Aplicacion::getInstance()->getConexionBd();
        $nombreUsuario = filter_var(htmlspecialchars($nombreUsuario), FILTER_SANITIZE_STRING);
        $query = "SELECT * FROM usuarios WHERE user = ?";
        $stmt = $db->prepare($query); // Preparar la consulta SQL
        $stmt->bind_param("s", $nombreUsuario); // Asociar el parámetro con la consulta SQL
        $stmt->execute(); // Ejecutar la consulta SQL
        $rs = $stmt->get_result(); // Obtener el conjunto de resultados
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new UsuarioTO($fila['ID_usuario'], $fila['user'], $fila['psw'], $fila['nombre'], $fila['apellidos'], 
                $fila['email'], $fila['ID_universidad'], $fila['ID_grado'], $fila['rol']);
            }
            $rs->free();
        } else {
            return false;
        }
        return $result;
    }

    /**
     * Busca un usuario en la base de datos por su nombre de usuario.
     *
     * @param string $nombreUsuario Nombre de usuario a buscar.
     * @return UsuarioTO|false Objeto UsuarioTO si se encontró el usuario, false en caso contrario.
     */
    public static function buscaUsuarioPorID($idUsuario)
    {   
        $db = Aplicacion::getInstance()->getConexionBd();
        $idUsuario = filter_var(htmlspecialchars($idUsuario), FILTER_SANITIZE_STRING);
        $query = "SELECT * FROM usuarios WHERE ID_usuario = ?";
        $stmt = $db->prepare($query); // Preparar la consulta SQL
        $stmt->bind_param("i", $idUsuario); // Asociar el parámetro con la consulta SQL
        $stmt->execute(); // Ejecutar la consulta SQL
        $rs = $stmt->get_result(); // Obtener el conjunto de resultados
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new UsuarioTO($fila['ID_usuario'], $fila['user'], $fila['psw'], $fila['nombre'], $fila['apellidos'], 
                $fila['email'], $fila['ID_universidad'], $fila['ID_grado'], $fila['rol']);
            }
            $rs->free();
        } else {
            return false;
        }
        return $result;
    }
}
?>
