<?php namespace es\fdi\ucm\aw\gamersDen;
    require_once __DIR__.'/Formulario.php';
    require_once __DIR__.'/Usuario.php';
    class FormularioRegistro extends Formulario{
        public function __construct(){
            parent::__construct('formRegistro', ['urlRedireccion' => 'index.php']);
        }
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
                    <input id="nombreUsuario" type="text" name="nombreUsuario" value="$nombreUsuario" />
                    {$erroresCampos['nombreUsuario']}
                </div>
                <div>
                    <label for="email">Correo Electronico:</label>
                    <input id="email" type="text" name="email" value="$email" />
                    {$erroresCampos['email']}
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input id="password" type="password" name="password" value="$password" />
                    {$erroresCampos['password']}
                </div>
                <div>
                    <label for="password2">Reintroduce el password:</label>
                    <input id="password2" type="password" name="password2" value="$password2" />
                    {$erroresCampos['password2']}
                </div>
                <div>
                    <button type="submit" name="registro">Registrar</button>
                </div>
            </fieldset>
            EOF;
            return $html;
        }
        protected function procesaFormulario(&$datos){
            $this->errores = [];
            $nombreUsuario = trim($datos['nombreUsuario'] ?? '');
            $nombreUsuario = filter_input(INPUT_POST, 'nombreUsuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ( ! $nombreUsuario || empty($nombreUsuario=trim($nombreUsuario)) || mb_strlen($nombreUsuario) < 5) {
                $this->$errores['nombreUsuario'] = 'El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.';
            }
            
            if ( ! $email || empty($email=trim($email)) || mb_strlen($email) < 5) {
                $this->$errores['email'] = 'El email tiene que tener una longitud de al menos 5 caracteres.';
            }
            
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ( ! $password || empty($password=trim($password)) || mb_strlen($password) < 5 ) {
                $this->$errores['password'] = 'El password tiene que tener una longitud de al menos 5 caracteres.';
            }
            
            $password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ( ! $password2 || empty($password2=trim($password2)) || $password != $password2 ) {
                $this->$errores['password2'] = 'Los passwords deben coincidir';
            }
            if (count($this->errores) === 0) {
                $user = Usuario::crea($nombreUsuario,$email,$password, Usuario::USER_ROLE);
                if(!$user){
                    $this->$errores[] = "El usuario ya existe";
                }else{
                    $_SESSION['login'] = true;
                    $_SESSION['nombre'] = $nombreUsuario;
                }
            }
        }
    }
?>