<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de formulario encargada de crear categorias
     */
    class FormularioCrearCategoria extends Formulario{
        /**
         * Constructor del formulario, con id formCreaCat y redireccion a la pagina de juegos
         */
        public function __construct(){
            parent::__construct('fomrCreaCat', ['urlRedireccion' => 'juegos.php']);
        }

        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            $nombre = $datos['nombre'] ?? '';
            $descripcion = $datos['descripcion'] ?? '';
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['nombre','descripcion'], $this->errores, 'span', array('class' => 'error'));
            $html = <<<EOF
            $htmlErroresGlobales
            <fieldset>
                <legend>Nueva Categoría</legend>
                <div>
                    <label for="articulo">Nombre de la categoría: </label>
                    <input id="nombre" name="nombre" type="text" value="$nombre">
                    {$erroresCampos['nombre']}
                </div>
                <div>
                    <label for="descripcion">Dale una descripción a esta categoría: </label>
                    <textarea id="descripcion" name="descripcion" rows="10" cols="50" value="$descripcion"></textarea>
                    {$erroresCampos['descripcion']}
                </div>
                <div>
                    <button type="submit" name="enviar"> Enviar </button>
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
            //Una vez validadas las entradas se inserta la categoria
            if(count($this->errores) === 0){
                $categoria = Categoria::addCategoria($nombre, $descripcion);
                if(!$categoria){
                    $this->errores[] = 'Ha ocurrido un error';
                }
            }
        }
    }
?>