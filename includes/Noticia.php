<?php namespace es\fdi\ucm\aw\gamersDen;
    class Noticia{

        private $id;
        private $titulo;
        private $imagen;
        private $contenido;
        private $descripcion;
        private $etiquetas;
        private $autor;
        private $fechas;

        //Constructor y getters
        private function __construct($id, $titulo, $imagen, $contenido, $descripcion, $etiquetas, $autor, $fechas){
            $this->id = $id;
            $this->imagen = $imagen;
            $this->contenido = $contenido;
            $this->titulo = $titulo;
            $this->etiquetas = $etiquetas;
            $this->autor = $autor;
            $this->fechas = $fechas;
            $this->descripcion = $descripcion;
        }

        // Cuando incluyamos la imagen hay que tenerla en cuenta en las distintas funcionalidades
        
        public static function cargarNoticia(){
            $mysqli = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT * FROM noticias");
<<<<<<< HEAD
            $result = $mysqli->query($query);  
            $returning = [];
=======
            $result = $mysqli->query($query);
    
            $noticiasArray = null;
            
>>>>>>> c3b1f57ed68cfc46fb02ac9920766cb48d33c343
            if($result) {
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $fila = $result->fetch_assoc();
                    $returning[] = new Noticia($fila['ID'], $fila['Titulo'], $fila['Imagen'], $fila['Contenido'], $fila['Descripcion'], $fila['Etiquetas'], $fila['Autor'], $fila['Fecha']);
                }
                $result->free();
                return $returning;
            } else{
                echo"No se ha encontrado el producto";
                return false;
            }
        }
        
        public static function subeNoticia() {
            $titulo = htmlspecialchars(trim(strip_tags($_POST["TituloNoticia"])));
            $contenido = htmlspecialchars(trim(strip_tags($_POST["contenidoNoticias"])));
            $fecha = htmlspecialchars(trim(strip_tags($_POST["fechaProducto"])));
            $autor = htmlspecialchars(trim(strip_tags($_POST["autorNoticias"])));
            $etiquetas = htmlspecialchars(trim(strip_tags($_POST["etiquetaNoticias"])));
            $urlImagen = htmlspecialchars(trim(strip_tags($_POST["urlNoticia"])));
            
            $mysqli = Aplicacion::getInstance()->getConexionBd();
            
            $sql = "INSERT INTO noticias (Nombre, Descripcion, Fecha, Vendedor, Precio, Caracteristicas)
                    VALUES ('$nombre', '$descripcion', '$lanzamiento', '$desarrollador', '$precio', '$caracteristica', '$urlImagen')";
            
            if (mysqli_query($mysqli, $sql)) {
                return true;
            }
            else {
                return false;
            }
        }
        
        public static function buscaNoticia($id) {
            $mysqli = Aplicacion::getInstance()->getConexionBd();
            $query = "SELECT * FROM productos WHERE ID = '$id'";
            $result = $mysqli->query($query);
            
            if($result) {
                $fila = $result->fetch_assoc();
                $buscaProducto = new Noticia($fila['ID'], $fila['Titulo'], $fila['Imagen'], $fila['Contenido'], $fila['Descripcion'], $fila['Etiquetas'], $fila['Autor'], $fila['Fecha']);
                $result->free();
                return $buscaProducto;
            } else{
                echo"No se ha encontrado el producto";
                return false;
            }
        }
        
    
        public function getID() {
            return $this->id;
        }
        
        public function getTitulo() {
            return $this->titulo;
        }

        public function getNombre() {
            return $this->nombre;
        }
        public function getDescripcion() {
            return $this->descripcion;
        }
        
        public function getFecha() {
            return $this->fecha;
        }
        
        public static function enseñarPorCar($categoria) {
            $mysqli = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT * FROM noticias WHERE Etiquetas = $categoria");
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
                echo"No se ha encontrado el producto";
                return false;
            }
        }

        public static function buscarNoticiaKeyWords($keyWords){
            $palabras = explode(" ", $keyWords); //separamos cada una de las keywords a buscar
            $mysqli = Aplicacion::getInstance()->getConexionBd();
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
