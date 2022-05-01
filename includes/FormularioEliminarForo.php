<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada del borrado de foros de la aplicacion
     */
    class FormularioEliminarForo extends Formulario{
        private $idForo;
        private $idAutor;
        /**
         * Constructor del formulario, con id formDelForo y redireccion a la pagina de foros
         * @param int $idForo ID del foro a eliminar
         * @param int $idAutor ID del autor del foro
         */
        public function __construct($idForo, $idAutor){
            $this->idForo = $idForo;
            $this->idAutor = $idAutor;
            parent::__construct('formDelForo',['urlRedireccion' => 'foro_general.php']);
        }

        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['idForo'], $this->errores, 'span', array('class' => 'error'));
            /*
            *   Los campos que se crean son un input invisible con el id del foro y un botón para enviar.
            */
            $html = <<<EOF
                $htmlErroresGlobales
                <input type="hidden" name="idForo" value="{$this->idForo}"  />
                {$erroresCampos['idForo']}
                <button type = "submit" onclick="return confirm('Estás seguro que deseas eliminar el foro?');" class = "btn btn-link" > <img class = "botonModificarNoticia" src = "img/trash.svg"> </button>
            EOF;
            return $html;
        }

        /**
         * Se encarga de procesar en formulario una vez se pulsa en el boton de enviar
         * @param array &$datos Datos que han sido enviados en el formulario
         */
        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            $idForo = filter_var($datos['idForo'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$idForo) {
                $this->errores[] = 'No tengo claro que foro eliminar.';
            }
            if(!( $this->checkIdentity($this->idAutor,$_SESSION['ID']) || $this->checkRole($_SESSION['ID'], 1) || $this->checkRole($_SESSION['ID'], 4) ) ){
                $this->errores[] = 'No se ha podido verificar la identidad del usuario';
            }
            $foro = Foro::buscaForo($idForo);
            if(!$foro){
                $this->errores[] = 'Foro no encontrado';
            }
            //Una vez validado todo se procede a eliminar el foro
            if(count($this->errores) === 0){
                if(!($foro->borrarForo())){
                    $this->errores[] = 'Ha ocurrido un error';
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