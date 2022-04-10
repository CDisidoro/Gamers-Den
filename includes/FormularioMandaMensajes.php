<?php namespace es\fdi\ucm\aw\gamersDen;

    class FormularioMandaMensajes extends Formulario{
        private $idAmigo;
        public function __construct($idAmigo){
            $this->idAmigo = $idAmigo;
            $redireccion = 'chat_particular.php?idAmigo=' . $this->idAmigo;
            parent::__construct('formChatParticular', ['urlRedireccion' => $redireccion]);
        }
        
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
                    <input id="mensaje" type="text" name="Mensaje" value="$mensaje" required/>
                    {$erroresCampos['Mensaje']}
                    <input type="hidden" value="$IDUsuario" id="IDUsuario" name="IDUsuario">
                    {$erroresCampos['IDUsuario']}
                </div>
                <div>
                    <button type="submit" name="enviar"> Enviar </button>
                </div>
            </fieldset>
            EOF;
            return $html;
        }

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
                if(!(Mensaje::addMensajes($mensaje, $useramigo->getId(), $remitente->getId()))){
                    $this->errores[] = "No ha sido posible enviar el mensaje";
                }
            }
        }
    }
?>