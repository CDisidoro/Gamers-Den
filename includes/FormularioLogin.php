<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de gestionar el inicio de sesion
     */
    class FormularioLogin extends Formulario{
        /**
         * Crea el formulario llamando al constructor de la clase padre, con identificador formLogin y redireccion al Home una vez finalizado el login correctamente
         */
        public function __construct() {
            parent::__construct('formLogin', ['urlRedireccion' => 'index.php']);
        }
        
        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
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

        /**
         * Se encarga de procesar en formulario una vez se pulsa en el boton de enviar
         * @param array &$datos Datos que han sido enviados en el formulario
         */
        protected function procesaFormulario(&$datos){
            $this->errores = [];
            //Se validan todas las entradas para evitar caracteres raros
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
            //Si todo va bien en la validacion intentara hacer el login
            if (count($this->errores) === 0) {
                $usuario = Usuario::login($Usuario, $password);
                if (!$usuario) {
                    $this->errores[] = "El usuario o el password no coinciden";
                } else { //Si todo va bien carga todas las variables de sesion
                    $_SESSION['login'] = true;
                    $_SESSION['Usuario'] = $Usuario;
                    $_SESSION['rol'] = $usuario->getRol();
                    $_SESSION['ID'] = $usuario->getId();
                    $_SESSION['Bio'] = $usuario->getBio();
                }
            }
        }
    }
?>