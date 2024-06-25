<?php
require_once 'includes/Aplicacion.php';
require_once 'includes/TO/AsignaturaTO.php';

class DAOAsignatura {

    public function __construct() {
    }

    /**
     * Obtiene el nombre de la asignatura asociada a un test mediante su ID.
     *
     * @param int $idTest ID del test
     * @return string|null Nombre de la asignatura o null si no se encuentra
     */
    public static function obtenerNombreAsignaturaTest($idTest) {
        $db = Aplicacion::getInstance()->getConexionBd();
        $idTest = mysqli_real_escape_string($db, $idTest);
        $query = "SELECT asignaturas.nombre AS nombre_asignatura
                  FROM tests 
                  INNER JOIN test_asignatura ON tests.ID_test = test_asignatura.ID_test 
                  INNER JOIN asignaturas ON test_asignatura.ID_asignatura = asignaturas.ID_asignatura
                  WHERE tests.ID_test = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $idTest);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            return $fila['nombre_asignatura'];
        } else {
            return null;
        }
    }

     /**
     * Obtiene las asignaturas asociadaa a un user mediante su ID.
     *
     * @param int $idUsuario ID del user
     * @return array asignaturas
     */
    public static function obtenerAsignaturasPorUsuario($idUsuario) {
        $db = Aplicacion::getInstance()->getConexionBd();
        $idUsuario = mysqli_real_escape_string($db, $idUsuario);
        $query = "SELECT asignaturas.ID_asignatura, asignaturas.ID_universidad, asignaturas.nombre, asignaturas.abreviatura
                  FROM asignaturas
                  JOIN grado_asignatura ON asignaturas.ID_asignatura = grado_asignatura.ID_asignatura
                  JOIN usuarios ON grado_asignatura.ID_grado = usuarios.ID_grado
                  WHERE usuarios.ID_usuario = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $asignaturas = [];
        while ($row = $result->fetch_assoc()) {
            $asignaturas[] = new AsignaturaTO($row['ID_asignatura'], $row['ID_universidad'], $row['nombre'], $row['abreviatura']);
        }
        return $asignaturas;
    }
}
?>