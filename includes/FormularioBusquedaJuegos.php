<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de FormularioGestionManual encargada de buscar un videojuego
     */
    class FormularioBusquedaJuegos extends FormularioGestionManual{
        /**
         * Crea el formulario, con id formBuscaJuegos y redireccion a la pagina de resultados
         */
        public function __construct(){
            parent::__construct('formBuscaJuegos', ['method' => 'GET', 'action' => 'mostrarBuscarJuego.php']);
        }

        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            // Se reutiliza las palabras clave usadas previamente o se dejan en blanco
            $keyWords = $datos['keyWords'] ?? '';
            // Se generan los mensajes de error si existen.
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['keyWords'], $this->errores, 'span', array('class' => 'error'));
            // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
            $html = <<<EOF
            $htmlErroresGlobales
            <fieldset class="container">
                <div>
                    <label for="keyWords" class="form-label">Introduce palabras clave:</label>
                    <input id="keyWords" class="form-control" type="text" name="keyWords" value="$keyWords" required/>
                    {$erroresCampos['keyWords']}
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
            $keyWords = trim($datos['keyWords'] ?? '');
            $keyWords = filter_var($keyWords, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$keyWords ||  mb_strlen($keyWords) == 0 ) {
                $this->errores['keyWords'] = 'Debes especificar alg??n texto a buscar';
            }
            $result = new ResultadoGestionFormulario(true);
            if (count($this->errores) === 0) {
                $resultado = [];
                // Pedimos un mensaje m??s all?? de la p??gina actual para saber si hay m??s p??ginas
                $resultado['juegos'] = Videojuego::buscaPorKeyWords($keyWords);
                $resultado['extraUrlParams'] = ['tipoFormulario'=>'formBuscaJuegos', 'keyWords' => $keyWords];
                $result->setResultado($resultado);
                if (!$resultado['juegos']) {
                    $this->errores[] = "Su b??squeda no ha obtenido resultados";
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