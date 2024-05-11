<?php
require_once 'includes/Formulario.php';
require_once 'includes/SA/SAUniversidad.php';
require_once 'includes/SA/SAGrado.php';
require_once 'includes/SA/SAUsuario.php';

class FormularioRegistro2 extends Formulario
{
    /**
     * Constructor de la clase FormularioRegistro2.
     */
    public function __construct()
    {
        // Llama al constructor de la clase padre
        parent::__construct('formRegistro', array('urlRedireccion' => 'index.php'));
    }

    /**
     * Genera los campos del formulario de registro.
     *
     * @param array $datos Datos del formulario.
     * @return string HTML con los campos del formulario.
     */
    protected function generaCamposFormulario(&$datos)
    {
        // Genera los mensajes de error globales y por campo
        $erroresGlobales = $this->generaListaErroresGlobales($this->errores);
        $erroresCampos = $this->generaErroresCampos(['user', 'nombre', 'apellidos', 'email', 'psw', 'psw_confirm'], $this->errores, 'span', ['class' => 'error']);

        // Genera el HTML de los campos del formulario
        $html = <<<HTML
        <p class="form-title">Registro</p>
        <p class="message">Por favor, introduce tu grado.</p>
        {$erroresGlobales}
        <label>
            <select name="ID_grado" id="grado" required placeholder="" class="input">
                <option value=""></option>
HTML;
                // Obtiene los datos del formulario anterior de la sesión
                $datosRegistro1 = $_SESSION['datos_registro'];
                // Obtiene y genera opciones del select con los grados de la universidad seleccionada en el formulario anterior
                $grados = SAGrado::obtenerGradosPorUniversidad($datosRegistro1['ID_universidad']); 
                foreach ($grados as $aux) : 
                    $html .= "<option value=\"{$aux->getIdGrado()}\">{$aux->getNombre()}</option>";
                endforeach; 
        $html .= <<<HTML
            </select>
            <span>Grado</span>
        </label>
        <button type="submit" name="registro" placeholder="" class="form-submit">Crear cuenta</button>

HTML;
        return $html;
    }

    /**
     * Procesa los datos del formulario de registro.
     *
     * @param array $datos Datos del formulario.
     */
    protected function procesaFormulario(&$datos)
    {
        // Array para almacenar errores
        $errores = [];

        // Si no hay errores, registra al usuario
        if (empty($errores)) {

            // Obtiene los datos del formulario anterior de la sesión
            $datosRegistro1 = $_SESSION['datos_registro'];

            // Registra al usuario con los datos de los dos formularios
            $usuario = SAUsuario::registrarUsuario($datosRegistro1['user'], $datosRegistro1['psw'], $datosRegistro1['nombre'], 
            $datosRegistro1['apellidos'], $datosRegistro1['email'], $datosRegistro1['ID_universidad'], $datos['ID_grado']);

            // Si el registro es exitoso, loguea al usuario y redirige al index
            if ($usuario == 1) {

                // Elimina los datos de registro de la sesión
                unset($_SESSION['datos_registro']);

                // Loguea al nuevo usuario
                $usuarioN = SAUsuario::login($datosRegistro1['user'], $datosRegistro1['psw']);
                $_SESSION["loggedin"] = true;
                $_SESSION["ID_usuario"] = $usuarioN->getId();
                $_SESSION["user"] = $usuarioN->getNombreUsuario();
                header('Location: index.php');

            } else if($usuario == 0){
                // Si hay un error al registrar al usuario, muestra un mensaje de error
                $errores[] = "Hubo un error al registrar el usuario.";
            }
            else{
                // Si el usuario ya está registrado, muestra un mensaje de error
                $errores[] = "El usuario {$datosRegistro1['user']} ya está registrado.";
            }
        }

        // Guarda los errores en la instancia del formulario
        $this->errores = $errores;
    }
}
?>