<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada del agregar juegos a la lista de deseos de un usuario
     */
    class FormularioAddListaDeseos extends Formulario{
        private $idJuego;
        private $idUsuario;
        /**
         * Constructor del formulario, con id formAddWish y redireccion al juego agregado
         * @param int $idJuego ID del juego a agregar a la lista de deseos
         * @param int $idUsuario ID del usuario que quiere agregar el juego a su lista de deseos
         */
        public function __construct($idJuego, $idUsuario){
            $this->idJuego = $idJuego;
            $this->idUsuario = $idUsuario;
            parent::__construct('formAddWish',['urlRedireccion' => 'juego_particular.php?id='.$idJuego]);
        }

        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $html = <<<EOF
                $htmlErroresGlobales
                <input type="hidden" name="idJuego" value="{$this->idJuego}" />
                <input type="hidden" name="idusuario" value="{$this->idUsuario}" />
                <button type = "submit" class = "botonPrueba" > Añadir a tu lista de deseos </button>
            EOF;
            return $html;
        }

        /**
         * Se encarga de procesar en formulario una vez se pulsa en el boton de enviar
         * @param array &$datos Datos que han sido enviados en el formulario
         */
        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            $juego = Videojuego::buscaVideojuego($this->idJuego);
            if(!$juego){
                $this->errores[] = 'Videojuego no encontrado';
            }
            $usuario = Usuario::buscaPorId($this->idUsuario);
            if(!$usuario){
                $this->errores[] = 'Usuario no encontrado';
            }
            //Una vez validado todo se procede a agregar el juego a la lista de deseos del usuario
            if(count($this->errores) === 0){
                if($usuario->checkWishList($juego->getID())){
                    $this->errores[] = 'Ya tienes este juego en tu lista de deseos';
                }else if (!$usuario->addToWishList($juego->getID())){
                    $this->errores[] = 'Algo ha salido mal';
                }else{
                    $this->errores[] = 'Se ha agregado el juego a la lista de deseos exitosamente';
                }
            }
        }
    }
?>