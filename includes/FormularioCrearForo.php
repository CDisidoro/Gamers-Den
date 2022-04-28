<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de dar alta Foros en la pagina web
     */
    class FormularioCrearForo extends Formulario{
        /**
         * Constructor del formulario, con id formCreaForo y redireccion a la pagina de foros
         */
        public function __construct($idUsuario){
            parent::__construct('fomrCreaForo', ['urlRedireccion' => 'foro_general.php', 'enctype' => 'multipart/form-data']);
        }

        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            $contenido = $datos['contenido'] ?? '';
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['contenido'], $this->errores, 'span', array('class' => 'error'));
            $html = <<<EOF
            $htmlErroresGlobales
            <fieldset class="container">
                <div>
                    <label class="form-label" for="articulo">TEMA DEL FORO: </label>
                    <input class="form-control" id="contenido" name="contenido" type="text" value="$contenido" required>
                    {$erroresCampos['contenido']}
                </div>
                <div>
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
            $contenido = filter_var($datos['contenido'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $usuario = Usuario::buscaPorId($_SESSION['ID']);
            if (!$contenido) {
                $this->errores['contenido'] = 'El tema no es válido.';
            }
            if(count($this->errores) === 0){
                if(!(Foro::subirForo($contenido, $usuario->getId()))){
                    $this->errores[] = "No ha sido crear la tematica";
                }
            }
        }
    }
?>