<?php
require_once '../comun/Aplicacion.php';
require_once 'UsuarioTO.php';

class DAOUsuario {
    private $db;

    public function __construct() {
        $this->db = Aplicacion::getInstance()->getConnection(); // Asegura una única instancia de conexión.
    }

    // Método para insertar un nuevo usuario
    public function insertarUsuario(UsuarioTO $usuario) {
        $query = "INSERT INTO usuarios (user, psw, nombre, apellidos, email, ID_universidad, ID_grado, rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $passwordHash = password_hash($usuario->passwordHash, PASSWORD_DEFAULT); // Asegúrate de hashear la contraseña
        $stmt->execute([
            $usuario->username,
            $passwordHash,
            $usuario->nombre,
            $usuario->apellidos,
            $usuario->email,
            $usuario->idUniversidad,
            $usuario->idGrado,
            $usuario->rol
        ]);

        return $this->db->lastInsertId(); // Devuelve el ID del usuario insertado
    }

    // Método para obtener un usuario por su ID
    public function obtenerUsuarioPorId($id) {
        $query = "SELECT * FROM usuarios WHERE ID_usuario = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($row) {
            return new UsuarioTO($row['ID_usuario'], $row['user'], null, $row['nombre'], $row['apellidos'], $row['email'], $row['ID_universidad'], $row['ID_grado'], $row['rol']);
        } else {
            return null;
        }
    }

    // Método para actualizar un usuario
    public function actualizarUsuario(UsuarioTO $usuario) {
        $query = "UPDATE usuarios SET user = ?, nombre = ?, apellidos = ?, email = ?, ID_universidad = ?, ID_grado = ?, rol = ? WHERE ID_usuario = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $usuario->username,
            $usuario->nombre,
            $usuario->apellidos,
            $usuario->email,
            $usuario->idUniversidad,
            $usuario->idGrado,
            $usuario->rol,
            $usuario->idUsuario
        ]);
        return $stmt->rowCount(); // Devuelve el número de filas afectadas
    }

    // Método para eliminar un usuario
    public function eliminarUsuario($id) {
        $query = "DELETE FROM usuarios WHERE ID_usuario = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->rowCount(); // Devuelve el número de filas afectadas
    }
}
?>
