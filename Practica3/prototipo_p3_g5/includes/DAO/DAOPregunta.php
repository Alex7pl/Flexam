<?php
require_once '../comun/Aplicacion.php';
require_once 'PreguntaTO.php';

class DAOPregunta {
    private $db;

    public function __construct() {
        $this->db = Aplicacion::getInstance()->getConnection(); // Utilizar la conexión del singleton Aplicacion
    }

    // Método para insertar una nueva pregunta
    public function insertarPregunta(PreguntaTO $pregunta) {
        $query = "INSERT INTO preguntas (ID_test, pregunta) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $pregunta->idTest,
            $pregunta->pregunta
        ]);
        return $this->db->lastInsertId(); // Devuelve el ID de la pregunta insertada
    }

    // Método para obtener una pregunta por su ID
    public function obtenerPreguntaPorId($id) {
        $query = "SELECT * FROM preguntas WHERE ID_pregunta = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($row) {
            return new PreguntaTO($row['ID_pregunta'], $row['ID_test'], $row['pregunta']);
        } else {
            return null;
        }
    }

    // Método para actualizar una pregunta
    public function actualizarPregunta(PreguntaTO $pregunta) {
        $query = "UPDATE preguntas SET pregunta = ? WHERE ID_pregunta = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $pregunta->pregunta,
            $pregunta->idPregunta
        ]);
        return $stmt->rowCount(); // Devuelve el número de filas afectadas
    }

    // Método para eliminar una pregunta
    public function eliminarPregunta($id) {
        $query = "DELETE FROM preguntas WHERE ID_pregunta = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->rowCount(); // Devuelve el número de filas afectadas
    }

    // Método para listar todas las preguntas de un test
    public function listarPreguntasPorTest($idTest) {
        $query = "SELECT * FROM preguntas WHERE ID_test = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$idTest]);
        $preguntas = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $preguntas[] = new PreguntaTO($row['ID_pregunta'], $row['ID_test'], $row['pregunta']);
        }
        return $preguntas;
    }
}
?>
