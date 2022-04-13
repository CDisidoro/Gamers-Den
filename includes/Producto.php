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

		protected function getNombreArticulo($articulo) {
			$videojuego = Videojuego::buscaVideojuego($articulo);
			return $videojuego->getNombre();
		}

		protected function getImageArticulo($articulo) {
			$videojuego = Videojuego::buscaVideojuego($articulo);
			return $videojuego->getUrlImagen();
		}

		//FUNCIONES IMPORTANTES	
		/**
		 * Publica un producto nuevo en la tienda
		 * @param int $vendedor ID del usuario vendedor del juego
		 * @param string $articulo Nombre del videojuego que se quiere vender
		 * @param int $precio Precio del producto, puede ser diferente al precio oficial del desarrollador
		 * @param string $descripcion Descripcion del producto en venta, puede ser diferente a la descripcion oficial del juego
		 * @return bool Verdadero si se ha insertado el articulo nuevo, o false si hubo algun problema
		 */
		public static function subeProducto($vendedor, $articulo, $precio, $descripcion) {
            $conector = Aplicacion::getInstance()->getConexionBd();
			$juego = Videojuego ::buscaVideojuego($articulo);
			$articuloId = $juego->getID();
			$query = "INSERT INTO tienda (Articulo, Descripcion, Vendedor, Precio)
					VALUES ('$articuloId', '$descripcion', '$vendedor', '$precio')";
			if (!$conector->query($query) ){
                error_log("Error BD ({$conector->errno}): {$conector->error}");
				return false;
            }else{
                return true;
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

		/**
		 * Busca un producto de la tienda en base a su ID
		 * @param int $id ID del producto que se desea buscar
		 * @return Producto|false Si encuentra un producto lo retorna o false si no lo encuentra
		 */
		public static function buscaProducto($id) {
			$mysqli = Aplicacion::getInstance()->getConexionBd();
			$query = "SELECT * FROM tienda WHERE ID = '$id'";
			$result = $mysqli->query($query);
			
			if($result) {
				$fila = $result->fetch_assoc();
				if(is_null($fila)){ //Comprueba si hay un resultado. Si no lo hay devuelve false
					return false;
				}
				$buscaProducto = new Producto($fila['ID'],$fila['Articulo'],$fila['Descripcion'],
										$fila['Fecha'],$fila['Vendedor'],$fila['Precio'], $fila['Caracteristica']);
				$result->free();
				return $buscaProducto;
			} else{
				return false;
			}
		}

		/**
		 * Busca productos en la tienda en base a su Nombre
		 * @param string $nombre Nombre del producto que se desea buscar
		 * @return array|false Si encuentra productos los retorna en un array o false si no los encuentra
		 */
		public static function buscaPorNombre($nombre) {
			$mysqli = Aplicacion::getInstance()->getConexionBd();
			$query = "SELECT tienda.ID, tienda.Articulo, tienda.Vendedor, juegos.Nombre, tienda.Precio,
			tienda.Descripcion, tienda.Fecha, tienda.Caracteristica
			FROM tienda INNER JOIN juegos ON tienda.Articulo=juegos.ID
			WHERE juegos.Nombre = '$nombre'";
			$result = $mysqli->query($query);
			$buscaProducto = [];
			if($result) {
				for($i = 0; $i < $result->num_rows; $i++){
					$fila = $result->fetch_assoc();
					if(is_null($fila)){ //Comprueba si hay un resultado. Si no lo hay devuelve false
						return false;
					}
					$buscaProducto[] = new Producto($fila['ID'],$fila['Articulo'],$fila['Descripcion'],
							$fila['Fecha'],$fila['Vendedor'],$fila['Precio'], $fila['Caracteristica']);
				}
				$result->free();
				return $buscaProducto;
			} else{
				return false;
			}
		}

		/**
		 * Muestra una lista de productos en funcion de una caracteristica
		 * @param string $caracteristica Caracteristica que se desea buscar
		 * @return array|-1 Si se encuentran productos con la caracteristica, se retorna un array de productos, o -1 si no encuentra ninguno
		 */
		public static function mostrarPorCar($caracteristica) {
			$conector = Aplicacion::getInstance()->getConexionBd();
			$query = sprintf("SELECT * FROM tienda WHERE Caracteristica = '$caracteristica'");
			$result = $conector->query($query);
			$ofertasArray = null;
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
			}else{
				error_log("Error BD ({$conector->errno}): {$conector->error}");
			}
		}

		/**
		 * Obtiene una lista de todos los productos en la BD
		 * @return array|-1 Si ha encontrado productos en la tienda dara un array con todos los productos, o -1 si no hay productos
		 */
		public static function getAllProductos(){
			$conector = Aplicacion::getInstance()->getConexionBd();
			$query = sprintf("SELECT * FROM tienda");
			$result = $conector->query($query);
			$ofertasArray = null;
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
			}else{
				error_log("Error BD ({$conector->errno}): {$conector->error}");
			}
		}
	}
?>