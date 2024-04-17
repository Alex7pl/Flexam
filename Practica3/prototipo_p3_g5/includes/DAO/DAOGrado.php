<?php
require_once '../comun/Aplicacion.php';
require_once 'GradoTO.php';

class DAOGrado {
    private $db;

    public function __construct() {
        $this->db = Aplicacion::getInstance()->getConnection(); // Utiliza la conexión del singleton Aplicacion
    }

    // Método para insertar un nuevo grado
    public function insertarGrado(GradoTO $grado) {
        $query = "INSERT INTO grados (ID_universidad, nombre) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $grado->idUniversidad,
            $grado->nombre
        ]);
        return $this->db->lastInsertId(); // Devuelve el ID del grado insertado
    }

    // Método para obtener un grado por su ID
    public function obtenerGradoPorId($id) {
        $query = "SELECT * FROM grados WHERE ID_grado = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($row) {
            return new GradoTO($row['ID_grado'], $row['ID_universidad'], $row['nombre']);
        } else {
            return null;
        }
    }

    // Método para actualizar un grado
    public function actualizarGrado(GradoTO $grado) {
        $query = "UPDATE grados SET nombre = ? WHERE ID_grado = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $grado->nombre,
            $grado->idGrado
        ]);
        return $stmt->rowCount(); // Devuelve el número de filas afectadas
    }

    // Método para eliminar un grado
    public function eliminarGrado($id) {
        $query = "DELETE FROM grados WHERE ID_grado = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->rowCount(); // Devuelve el número de filas afectadas
    }

    // Método para listar todos los grados de una universidad
    public function listarGradosPorUniversidad($idUniversidad) {
        $query = "SELECT * FROM grados WHERE ID_universidad = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$idUniversidad]);
        $grados = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $grados[] = new GradoTO($row['ID_grado'], $row['ID_universidad'], $row['nombre']);
        }
        return $grados;
    }
}
?>
