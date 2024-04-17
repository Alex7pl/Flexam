<?php
require_once '../comun/Aplicacion.php';
require_once 'AsignaturaTO.php';

class DAOAsignatura {
    private $db;

    public function __construct() {
        $this->db = Aplicacion::getInstance()->getConnection(); // Utiliza la conexión del singleton Aplicacion
    }

    // Método para insertar una nueva asignatura
    public function insertarAsignatura(AsignaturaTO $asignatura) {
        $query = "INSERT INTO asignaturas (ID_universidad, nombre, abreviatura) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $asignatura->idUniversidad,
            $asignatura->nombre,
            $asignatura->abreviatura
        ]);
        return $this->db->lastInsertId(); // Devuelve el ID de la asignatura insertada
    }

    // Método para obtener una asignatura por su ID
    public function obtenerAsignaturaPorId($id) {
        $query = "SELECT * FROM asignaturas WHERE ID_asignatura = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($row) {
            return new AsignaturaTO($row['ID_asignatura'], $row['ID_universidad'], $row['nombre'], $row['abreviatura']);
        } else {
            return null;
        }
    }

    // Método para actualizar una asignatura
    public function actualizarAsignatura(AsignaturaTO $asignatura) {
        $query = "UPDATE asignaturas SET nombre = ?, abreviatura = ? WHERE ID_asignatura = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $asignatura->nombre,
            $asignatura->abreviatura,
            $asignatura->idAsignatura
        ]);
        return $stmt->rowCount(); // Devuelve el número de filas afectadas
    }

    // Método para eliminar una asignatura
    public function eliminarAsignatura($id) {
        $query = "DELETE FROM asignaturas WHERE ID_asignatura = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->rowCount(); // Devuelve el número de filas afectadas
    }

    // Método para listar todas las asignaturas de una universidad
    public function listarAsignaturasPorUniversidad($idUniversidad) {
        $query = "SELECT * FROM asignaturas WHERE ID_universidad = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$idUniversidad]);
        $asignaturas = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $asignaturas[] = new AsignaturaTO($row['ID_asignatura'], $row['ID_universidad'], $row['nombre'], $row['abreviatura']);
        }
        return $asignaturas;
    }
}
?>
