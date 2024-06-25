<?php
require_once 'includes/Aplicacion.php';
require_once 'includes/TO/GradoTO.php';

class DAOGrado {

    public function __construct() {
    }

    /**
     * Lista todos los grados de una universidad.
     *
     * @param string $idUniversidad ID de la universidad
     * @return array Arreglo de objetos GradoTO
     */
    public static function listarGradosPorUniversidad($idUniversidad) {
        $db = Aplicacion::getInstance()->getConexionBd();
        $idUniversidad = mysqli_real_escape_string($db, $idUniversidad);
        $query = "SELECT * FROM grados WHERE ID_universidad = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $idUniversidad);
        $stmt->execute();
        $result = $stmt->get_result();
        $grados = [];
        while ($row = $result->fetch_assoc()) {
            $grados[] = new GradoTO($row['ID_grado'], $row['nombre'], $row['ID_universidad']);
        }
        return $grados;
    }

    /**
     * Obtiene los grados de una universidad en formato JSON.
     *
     * @param string $idUniversidad ID de la universidad
     * @return array Resultado de la consulta en formato JSON
     */
    public static function obtenerJSON($idUniversidad){
        $db = Aplicacion::getInstance()->getConexionBd();
        $idUniversidad = mysqli_real_escape_string($db, $idUniversidad);
        $query = "SELECT * FROM grados WHERE ID_universidad = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $idUniversidad);
        if ($stmt->execute()){
            $grados = $stmt->get_result();
        }
        else{
            $grados = array();
        }

        return $grados;
    }

    /**
     * Lista todos los grados.
     *
     * @return mysqli_result Resultado de la consulta
     */
    public static function obtenerGrados() {
        $db = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM grados";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}
?>

