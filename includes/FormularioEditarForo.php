<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de editar Foros en la pagina web
     */
    class FormularioEditarForo extends Formulario{
        private $idAutor;
        private $idForo;
        /**
         * Constructor del formulario, con id formEditaForo y redireccion a la pagina de foros
         */
        public function __construct($idUsuario, $idForo){
            $this->idAutor = $idUsuario;
            $this->idForo = $idForo;
            parent::__construct('fomrEditaForo', ['urlRedireccion' => 'foro_particular.php?id='.$idForo]);
        }

        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            $foro = Foro::buscaForo($this->idForo);
            $contenido = $datos['contenido'] ?? $foro->getContenido();
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
            $foro = Foro::buscaForo($this->idForo);
            $contenido = filter_var($datos['contenido'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $usuario = Usuario::buscaPorId($this->idAutor);
            if (!$contenido) {
                $this->errores['contenido'] = 'El tema no es válido.';
            }
            if(!( $this->checkIdentity($this->idAutor,$_SESSION['ID']) || $this->checkRole($_SESSION['ID'], 1) || $this->checkRole($_SESSION['ID'], 4) ) ){
                $this->errores[] = 'No se ha podido verificar la identidad del usuario';
            }
            if(count($this->errores) === 0){
                if(!($foro->editarForo($contenido))){
                    $this->errores[] = "No ha sido posible editar la tematica";
                }
            }
        }
        /**
         * Valida si la identidad del usuario logeado coincide con la del autor del foro
         * @param int $idAutor ID del autor del foro
         * @param int $idUsuario ID del usuario que ha iniciado sesion
         * @return bool Si la identidad coincide retorna true, sino retorna false
         */
        protected function checkIdentity($idAutor, $idUsuario){
            return $idAutor == $idUsuario;
        }
        /**
         * Valida si la identidad del usuario logeado tiene el rol especificado
         * @param int $idUsuario ID del usuario que ha iniciado sesion
         * @param int $role Rol que se desea comprobar
         * @return bool Si el rol lo tiene retorna true, sino retorna false
         */
        protected function checkRole($idUsuario, $role){
            return Usuario::buscaPorId($idUsuario)->hasRole($role);
        }
    }
?>