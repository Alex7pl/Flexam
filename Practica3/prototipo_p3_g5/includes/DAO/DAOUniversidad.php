<?php
require_once '../comun/Aplicacion.php';
require_once 'UniversidadTO.php';

class DAOUniversidad {
    private $db;

    public function __construct() {
        $this->db = Aplicacion::getInstance()->getConnection(); // Usar la conexión del singleton Aplicacion
    }

    // Método para insertar una nueva universidad
    public function insertarUniversidad(UniversidadTO $universidad) {
        $query = "INSERT INTO universidades (nombre, abreviatura, ciudad) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $universidad->nombre,
            $universidad->abreviatura,
            $universidad->ciudad
        ]);
        return $this->db->lastInsertId(); // Devuelve el ID de la universidad insertada
    }

    // Método para obtener una universidad por su ID
    public function obtenerUniversidadPorId($id) {
        $query = "SELECT * FROM universidades WHERE ID_universidad = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($row) {
            return new UniversidadTO($row['ID_universidad'], $row['nombre'], $row['abreviatura'], $row['ciudad']);
        } else {
            return null;
        }
    }

    // Método para actualizar una universidad
    public function actualizarUniversidad(UniversidadTO $universidad) {
        $query = "UPDATE universidades SET nombre = ?, abreviatura = ?, ciudad = ? WHERE ID_universidad = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $universidad->nombre,
            $universidad->abreviatura,
            $universidad->ciudad,
            $universidad->idUniversidad
        ]);
        return $stmt->rowCount(); // Devuelve el número de filas afectadas
    }

    // Método para eliminar una universidad
    public function eliminarUniversidad($id) {
        $query = "DELETE FROM universidades WHERE ID_universidad = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->rowCount(); // Devuelve el número de filas afectadas
    }

    // Método para listar todas las universidades
    public function listarUniversidades() {
        $query = "SELECT * FROM universidades";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $universidades = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $universidades[] = new UniversidadTO($row['ID_universidad'], $row['nombre'], $row['abreviatura'], $row['ciudad']);
        }
        return $universidades;
    }
}
?>
