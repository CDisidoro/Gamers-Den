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
            $listaJuegos = $this->generarSelector();
            $html = <<<EOF
            $htmlErroresGlobales
            <fieldset class="container">
                <div>
                    <label for="articulo" class="form-label">Selecciona un videojuego: </label>
                    $listaJuegos
                    {$erroresCampos['articulo']}
                </div>
                <div>
                    <label for="precio" class="form-label">Ponle un precio a tu producto: </label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">€</span>
                        <input id="precio" name="precio" class="form-control" type="text" value="$precio">
                    </div>
                    {$erroresCampos['precio']}
                </div>
                <div>
                    <label for="descripcion" class="form-label">Dale una descripción atractiva: </label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="10" cols="50" value="$descripcion"></textarea>
                    {$erroresCampos['descripcion']}
                </div>
                <div>
                    <input type="hidden" id="idUsuario" name="idUsuario" value="$idUsuario"/>
                    {$erroresCampos['idUsuario']}
                    <button type="submit" class="btn btn-success" name="enviar"> Enviar </button>
                </div>
            </fieldset>
            EOF;
            return $html;
        }

        function generarSelector(){
            $listaJuegos = Videojuego::cargarVideojuegos();
            $selector = '<select name="articulo" id="articulo" class="form-control">';
            foreach($listaJuegos as $juego){
                $id = $juego->getID();
                $nombre = $juego->getNombre();
                $selector .= '<option value='.$id.'>'.$nombre.'</option>';
            }
            $selector .= '</select>';
            return $selector;
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
            $articulo = filter_var($datos['articulo'] ?? null, FILTER_SANITIZE_NUMBER_INT);
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