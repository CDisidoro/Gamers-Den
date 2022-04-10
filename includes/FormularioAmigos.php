<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de gestionar el agregado de amigos
     */
    class FormularioAmigos extends Formulario{
        /**
         * Crea el formulario llamando al constructor de la clase padre, con identificador formAmigos y redireccion al Perfil una vez finalizada la agregacion
         */
        public function __construct() {
            parent::__construct('formAmigos', ['urlRedireccion' => 'perfil.php']);
        }
        
        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            // Se reutiliza el Usuario de usuario introducido previamente o se deja en blanco
            $nombreAmigo = $datos['nombreAmigo'] ?? '';

            // Se generan los mensajes de error si existen.
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['nombreAmigo'], $this->errores, 'span', array('class' => 'error'));

            // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
            $html = <<<EOF
            $htmlErroresGlobales
            <fieldset>
                <legend>Añadir amigos</legend>
                <div>
                    <label for="nombreAmigo">Nombre de Usuario:</label>
                    <input id="nombreAmigo" type="text" name="nombreAmigo" value="$nombreAmigo" required/>
                    {$erroresCampos['nombreAmigo']}
                </div>
                <div>
                    <button type="submit" name="añadir"> Añadir </button>
                </div>          
            </fieldset>       
            EOF;
            return $html;
        }

        /**
         * Se encarga de procesar en formulario una vez se pulsa en el boton de enviar
         * @param array &$datos Datos que han sido enviados en el formulario
         */
        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            $Usuario = trim($datos['nombreAmigo'] ?? '');
            $Usuario = filter_var($Usuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (count($this->errores) === 0) {
                $user = Usuario::buscarUsuario($Usuario); //Busca el usuario que se desea agregar
                if (!$user) { //Si no existe se da un mensaje de error
                    $this->errores[] = "No se ha encontrado al usuario";
                } 
                else if($user->getId() == $_SESSION['ID']){ //Si intentamos agregarnos a nosotros mismos dara error
                    $this->errores[] = "No te puedes agregar a ti mismo";
                }
                else if($user->alreadyFriends($user, $_SESSION['ID'])){ //Verificamos si ya somos amigos de ese usuario
                    $this->errores[] = "Ya eres amigo de ese usuario";
                }
                else{ //Si todo sale bien agregamos el amigo nuevo
                    $user = Usuario::addFriends($user, $_SESSION['ID']);
                }
            }
        }
    }
?>