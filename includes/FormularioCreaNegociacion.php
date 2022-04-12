<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de gestionar el borrado de amigos
     */
    class FormularioCreaNegociacion extends Formulario{
        private $idVendedor;

        /**
        *   El formulario recibe en el constructor el id del amigo que se quiere eliminar.
        *   Tiene como ID formEliminarAmigos y una vez finaliza el borrado redirige al Perfil
        *   @param int $idAmigo ID del amigo que se quiere eliminar
        */
        public function __construct($idVendedor) { 
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
            /*
            *   Los campos que se crean son un input invisible con el id del amigo y un botón para enviar.
            */
            $html = <<<EOF
                <input type="hidden" name="idVendedor" value="{$this->idVendedor}"  />
                <button type = "submit" name="enviar"> Iniciar Chat </button>
            EOF;
            return $html;
        }

        /**
         * Se encarga de procesar en formulario una vez se pulsa en el boton de enviar
         * @param array &$datos Datos que han sido enviados en el formulario
         */
        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            $idVendedor = filter_var($datos['idVendedor'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$idVendedor) {
                $this->errores['idVendedor'] = 'El usuario vendedor no existe.';
            }
            /*
            *   Después de validar el id del amigo se busca en la bd. Si existe y es amigo del usuario de la sesión, se elimina.
            */
            if(count($this->errores) === 0){
                $vendedor = Usuario::buscaPorId($idVendedor);
                if($vendedor != null){
                    if(!($vendedor->alreadyVendedor($uservendedor, $_SESSION['ID']))){
                        $vendedor->addBuyer($vendedor, $_SESSION['ID']);
                    }
                }
                else{
                    $this->errores[] = 'Algo ha salido mal';
                }
            }
        }
    }
?>