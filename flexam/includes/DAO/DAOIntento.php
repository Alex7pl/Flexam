<?php
require_once 'includes/Aplicacion.php';
require_once 'includes/TO/IntentoTO.php';

class DAOIntento {

    public function __construct() {
    }

    /**
     * Inserta un nuevo intento en la base de datos.
     *
     * @param IntentoTO $intento Objeto IntentoTO con los datos del intento a insertar
     * @return bool true si se insertó correctamente, false si hubo un error
     */
    public static function insertarIntento(IntentoTO $intento){

        $db = Aplicacion::getInstance()->getConexionBd();
        $query = "INSERT INTO respuesta_usuario (ID_test, ID_usuario, nota, aciertos, fecha, restriccion) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);

        // Obtener los valores de los getters y almacenarlos en variables
        $idTest = mysqli_real_escape_string($db, $intento->getIdTest());
        $idUsuario = mysqli_real_escape_string($db, $intento->getIdUsuario());
        $nota = mysqli_real_escape_string($db, $intento->getNota());
        $aciertos = mysqli_real_escape_string($db, $intento->getAciertos());
        $fecha = mysqli_real_escape_string($db, $intento->getFecha());
        $res = mysqli_real_escape_string($db, $intento->getRestriccion());

        $stmt->bind_param("iiidsi", $idTest, $idUsuario, $nota, $aciertos, $fecha, $res);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Obtiene el último intento activo de un usuario en un test.
     *
     * @param int $idTest ID del test
     * @param int $idUser ID del usuario
     * @return IntentoTO|false Objeto IntentoTO si se encuentra, false si no
     */
    public static function obtenerIntentoActUser($idTest, $idUser){

        $db = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM respuesta_usuario 
        WHERE ID_test = ? AND ID_usuario = ? 
        ORDER BY ID_intento DESC LIMIT 1";
        $stmt = $db->prepare($query);
        $idTest = mysqli_real_escape_string($db, $idTest);
        $idUser = mysqli_real_escape_string($db, $idUser);
        $stmt->bind_param("ss", $idTest, $idUser);
        $stmt->execute();
        $rs = $stmt->get_result();

        if ($rs) {
            $row = $rs->fetch_assoc();
            if ($row) {
                return new IntentoTO($row['ID_test'], $row['ID_usuario'], $row['ID_intento'], $row['nota'], $row['aciertos'], $row['fecha'], $row['restriccion']);
            }
        }
        return false;
    }

    /**
     * Obtiene todos los intentos de un usuario en un test específico.
     *
     * @param int $idUsuario ID del usuario
     * @param int $idTest ID del test
     * @return array Array de objetos IntentoTO
     */
    public static function obtenerIntentosPorUsuarioTest($idUsuario, $idTest) {

        $db = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM respuesta_usuario WHERE ID_usuario = ? AND ID_test = ?";
        $stmt = $db->prepare($query);
        $idUsuario = mysqli_real_escape_string($db, $idUsuario);
        $idTest = mysqli_real_escape_string($db, $idTest);
        $stmt->bind_param("ss", $idUsuario, $idTest);
        $stmt->execute();
        $intentos = [];
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $intentos[] = new IntentoTO($row['ID_test'], $row['ID_usuario'], $row['ID_intento'], $row['nota'], $row['aciertos'], $row['fecha'], $row['restriccion']);
        }

        return $intentos;
    }

    /**
     * Obtiene todos los intentos de un usuario.
     *
     * @param int $idUsuario ID del usuario
     * @return array Array de objetos IntentoTO
     */
    public static function obtenerIntentosPorUsuario($idUsuario) {

        $db = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM respuesta_usuario WHERE ID_usuario = ?";
        $stmt = $db->prepare($query);
        $idUsuario = mysqli_real_escape_string($db, $idUsuario);
        $stmt->bind_param("s", $idUsuario);
        $stmt->execute();
        $intentos = [];
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $intentos[] = new IntentoTO($row['ID_test'], $row['ID_usuario'], $row['ID_intento'], $row['nota'], $row['aciertos'], $row['fecha'], $row['restriccion']);
        }

        return $intentos;
    }

    /**
     * Obtiene el número de intentos de un usuario en un test específico.
     *
     * @param int $idTest ID del test
     * @param int $idUsuario ID del usuario
     * @return int|false Número de intentos si se encuentra, false si no
     */
    public static function numIntentosPorTest($idTest, $idUsuario) {

        $db = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT COUNT(*) AS numero_intentos
        FROM respuesta_usuario WHERE ID_test = ? AND ID_usuario = ?";
        $stmt = $db->prepare($query);
        $idTest = mysqli_real_escape_string($db, $idTest);
        $idUsuario = mysqli_real_escape_string($db, $idUsuario);
        $stmt->bind_param("ss", $idTest, $idUsuario);
        $stmt->execute();
        $rs = $stmt->get_result();

        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                return $fila['numero_intentos'];
            }
        }
        return false;
    }

    /**
     * Obtiene las estadísticas totales de un test para un usuario.
     *
     * @param int $idTest ID del test
     * @param int $idUsuario ID del usuario
     * @return array|false Array con las estadísticas si se encuentran, false si no
     */
    public static function estadisticasTestTotales($idTest, $idUsuario){

        $db = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT AVG(nota) AS nota_media, SUM(aciertos) AS total_aciertos FROM respuesta_usuario 
        WHERE ID_test = ? AND ID_usuario = ?";
        $stmt = $db->prepare($query);
        $idTest = mysqli_real_escape_string($db, $idTest);
        $idUsuario = mysqli_real_escape_string($db, $idUsuario);
        $stmt->bind_param("ss", $idTest, $idUsuario);
        $stmt->execute();
        $rs = $stmt->get_result();

        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $array = array("nota_media" => $fila['nota_media'], "total_aciertos" => $fila['total_aciertos']);
                return $array;
            }
        }
        return false;
    }
}
?>
