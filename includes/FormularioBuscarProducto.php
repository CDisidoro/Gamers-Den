<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de la busqueda de productos
     */
    class FormularioBuscarProducto extends FormularioGestionManual{
        /**
         * Crea el formulario llamando al constructor de la clase padre, con identificador formSearchProductos y redireccion a los resultados
         */
        public function __construct(){
            parent::__construct('formSearchProductos', ['method' => 'GET', 'action' => 'resultadoBuscaProductos.php']);
        }

        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            // Se reutiliza elnombre del juego introducido previamente o se deja en blanco
            $nombreJuego = $datos['nombreJuego'] ?? '';
            // Se generan los mensajes de error si existen.
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['nombreJuego'], $this->errores, 'span', array('class' => 'error'));
            // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
            $html = <<<EOF
            $htmlErroresGlobales
            <fieldset class="container">
                <div>
                    <label for="nombreJuego" class="form-label">Introduce el nombre del juego que quieres buscar:</label>
                    <input class="form-control" id="nombreJuego" type="text" name="nombreJuego" value="$nombreJuego" required/>
                    {$erroresCampos['nombreJuego']}
                </div>
                <div>
                    <button type="submit" class="btn btn-success" name="buscar"> Buscar </button>
                </div>
            </fieldset>
            EOF;
            return $html;
        }

        /**
         * Se encarga de procesar en formulario una vez se pulsa en el boton de enviar
         * @param array &$datos Datos que han sido enviados en el formulario
         * @return ResultadoGestionFormulario El resultado de la busqueda
         */
        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            $nombreJuego = trim($datos['nombreJuego'] ?? '');
            $nombreJuego = filter_var($nombreJuego, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$nombreJuego ||  mb_strlen($nombreJuego) == 0 ) {
                $this->errores['nombreJuego'] = 'Debes especificar algún texto a buscar';
            }
            $result = new ResultadoGestionFormulario(true);
            if (count($this->errores) === 0) {
                $resultado = [];
                $resultado['juegos'] = Producto::buscarProductoKeyWords($nombreJuego);
                $resultado['extraUrlParams'] = ['tipoFormulario'=>'formSearchProductos', 'nombreJuego' => $nombreJuego];
                $result->setResultado($resultado);
                if (!$resultado['juegos']) {
                    $this->errores[] = "Su búsqueda no ha obtenido resultados";
                }
            }
            else {
                $result->setErrores($this->errores);
            }
            $result->setHtmlFormulario($this->generaFormulario($datos));
            return $result;
        }
    }
?>