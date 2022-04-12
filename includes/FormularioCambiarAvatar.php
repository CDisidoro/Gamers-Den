<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de gestionar el cambio de avatar
     */
    class FormularioCambiarAvatar extends Formulario{
        private $idAvatar;
        private $idUsuario;
        /**
         * Crea el formulario llamando al constructor de la clase padre, con identificador formUpdateAvatar y redireccion al Perfil una vez finalizado el cambio
         */
        public function __construct($idAvatar, $idUsuario){
            $this->idAvatar = $idAvatar;
            $this->idUsuario = $idUsuario;
            parent::__construct('formUpdateAvatar', ['urlRedireccion' => 'perfil.php']);
        }


        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            // Se reutiliza el Usuario de usuario introducido previamente o se deja en blanco
            $idAvatar = $this->idAvatar;
            $idUsuario = $this->idUsuario;
            // Se generan los mensajes de error si existen.
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['idAvatar','idUsuario'], $this->errores, 'span', array('class' => 'error'));

            $srcAvatar = 'img/Avatar'.$idAvatar.'.jpg';
            $htmlAvatar = '<img class ="avatarPerfilUsuario" src="';
            $htmlAvatar .= $srcAvatar;
            $htmlAvatar .= '">';
            // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
            $html = <<<EOF
            $htmlErroresGlobales
                    <input id="idAvatar" type="hidden" name="idAvatar" value="$idAvatar" required/>
                    {$erroresCampos['idAvatar']}
                    <input id="idUsuario" type="hidden" name="idUsuario" value="$idUsuario" required/>
                    {$erroresCampos['idUsuario']}
                    <button type = "submit" class = "botonPrueba" > $htmlAvatar </button>
            EOF;
            return $html;
        }

        /**
         * Se encarga de procesar en formulario una vez se pulsa en el boton de enviar
         * @param array &$datos Datos que han sido enviados en el formulario
         */
        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            $idAvatar = filter_var($datos['idAvatar'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$idAvatar) {
                $this->errores[] = 'No se ha elegido un ID de avatar valido';
            }
            $idUsuario = filter_var($datos['idUsuario'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$idUsuario) {
                $this->errores[] = 'No tengo un ID de usuario valido';
            }
            if(count($this->errores) === 0){
                $usuario = Usuario::buscaPorId($idUsuario);
                if (!($usuario->updateAvatar($idAvatar) && $usuario)) {
                    $this->errores[] = 'Algo ha salido mal';
                }
            }
        }
    }
?>