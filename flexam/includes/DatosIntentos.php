<?php

require_once 'includes/SA/SAIntento.php';
require_once 'includes/SA/SATest.php';
require_once 'includes/TO/TestTO.php';
require_once 'includes/TO/IntentoTO.php';

/**
 * Clase para construir tablas de resultados y estadísticas de intentos.
 */
class DatosIntentos
{
    /**
     * Constructor de la clase DatosIntentos.
     */
    public function __construct() {
    }

    /**
     * Construye las tablas de resultados y estadísticas de intentos.
     *
     * @param bool $es_Resultado Indica si se está mostrando un resultado específico.
     * @param int $idUser ID del usuario.
     * @param int $idTest ID del test.
     * @param string $asignatura Nombre de la asignatura.
     * @param int $fallos Número de fallos en el intento.
     */
    public function construirTablas($es_Resultado, $idUser, $idTest, $asignatura, $fallos){

        // Construir tabla de resultado si es necesario
        if($es_Resultado){
            $this->tablaActual($idTest, $idUser, $fallos);
        }

        // Construir tabla de estadísticas totales
        $this->tablaEstadisticasTotales($es_Resultado, $idTest, $idUser, $asignatura);

    }

    /**
     * Construye la tabla de resultados del intento actual.
     *
     * @param int $idTest ID del test.
     * @param int $idUser ID del usuario.
     * @param int $fallos Número de fallos en el intento.
     */
    private function tablaActual($idTest, $idUser, $fallos){

        // Obtener información del test y el intento
        $test = SATest::obtenerTestPorId($idTest);
        $intento = SAIntento::obtenerIntentoActUser($idTest, $idUser);

        // Calcular número de respuestas en blanco
        $respuestas_en_blanco = $test->getNumPreguntas() - $intento->getAciertos() - $fallos;
?>
        <!-- Mostrar resultados del test actual -->
        <h2>Resultados del test '<?php echo htmlspecialchars($test->getTitulo()); ?>'</h2>
        <div style='text-align: center; margin-top: 25px'>
            <h2>En este intento has obtenido...</h2>
            <table style='margin: auto;'>
                <tr><th>Evaluación</th><th>Valor</th></tr>
                <tr><td>Preguntas totales</td><td><?php echo $test->getNumPreguntas(); ?></td></tr>
                <tr><td>Aciertos</td><td><?php echo $intento->getAciertos(); ?></td></tr>
                <tr><td>Fallos</td><td><?php echo $fallos; ?></td></tr>
                <tr><td>Respuestas en blanco</td><td><?php echo $respuestas_en_blanco; ?></td></tr>
                <tr><td>Nota</td><td><?php echo $intento->getNota(); ?>/10</td></tr>
            </table>
        </div>
<?php
    }

    /**
     * Construye la tabla de estadísticas totales de los intentos.
     *
     * @param bool $es_Resultado Indica si se está mostrando un resultado específico.
     * @param int $idTest ID del test.
     * @param int $idUser ID del usuario.
     * @param string $asignatura Nombre de la asignatura.
     */
    private function tablaEstadisticasTotales($es_Resultado, $idTest, $idUser, $asignatura){
        // Obtener información del test y estadísticas totales de intentos
        $test = SATest::obtenerTestPorId($idTest);
        $total_intentos = SAIntento::numIntentosPorTest($idTest, $idUser);
        $array = SAIntento::estadisticasTestTotales($idTest, $idUser);
    
        // Calcular porcentaje de aciertos entre todos los intentos
        $porcentaje_aciertos = ($test->getNumPreguntas() * $total_intentos) > 0 ? 
        round(($array["total_aciertos"] / ($test->getNumPreguntas() * $total_intentos)) * 100, 2) : 0;
    
        $nota_media = round($array["nota_media"], 2);
    
        // Mostrar estadísticas totales de los intentos
        if(!$es_Resultado) {
    ?>
            <h2>Estadísticas de '<?php echo htmlspecialchars($test->getTitulo()); ?>'</h2>
            <h3><?php echo htmlspecialchars($asignatura); ?></h3>
    <?php
        }
    ?>
        <div style='text-align: center; margin-top: 25px'>
            <h2>Estadísticas de todos los intentos</h2>
            <table style='margin: auto;'>
                <tr><th>Evaluación</th><th>Valor</th></tr>
                <tr><td>Número total de intentos</td><td><?php echo $total_intentos; ?></td></tr>
                <tr><td>Nota media entre todos los intentos</td><td><?php echo $nota_media; ?> / 10</td></tr>
                <tr><td>Porcentaje de aciertos entre todos los intentos</td><td><?php echo $porcentaje_aciertos; ?>%</td></tr>
            </table>
        </div>
    <?php
    }    
}
?>