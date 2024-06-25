<?php
require_once 'includes/Aplicacion.php';
require_once 'includes/TO/UniversidadTO.php';

class DAOUniversidad {

    public function __construct() {
        
    }

    /**
     * Obtiene todas las universidades de la base de datos.
     *
     * @return array Arreglo de objetos UniversidadTO
     */
    public static function obtenerUniversidades() {
        $db = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM universidades";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $universidades = [];
        while ($row = $result->fetch_assoc()) {
            $idUniversidad = htmlspecialchars($row['ID_universidad']);
            $nombre = htmlspecialchars($row['nombre']);
            $abreviatura = htmlspecialchars($row['abreviatura']);
            $ciudad = htmlspecialchars($row['ciudad']);
            $universidades[] = new UniversidadTO($idUniversidad, $nombre, $abreviatura, $ciudad);
        }
        return $universidades;
    }
}
?>
