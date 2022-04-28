<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de gestionar el cambio de avatar
     */
    class FormularioCambiarAvatar extends Formulario{
        private $idUsuario;
        /**
         * Crea el formulario llamando al constructor de la clase padre, con identificador formUpdateAvatar y redireccion al Perfil una vez finalizado el cambio
         */
        public function __construct($idUsuario){
            $this->idUsuario = $idUsuario;
            parent::__construct('formUpdateAvatar', ['urlRedireccion' => 'perfil.php', 'enctype' => 'multipart/form-data']);
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
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            // Se reutiliza el Usuario de usuario introducido previamente o se deja en blanco
            $idUsuario = $this->idUsuario;
            // Se generan los mensajes de error si existen.
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['idUsuario', 'imagen'], $this->errores, 'span', array('class' => 'error'));

            // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
            $html = <<<EOF
                $htmlErroresGlobales
                <div class="container">
                    <label class="form-label">Carga una imagen:</label>
                    <input class="form-control" type="file" id="imagen" name="imagen" required/>
                    {$erroresCampos['imagen']}
                    <input id="idUsuario" type="hidden" name="idUsuario" value="$idUsuario" required/>
                    {$erroresCampos['idUsuario']}
                    <button type = "submit" class = "btn btn-success" > Cambiar Avatar </button>
                </div>
            EOF;
            return $html;
        }

        /**
         * Se encarga de procesar en formulario una vez se pulsa en el boton de enviar
         * @param array &$datos Datos que han sido enviados en el formulario
         */
        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            $idUsuario = filter_var($datos['idUsuario'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$idUsuario) {
                $this->errores[] = 'No tengo un ID de usuario valido';
            }
            $imagen = $this->loadImage();
            if(count($this->errores) === 0){
                $usuario = Usuario::buscaPorId($idUsuario);
                if (!($usuario->updateAvatar($imagen) && $usuario)) {
                    $this->errores[] = 'Algo ha salido mal';
                }
            }
        }
    }
?>