<?php namespace es\fdi\ucm\aw\gamersDen;
/**
 * Clase hija de Formulario encargada de gestionar el alta de usuarios en la aplicacion
 */
    class FormularioRegistro extends Formulario{
        /**
         * Crea el formulario llamando al constructor de la clase padre, con identificador formRegistro y redireccion al Home una vez dado de alta
         */
        public function __construct(){
            parent::__construct('formRegistro', ['urlRedireccion' => 'index.php']);
        }
        
        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            $nombreUsuario = $datos['nombreUsuario'] ?? '';
            $email = $datos['email'] ?? '';
            $password = $datos['password'] ?? '';
            $password2 = $datos['password2'] ?? '';
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['nombreUsuario','email','password','password2'], $this->errores, 'span', array('class' => 'error'));
            $html = <<<EOF
            $htmlErroresGlobales
            <fieldset>
                <legend>Datos para el registro</legend>
                <div>
                    <label for="nombreUsuario">Nombre de usuario:</label>
                    <input id="nombreUsuario" type="text" name="nombreUsuario" value="$nombreUsuario" required/>
                    {$erroresCampos['nombreUsuario']}
                </div>
                <div>
                    <label for="email">Correo Electronico:</label>
                    <input id="email" type="email" name="email" value="$email" required/>
                    {$erroresCampos['email']}
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input id="password" type="password" name="password" value="$password" required/>
                    {$erroresCampos['password']}
                </div>
                <div>
                    <label for="password2">Reintroduce el password:</label>
                    <input id="password2" type="password" name="password2" value="$password2" required/>
                    {$erroresCampos['password2']}
                </div>
                <div>
                    <button type="submit" name="registro">Registrar</button>
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
            $nombreUsuario = trim($datos['nombreUsuario'] ?? '');
            $nombreUsuario = filter_input(INPUT_POST, 'nombreUsuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ( ! $nombreUsuario || empty($nombreUsuario=trim($nombreUsuario)) || mb_strlen($nombreUsuario) < 5) {
                $this->errores['nombreUsuario'] = 'El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.';
            }
            
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ( ! $email || empty($email=trim($email)) || mb_strlen($email) < 5) {
                $this->errores['email'] = 'El email tiene que tener una longitud de al menos 5 caracteres.';
            }
            
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ( ! $password || empty($password=trim($password)) || mb_strlen($password) < 5 ) {
                $this->errores['password'] = 'El password tiene que tener una longitud de al menos 5 caracteres.';
            }
            
            $password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ( ! $password2 || empty($password2=trim($password2)) || $password != $password2 ) {
                $this->errores['password2'] = 'Los passwords deben coincidir';
            }
            if (count($this->errores) === 0) {
                $user = Usuario::crea($nombreUsuario,$email,$password, Usuario::USER_ROLE); //Procesa el alta del usuario nuevo
                if(!$user){
                    $this->errores[] = "El usuario ya existe";
                }else{
                    $user = Usuario::login($nombreUsuario,$password); //Actualiza el objeto usuario para que logee con el usuario recien creado y tenga el id, bio y roles
                    $_SESSION['login'] = true;
                    $_SESSION['Usuario'] = $nombreUsuario;
                    $_SESSION['rol'] = $user->getRol();
                    $_SESSION['ID'] = $user->getId();
                    $_SESSION['Bio'] = $user->getBio();
                }
            }
        }
    }
?>