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
            parent::__construct('formEditarNoticia', ['urlRedireccion' => 'noticias_concreta.php?id='.$idNoticia, 'enctype' => 'multipart/form-data']);
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
            $etiquetaNoticia = $datos['etiqueta'] ?? $noticia->getEtiquetas();
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['idNoticia','titulo','imagen','contenido','descripcion','etiqueta'], $this->errores, 'span', array('class' => 'error'));
            if($this->checkIdentity($noticia->getAutor(),$this->idUsuario) || $this->checkAdmin($this->idUsuario)){
                $html = <<<EOF
                    $htmlErroresGlobales
                    <fieldset class="container">
                        <input type="hidden" name="idNoticia" value="$idNoticia" />
                        {$erroresCampos['idNoticia']}
                        <div>
                            <label for="titulo" class="form-label">Nuevo título: </label>
                            <input type="text" class="form-control" id="titulo" name="titulo" value="$tituloNoticia" required>
                            {$erroresCampos['titulo']}
                        </div>
                        <div>
                            <label for="imagen" class="form-label">Cambiar imagen: </label>
                            <input class="form-control" type="file" id="imagen" name="imagen"/>
                            {$erroresCampos['imagen']}
                        </div>
                        <div>
                            <label for="contenido" class="form-label">Edita el contenido de la noticia: </label>
                            <textarea class="form-control" id="contenido" name="contenido" rows="10" cols="50" required>$contenidoNoticia</textarea>
                            {$erroresCampos['contenido']}
                        </div>
                        <div>
                            <label for="descripcion" class="form-label">Edita la descripcion: </label>
                            <input class="form-control" type="text" id="descripcion" name="descripcion" value="$descripcionNoticia" required>
                            {$erroresCampos['descripcion']}
                        </div>
                        <div>
                            <label for="etiqueta" class="form-label">Cambia la etiqueta: </label>
                            <select class="js-example-basic-multiple" name="etiquetas[]" style="width: 75%" multiple="multiple" required>
                                <option value="1">Nuevo</option>
                                <option value="2">Destacado</option>
                                <option value="3">Popular</option>
                                <option value="4">Cartelera</option>
                            </select>  
                            <script>
                                $(document).ready(function() {
                                    $('.js-example-basic-multiple').select2({width: 'resolve'});
                                });   
                            </script>                       
                            {$erroresCampos['etiqueta']}
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success" name="enviar"> Enviar </button>
                        </div>
                    </fieldset>
                    EOF;
            }else{
                $html="<p>No tienes autorizado el acceso a esta sección. Por favor inicia sesión con el usuario escritor para poder editar la noticia</p>";
            }
            return $html;
        }

        /**
         * Se encarga de subir una imagen a la BD y retornar la ruta donde ha sido subida.
         * Fuente: https://www.jose-aguilar.com/blog/upload-de-imagenes-con-php/
         * @return string|false Si ha subido correctamente la imagen retornara su ruta de subida o false si algo ha ido mal
         */
        protected function loadImage(){
            $nombreImg = $_FILES['imagen']['name']; //Obtenemos el fichero
            if(isset($nombreImg) && $nombreImg != ""){ //Si existe el fichero y no esta vacio
                //Obtenemos la informacion del fichero
                $ext = $_FILES['imagen']['type'];
                $size = $_FILES['imagen']['size'];
                $tmpName = $_FILES['imagen']['tmp_name'];
                //Verifica si la extension y tamano son apropiados
                if(!(strpos($ext, "jpg") || strpos($ext, "jpeg") && ($size < 10000000))){
                    $this->errores['imagen'] = 'La imagen debe ser extensión .jpg y de tamaño máximo de 1MB';
                }else{
                    $ruta = 'img/'.$nombreImg;
                    //Intentamos subir la imagen TmpName a la carpeta img con su nombre real
                    if(move_uploaded_file($tmpName, $ruta)){
                        return $ruta;
                    }else{
                        $this->errores['imagen'] = 'Ha ocurrido un error al guardar la imagen';
                    }
                }
            }
            return false;
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
            if(isset($_FILES['imagen']['name']) && $_FILES['imagen']['name'] != ""){
                $imagen = $this->loadImage();
            }else{
                $imagen = Noticia::buscaNoticia($idNoticia)->getImagen();
            }
            $contenido = filter_var($datos['contenido'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$contenido) {
                $this->errores['contenido'] = 'El contenido no es válido.';
            }
            $descripcion = filter_var($datos['descripcion'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$descripcion) {
                $this->errores['descripcion'] = 'La descripcion no es valida';
            }

            $etiquetas = $datos['etiquetas'];
            foreach($etiquetas as $etiqueta){
                $etiqueta = filter_var($etiqueta ?? null, FILTER_SANITIZE_NUMBER_INT);
            }      
            
            if (!$etiquetas) {
                $this->errores['etiqueta'] = 'La etiqueta no es valida';
            }
            if(count($this->errores) === 0){
                /*
                *   Después de validar el id de la noticia se busca en la bd. Si existe se edita.
                */
                $noticia = Noticia::buscaNoticia($idNoticia);
                if(!$noticia){
                    $this->errores[] = 'Error buscando la noticia';
                }else{
                    if(!($noticia->editarNoticia($titulo,$imagen,$contenido,$descripcion,$etiquetas))){
                        $this->errores[] = 'Ha ocurrido un error al editar la noticia';
                    }
                } 
            }      
        }
    }
?>