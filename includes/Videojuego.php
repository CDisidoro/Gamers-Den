<?php namespace es\fdi\ucm\aw\gamersDen;
	/**
	 * Clase basica para la gestion de Videojuegos
	 */
	class Videojuego{
		//ATRIBUTOS DE CLASE
		private $id;
		private $nombre;
		private $descripcion;
		private $lanzamiento;
		private $desarrollador;
		private $urlImagen;
		private $precio;

		//CONSTRUCTOR Y GETTERS
		/**
		 * Constructor de Videojuegos nuevos
		 * @param int $id ID del videojuego
		 * @param string $nombre Nombre del juego
		 * @param string $descripcion Descripcion rapida del juego
		 * @param string $desarrollador Empresa desarrolladora del videojuego
		 * @param date $lanzamiento Fecha de lanzamiento del juego
		 * @param int $precio Precio oficial del videojuego
		 * @param string $urlImagen (PENDIENTE) Ruta donde esta guardada la imagen del videojuego
		 */
		function __construct($id, $nombre, $descripcion, $desarrollador, $lanzamiento, $precio, $urlImagen = null) {
			$this->id = $id;
			$this->nombre = $nombre;
			$this->descripcion = $descripcion;
			$this->lanzamiento = $lanzamiento;
			$this->precio = $precio;
			$this->desarrollador = $desarrollador;
			$this->urlImagen = $urlImagen;
		}

		/**
		 * Obtiene el ID del videojuego
		 * @return int $id ID del juego
		 */
		public function getID() {
			return $this->id;
		}
		
		/**
		 * Obtiene el nombre del juego
		 * @return string $nombre Nombre del juego
		 */
		public function getNombre() {
			return $this->nombre;
		}

		/**
		 * Obtiene la descripcion del juego
		 * @return string $descripcion Descripcion del videojuego
		 */
		public function getDescripcion() {
			return $this->descripcion;
		}
		
		/**
		 * Obtiene la fecha de lanzamiento del videojuego
		 * @return date $lanzamiento Fecha de lanzamiento
		 */
		public function getLanzamiento() {
			return $this->lanzamiento;
		}
		
		/**
		 * Obtiene el nombre de la empresa desarrolladora del juego
		 * @return string $desarrollador Desarrollador del juego
		 */
		public function getDesarrollador() {
			return $this->desarrollador;
		}
		
		/**
		 * Obtiene el precio del videojuego
		 * @return int $precio Precio oficial del videojuego
		 */
		public function getPrecio() {
			return $this->precio;
		}

		/**
		 * Obtiene la ruta donde esta guardada la imagen del videojuego
		 * @return string $urlImagen Ruta de la imagen
		 */
		public function getUrlImagen(){
			return $this->urlImagen;
		}

		//FUNCIONES IMPORTANTES

		/**
		 * Busca videojuegos por un conjunto de palabras clave
		 * @param string $keywords Palabras clave con las que se buscaran videojuegos
		 * @return array $returning Array con los juegos coincidentes
		 */
		public static function buscaPorKeywords($keywords){
			$conector = Aplicacion::getInstance()->getConexionBd();
			$palabras = $conector->real_escape_string($keywords); //Filtro de seguridad
			$palabras = explode(" ",$keywords); //Separa cada palabra
			$returning = [];
			foreach($palabras as $palabra){
                $query = sprintf("SELECT * FROM juegos WHERE Nombre LIKE '%%{$palabra}%%'");
                $result = $conector->query($query);
                if($result){
                    for ($i = 0; $i < $result->num_rows; $i++) {
                        $fila = $result->fetch_assoc();
                        $esta = false;
                        foreach($returning as $juego){
                            if($juego->getID() == $fila['ID']){
                                $esta = true;
                            }
                        }
                        if(!$esta){
                            $returning[] = new Videojuego($fila['ID'], $fila['Nombre'], $fila['Descripcion'], $fila['Desarrollador'], $fila['Lanzamiento'], $fila['Precio'], $fila['Imagen']);
                        }
                        $esta = false;
                    }
                    $result->free();
                }
			}
			return $returning;
		}

		/**
		 * Carga todos los videojuegos de la BD en un array
		 * @return array Array con todos los Videojuegos disponibles
		 */
		public static function cargarVideojuegos(){
			$conector = Aplicacion::getInstance()->getConexionBd();
			$query = sprintf("SELECT * FROM juegos");
			$result = $conector->query($query);
			$ofertasArray = null;
			if($result) {
				for ($i = 0; $i < $result->num_rows; $i++) {
					$fila = $result->fetch_assoc();
					$ofertasArray[] = new Videojuego($fila['ID'],$fila['Nombre'],$fila['Descripcion'],
										$fila['Desarrollador'],$fila['Lanzamiento'],$fila['Precio'],$fila['Imagen']);		
				}
				return $ofertasArray;
			}
			else{
				error_log("Error BD ({$conector->errno}): {$conector->error}");
			}
		}
		

		/**
		 * Da de alta un videjuego nuevo en la BD
		 * @param string $nombre Nombre del videojuego
		 * @param string $descripcion Descripcion del videojuego
		 * @param date $lanzamiento Fecha de lanzamiento del videojuego
		 * @param string $desarrollador Empresa desarrolladora del videojuego
		 * @param int $precio Precio oficial del videojuego
		 * @param string $imagen Ruta de la imagen de la noticia
		 * @return bool Si se ha subido correctamente el juego nuevo devuelve true, o false si algo ha ido mal
		 */
		public static function subeVideojuego($nombre, $descripcion, $lanzamiento, $desarrollador, $precio, $imagen) {
			$conector = Aplicacion::getInstance()->getConexionBd();
			$query = "INSERT INTO juegos (Nombre, Descripcion, Lanzamiento, Desarrollador, Precio, Imagen)
					VALUES ('$nombre', '$descripcion', '$lanzamiento', '$desarrollador', '$precio', '$imagen')";
			if (!$conector->query($query)){
				error_log("Error BD ({$conector->errno}): {$conector->error}");
				return false;
			}else{
				return true;
			}
		}

		/**
		 * Elimina de la BD el juego que haya llamado esta funcion, asi como su imagen asociada
		 * @return bool Si se ha borrado el juego y su imagen asociada , retorna true, sino retornara false
		 */
		public function borrarJuego(){
            $conector = Aplicacion::getInstance()->getConexionBd();
			$query = sprintf("DELETE FROM juegos WHERE ID = $this->id");
            if (!$conector->query($query) ) {
                error_log("Error BD ({$conector->errno}): {$conector->error}");
                return false;
            }
            //Borrado de la imagen asociada
            if(!unlink($this->urlImagen)){
                error_log("Error eliminando la imagen del juego");
                return false;
            }
            return true;
		}

		/**
		 * Edita el videojuego existente en la BD que haya llamado la funcion
		 * 
		 */
        public function editarVideojuego($nombre, $descripcion, $lanzamiento, $desarrollador, $precio, $imagen){
            $conn = Aplicacion::getInstance()->getConexionBd();
			$idJuego = $this->getID();
            $query = sprintf("UPDATE juegos 
            SET Nombre = '$nombre', Descripcion = '$descripcion', Lanzamiento = '$lanzamiento', Desarrollador = '$desarrollador', Precio = '$precio', Imagen = '$imagen'
            WHERE id = $idJuego");
            if ( ! $conn->query($query) ) {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
                return false;
            }
            return true;
        }

		/**
		 * Busca un videojuego en base a su nombre
		 * @param string $nombre Nombre del videojuego que se esta buscando
		 * @return Videojuego|false Retorna un objeto videojuego si ha encontrado el juego o false si no lo encontro
		 */
		public static function buscarPorNombre($nombre) {
			$mysqli = Aplicacion::getInstance()->getConexionBd();
			$query = "SELECT * FROM juegos WHERE Nombre = '$nombre'";
			$result = $mysqli->query($query);
			if($result) {
				$fila = $result->fetch_assoc();
				if(is_null($fila)){ //Comprueba si hay un resultado. Si no lo hay devuelve false
					return false;
				}
				$buscaJuego = new Videojuego($fila['ID'],$fila['Nombre'],$fila['Descripcion'],
										$fila['Desarrollador'],$fila['Lanzamiento'],$fila['Precio'],$fila['Imagen']);
				return $buscaJuego;
			} else{
				return false;
			}
		}
		
		/**
		 * Busca un videojuego en base a su ID
		 * @param int $id ID del videojuego que se desea buscar
		 * @return Videojuego|false Retorna un objeto videojuego si se ha encontrado el juego o false si no fue encontrado
		 */
		public static function buscaVideojuego($id) {
			$mysqli = Aplicacion::getInstance()->getConexionBd();
			$query = "SELECT * FROM juegos WHERE ID = '$id'";
			$result = $mysqli->query($query);
			if($result) {
				$fila = $result->fetch_assoc();
				if(is_null($fila)){ //Comprueba si hay un resultado. Si no lo hay devuelve false
					return false;
				}
				$buscaJuego = new Videojuego($fila['ID'],$fila['Nombre'],$fila['Descripcion'],
										$fila['Desarrollador'],$fila['Lanzamiento'],$fila['Precio'],$fila['Imagen']);
				return $buscaJuego;
			} else{
				return false;
			}
		}		
	}
?>