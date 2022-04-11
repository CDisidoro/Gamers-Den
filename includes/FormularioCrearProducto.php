<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de dar de alta productos en la tienda
     */
    class FormularioCrearProducto extends Formulario{
        private $idUsuario;
        /**
        * Constructor del formulario, con id formCrearProducto y Redireccion a la tienda
        * @param int $idUsuario ID del usuario que vende el producto nuevo
        */
        public function __construct($idUsuario) {
            $this->idUsuario = $idUsuario; 
            parent::__construct('formCrearProducto', ['urlRedireccion' => 'tienda.php?caracteristica=Destacado']);
        }

        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            $articulo = $datos['articulo'] ?? '';
            $precio = $datos['precio'] ?? '';
            $idUsuario = $this->idUsuario;
            $descripcion = $datos['descripcion'] ?? '';
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['articulo','precio','idUsuario','descripcion'], $this->errores, 'span', array('class' => 'error'));
            $html = <<<EOF
            $htmlErroresGlobales
            <fieldset>
                <legend>Nuevo producto</legend>
                <div>
                    <label for="articulo">Selecciona un videojuego: </label>
                    <input id="articulo" name="articulo" type="text" value="$articulo"/>
                    {$erroresCampos['articulo']}
                </div>
                <div>
                    <label for="precio">Ponle un precio a tu producto: </label>
                    <input id="precio" name="precio" type="text" value="$precio"> </textarea>
                    {$erroresCampos['precio']}
                </div>
                <div>
                    <label for="descripcion">Dale una descripción atractiva: </label>
                    <textarea id="descripcion" name="descripcion" rows="10" cols="50" value="$descripcion"></textarea>
                    {$erroresCampos['descripcion']}
                </div>
                <div>
                    <input type="hidden" id="idUsuario" name="idUsuario" value="$idUsuario"/>
                    {$erroresCampos['idUsuario']}
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
            $idUsuario = filter_var($datos['idUsuario'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$idUsuario) {
                $this->errores['idUsuario'] = 'El id de usuario no es válido.';
            }
            $articulo = filter_var($datos['articulo'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$articulo) {
                $this->errores['articulo'] = 'El id del videojuego no es válido.';
            }
            $precio = filter_var($datos['precio'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$precio) {
                $this->errores['precio'] = 'El precio no es válido.';
            }
            $descripcion = filter_var($datos['descripcion'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$descripcion) {
                $this->errores['descripcion'] = 'La descripcion no es valida';
            }
            //Una vez validadas las entradas se inserta el producto
            if(count($this->errores) === 0){
                $producto = Producto::subeProducto($idUsuario,$articulo,$precio,$descripcion);
                if(!$producto){
                    $this->errores[] = 'Ha ocurrido un error';
                }
            }
        }
    }
?>