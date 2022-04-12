<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de gestionar la edicion de una noticia
     */
    class FormularioCrearNoticia extends Formulario{
        private $idUsuario;
        /**
        * El formulario recibe en el constructor el id de la noticia que se quiere editar.
        * Tiene ID formEditarNoticia y una vez finalizado redirige a la noticia que se ha editado
        * @param int $idNoticia ID de la noticia que se desea editar
        */
        public function __construct($idUsuario) {
            $this->idUsuario = $idUsuario;
            parent::__construct('formCrearNoticia', ['urlRedireccion' => 'noticias_principal.php?tag=1', 'enctype' => 'multipart/form-data']);
        }

        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        //<textarea id="titulo" rows="10" cols="50">{$Noticia->getTitulo()} </textarea>
        protected function generaCamposFormulario(&$datos){
            $titulo = $datos['titulo'] ?? '';
            $contenido = $datos['contenido'] ?? '';
            $descripcion = $datos['descripcion'] ?? '';
            $idUsuario = $this->idUsuario;
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['titulo','imagen','contenido','descripcion'], $this->errores, 'span', array('class' => 'error'));
            $html = <<<EOF
            $htmlErroresGlobales
            <fieldset>
                <legend>Nueva noticia</legend>
                <div>
                    <label for="titulo">Nuevo título: </label>
                    <textarea id="titulo" name="titulo" rows="10" cols="50" value="$titulo"></textarea>
                    {$erroresCampos['titulo']}
                </div>
                <div>
                    <label for="imagen">Nueva imagen: </label>
                    <input type="file" id="imagen" name="imagen" required/>
                    {$erroresCampos['imagen']}
                </div>
                <div>
                    <label for="contenido">Nuevo contenido de la noticia: </label>
                    <textarea id="contenido" name="contenido" rows="10" cols="50" value="$contenido"></textarea>
                    {$erroresCampos['contenido']}
                </div>
                <div>
                    <label for="descripcion">Nueva descripcion: </label>
                    <textarea id="descripcion" name="descripcion" rows="10" cols="50" value="$descripcion"></textarea>
                    {$erroresCampos['descripcion']}
                </div>
                <div>
                    <input type="hidden" id="idUsuario" name="idUsuario" value="$idUsuario"/>
                    <button type="submit" name="enviar"> Enviar </button>
                </div>
            </fieldset>
            EOF;
            return $html;
        }

        /**
         * Se encarga de subir una imagen a la BD y retornar la ruta donde ha sido subida.
         * Fuente: https://www.jose-aguilar.com/blog/upload-de-imagenes-con-php/
         * @param &$datos Datos que han sido enviados en el formulario
         * @return string|false Si ha subido correctamente la imagen retornara su ruta de subida o false si algo ha ido mal
         */
        protected function loadImage(&$datos){
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
         * Se encarga de procesar en formulario una vez se pulsa en el boton de enviar
         * @param array &$datos Datos que han sido enviados en el formulario
         */
        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            $titulo = filter_var($datos['titulo'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$titulo) {
                $this->errores['titulo'] = 'El titulo no es válido.';
            }
            $imagen = $this->loadImage($datos);
            $contenido = filter_var($datos['contenido'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$contenido) {
                $this->errores['contenido'] = 'El contenido no es válido.';
            }
            $descripcion = filter_var($datos['descripcion'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$descripcion) {
                $this->errores['descripcion'] = 'La descripcion no es valida';
            }
            //Una vez validadas las entradas se inserta el producto
            if(count($this->errores) === 0){
                $noticia = Noticia::subeNoticia($titulo,$contenido,$this->idUsuario,$imagen,$descripcion);
                if(!$noticia){
                    $this->errores[] = 'Ha ocurrido un error';
                }
            }      
        }
    }
?>