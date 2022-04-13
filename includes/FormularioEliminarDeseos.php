<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de gestionar el borrado de juegos de la lista de deseos
     */
    class FormularioEliminarDeseos extends Formulario{
        private $idJuego;
        private $idUsuario;

        /**
        *   El formulario recibe en el constructor el id del juego que se quiere eliminar.
        *   Tiene como ID formEliminarDeseos y una vez finaliza el borrado redirige al Perfil
        *   @param int $idAmigo ID del juego que se quiere eliminar de la lista
        *   @param int $idUsuario ID del usuario que quiere eliminar el juego de su lista
        */
        public function __construct($idJuego, $idUsuario) { 
            parent::__construct('formEliminarDeseos', ['urlRedireccion' => 'perfil.php']);
            $this->idJuego = $idJuego;
            $this->idUsuario = $idUsuario;
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
                <input type="hidden" name="idJuego" value="{$this->idJuego}"/>
                <input type="hidden" name="idUsuario" value="{$this->idUsuario}"/>
                <button type = "submit" class = "botonPrueba" > <img class = "botonBorrarAmigo" src = "img/papelera.jpg"> </button>
            EOF;
            return $html;
        }

        /**
         * Se encarga de procesar en formulario una vez se pulsa en el boton de enviar
         * @param array &$datos Datos que han sido enviados en el formulario
         */
        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            $idJuego = filter_var($datos['idJuego'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$idJuego) {
                $this->errores[] = 'No tengo claro que juego eliminar.';
            }
            $idUsuario = filter_var($datos['idUsuario'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$idUsuario) {
                $this->errores[] = 'No tengo claro que usuario hizo la petición';
            }
            /*
            *   Después de validar el id del amigo se busca en la bd. Si existe y es amigo del usuario de la sesión, se elimina.
            */
            if(count($this->errores) === 0){
                $usuario = Usuario::buscaPorId($idUsuario);
                if ($usuario->checkWishList($idJuego) && $usuario) {
                    if(!($usuario->deleteWishList($idJuego))){
                        $this->errores[] = 'Algo ha salido mal';
                    }
                }
                else{
                    $this->errores[] = 'Algo ha salido mal';
                }
            }
        }
    }
?>