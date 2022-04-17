<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase hija de Formulario encargada de gestionar la edicion de un juego
     */
    class FormularioEditarJuego extends Formulario{
        private $idJuego;
        private $idUsuario;
        /**
        * El formulario recibe en el constructor el id del juego que se quiere editar.
        * Tiene ID formEditarJuego y una vez finalizado redirige al juego que se ha editado
        * @param int $idJuego ID del juego que se desea editar
        */
        public function __construct($idJuego, $idUsuario) { 
            parent::__construct('formEditarJuego', ['urlRedireccion' => 'juego_particular.php?id='.$idJuego, 'enctype' => 'multipart/form-data']);
            $this->idJuego = $idJuego;
            $this->idUsuario = $idUsuario;
        }

        /**
         * Se encarga de generar los campos necesarios para el formulario
         * @param array &$datos Almacena los datos del formulario si ha sido enviado anteriormente y hubo errores
         * @return string $html Retorna el contenido HTML del formulario
         */
        protected function generaCamposFormulario(&$datos){
            $juego = Videojuego::buscaVideojuego($this->idJuego);
            $idJuego = $juego->getID();
            $nombreJuego = $datos['nombre'] ?? $juego->getNombre();
            $imagenJuego = $datos['imagen'] ?? $juego->getUrlImagen();
            $lanzamientoJuego = $datos['lanzamiento'] ?? $juego->getLanzamiento();
            $descripcionJuego = $datos['descripcion'] ?? $juego->getDescripcion();
            $desarrolladorJuego = $datos['desarrollador'] ?? $juego->getDesarrollador();
            $precioJuego = $datos['precio'] ?? $juego->getPrecio();
            $categorias = self::generaListaCategorias($juego->getCategorias());
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['idJuego','nombre','imagen','lanzamiento','descripcion','desarrollador','precio','categorias'], $this->errores, 'span', array('class' => 'error'));
            if($this->checkRole($this->idUsuario, 3) || $this->checkRole($this->idUsuario, 1)){
                $html = <<<EOF
                    $htmlErroresGlobales
                    <fieldset>
                        <legend>Nuevo videojuego</legend>
                        <div>
                            <input type="hidden" name="idJuego" value="$idJuego" />
                            {$erroresCampos['idJuego']}
                            <label for="articulo">Nombre del videojuego: </label>
                            <input id="nombre" name="nombre" type="text" value="$nombreJuego">
                            {$erroresCampos['nombre']}
                        </div>
                        <div>
                            <label for="descripcion">Dale una descripción al juego: </label>
                            <textarea id="descripcion" name="descripcion" rows="10" cols="50">$descripcionJuego</textarea>
                            {$erroresCampos['descripcion']}
                        </div>
                        <div>
                            <label for="lanzamiento">Fecha de lanzamiento: </label>
                            <input id="lanzamiento" name="lanzamiento" type="date" value="$lanzamientoJuego">
                            {$erroresCampos['lanzamiento']}
                        </div>
                        <div>
                            <label for="desarrollador">Nombre del desarrollador: </label>
                            <input id="desarrollador" name="desarrollador" type="text" value="$desarrolladorJuego">
                            {$erroresCampos['desarrollador']}
                        </div>
                        <div>
                            <label for="precio">Precio oficial del desarrollador: </label>
                            <input id="precio" name="precio" type="text" value="$precioJuego">
                            {$erroresCampos['precio']}
                        </div>
                        <div>
                            <label for="imagen">Nueva imagen: </label>
                            <input type="file" id="imagen" name="imagen"/>
                            {$erroresCampos['imagen']}
                        </div>
                        <div>
                            <label for="categorias">Categorias:</label>
                            $categorias
                            {$erroresCampos['categorias']}
                        </div>
                        <div>
                            <button type="submit" name="enviar"> Enviar </button>
                        </div>
                    </fieldset>
                    EOF;
            }else{
                $html="<p>No tienes autorizado el acceso a esta sección. Por favor inicia sesión con el usuario catalogador o administrador para poder editar el juego</p>";
            }
            return $html;
        }

        private function generaListaCategorias($catJuego){
            $categorias = Categoria::cargaCategorias();
            if(!$categorias){
                return '';
            }
            $html = '';
            foreach($categorias as $categoria){
                $hasCat = array_search($categoria,$catJuego);
                if($hasCat != false || $hasCat === 0){//El cero lo esta considerando como un false!!!
                    $html .= '<label><input type="checkbox" id="categorias" name="categorias[]" value="'.$categoria->getID().'" checked>'.$categoria->getNombre().'</label>';
                }else{
                    $html .= '<label><input type="checkbox" id="categorias" name="categorias[]" value="'.$categoria->getID().'">'.$categoria->getNombre().'</label>';
                }
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
         * Valida si la identidad del usuario logeado tiene el rol especificado
         * @param int $idUsuario ID del usuario que ha iniciado sesion
         * @param int $role Rol que se desea comprobar
         * @return bool Si el rol lo tiene retorna true, sino retorna false
         */
        protected function checkRole($idUsuario, $role){
            return Usuario::buscaPorId($idUsuario)->hasRole($role);
        }

        /**
         * Se encarga de procesar en formulario una vez se pulsa en el boton de enviar
         * @param array &$datos Datos que han sido enviados en el formulario
         */
        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            $idJuego = filter_var($datos['idJuego'] ?? null, FILTER_SANITIZE_NUMBER_INT);
            if (!$idJuego) {
                $this->errores['idJuego'] = 'El id del juego no es válido.';
            }
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
            if(isset($_FILES['imagen']['name']) && $_FILES['imagen']['name'] != ""){
                $imagen = $this->loadImage();
            }else{
                $imagen = Videojuego::buscaVideojuego($idJuego)->getUrlImagen();
            }
            if(count($this->errores) === 0){
                /*
                *   Después de validar el id de la juego se busca en la bd. Si existe se edita.
                */
                $juego = Videojuego::buscaVideojuego($idJuego);
                if(!$juego){
                    $this->errores[] = 'Error buscando el juego';
                }else{
                    if(!($juego->editarVideojuego($nombre, $descripcion, $lanzamiento, $desarrollador, $precio, $imagen))){
                        $this->errores[] = 'Ha ocurrido un error al editar el videojuego';
                    }
                } 
            }      
        }
    }
?>