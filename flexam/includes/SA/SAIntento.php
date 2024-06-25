<?php
require_once 'includes/DAO/DAOIntento.php';

/**
 * Clase que representa el Servicio de Aplicación para la entidad Intento.
 */
class SAIntento {

    /**
     * Constructor de la clase SAIntento.
     */
    public function __construct() {
    }

    /**
     * Registra un nuevo intento en la base de datos.
     *
     * @param int $idTest ID del test.
     * @param int $idUsuario ID del usuario.
     * @param float $nota Nota del intento.
     * @param int $aciertos Número de aciertos del intento.
     * @param string $fecha Fecha del intento.
     * @param string $res Respuestas del intento.
     * @return bool True si el registro fue exitoso, false en caso contrario.
     */
    public static function registrarIntento($idTest, $idUsuario, $nota, $aciertos, $fecha, $res){

        $intento = new IntentoTO($idTest, $idUsuario, null, $nota, $aciertos, $fecha, $res);

        $result = DAOIntento::insertarIntento($intento);

        return $result ? true : false;
    }

    /**
     * Obtiene el intento más reciente de un usuario para un test específico.
     *
     * @param int $idTest ID del test.
     * @param int $idUser ID del usuario.
     * @return IntentoTO|false Objeto IntentoTO si se encontró el intento, false en caso contrario.
     */
    public static function obtenerIntentoActUser($idTest, $idUser){

        return DAOIntento::obtenerIntentoActUser($idTest, $idUser);
    }

    /**
     * Obtiene todos los intentos de un usuario para un test específico.
     *
     * @param int $idUsuario ID del usuario.
     * @param int $idTest ID del test.
     * @return array Arreglo de objetos IntentoTO.
     */
    public static function obtenerIntentosPorUsuarioTest($idUsuario, $idTest) {

        return DAOIntento::obtenerIntentosPorUsuarioTest($idUsuario, $idTest);
    }

    /**
     * Obtiene todos los intentos de un usuario.
     *
     * @param int $idUsuario ID del usuario.
     * @return array Arreglo de objetos IntentoTO.
     */
    public static function obtenerIntentosPorUsuario($idUsuario) {

        return DAOIntento::obtenerIntentosPorUsuario($idUsuario);
    }

    /**
     * Obtiene el número de intentos realizados por un usuario en un test específico.
     *
     * @param int $idTest ID del test.
     * @param int $idUsuario ID del usuario.
     * @return int Número de intentos.
     */
    public static function numIntentosPorTest($idTest, $idUsuario) {

        return DAOIntento::numIntentosPorTest($idTest, $idUsuario);
    }

    /**
     * Obtiene las estadísticas totales de un test para un usuario.
     *
     * @param int $idTest ID del test.
     * @param int $idUsuario ID del usuario.
     * @return array|false Arreglo con las estadísticas del test o false si no se encuentran.
     */
    public static function estadisticasTestTotales($idTest, $idUsuario){

        return DAOIntento::estadisticasTestTotales($idTest, $idUsuario);
    }
}
?>
