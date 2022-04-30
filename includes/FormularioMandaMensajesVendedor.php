<?php namespace es\fdi\ucm\aw\gamersDen;

    class FormularioMandaMensajesVendedor extends Formulario{
        private $idVendedor;
        /**
         * Crea el formulario llamando al constructor de la clase padre, con identificador formChatParticular y redireccion al mismo chat una vez enviado el mensaje
         * @param int $idVendedor ID del amigo con quien se esta chateando
         */
        public function __construct($idVendedor){
            $this->idVendedor = $idVendedor;
            $redireccion = 'chat_negocio.php?idVendedor=' . $this->idVendedor;
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
            $IDUsuario = $datos['IDUsuario'] ?? $this->idVendedor;
            // Se generan los mensajes de error si existen.
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['Mensaje','IDUsuario'], $this->errores, 'span', array('class' => 'error'));
            // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
            $html = <<<EOF
            $htmlErroresGlobales
            <fieldset>
                <div>
                    <textarea id="mensaje" type="text" class="form-control" name="Mensaje" rows="1" required/>$mensaje</textarea>
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
            $uservendedor = Usuario::buscaPorId(trim($datos['IDUsuario']));
            $remitente = Usuario::buscaPorId($_SESSION['ID']);
            $mensaje = trim($datos['Mensaje'] ?? '');
            $mensaje = filter_var($mensaje, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$mensaje ||  mb_strlen($mensaje) == 0 ) 
                $this->errores[] = 'Por favor escribe el mensaje antes de mandarlo';
            else if (!$uservendedor)
                $this->errores[] = "No se ha encontrado al usuario";
            else if(!($uservendedor->alreadyVendedor($uservendedor, $_SESSION['ID'])))
                $this->errores[] = "No eres negociante de ese usuario";
            if (count($this->errores) === 0) {
                // Pedimos un mensaje más alla de la página actual para saber si hay más páginas
                if(!(Mensaje::addMensajes($mensaje, $uservendedor->getId(), $remitente->getId(), 2))){
                    $this->errores[] = "No ha sido posible enviar el mensaje";
                }
            }
        }
    }
?>