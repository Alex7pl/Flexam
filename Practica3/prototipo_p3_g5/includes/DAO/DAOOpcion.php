<?php
require_once '../comun/Aplicacion.php';
require_once 'OpcionTO.php';

class DAOOpcion {
    private $db;

    public function __construct() {
        $this->db = Aplicacion::getInstance()->getConnection(); // Utiliza la conexión del singleton Aplicacion
    }

    // Método para insertar una nueva opción
    public function insertarOpcion(OpcionTO $opcion) {
        $query = "INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $opcion->idTest,
            $opcion->idPregunta,
            $opcion->idOpcion,
            $opcion->opcion,
            $opcion->correcta
        ]);
        return $this->db->lastInsertId(); // Devuelve el ID de la opción insertada
    }

    // Método para obtener una opción por su ID
    public function obtenerOpcionPorId($idTest, $idPregunta, $idOpcion) {
        $query = "SELECT * FROM opciones WHERE ID_test = ? AND ID_pregunta = ? AND ID_opcion = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$idTest, $idPregunta, $idOpcion]);
        $row = $stmt->fetch();
        if ($row) {
            return new OpcionTO($row['ID_test'], $row['ID_pregunta'], $row['ID_opcion'], $row['opcion'], $row['correcta']);
        } else {
            return null;
        }
    }

    // Método para actualizar una opción
    public function actualizarOpcion(OpcionTO $opcion) {
        $query = "UPDATE opciones SET opcion = ?, correcta = ? WHERE ID_test = ? AND ID_pregunta = ? AND ID_opcion = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $opcion->opcion,
            $opcion->correcta,
            $opcion->idTest,
            $opcion->idPregunta,
            $opcion->idOpcion
        ]);
        return $stmt->rowCount(); // Devuelve el número de filas afectadas
    }

    // Método para eliminar una opción
    public function eliminarOpcion($idTest, $idPregunta, $idOpcion) {
        $query = "DELETE FROM opciones WHERE ID_test = ? AND ID_pregunta = ? AND ID_opcion = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$idTest, $idPregunta, $idOpcion]);
        return $stmt->rowCount(); // Devuelve el número de filas afectadas
    }

    // Método para listar todas las opciones de una pregunta de un test
    public function listarOpcionesPorPregunta($idTest, $idPregunta) {
        $query = "SELECT * FROM opciones WHERE ID_test = ? AND ID_pregunta = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$idTest, $idPregunta]);
        $opciones = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $opciones[] = new OpcionTO($row['ID_test'], $row['ID_pregunta'], $row['ID_opcion'], $row['opcion'], $row['correcta']);
        }
        return $opciones;
    }
}
?>
