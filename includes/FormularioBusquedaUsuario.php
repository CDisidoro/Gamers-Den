<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de FormularioGestionManual encargada de buscar una noticia
     */
    class FormularioBusquedaUsuario extends FormularioGestionManual{
        /**
         * Crea el formulario llamando al constructor de la clase padre, con identificador formBusquedaNoticias y redireccion a los resultados
         */
        public function __construct(){
            parent::__construct('formBusquedaUsuario', [
                'method' => 'GET',
                'action' => 'mostrarBusquedaUsuario.php'
            ]);
        }
        
        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            // Se reutiliza el Usuario de usuario introducido previamente o se deja en blanco
            $keyWords = $datos['keyWords'] ?? '';
            // Se generan los mensajes de error si existen.
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['keyWords'], $this->errores, 'span', array('class' => 'error'));
            // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
            $html = <<<EOF
            $htmlErroresGlobales
            <fieldset>
                <div class="container">
                    <label for="keyWords" class="form-label">Introduce nombre de usuario:</label>
                    <input id="keyWords" type="text" class="form-control" name="keyWords" value="$keyWords" required/>
                    {$erroresCampos['keyWords']}
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
            $keyWords = trim($datos['keyWords'] ?? '');
            $keyWords = filter_var($keyWords, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$keyWords ||  mb_strlen($keyWords) == 0 ) {
                $this->errores['keyWords'] = 'Debes especificar algún texto a buscar';
            }
            $result = new ResultadoGestionFormulario(true);
            if (count($this->errores) === 0) {
                $resultado = [];
                // Pedimos un mensaje más allá de la página actual para saber si hay más páginas
                $resultado['usuarios'] = Usuario::buscarUsuarioKeyWords($keyWords);
                $resultado['extraUrlParams'] = ['tipoFormulario'=>'formBusquedaUsuario', 'keyWords' => $keyWords];
                $result->setResultado($resultado);
                if (!$resultado['usuarios']) {
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