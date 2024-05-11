<?php
require_once 'includes/Formulario.php';
require_once 'includes/SA/SAUsuario.php';

class FormularioLogin extends Formulario
{
    /**
     * Constructor de la clase FormularioLogin.
     */
    public function __construct()
    {
        // Llama al constructor de la clase padre
        parent::__construct('formLogin', array('urlRedireccion' => 'index.php'));
    }

    /**
     * Genera los campos del formulario de login.
     *
     * @param array $datos Datos del formulario.
     * @return string HTML con los campos del formulario.
     */
    protected function generaCamposFormulario(&$datos)
    {
        // Genera los mensajes de error globales y por campo
        $erroresGlobales = $this->generaListaErroresGlobales($this->errores);
        $erroresCampos = $this->generaErroresCampos(['nombreUsuario', 'password'], $this->errores, 'span', ['class' => 'error']);

        // Genera el HTML de los campos del formulario
        $html = <<<HTML
        <p class="form-title">Login</p>
        {$erroresGlobales}
        <label>
            <input type="text" name="nombreUsuario" required="" placeholder="" class="input">
            <span>Usuario</span>
        </label>
        {$erroresCampos['nombreUsuario']}
        <label>
            <input type="password" name="password" required="" placeholder="" class="input">
            <span>Contraseña</span>
        </label>
        {$erroresCampos['password']}
        <input type="submit" value="Login" required="" placeholder="" class="form-submit">
        <!--  enlace para el registro  -->
        <p class="link-signin">¿No tienes una cuenta? <a href="sign_up1.php">Regístrate ahora</a>.</p>
HTML;
        return $html;
    }

    /**
     * Procesa los datos del formulario de login.
     *
     * @param array $datos Datos del formulario.
     */
    protected function procesaFormulario(&$datos)
    {
        // Array para almacenar errores
        $errores = [];
        
        // Obtener datos del formulario y sanearlos
        $nombreUsuario = isset($datos['nombreUsuario']) ? filter_var(trim($datos['nombreUsuario']), FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
        $password = isset($datos['password']) ? filter_var(trim($datos['password']), FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';

        // Validar campos obligatorios
        if (!$nombreUsuario) {
            $errores['nombreUsuario'] = 'El usuario es requerido';
        }

        if (!$password) {
            $errores['password'] = 'La contraseña es requerida';
        }

        // Si no hay errores, intenta iniciar sesión
        if (empty($errores)) {
            $usuario = SAUsuario::login($nombreUsuario, $password);
            if (!$usuario) {
                $errores[] = "Usuario o contraseña incorrectos";
            } else {
                // Inicia sesión y guarda información del usuario en variables de sesión
                $_SESSION["loggedin"] = true;
                $_SESSION["ID_usuario"] = $usuario->getId();
                $_SESSION["ID_universidad"] = $usuario->getIdUniversidad();
                $_SESSION["user"] = $usuario->getNombreUsuario();
            }
        }

        // Guarda los errores en la instancia del formulario
        $this->errores = $errores;
    }
}
?>
