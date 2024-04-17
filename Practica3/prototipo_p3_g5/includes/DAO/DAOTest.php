<?php
require_once '../comun/Aplicacion.php';
require_once 'TestTO.php';

class DAOTest {
    private $db;

    public function __construct() {
        $this->db = Aplicacion::getInstance()->getConnection(); // Utilizar la conexión del singleton Aplicacion
    }

    // Método para insertar un nuevo test
    public function insertarTest(TestTO $test) {
        $query = "INSERT INTO tests (titulo, ID_usuario, num_preguntas, es_publico, es_anonimo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $test->titulo,
            $test->idUsuario,
            $test->numPreguntas,
            $test->esPublico,
            $test->esAnonimo
        ]);
        return $this->db->lastInsertId(); // Devuelve el ID del test insertado
    }

    // Método para obtener un test por su ID
    public function obtenerTestPorId($id) {
        $query = "SELECT * FROM tests WHERE ID_test = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($row) {
            return new TestTO($row['ID_test'], $row['titulo'], $row['ID_usuario'], $row['num_preguntas'], $row['es_publico'], $row['es_anonimo']);
        } else {
            return null;
        }
    }

    // Método para actualizar un test
    public function actualizarTest(TestTO $test) {
        $query = "UPDATE tests SET titulo = ?, num_preguntas = ?, es_publico = ?, es_anonimo = ? WHERE ID_test = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $test->titulo,
            $test->numPreguntas,
            $test->esPublico,
            $test->esAnonimo,
            $test->idTest
        ]);
        return $stmt->rowCount(); // Devuelve el número de filas afectadas
    }

    // Método para eliminar un test
    public function eliminarTest($id) {
        $query = "DELETE FROM tests WHERE ID_test = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->rowCount(); // Devuelve el número de filas afectadas
    }

    // Método para listar todos los tests de un usuario
    public function listarTestsPorUsuario($idUsuario) {
        $query = "SELECT * FROM tests WHERE ID_usuario = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$idUsuario]);
        $tests = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tests[] = new TestTO($row['ID_test'], $row['titulo'], $row['ID_usuario'], $row['num_preguntas'], $row['es_publico'], $row['es_anonimo']);
        }
        return $tests;
    }
}
?>
