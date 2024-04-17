<?php

define('DB_NAME', 'flexam');


// Detecta si el entorno es local o de producción basándose en el nombre del servidor
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    // Entorno de desarrollo local
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');

    define('BASE_URL', 'http://localhost/p3_aw/');
    define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/p3_aw/');

} else {
    // Entorno de producción
    define('DB_HOST', 'vm024.db.swarm.test');
    define('DB_USER', 'flexam');
    define('DB_PASSWORD', 'Flexam24'); 

    define('BASE_URL', 'https://vm024.containers.fdi.ucm.es/');
    define('BASE_PATH', '/var/www/produccion/');
}

define('COMMON_PATH', BASE_PATH . 'code/comun/');
define('VIEWS_PATH', BASE_PATH . 'code/views/');

// Definir otras rutas relativas a BASE_URL si es necesario
define('STYLES_URL', BASE_URL . 'styles/');
define('RESOURCES_URL', BASE_URL . 'resources/');

?>
