<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de dar alta juegos en la pagina web
     */
    class FormularioCrearJuego extends Formulario{
        /**
         * Constructor del formulario, con id formCreaJuego y redireccion a la pagina de juegos
         */
        public function __construct(){
            parent::__construct('fomrCreaJuego', ['urlRedireccion' => 'juegos.php', 'enctype' => 'multipart/form-data']);
        }

        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            $nombre = $datos['nombre'] ?? '';
            $descripcion = $datos['descripcion'] ?? '';
            $lanzamiento = $datos['lanzamiento'] ?? '';
            $desarrollador = $datos['desarrollador'] ?? '';
            $precio = $datos['precio'] ?? '';
            $categorias = self::generaListaCategorias();
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['nombre','descripcion','lanzamiento','desarrollador','precio','imagen','categorias'], $this->errores, 'span', array('class' => 'error'));
            $html = <<<EOF
            $htmlErroresGlobales
            <fieldset class="container">
                <div>
                    <label class="form-label" for="articulo">Nombre del videojuego: </label>
                    <input class="form-control" id="nombre" name="nombre" type="text" value="$nombre" required>
                    {$erroresCampos['nombre']}
                </div>
                <div>
                    <label class="form-label" for="descripcion">Dale una descripción al juego: </label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="10" cols="50" required>$descripcion</textarea>
                    {$erroresCampos['descripcion']}
                </div>
                <div>
                    <label class="form-label" for="lanzamiento">Fecha de lanzamiento: </label>
                    <input class="form-control" id="lanzamiento" name="lanzamiento" type="date" value="$lanzamiento" required>
                    {$erroresCampos['lanzamiento']}
                </div>
                <div>
                    <label class="form-label" for="desarrollador">Nombre del desarrollador: </label>
                    <input class="form-control" id="desarrollador" name="desarrollador" type="text" value="$desarrollador" required>
                    {$erroresCampos['desarrollador']}
                </div>
                <div>
                    <label class="form-label" for="precio">Precio oficial del desarrollador: </label>
                    <input class="form-control" id="precio" name="precio" type="text" value="$precio" required>
                    {$erroresCampos['precio']}
                </div>
                <div>
                    <label class="form-label" for="imagen">Nueva imagen: </label>
                    <input class="form-control" type="file" id="imagen" name="imagen" required/>
                    {$erroresCampos['imagen']}
                </div>
                <div>
                    <label for="categorias">Categorias:</label>
                    $categorias
                    {$erroresCampos['categorias']}
                </div>
                <div>
                    <button type="submit" class="btn btn-success" name="enviar"> Enviar </button>
                </div>
            </fieldset>
            EOF;
            return $html;
        }

        private function generaListaCategorias(){
            $categorias = Categoria::cargaCategorias();
            if(!$categorias){
                return '';
            }
            $html = '';
            foreach($categorias as $categoria){
                $html .= '<label><input class="form-check-input" type="checkbox" id="categorias" name="categorias[]" value="'.$categoria->getID().'">'.$categoria->getNombre().'</label>';
            }
            return $html;
        }

        /**
         * Se encarga de procesar en formulario una vez se pulsa en el boton de enviar
         * @param array &$datos Datos que han sido enviados en el formulario
         */
        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            $nombre = filter_var($datos['nombre'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$nombre) {
                $this->errores['nombre'] = 'El nombre no es válido.';
            }
            $desarrollador = filter_var($datos['desarrollador'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$desarrollador) {
                $this->errores['desarrollador'] = 'El nombre del desarrollador no es válido.';
            }
            $descripcion = filter_var($datos['descripcion'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$descripcion) {
                $this->errores['descripcion'] = 'La descripcion no es valida';
            }
            $precio = filter_var($datos['precio'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$precio) {
                $this->errores['precio'] = 'El precio no es valido';
            }
            $lanzamiento = filter_var($datos['lanzamiento'] ?? null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$lanzamiento) {
                $this->errores['lanzamiento'] = 'La fecha de lanzamiento no es valida';
            }
            $imagen = $this->loadImage();
            //Una vez validadas las entradas se inserta el producto
            if(count($this->errores) === 0){
                $categorias = $datos['categorias'];
                $arrayCategorias = [];
                foreach($categorias as $categoria){
                    $arrayCategorias[] = Categoria::buscaPorId($categoria);
                }
                $juego = Videojuego::subeVideojuego($nombre, $descripcion, $lanzamiento, $desarrollador, $precio, $imagen,$arrayCategorias);
                if(!$juego){
                    $this->errores[] = 'Ha ocurrido un error';
                }
            }
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
    }
?>