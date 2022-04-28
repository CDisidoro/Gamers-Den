<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de FormularioGestionManual encargada de buscar una noticia
     */
    class FormularioBusquedaUsuario extends FormularioGestionManual{
        /**
         * Crea el formulario llamando al constructor de la clase padre, con identificador formBusquedaUsuario y redireccion a los resultados
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
            $Usuario = $datos['usuario'] ?? '';
            // Se generan los mensajes de error si existen.
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['usuario'], $this->errores, 'span', array('class' => 'error'));
            // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
            $html = <<<EOF
            $htmlErroresGlobales
            <fieldset>
                <div class="container">
                    <label for="usuario" class="form-label">Introduce nombre de usuario:</label>
                    <input id="usuario" type="text" class="form-control" name="usuario" value="$Usuario" required/>
                    {$erroresCampos['usuario']}
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
            $usuario = trim($datos['usuario'] ?? '');
            $usuario = filter_var($usuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$usuario ||  mb_strlen($usuario) == 0 ) {
                $this->errores['usuario'] = 'Debes especificar algún texto a buscar';
            }
            $result = new ResultadoGestionFormulario(true);
            if (count($this->errores) === 0) {
                $resultado = [];
                // Pedimos un mensaje más allá de la página actual para saber si hay más páginas
                $resultado['usuarios'] = Usuario::buscarUsuarioKeyWords($usuario);
                $resultado['extraUrlParams'] = ['tipoFormulario'=>'formBusquedaUsuario', 'usuario' => $usuario];
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