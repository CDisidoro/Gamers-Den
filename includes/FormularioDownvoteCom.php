<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de gestionar el borrado de foros de la tienda
     */
    class FormularioDownvoteCom extends Formulario{
        private $idUsuario;
        private $idComentario;
        /**
        *   
        *   @param int $idComentario ID del foro que se hacer un upvote
        *   @param int $idUsuario ID del usuario logeado para verificar la identidad
        */
        public function __construct($idComentario, $idUsuario, $redirection) { 
            $this->idComentario = $idComentario;
            $this->idUsuario = $idUsuario;
            parent::__construct('formDownvoteCom', ['urlRedireccion' => $redirection]);
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
            $usuario = Usuario::buscaPorId($this->idUsuario);
            if($usuario->alreadyDownvoted($this->idComentario)){
                $html = <<<EOF
                    <input type="hidden" name="idComentario" value="{$this->idComentario}"  />
                    <button type = "submit" class = "btn btn-link" > <img class = "botonUpvoteForo" src = "img/DownVoteOn.jpg"> </button>
                EOF;
            }
            else{
                $html = <<<EOF
                    <input type="hidden" name="idComentario" value="{$this->idComentario}"  />
                    <button type = "submit" class = "btn btn-link" > <img class = "botonUpvoteForo" src = "img/DownVoteOff.jpg"> </button>
                EOF;
            }
            return $html;
        }

        /**
         * Se encarga de procesar en formulario una vez se pulsa en el boton de enviar
         * @param array &$datos Datos que han sido enviados en el formulario
         */
        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            $idComentario = filter_var($datos['idComentario'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$idComentario) {
                $this->errores[] = 'No tengo claro que escoger.';
            }
            $comentario = Comentario::buscaComentarios($idComentario);
            if(!$comentario){
                $this->errores[] = 'Comentario no encontrado';
            }
            if(!$this->checkIdentity($_SESSION['ID'],$this->idUsuario)){
                $this->errores[] = 'No se ha podido verificar la identidad del usuario';
            }
            $usuario = Usuario::buscaPorId($this->idUsuario);
            if(count($this->errores) === 0){
                if ($usuario->alreadyUpvotedCom($idComentario))
                    $usuario->eliminaUpvoteCom($idComentario);

                if ($usuario->alreadyDownvotedCom($idComentario)){
                    if(!$usuario->eliminaDownvoteCom($idComentario))
                        $this->errores[] = 'Algo ha salido mal';
                }
                else{
                    if(!$usuario->masDownvoteCom($idComentario))
                        $this->errores[] = 'Algo ha salido mal';
                }
            }
        }
        
        /**
         * Valida si la identidad del usuario logeado coincide con la que se nos pasa al formulario
         * @param int $id  ID de la sesion
         * @param int $idUsuario ID del usuario que ha iniciado sesion
         * @return bool Si la identidad coincide retorna true, sino retorna false
         */
        protected function checkIdentity($id, $idUsuario){
            return $id == $idUsuario;
        }
    }
?>
