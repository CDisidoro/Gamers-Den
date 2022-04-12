<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de gestionar la edicion de una noticia
     */
    class FormularioEditarNoticia extends Formulario{
        private $idNoticia;
        private $idUsuario;
        /**
        * El formulario recibe en el constructor el id de la noticia que se quiere editar.
        * Tiene ID formEditarNoticia y una vez finalizado redirige a la noticia que se ha editado
        * @param int $idNoticia ID de la noticia que se desea editar
        */
        public function __construct($idNoticia, $idUsuario) { 
            parent::__construct('formEditarNoticia', ['urlRedireccion' => 'noticias_concreta.php?id='.$idNoticia]);
            $this->idNoticia = $idNoticia;
            $this->idUsuario = $idUsuario;
        }

        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            $noticia = Noticia::buscaNoticia($this->idNoticia);
            $idNoticia = $noticia->getID();
            $tituloNoticia = $datos['titulo'] ?? $noticia->getTitulo();
            $imagenNoticia = $datos['imagen'] ?? $noticia->getImagen();
            $contenidoNoticia = $datos['contenido'] ?? $noticia->getContenido();
            $descripcionNoticia = $datos['descripcion'] ?? $noticia->getDescripcion();
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['idNoticia','titulo','imagen','contenido','descripcion'], $this->errores, 'span', array('class' => 'error'));
            if($this->checkIdentity($noticia->getAutor(),$this->idUsuario) || $this->checkAdmin($this->idUsuario)){
                $html = <<<EOF
                    $htmlErroresGlobales
                    <fieldset>
                        <input type="hidden" name="idNoticia" value="$idNoticia" />
                        {$erroresCampos['idNoticia']}
                        <div>
                            <label for="titulo">Nuevo título: </label>
                            <textarea id="titulo" name="titulo" rows="10" cols="50">$tituloNoticia</textarea>
                            {$erroresCampos['titulo']}
                        </div>
                        <div>
                            <label for="imagen">Cambiar imagen: </label>
                            <textarea id="imagen" name="imagen" rows="10" cols="50">$imagenNoticia</textarea>
                            {$erroresCampos['imagen']}
                        </div>
                        <div>
                            <label for="contenido">Edita el contenido de la noticia: </label>
                            <textarea id="contenido" name="contenido" rows="10" cols="50">$contenidoNoticia</textarea>
                            {$erroresCampos['contenido']}
                        </div>
                        <div>
                            <label for="descripcion">Edita la descripcion: </label>
                            <textarea id="descripcion" name="descripcion" rows="10" cols="50">$descripcionNoticia</textarea>
                            {$erroresCampos['descripcion']}
                        </div>
                        <div>
                            <button type="submit" name="enviar"> Enviar </button>
                        </div>
                    </fieldset>
                    EOF;
            }else{
                $html="<p>No tienes autorizado el acceso a esta sección. Por favor inicia sesión con el usuario escritor para poder editar la noticia</p>";
            }
            return $html;
        }

        /**
         * Valida si la identidad del usuario logeado coincide con la del escritor de la noticia
         * @param int $idEscritor ID del escritor
         * @param int $idUsuario ID del usuario que ha iniciado sesion
         * @return bool Si la identidad coincide retorna true, sino retorna false
         */
        protected function checkIdentity($idEscritor, $idUsuario){
            return $idEscritor == $idUsuario;
        }

        /**
         * Valida si el usuario tiene permisos de administrador
         * @param int $idUsuario ID del usuario logeado que desea validar su rol de admin
         * @return bool Retornara verdadero si su nivel de rol es 1 (Admin) o false si no es administrador
         */
        protected function checkAdmin($idUsuario){
            $usuario = Usuario::buscaPorId($idUsuario);
            return $usuario->getRol() == 1;
        }

        /**
         * Se encarga de procesar en formulario una vez se pulsa en el boton de enviar
         * @param array &$datos Datos que han sido enviados en el formulario
         */
        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            $idNoticia = filter_var($datos['idNoticia'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$idNoticia) {
                $this->errores['idNoticia'] = 'El id de noticia no es válido.';
            }
            $titulo = filter_var($datos['titulo'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$titulo) {
                $this->errores['titulo'] = 'El titulo no es válido.';
            }
            $imagen = filter_var($datos['imagen'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$imagen) {
                $this->errores['imagen'] = 'La imagen no es válida.';
            }
            $contenido = filter_var($datos['contenido'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$contenido) {
                $this->errores['contenido'] = 'El contenido no es válido.';
            }
            $descripcion = filter_var($datos['descripcion'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$descripcion) {
                $this->errores['descripcion'] = 'La descripcion no es valida';
            }
            if(count($this->errores) === 0){
                /*
                *   Después de validar el id de la noticia se busca en la bd. Si existe se edita.
                */
                $noticia = Noticia::buscaNoticia($idNoticia);
                if(!$noticia){
                    $this->errores[] = 'Error buscando la noticia';
                }else{
                    if(!($noticia->editarNoticia($titulo,$imagen,$contenido,$descripcion))){
                        $this->errores[] = 'Ha ocurrido un error al editar la noticia';
                    }
                } 
            }      
        }
    }
?>