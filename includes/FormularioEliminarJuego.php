<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada del borrado de juegos de la aplicacion
     */
    class FormularioEliminarJuego extends Formulario{
        private $idJuego;
        /**
         * Constructor del formulario, con id formDelJuego y redireccion a la pagina de juegos
         * @param int $idJuego ID del juego a eliminar
         */
        public function __construct($idJuego){
            $this->idJuego = $idJuego;
            parent::__construct('formDelJuego',['urlRedireccion' => 'juegos.php']);
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
                <input type="hidden" name="idJuego" value="{$this->idJuego}"  />
                <button type = "submit" onclick="return confirm('Estás seguro que deseas eliminar el juego?');" class = "btn btn-link" > <img class = "botonModificarNoticia" src = "img/trash.svg"> </button>
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
            $juego = Videojuego::buscaVideojuego($idJuego);
            if(!$juego){
                $this->errores[] = 'Videojuego no encontrado';
            }
            //Una vez validado todo se procede a eliminar el juego
            if(count($this->errores) === 0){
                if (!$juego->borrarJuego()){
                    $this->errores[] = 'Algo ha salido mal';
                }
            }
        }
    }
?>