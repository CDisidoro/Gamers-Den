<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de gestionar el agregado de amigos
     */
    class FormularioEliminarSolicitudEntrante extends Formulario{
        private $nombreAmigo;
        /**
        *  El formulario recibe en el constructor el id del amigo que se quiere agregar.
        *  Tiene como ID formEliminarNoticia y al terminar redirige a la seccion principal de noticias
        *  @param int $idAmigo ID del amigo que se desea agregar
        */
        public function __construct($nombreAmigo) {
            parent::__construct('formEliminarSolicitudEntrante', ['urlRedireccion' => 'inbox.php']);
            $this->nombreAmigo = $nombreAmigo;
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
                <input type="hidden" name="idNoticia" value="{$this->nombreAmigo}" />
                <button type = "submit" class="btn btn-danger" class = "botonPrueba"><img src="img/trash.svg"></button>                   
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
            $Usuario = trim($this->nombreAmigo ?? '');
            $Usuario = filter_var($Usuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (count($this->errores) === 0) {
                $user = Usuario::buscarUsuario($Usuario); //Busca el usuario que se desea agregar
                if (!$user) { //Si no existe se da un mensaje de error
                    $this->errores[] = "No se ha encontrado al usuario";
                } 
                else if($user->getId() == $_SESSION['ID']){ //Si intentamos agregarnos a nosotros mismos dará error
                    $this->errores[] = "Error";
                }
                else if(!$user->alreadySolicitud($user->getId(), $_SESSION['ID'])){ //Verificamos que haya solicitudes pendientes
                    $this->errores[] = "No hay una solicitud pendiente";
                }
                else{ //Si todo sale bien eliminamos la solicitud
                    $user->deleteMySolicitud($user->getId(), $_SESSION['ID']);
                }
            }
        }
    }
?>