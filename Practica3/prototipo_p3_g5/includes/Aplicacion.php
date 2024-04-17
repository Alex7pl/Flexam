<?php
require_once 'comun/config.php'; // Incluye la configuración al principio para asegurar que las constantes están disponibles

class Aplicacion {
    private static $instance = null;
    private $connection;

    private function __construct() {
        // Crea la conexión PDO con las constantes definidas
        $this->connection = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
            DB_USER,
            DB_PASSWORD,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
        );
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Aplicacion();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>
