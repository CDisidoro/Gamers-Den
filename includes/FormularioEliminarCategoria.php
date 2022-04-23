<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de gestionar el borrado de categorias
     */
    class FormularioEliminarCategoria extends Formulario{
        private $idCat;

        /**
        *   El formulario recibe en el constructor el id de la categoria que se quiere eliminar.
        *   Tiene como ID formEliminarCategoria y una vez finaliza el borrado redirige al Perfil
        *   @param int $idCat ID de la categoria que se quiere eliminar
        */
        public function __construct($idCat) { 
            parent::__construct('formEliminarCategoria', ['urlRedireccion' => 'juegos.php']);
            $this->idCat = $idCat;
        }
        
        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            /*
            *   Los campos que se crean son un input invisible con el id de la categoria y un botón para enviar.
            */
            $html = <<<EOF
                <input type="hidden" name="idCat" value="{$this->idCat}"  />
                <button class="btn btn-link" type = "submit" onclick="return confirm('Estás seguro que deseas eliminar la categoria?');"> <img class = "botonModificarNoticia" src = "img/trash.svg"> </button>
            EOF;
            return $html;
        }

        /**
         * Se encarga de procesar en formulario una vez se pulsa en el boton de enviar
         * @param array &$datos Datos que han sido enviados en el formulario
         */
        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            $idCat = filter_var($datos['idCat'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$idCat) {
                $this->errores[] = 'No tengo claro que categoria eliminar.';
            }
            if(count($this->errores) === 0){
                $categoria = Categoria::buscaPorId($idCat);
                if ($categoria) {
                    $categoria->borrarCategoria();
                }
                else{
                    $this->errores[] = 'Algo ha salido mal';
                }
            }
        }
    }
?>