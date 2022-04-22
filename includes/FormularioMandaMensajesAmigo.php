<?php namespace es\fdi\ucm\aw\gamersDen;

    class FormularioMandaMensajesAmigo extends Formulario{
        private $idAmigo;
        /**
         * Crea el formulario llamando al constructor de la clase padre, con identificador formChatParticular y redireccion al mismo chat una vez enviado el mensaje
         * @param int $idAmigo ID del amigo con quien se esta chateando
         */
        public function __construct($idAmigo){
            $this->idAmigo = $idAmigo;
            $redireccion = 'chat_amigo.php?idAmigo=' . $this->idAmigo;
            parent::__construct('formChatParticular', ['urlRedireccion' => $redireccion]);
        }
        
        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            // Se reutiliza el Usuario de usuario introducido previamente o se deja en blanco
            $mensaje = $datos['Mensaje'] ?? '';
            $IDUsuario = $datos['IDUsuario'] ?? $this->idAmigo;
            // Se generan los mensajes de error si existen.
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['Mensaje','IDUsuario'], $this->errores, 'span', array('class' => 'error'));
            // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
            $html = <<<EOF
            $htmlErroresGlobales
            <fieldset>
                <div>
                    <input id="mensaje" type="text" class="form-control" name="Mensaje" value="$mensaje" required/>
                    {$erroresCampos['Mensaje']}
                    <input type="hidden" value="$IDUsuario" id="IDUsuario" name="IDUsuario">
                    {$erroresCampos['IDUsuario']}
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success" name="enviar"> Enviar </button>
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
            $useramigo = Usuario::buscaPorId(trim($datos['IDUsuario']));
            $remitente = Usuario::buscaPorId($_SESSION['ID']);
            $mensaje = trim($datos['Mensaje'] ?? '');
            $mensaje = filter_var($mensaje, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$mensaje ||  mb_strlen($mensaje) == 0 ) 
                $this->errores[] = 'Por favor escribe el mensaje antes de mandarlo';
            else if (!$useramigo)
                $this->errores[] = "No se ha encontrado al usuario";
            else if(!($useramigo->alreadyFriends($useramigo, $_SESSION['ID'])))
                $this->errores[] = "No eres amigo de ese usuario";
            if (count($this->errores) === 0) {
                // Pedimos un mensaje más alla de la página actual para saber si hay más páginas
                if(!(Mensaje::addMensajes($mensaje, $useramigo->getId(), $remitente->getId(), 1))){
                    $this->errores[] = "No ha sido posible enviar el mensaje";
                }
            }
        }
    }
?>