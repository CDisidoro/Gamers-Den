<?php namespace es\fdi\ucm\aw\gamersDen;
//require_once __DIR__.'/Formulario.php';
//require_once __DIR__.'/Usuario.php';

class FormularioLogin extends Formulario
{
    public function __construct() {
        parent::__construct('formLogin', ['urlRedireccion' => 'index.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        // Se reutiliza el Usuario de usuario introducido previamente o se deja en blanco
        $Usuario = $datos['Usuario'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['Usuario', 'password'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Usuario y contraseña</legend>
            <div>
                <label for="text">Nombre de Usuario:</label>
                <input id="Usuario" type="Usuario" name="Usuario" value="$Usuario" required/>
                {$erroresCampos['Usuario']}
            </div>
            <div>
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" required/>
                {$erroresCampos['password']}
            </div>
            <div>
                <button type="submit" name="login">Entrar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $Usuario = trim($datos['Usuario'] ?? '');
        $Usuario = filter_var($Usuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $Usuario || empty($Usuario) ) {
            $this->errores['Usuario'] = 'El nombre de usuario no puede estar vacío';
        }
        
        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password || empty($password) ) {
            $this->errores['password'] = 'El password no puede estar vacío.';
        }
        
        if (count($this->errores) === 0) {
            $usuario = Usuario::login($Usuario, $password);
        
            if (!$usuario) {
                $this->errores[] = "El usuario o el password no coinciden";
            } else {
                $_SESSION['login'] = true;
                $_SESSION['Usuario'] = $Usuario;
                if($usuario->hasRole(Usuario::ADMIN_ROLE)){
                    $_SESSION['rol'] = 1;
                }else if($usuario->hasRole(Usuario::ESCRITOR_ROLE)){
                    $_SESSION['rol'] = 2;
                }else{
                    $_SESSION['rol'] = 3;
                }
                $_SESSION['ID'] = $usuario->getId();
                $_SESSION['Bio'] = $usuario->getBio();
                
            }
        }
    }
}
