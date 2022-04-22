<?php namespace es\fdi\ucm\aw\gamersDen;
/**
 * Clase hija de Formulario encargada de cambiar la biografia del usuario
 */
    class FormularioCambiarBio extends Formulario{
        private $idUsuario;
        /**
         * Crea el formulario llamando al constructor de la clase padre, con identificador formUpdateBio y redireccion al Perfil una vez finalizado el cambio
         */
        public function __construct($idUsuario){
            $this->idUsuario = $idUsuario;
            parent::__construct('formUpdateBio', ['urlRedireccion' => 'perfil.php']);
        }
        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            // Se reutiliza el Usuario de usuario introducido previamente o se deja en blanco
            $idUsuario = $this->idUsuario;
            $usuario = Usuario::buscaPorId($idUsuario);
            $bio = $datos['Bio'] ?? $usuario->getBio();
            // Se generan los mensajes de error si existen.
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['idUsuario','Bio'], $this->errores, 'span', array('class' => 'error'));
            // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
            $html = <<<EOF
            $htmlErroresGlobales
            <fieldset>
                <div class="container">
                    <label for="Bio" class="form-label">Biografía:</label>
                    <textarea id="Bio" class="form-control" name="Bio" rows="15" cols="60"/>$bio</textarea>
                    {$erroresCampos['Bio']}
                    <input id="idUsuario" type="hidden" name="idUsuario" value="$idUsuario" required/>
                    {$erroresCampos['idUsuario']}
                    <button type="submit" class="btn btn-success" name="updateBio">Cambiar Biografía</button>
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
            $bio = filter_var($datos['Bio'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$bio) {
                $this->errores['Bio'] = 'No he recibido una biografía válida';
            }
            $idUsuario = filter_var($datos['idUsuario'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$idUsuario) {
                $this->errores['idUsuario'] = 'No tengo un ID de usuario valido';
            }
            if(count($this->errores) === 0){
                $usuario = Usuario::buscaPorId($idUsuario);
                if (!($usuario->updateBio($bio) && $usuario)) {
                    $this->errores[] = 'Algo ha salido mal';
                }
            }
        }

    }
?>