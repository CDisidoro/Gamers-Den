<?php namespace es\fdi\ucm\aw\gamersDen;
	/**
	 * Clase base encargada de gestionar productos de la tienda
	 */
	class Producto{
		//ATRIBUTOS DE CLASE
		private $id;
		private $articulo;
		private $descripcion;
		private $fecha;
		private $vendedor;
		private $precio;
		private $caracteristica;
		
		//CONSTRUCTOR Y GETTERS

		/**
		 * Constructor de productos de tienda
		 * @param int $id ID asociado a la publicacion de la tienda
		 * @param int $articulo ID asociado al videojuego que se esta vendiendo
		 * @param string $descripcion Descripcion de la publicacion de la tienda
		 * @param date $fecha Fecha de publicacion de la venta
		 * @param int $vendedor ID asociado al usuario que vende el producto
		 * @param int $precio Precio del producto
		 * @param string $caracteristica Caracteristica especial que tiene la publicacion
		 */
		function __construct($id, $articulo, $descripcion, $fecha, $vendedor, $precio, $caracteristica) {
			$this->id = $id;
			$this->articulo = $articulo;
			$this->descripcion = $descripcion;
			$this->fecha = $fecha;
			$this->precio = $precio;
			$this->vendedor = $vendedor;
			$this->caracteristica = $caracteristica;
		}

		/**
		 * Obtiene el ID del producto
		 * @return int $id ID de la publicacion
		 */
		public function getID() {
			return $this->id;
		}
		
		/**
		 * Obtiene el ID del juego vinculado al producto
		 * @return int $articulo ID del juego asociado al producto
		 */
		public function getArticulo() {
			return $this->articulo;
		}
		
		/**
		 * Obtiene la descripcion del producto
		 * @return string $descripcion Descripcion del producto
		 */
		public function getDescripcion() {
			return $this->descripcion;
		}
		
		/**
		 * Obtiene la fecha de publicacion del producto
		 * @return date $fecha Fecha de publicacion del producto
		 */
		public function getFecha() {
			return $this->fecha;
		}
		
		/**
		 * Obtiene el ID vinculado al vendedor del producto
		 * @return int $vendedor ID del vendedor asociado
		 */
		public function getVendedor() {
			return $this->vendedor;
		}
		
		/**
		 * Obtiene el precio del producto
		 * @return int $precio Precio del articulo
		 */
		public function getPrecio() {
			return $this->precio;
		}

		/**
		 * Obtiene la caracteristica del producto
		 * @return string $caracteristica Caracteristica especial del producto
		 */
		public function getCaracteristica() {
			return $this->caracteristica;
		}

		/**
		 * Obtiene la imagen del producto
		 * @return string $articuloUrl Ruta donde esta guardada la imagen del producto
		 */
		public function getImagen() {
			$articuloUrl = self::getImageArticulo($this->getArticulo());
			return $articuloUrl;
		}
		
		/**
		 * Obtiene el nombre del producto
		 * @return string $articuloNom Nombre del producto
		 */
		public function getNombre() {
			$articuloNom = self::getNombreArticulo($this->getArticulo());
			return $articuloNom;
		}

		//FUNCIONES IMPORTANTES

		// Cuando incluyamos la imagen hay que tenerla en cuenta en las distintas funcionalidades
		
		/*public static function cargarProducto(){
			$mysqli = getConexionBD();
			$query = sprintf("SELECT * FROM productos");
			$result = $mysqli->query($query);

			$ofertasArray;
			
			if($result) {
				for ($i = 0; $i < $result->num_rows; $i++) {
					$fila = $result->fetch_assoc();
					$ofertasArray[] = new Producto($fila['ID'],$fila['Nombre'],$fila['Descripcion'],
										$fila['Fecha'],$fila['Vendedor'],$fila['Precio'], $fila['Caracterisitica'], $fila['UrlImagen']);		
				}
				$result->free();
				return $ofertasArray;
			}
			else{
				echo "Error in ".$query."<br>".$mysqli->error;
			}
		}*/
		
		public static function subeProducto() {
			$articulo = htmlspecialchars(trim(strip_tags($_POST["NombreProducto"])));
			$descripcion = htmlspecialchars(trim(strip_tags($_POST["descripcionProducto"])));
			$fecha = htmlspecialchars(trim(strip_tags($_POST["fechaProducto"])));
			$vendedor = htmlspecialchars(trim(strip_tags($_POST["VendedorProducto"])));
			$precio = htmlspecialchars(trim(strip_tags($_POST["precioProducto"])));
			$caracteristica = htmlspecialchars(trim(strip_tags($_POST["caracteristicaProducto"])));
			$urlImagen = htmlspecialchars(trim(strip_tags($_POST["urlProducto"])));
			
			$mysqli = Aplicacion::getInstance()->getConexionBd();
			$articulo = Videojuego ::buscarporNombre($nombre);
			$articuloId = $articulo->getNombre();
			
			$sql = "INSERT INTO tienda (Articulo, Descripcion, Fecha, Vendedor, Precio, Caracteristica)
					VALUES ('$articuloId', '$descripcion', '$fecha', '$vendedor', '$precio', '$caracteristica')";
			
			if (mysqli_query($mysqli, $sql)) {
				return true;
			}
			else {
				return false;
			}
		}

		/**
         * Actualiza un producto de la base de datos
         * @param string $descripcion Descripcion nueva del producto
		 * @param int $precio Precio nuevo del producto
         * @return bool True si todo ha ido bien, false si ha ocurrido un error
         */
        public function updateProduct($descripcion, $precio){
            $conector = Aplicacion::getInstance()->getConexionBd();
            $productId = $this->getId();
            $query = sprintf("UPDATE tienda SET Descripcion = '$descripcion', Precio = '$precio' WHERE tienda.ID = $productId");
            if (!$conector->query($query)){
                error_log("Error BD ({$conector->errno}): {$conector->error}");
            }else{
                return true;
            }
        }

		/**
		 * Elimina el producto de la BD que ha llamado la funcion
		 * @return bool Verdadero si se ha conseguido borrar, false si ha ocurrido un error
		 */
		public function borrarProducto(){
            $conector = Aplicacion::getInstance()->getConexionBd();
			$idProducto = $this->id;
            $query = sprintf("DELETE FROM tienda WHERE tienda.ID = $idProducto");
            if (!$conector->query($query)){
                error_log("Error BD ({$conector->errno}): {$conector->error}");
            }else{
                return true;
            }
		}

		public static function buscaProducto($id) {
			$mysqli = Aplicacion::getInstance()->getConexionBd();
			$query = "SELECT * FROM tienda WHERE ID = '$id'";
			$result = $mysqli->query($query);
			
			if($result) {
				$fila = $result->fetch_assoc();
				$buscaProducto = new Producto($fila['ID'],$fila['Articulo'],$fila['Descripcion'],
										$fila['Fecha'],$fila['Vendedor'],$fila['Precio'], $fila['Caracteristica']);
				$result->free();
				return $buscaProducto;
			} else{
				echo"No se ha encontrado el producto";
				return false;
			}
		}

		public static function buscador($buscador) {
			$mysqli = Aplicacion::getInstance()->getConexionBd();
			$query = sprintf("SELECT * FROM tienda");
			$result = $mysqli->query($query);
			$returning = [];
			if($result) {
				for ($i = 0; $i < $result->num_rows; $i++) {
					$fila = $result->fetch_assoc();
					if(strstr($fila['Articulo'],$buscador,false) != false)
						$returning = new Producto($fila['ID'],$fila['Articulo'],$fila['Descripcion'],
							$fila['Fecha'],$fila['Vendedor'],$fila['Precio'], $fila['Caracteristica']);
				}
				$result->free();
				return $returning;
			} else{
				echo"No se ha encontrado el producto";
				return false;
			}
		}
		public static function mostrarPorCar($caracterisitica) { //esta función no es eficiente 
			$mysqli = Aplicacion::getInstance()->getConexionBd();
			$query = sprintf("SELECT * FROM tienda");
			$result = $mysqli->query($query);

			$ofertasArray;
			$notNull = 0;
			if($result) {
				for ($i = 0; $i < $result->num_rows; $i++) {
					$fila = $result->fetch_assoc();
					if($fila['Caracteristica'] == $caracterisitica)
					{
						$ofertasArray[] = new Producto($fila['ID'],$fila['Articulo'],$fila['Descripcion'],
							$fila['Fecha'],$fila['Vendedor'],$fila['Precio'], $fila['Caracteristica']);
						$notNull++;		
					}
				}
				$result->free();
				if($notNull == 0)
					return -1;
				return $ofertasArray;
			}
			else{
				echo "Error in ".$query."<br>".$mysqli->error;
			}
		}
		
		public static function getAllProductos(){
			$mysqli = Aplicacion::getInstance()->getConexionBd();
			$query = sprintf("SELECT * FROM tienda");
			$result = $mysqli->query($query);

			$ofertasArray;
			$notNull = 0;
			if($result) {
				for ($i = 0; $i < $result->num_rows; $i++) {
					$fila = $result->fetch_assoc();
					$ofertasArray[] = new Producto($fila['ID'],$fila['Articulo'],$fila['Descripcion'],
						$fila['Fecha'],$fila['Vendedor'],$fila['Precio'], $fila['Caracteristica']);
					$notNull++;		
				}
				$result->free();
				if($notNull == 0)
					return -1;
				return $ofertasArray;
			}
			else{
				echo "Error in ".$query."<br>".$mysqli->error;
			}
		}

		protected function getNombreArticulo($articulo) {
			$mysqli = Aplicacion::getInstance()->getConexionBd();
			$query = sprintf("SELECT Ju.Nombre FROM juegos Ju WHERE Ju.ID LIKE $articulo");
			$result = $mysqli->query($query);
			if($result) {
				$fila = $result->fetch_assoc();
				$value = $fila['Nombre'];
				$result->free();
				return $value;
			}
			else{
				echo "Error in ".$query."<br>".$mysqli->error;
			}
		}

		protected function getImageArticulo($articulo) {
			$mysqli = Aplicacion::getInstance()->getConexionBd();
			$query = sprintf("SELECT Ju.Imagen FROM juegos Ju WHERE Ju.ID LIKE $articulo");
			$result = $mysqli->query($query);
			if($result) {
				$fila = $result->fetch_assoc();
				$value = $fila['Imagen'];
				$result->free();
				return $value;
			}
			else{
				echo "Error in ".$query."<br>".$mysqli->error;
			}
		}
	}
?>