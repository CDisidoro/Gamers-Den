<?php namespace es\fdi\ucm\aw\gamersDen;
    class Noticia{

        private $id;
        private $titulo;
        private $imagen;
        private $contenido;
        private $etiquetas;
        private $autor;
        private $fechas;
        //Constructor y getters
        private function __construct($titulo, $imagen, $contenido, $id = null, $etiquetas, $autor, $fechas){
            $this->id = $id;
            $this->imagen = $imagen;
            $this->contenido = $contenido;
            $this->titulo = $titulo;
            $this->etiquetas = $etiquetas;
            $this->autor = $autor;
            $this->fechas = $fechas;
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
        
        public static function buscaProducto($id) {
            $mysqli = getConexionBD();
            $query = "SELECT * FROM productos WHERE ID = '$id'";
            $result = $mysqli->query($query);
            
            if($result) {
                $fila = $result->fetch_assoc();
                $buscaProducto = new Producto($fila['ID'],$fila['Nombre'],$fila['Descripcion'],
                                        $fila['Fecha'],$fila['VEndedor'],$fila['Precio'], $fila['Caracterisitica'], $fila['UrlImagen']);
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
        
        public function getNombre() {
            return $this->nombre;
        }
        public function getDescripcion() {
            return $this->descripcion;
        }
        
        public function getFecha() {
            return $this->fecha;
        }
        
        public function getVendedor() {
            return $this->vendedor;
        }
        
        public function getPrecio() {
            return $this->precio;
        }
    
        public function getCaracteristica() {
            return $this->caracteristic;
        }
    
        public function geturlImagen() {
            return $this->urlImagen;
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
        public static function enseñarPorCar() {
            $mysqli = getConexionBD();
            $query = sprintf("SELECT * FROM productos PR WHERE PR.Caracteristicas LIKE $producto->caracteristica");
            $result = $mysqli->query($query);
            $returning = [];
            if($result) {
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $fila = $result->fetch_assoc();
                    $returning[] = $numavatar['ID'];
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
?>