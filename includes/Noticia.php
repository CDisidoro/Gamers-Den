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
            $mysqli = getConexionBD();
            $query = sprintf("SELECT * FROM noticias");
            $result = $mysqli->query($query);
    
            $noticiasArray;
            
            if($result) {
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $fila = $result->fetch_assoc();
                    $noticiasArray[] = new Noticia($fila['Titulo'],$fila['Imagen'], $fila['Contenido'],
                                         $fila['ID'], $fila['Etiquetas'],$fila['Autor'], $fila['Fecha']);		
                }
                $result->free();
                return $noticiasArray;
            }
            else{
                echo "Error in ".$query."<br>".$mysqli->error;
            }
        }
        
        public static function subeNoticia() {
            $titulo = htmlspecialchars(trim(strip_tags($_POST["TituloNoticia"])));
            $contenido = htmlspecialchars(trim(strip_tags($_POST["contenidoNoticias"])));
            $fecha = htmlspecialchars(trim(strip_tags($_POST["fechaProducto"])));
            $autor = htmlspecialchars(trim(strip_tags($_POST["autorNoticias"])));
            $etiquetas = htmlspecialchars(trim(strip_tags($_POST["etiquetaNoticias"])));
            $urlImagen = htmlspecialchars(trim(strip_tags($_POST["urlNoticia"])));
            
            $mysqli = getConexionBD();
            
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
                $buscaProducto = new Noticia($fila['Titulo'], $fila['Imagen'], $fila['Contenido'], $fila['ID'], $fila['Etiquetas'], $fila['Autor'], $fila['Fecha']);
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
    
        public static function buscador($buscador) {
            $mysqli = getConexionBD();
            $query = sprintf("SELECT * FROM productos");
            $result = $mysqli->query($query);
            $returning = [];
            if($result) {
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $fila = $result->fetch_assoc();
                    if(strstr($fila['Nombre'],$buscador,false) != false)
                        $returning[] = $numavatar['ID'];
                }
                $result->free();
                return $returning;
            } else{
                echo"No se ha encontrado el producto";
                return false;
            }
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
        
      }
?>
