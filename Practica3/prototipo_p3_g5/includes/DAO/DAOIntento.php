<?php
require_once '../comun/Aplicacion.php';
require_once 'IntentoTO.php';

class DAOIntento {
    private $db;

    public function __construct() {
        $this->db = Aplicacion::getInstance()->getConnection(); // Utiliza la conexión del singleton Aplicacion
    }

    // Método para insertar un nuevo intento de test
    public function insertarIntento(IntentoTestTO $intento) {
        $query = "INSERT INTO respuesta_usuario (ID_test, ID_usuario, nota, aciertos, fecha, restriccion) VALUES (?, ?, ?, ?, NOW(), ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $intento->idTest,
            $intento->idUsuario,
            $intento->nota,
            $intento->aciertos,
            $intento->restriccion
        ]);
        return $this->db->lastInsertId(); // Devuelve el ID del intento insertado
    }

    // Método para obtener un intento por su ID
    public function obtenerIntentoPorId($idIntento) {
        $query = "SELECT * FROM respuesta_usuario WHERE ID_intento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$idIntento]);
        $row = $stmt->fetch();
        if ($row) {
            return new IntentoTestTO($row['ID_intento'], $row['ID_test'], $row['ID_usuario'], $row['nota'], $row['aciertos'], $row['fecha'], $row['restriccion']);
        } else {
            return null;
        }
    }

    // Método para listar todos los intentos de un usuario en un test específico
    public function listarIntentosPorTestUsuario($idTest, $idUsuario) {
        $query = "SELECT * FROM respuesta_usuario WHERE ID_test = ? AND ID_usuario = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$idTest, $idUsuario]);
        $intentos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $intentos[] = new IntentoTestTO($row['ID_intento'], $row['ID_test'], $row['ID_usuario'], $row['nota'], $row['aciertos'], $row['fecha'], $row['restriccion']);
        }
        return $intentos;
    }
}
?>
