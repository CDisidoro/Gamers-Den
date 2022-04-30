<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de formulario encargada de editar categorias
     */
    class FormularioEditarCategoria extends Formulario{
        private $idCat;
        /**
         * Constructor del formulario, con id formEditarCat y redireccion a la pagina de la categoria
         */
        public function __construct($idCat){
            $this->idCat = $idCat;
            parent::__construct('fomrEditarCat', ['urlRedireccion' => 'juegos.php?categoria='.$idCat]);
        }

        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            $categoria = Categoria::buscaPorId($this->idCat);
            $nombre = $datos['nombre'] ?? $categoria->getNombre();
            $descripcion = $datos['descripcion'] ?? $categoria->getDescripcion();
            $idCat = $this->idCat;
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['id','nombre','descripcion'], $this->errores, 'span', array('class' => 'error'));
            $html = <<<EOF
            $htmlErroresGlobales
            <fieldset class="container">
                <div>
                    <label for="articulo" class="form-label">Nombre de la categoría: </label>
                    <input class="form-control" id="nombre" name="nombre" type="text" value="$nombre" required>
                    {$erroresCampos['nombre']}
                </div>
                <div>
                    <label for="descripcion" class="form-label">Dale una descripción a esta categoría: </label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="10" cols="50" required>$descripcion</textarea>
                    {$erroresCampos['descripcion']}
                </div>
                <div>
                    <input type="hidden" id="id" name="id" value="$idCat"/>
                    {$erroresCampos['id']}
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
            $nombre = filter_var($datos['nombre'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$nombre) {
                $this->errores['nombre'] = 'El nombre no es válido.';
            }
            $descripcion = filter_var($datos['descripcion'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$descripcion) {
                $this->errores['descripcion'] = 'La descripcion no es valida';
            }
            $idCat = $datos['id'];
            //Una vez validadas las entradas se inserta la categoria
            if(count($this->errores) === 0){
                $categoria = Categoria::buscaPorId($idCat);
                if(!$categoria){
                    $this->errores[] = 'Ha ocurrido un error buscando la categoria';
                }else{
                    if(!$categoria->editarCategoria($nombre, $descripcion)){
                        $this->errores[] = 'Ha ocurrido un error actualizando la categoria';
                    }
                }
            }
        }
    }
?>