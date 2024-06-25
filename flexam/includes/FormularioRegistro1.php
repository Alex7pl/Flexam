<?php
require_once 'includes/Formulario.php';
require_once 'includes/SA/SAUniversidad.php';
require_once 'includes/SA/SAUsuario.php';

class FormularioRegistro1 extends Formulario
{
    /**
     * Constructor de la clase FormularioRegistro1.
     */
    public function __construct()
    {
        // Llama al constructor de la clase padre
        parent::__construct('formRegistro', array('urlRedireccion' => 'sign_up2.php'));
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
        <p class="message">Por favor, introduce tus datos.</p>
        {$erroresGlobales}
        <label>
            <input type="text" name="user" id="user" required placeholder="" class="input">
            <span>Usuario</span>
        </label>
        {$erroresCampos['user']}
        <label>
            <input type="password" name="psw" id="psw" required placeholder="" class="input">
            <span>Contraseña</span>
        </label>
        {$erroresCampos['psw']}
        <label>
            <input type="password" name="psw_confirm" id="psw-confirm" required placeholder="" class="input">
            <span>Confirmar Contraseña</span>
        </label>
        {$erroresCampos['psw_confirm']}
        <div class="flex">
            <label>
                <input type="text" name="nombre" id="nombre" required placeholder="" class="input">
                <span>Nombre</span>
            </label>
            {$erroresCampos['nombre']}
            <label>
                <input type="text" name="apellidos" id="apellidos" required placeholder="" class="input">
                <span>Apellidos</span>
            </label>
            {$erroresCampos['apellidos']}
        </div>
        <label>
            <input type="email" name="email" id="email" required placeholder="" class="input">
            <span>Email</span>
        </label>
        {$erroresCampos['email']}
        <label>
            <select name="ID_universidad" id="universidad" required placeholder="" class="input">
                <option value=""></option>
HTML;
                // Obtiene y genera opciones del select con las universidades
                $universidades = SAUniversidad::listarUniversidades(); 
                foreach ($universidades as $universidad) : 
                    $html .= "<option value=\"{$universidad->getIdUniversidad()}\">{$universidad->getNombre()}</option>";
                endforeach; 
        $html .= <<<HTML
            </select>
            <span>Universidad</span>
        </label>
        <button type="submit" name="next" placeholder="" class="form-submit">Siguiente</button>

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

        // Validación y saneamiento de los datos del formulario
        $user = isset($datos['user']) ? filter_var(trim($datos['user']), FILTER_SANITIZE_FULL_SPECIAL_CHARS) : false;
        if (!$user) {
            $errores['user'] = 'El nombre de usuario es requerido.';
        }

        $user = isset($datos['user']) ? filter_var(trim($datos['user']), FILTER_SANITIZE_FULL_SPECIAL_CHARS) : false;
        $user = SAUsuario::buscaUsuarioPorNombre($user);
        if ($user) {
            $errores['user'] = 'El nombre de usuario ya ha sido registrado';
        }


        $nombre = isset($datos['nombre']) ? filter_var(trim($datos['nombre']), FILTER_SANITIZE_FULL_SPECIAL_CHARS) : false;
        if (!$nombre) {
            $errores['nombre'] = 'Tu nombre completo es requerido.';
        }

        $apellidos = isset($datos['apellidos']) ? filter_var(trim($datos['apellidos']), FILTER_SANITIZE_FULL_SPECIAL_CHARS) : false;
        if (!$apellidos) {
            $errores['apellidos'] = 'Tu nombre completo es requerido.';
        }

        $email = isset($datos['email']) ? filter_var(trim($datos['email']), FILTER_SANITIZE_EMAIL) : false;
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = 'Tu email es requerido o tiene mal formato.';
        }

        $psw = isset($datos['psw']) ? trim($datos['psw']) : '';
        if (!$psw || mb_strlen($psw) < 5) {
            $errores['psw'] = 'La contraseña debe tener al menos 5 caracteres.';
        }

        $psw_confirm = isset($datos['psw_confirm']) ? trim($datos['psw_confirm']) : '';
        if ($psw !== $psw_confirm) {
            $errores['psw_confirm'] = 'Las contraseñas no coinciden.';
        }

        // Si no hay errores, guarda los datos en la sesión
        if (empty($errores)) {
            $_SESSION['datos_registro'] = $datos;
        }

        // Guarda los errores en la instancia del formulario
        $this->errores = $errores;
    }
}
?>
