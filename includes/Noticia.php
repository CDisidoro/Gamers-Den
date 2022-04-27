<?php namespace es\fdi\ucm\aw\gamersDen;
    /**
     * Clase basica para la gestion de noticias
     */
    class Noticia{
        //ATRIBUTOS DE CLASE
        private $id;
        private $titulo;
        private $imagen;
        private $contenido;
        private $descripcion;
        private $etiquetas;
        private $autor;
        private $fecha;
        private $categorias = [
            '1' => 'Nuevo', 
            '2' => 'Destacado', 
            '3' => 'Popular',
            '4' => 'Front'
        ];
        //CONSTRUCTOR Y GETTERS

        /**
         * Constructor de noticias
         * @param int $id ID de la noticia
         * @param string $titulo Titulo de la noticia
         * @param string $imagen Ruta de la imagen asociada a la noticia
         * @param string $contenido Cuerpo principal de la noticia
         * @param string $descripcion Pequeña introduccion a la noticia que aparece en la pagina principal de noticias
         * @param string $etiquetas Conjunto de etiquetas asociadas a la noticia para facilitar su busqueda
         * @param int $autor ID del usuario autor de la noticia
         * @param date $fechas Fecha de creacion de la noticia
         */
        private function __construct($id, $titulo, $imagen, $contenido, $descripcion, $etiquetas, $autor, $fecha){
            $this->id = $id;
            $this->imagen = $imagen;
            $this->contenido = $contenido;
            $this->titulo = $titulo;
            $this->etiquetas = $etiquetas;
            $this->autor = $autor;
            $this->fecha = $fecha;
            $this->descripcion = $descripcion;
        }
        
        /**
         * Obtiene el ID asociado a la noticia
         * @return int $id ID de la noticia
         */
        public function getID() {
            return $this->id;
        }
        
        /**
         * Obtiene el Titulo asociado a la noticia
         * @return string $titulo Titulo de la noticia
         */
        public function getTitulo() {
            return $this->titulo;
        }

        /**
         * Obtiene la imagen asociada a la noticia
         * @return string $imagen Ruta de la imagen de la noticia
         */
        public function getImagen() {
            return $this->imagen;
        }

        /**
         * Obtiene la descripcion de la noticia
         * @return string $descripcion Descripcion de la noticia
         */
        public function getDescripcion() {
            return $this->descripcion;
        }

        /**
         * Obtiene el contenido de la noticia
         * @return string $contenido Cuerpo de la noticia
         */
        public function getContenido() {
            return $this->contenido;
        }
        
        /**
         * Obtiene las etiquetas asociadas a la noticia
         * @return string $etiquetas Etiquetas de la noticia
         */
        public function getEtiquetas(){
            return $this->etiquetas;
        }

        /**
         * Obtiene el ID asociado al autor de la noticia
         * @return int $id ID del autor de la noticia
         */
        public function getAutor(){
            return $this->autor;
        }

        /**
         * Obtiene la fecha de publicacion de la noticia
         * @return date $fecha Fecha de publicacion de la noticia
         */
        public function getFecha(){
            return $this->fecha;
        }

        //FUNCIONES IMPORTANTES

        // Cuando incluyamos la imagen hay que tenerla en cuenta en las distintas funcionalidades
        /**
         * Se encarga de cargar todas las noticias de la BD
         * @return array $returning Array con todas las noticias existentes en la BD
         */
        public static function cargarNoticia(){
            $mysqli = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT * FROM noticias");
            $result = $mysqli->query($query);  
            $returning = [];
            if($result) {
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $fila = $result->fetch_assoc();
                    $returning[] = new Noticia($fila['ID'], $fila['Titulo'], $fila['Imagen'], $fila['Contenido'], $fila['Descripcion'], $fila['Etiquetas'], $fila['Autor'], $fila['Fecha']);
                }
                $result->free();
                return $returning;
            } else{
                return false;
            }
        }
        
        /**
         * Se encarga de publicar una noticia nueva en la pagina (PENDIENTE DE ARREGLAR)
         * @return bool Si se ha efectuado correctamente la query retornara true, o false en el caso opuesto
         */
        public static function subeNoticia($titulo,$contenido,$autor,$urlImagen,$descripcion) {
            $etiquetas = 1;
            $conector = Aplicacion::getInstance()->getConexionBd();
            $query = "INSERT INTO noticias (Titulo, Imagen, Contenido, Descripcion, Etiquetas, Autor)
                    VALUES ('$titulo', '$urlImagen', '$contenido', '$descripcion', '$etiquetas', '$autor')";
            if ( ! $conector->query($query) ) {
                error_log("Error BD ({$conector->errno}): {$conector->error}");
                return false;
            }
            return true;
        }

        /**
         * Se encarga de borrar una noticia en funcion a su ID asignado
         * @param int $idNoticia ID de la noticia que se va a borrar
         * @return bool True si se ha borrado la noticia; False si no se ha podido borrar
         */
        public function editarNoticia($titulo, $imagen, $contenido, $descripcion, $etiquetas){
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("UPDATE noticias 
            SET Titulo = '$titulo', Contenido = '$contenido', Imagen = '$imagen', Descripcion = '$descripcion', Etiquetas = '$etiquetas'
            WHERE id = %d", $this->getID());
            if ( ! $conn->query($query) ) {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
                return false;
            }
            return true;
        }

        /**
         * Elimina la noticia que haya llamado a este metodo y su imagen asociada
         * @return bool Si ha podido borrar la imagen y la noticia del sistema retorna True, sino retorna false
         */
        public function borrarNoticia() {
            //Borrado de la noticia
            /* Los roles se borran en cascada por la FK
            * $result = self::borraRoles($usuario) !== false;
            */
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("DELETE FROM noticias WHERE id = %d"
                , $this->id
            );
            if ( ! $conn->query($query) ) {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
                return false;
            }
            //Borrado de la imagen asociada
            if(!unlink($this->imagen)){
                error_log("Error eliminando la imagen de la noticia");
                return false;
            }
            return true;
        }
        
        /**
         * Se encarga de buscar una noticia en funcion de su ID
         * @param int $id ID de la noticia a buscar
         * @return Noticia|false $buscaNoticia Noticia encontrada en la BD; false si no se ha encontrado la noticia
         */
        public static function buscaNoticia($id) {
            $mysqli = Aplicacion::getInstance()->getConexionBd();
            $query = "SELECT * FROM noticias WHERE ID = '$id'";
            $result = $mysqli->query($query);
            if($result) {
                $fila = $result->fetch_assoc();
				if(is_null($fila)){ //Comprueba si hay un resultado. Si no lo hay devuelve false
					return false;
				}
                $buscaNoticia = new Noticia($fila['ID'], $fila['Titulo'], $fila['Imagen'], $fila['Contenido'], $fila['Descripcion'], $fila['Etiquetas'], $fila['Autor'], $fila['Fecha']);
                $result->free();
                return $buscaNoticia;
            } else{
                return false;
            }
        }
        
        /**
         * Muestra un conjunto de noticias en funcion de su categoria
         * @param string $categoria Categoria de noticias que se desea mostrar
         * @return array|false Array con noticias de su categoria, o false si no se han encontrado resultados
         */
        public static function mostrarPorCar($categoria) {          
            $mysqli = Aplicacion::getInstance()->getConexionBd();
            $Categoria = $mysqli->real_escape_string($categoria); //filtro de seguridad
            $query = sprintf("SELECT * FROM noticias WHERE Etiquetas = '$Categoria'");
            $result = $mysqli->query($query);
            $returning = [];
            if($result) {
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $fila = $result->fetch_assoc();
                    $returning[] = new Noticia($fila['ID'], $fila['Titulo'], $fila['Imagen'], $fila['Contenido'], $fila['Descripcion'], $fila['Etiquetas'], $fila['Autor'], $fila['Fecha']);
                }
                $result->free();
                return $returning;
            } else{
                return false;
            }
        }

        /**
         * Busca noticias por un conjunto de palabras clave
         * @param string $keyWords Palabras clave con las que se va a buscar la noticia
         * @return array $returning Array con las noticias que coinciden con las palabras clave deseadas. Retornara vacio si no encuentra noticias relacionadas
         */
        public static function buscarNoticiaKeyWords($keyWords){            
            $mysqli = Aplicacion::getInstance()->getConexionBd();

            $palabras = $mysqli->real_escape_string($keyWords); //filtro de seguridad
            $palabras = explode(" ", $keyWords); //separamos cada una de las keywords a buscar
            $returning = [];
            foreach($palabras as $palabra){
                $query = sprintf("SELECT * FROM noticias WHERE Titulo LIKE '%%{$palabra}%%' OR Contenido LIKE '%%{$palabra}%%' OR Descripcion LIKE '%%{$palabra}%%'");
                $result = $mysqli->query($query);
                if($result){
                    for ($i = 0; $i < $result->num_rows; $i++) {
                        $fila = $result->fetch_assoc();
                        $esta = false;
                        foreach($returning as $noticia){
                            if($noticia->getID() == $fila['ID']){
                                $esta = true;
                            }
                        }
                        if(!$esta){
                            $returning[] = new Noticia($fila['ID'], $fila['Titulo'], $fila['Imagen'], $fila['Contenido'], $fila['Descripcion'], $fila['Etiquetas'], $fila['Autor'], $fila['Fecha']);
                        }
                        $esta = false;
                    }
                    $result->free();
                }
            }
            return $returning;
        }
    }
?>